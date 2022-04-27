<?php

namespace App\Library\Services\TodoService\Contracts;

interface ProviderModelFactoryContract
{
    public static function create(ProviderInterface $provider);
}
