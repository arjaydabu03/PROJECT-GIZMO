<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class AuthFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [
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
    ];
}
