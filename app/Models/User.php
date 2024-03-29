<?php

namespace App\Models;

use App\Filters\AuthFilter;
use Laravel\Sanctum\HasApiTokens;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Filterable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "id_no",
        "id_prefix",
        "first_name",
        "middle_name",
        "last_name",
        "suffix",
        "position",
        "username",
        "password",
        "role_id",

        "location_id",
        "location_code",
        "location_name",

        "department_id",
        "department_code",
        "department_name",

        "company_id",
        "company_code",
        "company_name",
    ];

    protected string $default_filters = AuthFilter::class;

    protected $hidden = ["password", "remember_token"];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function ap_tagging()
    {
        return $this->belongsToMany(
            ApTagAccount::class,
            "ap_account",
            "account_id",
            "ap_id",
            "id",
            "id"
        );
    }

    function scope_tagging()
    {
        return $this->hasMany(ApTagAccount::class, "account_id", "id");
    }
}
