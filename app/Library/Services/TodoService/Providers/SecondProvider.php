<?php

namespace App\Library\Services\TodoService\Providers;

use App\Library\Services\TodoService\Contracts\ProviderInterface;
use App\Library\Services\TodoService\Factory\ProviderModelFactory;
use App\Models\Task;
use Illuminate\Support\Facades\Http;

class SecondProvider extends BaseProvider implements ProviderInterface
{
    /**
     * @return ProviderInterface
     * @throws \Exception
     */
    public function updateTasksFromAPI(): ProviderInterface
    {
        $factory = ProviderModelFactory::create($this);
        foreach ($this->getTasks() as  $tasks) {
            foreach ($tasks as  $key => $task) {
                Task::updateOrCreate([
                    'remote_id' => $factory['remote_id'] ? $task[$factory['remote_id']] : $key,
                    'provider' => get_class($this)
                ], [
                    'difficulty' => $task[$factory['difficulty'] ?? $key],
                    'hour' => $task[$factory['hour']],
                ]);
            }

        }
        return $this;
    }


    public function getUrl(): string
    {
        return "http://www.mocky.io/v2/5d47f235330000623fa3ebf7";
    }
}
