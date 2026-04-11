<?php

namespace App\Models\Traits;

use App\Helpers\Hashid;

trait HasHashid
{
    public function getRouteKey(): string
    {
        return Hashid::encode($this->getKey());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->findOrFail(Hashid::decode($value));
    }
}
