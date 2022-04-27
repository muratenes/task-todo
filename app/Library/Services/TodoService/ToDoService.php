<?php

namespace App\Library\Services\TodoService;

class ToDoService
{
    /**
     * update tasks from providers.
     *
     * @param array[ProviderInterface] $providers
     * @return void
     */
    public function updateTasks(array $providers)
    {
        foreach ($providers as $provider) {
            $provider->updateTasksFromAPI();
        }
    }
}
