<?php

namespace App\Http\Controllers\Api;

use App\Models\Locations;
use App\Responses\Status;
use Illuminate\Http\Request;
use App\Functions\GlobalFunction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Location\StoreRequest;
use App\Http\Requests\DisplayValidate\DisplayRequest;

class LocationController extends Controller
{
    public function index(DisplayRequest $request)
    {
        $status = $request->status;

        $location = Locations::when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
            ->useFilters()
            ->dynamicPaginate();

        $is_empty = $location->isEmpty();

        if ($is_empty) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }
        return GlobalFunction::response_function(
            Status::LCOATION_DISPLAY,
            $location
        );
    }
    public function store(StoreRequest $request)
    {
        $location = Locations::create([
            "code" => $request->code,
            "name" => $request->name,
        ]);
        return GlobalFunction::save(Status::LOCATION_SAVE, $location);
    }
    public function update(StoreRequest $request, $id)
    {
        $location = Locations::find($id);

        $not_found = Locations::where("id", $id)->get();

        if ($not_found->isEmpty()) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }
        $location->update([
            "code" => $request["code"],
            "name" => $request["name"],
        ]);

        return GlobalFunction::response_function(
            Status::LCOATION_UPDATE,
            $location
        );
    }

    public function destroy($id)
    {
        $location = Locations::where("id", $id)
            ->withTrashed()
            ->get();

        if ($location->isEmpty()) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }

        $location = Locations::withTrashed()->find($id);
        $is_active = Locations::withTrashed()
            ->where("id", $id)
            ->first();
        if (!$is_active) {
            return $is_active;
        } elseif (!$is_active->deleted_at) {
            $location->delete();
            $message = Status::ARCHIVE_STATUS;
        } else {
            $location->restore();
            $message = Status::RESTORE_STATUS;
        }
        return GlobalFunction::response_function($message, $location);
    }
}
