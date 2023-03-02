<?php

namespace App\Models\Traits\Scopes;

trait UserScope
{
    public function scopeFilters($query, array $data=[])
    {
        //apply filters here
        return $query;
    }

    public function scopeSingleInfo($query)
    {
        //eager load any relations here
        return $query;
    }

    public function scopeListingInfo($query)
    {
        //eager load any relations here
        return $query;
    }
}
