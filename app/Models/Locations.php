<?php

namespace App\Models;

use App\Filters\LocationFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Locations extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = "locations";

    protected $fillable = ["code", "name"];

    protected string $default_filters = LocationFilter::class;
}
