<?php

namespace App\Library\Services\TodoService\Providers;

use App\Library\Services\TodoService\Contracts\ProviderInterface;
use App\Library\Services\TodoService\Factory\ProviderModelFactory;
use App\Models\Task;
use Illuminate\Support\Facades\Http;

class BaseProvider
{

    /**
     * @return ProviderInterface
     * @throws \Exception
     */
    public function updateTasksFromAPI(): ProviderInterface
    {
        $factory = ProviderModelFactory::create($this);
        foreach ($this->getTasks() as $key => $item) {
            Task::updateOrCreate([
                'remote_id' => $factory['remote_id'] ? $item[$factory['remote_id']] : $key,
                'provider' => get_class($this)
            ], [
                'difficulty' => $item[$factory['difficulty'] ?? $key],
                'hour' => $item[$factory['hour']],
            ]);
        }
        return $this;
    }


    public function getTasks(): array
    {
        return Http::acceptJson()->get($this->getUrl())->json();
    }
}
