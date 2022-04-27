<?php

namespace App\Library\Services\TodoService\Providers;

use App\Library\Services\TodoService\Contracts\ProviderInterface;

class FirstProvider extends BaseProvider implements ProviderInterface
{
    public function getUrl(): string
    {
        return "http://www.mocky.io/v2/5d47f24c330000623fa3ebfa";
    }
}
