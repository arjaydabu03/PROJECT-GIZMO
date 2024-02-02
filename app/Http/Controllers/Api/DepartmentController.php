<?php

namespace App\Http\Controllers\Api;

use App\Responses\Status;
use App\Models\Departments;
use Illuminate\Http\Request;
use App\Functions\GlobalFunction;
use App\Models\DepartmentLocation;
use App\Http\Controllers\Controller;
use App\Http\Requests\DisplayValidate\DisplayRequest;

class DepartmentController extends Controller
{
    public function index(DisplayRequest $request)
    {
        $status = $request->status;

        $department = Departments::when($status === "inactive", function (
            $query
        ) {
            $query->onlyTrashed();
        })
            ->useFilters()
            ->dynamicPaginate();

        $is_empty = $department->isEmpty();

        if ($is_empty) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }

        // RoleResource::collection($department);

        return GlobalFunction::response_function(
            Status::DEPARMENT_DISPLAY,
            $department
        );
    }
    public function store(Request $request)
    {
        $department = new Departments([
            "code" => $request->code,
            "name" => $request->name,
        ]);
        $department->save();
        $scope_location = $request["scope_location"];

        foreach ($scope_location as $key => $value) {
            DepartmentLocation::create([
                "department_id" => "1",
                "location_id" => $scope_location[$key]["id"],
                "location_code" => $scope_location[$key]["code"],
            ]);
        }
        return GlobalFunction::save(Status::DEPARTMENT_SAVE, $department);
    }
    public function update(Request $request, $id)
    {
        $scope_location = $request->scope_location;
        $department = Departments::find($id);

        $not_found = Departments::where("id", $id)->get();

        if ($not_found->isEmpty()) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }

        // // SCOPE FOR LOCATION
        // $newTaggedlocation = collect($scope_location)
        //     ->pluck("department_id")
        //     ->toArray();
        // $currentTaggedlocation = DepartmentLocation::where("department_id", $id)
        //     ->get()
        //     ->pluck("location_id")
        //     ->toArray();

        // foreach ($currentTaggedlocation as $location_id) {
        //     if (!in_array($location_id, $newTaggedlocation)) {
        //         DepartmentLocation::where("location_id", $id)
        //             ->where("location_id", $location_id)
        //             ->delete();
        //     }
        // }
        // foreach ($scope_location as $index => $value) {
        //     if (!in_array($value["id"], $currentTaggedlocation)) {
        //         DepartmentLocation::create([
        //             "department_id" => $id,
        //             "location_id" => $value["id"],
        //             "location_code" => $value["code"],
        //         ]);
        //     }
        // }
        $department->update([
            "code" => $request["code"],
            "name" => $request["name"],
        ]);
        $department->locations()->sync($request->scope_location);

        return GlobalFunction::response_function(
            Status::DEPARTMENT_UPDATE,
            $department
        );
    }

    public function destroy($id)
    {
        $department = Departments::where("id", $id)
            ->withTrashed()
            ->get();

        if ($department->isEmpty()) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }

        $department = Departments::withTrashed()->find($id);
        $is_active = Departments::withTrashed()
            ->where("id", $id)
            ->first();
        if (!$is_active) {
            return $is_active;
        } elseif (!$is_active->deleted_at) {
            $department->delete();
            $message = Status::ARCHIVE_STATUS;
        } else {
            $department->restore();
            $message = Status::RESTORE_STATUS;
        }
        return GlobalFunction::response_function($message, $department);
    }
}
