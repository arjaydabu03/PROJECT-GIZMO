<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentLocation extends Model
{
    use HasFactory;
    protected $table = "department_location";
    protected $fillable = ["department_id", "location_id", "location_code"];
}
