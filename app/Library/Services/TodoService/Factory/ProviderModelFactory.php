<?php

namespace App\Library\Services\TodoService\Factory;

use App\Library\Services\TodoService\Contracts\ProviderInterface;
use App\Library\Services\TodoService\Contracts\ProviderModelFactoryContract;
use App\Library\Services\TodoService\Providers\FirstProvider;
use App\Library\Services\TodoService\Providers\SecondProvider;

class ProviderModelFactory implements ProviderModelFactoryContract
{

    /**
     * @throws \Exception
     * @return array
     */
    public static function create(ProviderInterface $provider)
    {
        $provider = get_class($provider);
        switch ($provider) {
            case FirstProvider::class:
                return [
                    'remote_id' => 'id',
                    'difficulty' => 'zorluk',
                    'hour' => 'sure',
                ];
            case SecondProvider::class:
                return [
                    'remote_id' => null,
                    'difficulty' => 'level',
                    'hour' => 'estimated_duration',
                ];
            default:
                throw new \Exception("Gönderilen provider hatalı");
        }
    }
}
