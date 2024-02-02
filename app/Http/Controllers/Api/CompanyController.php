<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Responses\Status;
use Illuminate\Http\Request;
use App\Functions\GlobalFunction;
use App\Http\Controllers\Controller;
use App\Http\Requests\DisplayValidate\DisplayRequest;

class CompanyController extends Controller
{
    public function index(DisplayRequest $request)
    {
        $status = $request->status;

        $company = Company::when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
            ->useFilters()
            ->dynamicPaginate();

        $is_empty = $company->isEmpty();

        if ($is_empty) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }

        // RoleResource::collection($company);

        return GlobalFunction::response_function(
            Status::COMPANY_DISPLAY,
            $company
        );
    }
    public function store(Request $request)
    {
        $company = Company::create([
            "code" => $request->code,
            "name" => $request->name,
        ]);
        return GlobalFunction::save(Status::COMPANY_SAVE, $company);
    }
    public function update(Request $request, $id)
    {
        $company = Company::find($id);

        $not_found = Company::where("id", $id)->get();

        if ($not_found->isEmpty()) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }
        $company->update([
            "code" => $request["code"],
            "name" => $request["name"],
        ]);

        return GlobalFunction::response_function(
            Status::COMPANY_UPDATE,
            $company
        );
    }

    public function destroy($id)
    {
        $company = Company::where("id", $id)
            ->withTrashed()
            ->get();

        if ($company->isEmpty()) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }

        $company = Company::withTrashed()->find($id);
        $is_active = Company::withTrashed()
            ->where("id", $id)
            ->first();
        if (!$is_active) {
            return $is_active;
        } elseif (!$is_active->deleted_at) {
            $company->delete();
            $message = Status::ARCHIVE_STATUS;
        } else {
            $company->restore();
            $message = Status::RESTORE_STATUS;
        }
        return GlobalFunction::response_function($message, $company);
    }
}
