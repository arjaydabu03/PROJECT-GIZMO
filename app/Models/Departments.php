<?php

namespace App\Models;

use App\Filters\DepartmentFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departments extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = "departments";

    protected $fillable = ["code", "name"];

    protected string $default_filters = DepartmentFilter::class;

    public function locations()
    {
        return $this->belongsToMany(
            DepartmentLocation::class,
            "department_location",
            "department_id",
            "location_id",
            "id",
            "id"
        );
    }

    function scope_locations()
    {
        return $this->hasMany(DepartmentLocation::class, "department_id", "id");
    }
}
