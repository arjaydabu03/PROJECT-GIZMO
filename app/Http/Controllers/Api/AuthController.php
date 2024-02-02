<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Responses\Status;
use Illuminate\Http\Request;
use App\Functions\GlobalFunction;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\LoginResource;
use App\Http\Requests\Auth\StoreRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\Validation\ChangeRequest;
use App\Http\Requests\DisplayValidate\DisplayRequest;

class AuthController extends Controller
{
    public function index(DisplayRequest $request)
    {
        $status = $request->status;

        $users = User::when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
            ->useFilters()
            ->dynamicPaginate();

        $is_empty = $users->isEmpty();
        if ($is_empty) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }

        UserResource::collection($users);
        return GlobalFunction::response_function(Status::USER_DISPLAY, $users);
    }

    public function show($id)
    {
        $not_found = User::where("id", $id)->get();

        if ($not_found->isEmpty()) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }
        $users = User::where("id", $id)
            // ->with("scope_approval", "scope_order")
            ->get();
        $user_collection = UserResource::collection($users);

        return GlobalFunction::response_function(
            Status::USER_DISPLAY,
            $user_collection
        );
    }

    public function store(StoreRequest $request)
    {
        $user = User::create([
            "id_no" => $request["id_no"],
            "id_prefix" => $request["id_prefix"],

            "first_name" => $request["personal_info"]["first_name"],
            "middle_name" => $request["personal_info"]["middle_name"],
            "last_name" => $request["personal_info"]["last_name"],
            "suffix" => $request["personal_info"]["suffix"],

            "location_id" => $request["location"]["id"],
            "location_code" => $request["location"]["code"],
            "location_name" => $request["location"]["name"],

            "department_id" => $request["department"]["id"],
            "department_code" => $request["department"]["code"],
            "department_name" => $request["department"]["name"],

            "company_id" => $request["company"]["id"],
            "company_code" => $request["company"]["code"],
            "company_name" => $request["company"]["name"],

            "position" => $request["position"],
            "role_id" => $request["role_id"],

            "username" => $request["username"],
            "password" => Hash::make($request["username"]),
        ]);

        $user = new UserResource($user);

        return GlobalFunction::save(Status::USER_SAVE, $user);
    }

    public function login(Request $request)
    {
        $user = User::where("username", $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                "username" => ["The provided credentials are incorrect."],
                "password" => ["The provided credentials are incorrect."],
            ]);

            if ($user || Hash::check($request->password, $user->username)) {
                return GlobalFunction::login_user(Status::INVALID_ACTION);
            }
        }
        $token = $user->createToken("PersonalAccessToken")->plainTextToken;
        $user["token"] = $token;

        $cookie = cookie("gizmo", $token);

        $user = new LoginResource($user);

        return GlobalFunction::response_function(
            Status::LOGIN_USER,
            $user
        )->withCookie($cookie);
    }

    public function logout(Request $request)
    {
        // auth()->user()->tokens()->delete();//all token of one user
        auth()
            ->user()
            ->currentAccessToken()
            ->delete(); //current user
        return GlobalFunction::response_function(Status::LOGOUT_USER);
    }

    public function destroy(Request $request, $id)
    {
        $invalid_id = User::where("id", $id)
            ->withTrashed()
            ->get();

        if ($invalid_id->isEmpty()) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }

        $user_id = Auth()->user()->id;
        $not_allowed = User::where("id", $id)
            ->where("id", $user_id)
            ->exists();

        if ($not_allowed) {
            return GlobalFunction::invalid(Status::INVALID_ACTION);
        }
        $user = User::withTrashed()->find($id);
        $is_active = User::withTrashed()
            ->where("id", $id)
            ->first();
        if (!$is_active) {
            return $is_active;
        } elseif (!$is_active->deleted_at) {
            $user->delete();
            $message = Status::ARCHIVE_STATUS;
        } else {
            $user->restore();
            $message = Status::RESTORE_STATUS;
        }

        $user = new UserResource($user);

        return GlobalFunction::response_function($message, $user);
    }

    public function update(StoreRequest $request, $id)
    {
        $user = User::find($id);

        $user->update([
            "id_no" => $request["id_no"],
            "id_prefix" => $request["id_prefix"],

            "first_name" => $request["personal_info"]["first_name"],
            "middle_name" => $request["personal_info"]["middle_name"],
            "last_name" => $request["personal_info"]["last_name"],
            "suffix" => $request["personal_info"]["suffix"],

            "location_id" => $request["location"]["id"],
            "location_code" => $request["location"]["code"],
            "location_name" => $request["location"]["name"],

            "department_id" => $request["department"]["id"],
            "department_code" => $request["department"]["code"],
            "department_name" => $request["department"]["name"],

            "company_id" => $request["company"]["id"],
            "company_code" => $request["company"]["code"],
            "company_name" => $request["company"]["name"],

            "position" => $request["position"],
            "role_id" => $request["role_id"],

            "username" => $request["username"],
        ]);

        $user = new UserResource($user);

        return GlobalFunction::response_function(Status::USER_UPDATE, $user);
    }

    public function reset_password(Request $request, $id)
    {
        $user = User::find($id);

        $new_password = Hash::make($user->username);

        $user->update([
            "password" => $new_password,
        ]);

        return GlobalFunction::response_function(Status::CHANGE_PASSWORD);
    }

    public function change_password(ChangeRequest $request)
    {
        $id = Auth::id();
        $user = User::find($id);

        if ($user->username == $request->password) {
            throw ValidationException::withMessages([
                "password" => ["Please change your password."],
            ]);
        }
        $user->update([
            "password" => Hash::make($request["password"]),
        ]);
        return GlobalFunction::response_function(Status::CHANGE_PASSWORD);
    }

    public function old_password(PasswordRequest $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        //pwedi yang and &&
        if (!Hash::check($request->password, $user->password)) {
            return GlobalFunction::invalid(Status::INVALID_RESPONSE);
        }
    }

    public function validate_username(UsernameRequest $request)
    {
        return GlobalFunction::response_function(Status::SINGLE_VALIDATION);
    }
}
