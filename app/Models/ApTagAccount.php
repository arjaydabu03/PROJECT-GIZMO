<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApTagAccount extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "ap_account";
    protected $fillable = ["account_id", "ap_id", "ap_code"];
}
