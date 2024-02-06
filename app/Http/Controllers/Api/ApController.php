<?php

namespace App\Http\Controllers\Api;

use App\Models\ApTagging;
use App\Responses\Status;
use Illuminate\Http\Request;
use App\Functions\GlobalFunction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tagging\StoreRequest;
use App\Http\Requests\DisplayValidate\DisplayRequest;

class ApController extends Controller
{
    public function index(DisplayRequest $request)
    {
        $status = $request->status;

        $tagging = ApTagging::when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
            ->useFilters()
            ->dynamicPaginate();

        $is_empty = $tagging->isEmpty();

        if ($is_empty) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }

        return GlobalFunction::response_function(
            Status::TAGGING_DISPLAY_DISPLAY,
            $tagging
        );
    }
    public function store(StoreRequest $request)
    {
        $tagging = ApTagging::create([
            "company_code" => $request->company_code,
            "description" => $request->description,
        ]);
        return GlobalFunction::save(Status::TAGGING_SAVE, $tagging);
    }
    public function update(StoreRequest $request, $id)
    {
        $tagging = ApTagging::find($id);

        $not_found = ApTagging::where("id", $id)->get();

        if ($not_found->isEmpty()) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }
        $tagging->update([
            "company_code" => $request["company_code"],
            "description" => $request["description"],
        ]);

        return GlobalFunction::response_function(
            Status::TAGGING_UPDATE,
            $tagging
        );
    }

    public function destroy($id)
    {
        $tagging = ApTagging::where("id", $id)
            ->withTrashed()
            ->get();

        if ($tagging->isEmpty()) {
            return GlobalFunction::not_found(Status::NOT_FOUND);
        }

        $tagging = ApTagging::withTrashed()->find($id);
        $is_active = ApTagging::withTrashed()
            ->where("id", $id)
            ->first();
        if (!$is_active) {
            return $is_active;
        } elseif (!$is_active->deleted_at) {
            $tagging->delete();
            $message = Status::ARCHIVE_STATUS;
        } else {
            $tagging->restore();
            $message = Status::RESTORE_STATUS;
        }
        return GlobalFunction::response_function($message, $tagging);
    }
}
