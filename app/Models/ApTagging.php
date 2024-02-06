<?php

namespace App\Models;

use App\Filters\ApFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApTagging extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $table = "ap_tagging";

    protected $fillable = ["company_code", "description"];

    protected string $default_filters = ApFilter::class;
}
