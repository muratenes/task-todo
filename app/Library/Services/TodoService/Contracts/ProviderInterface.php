<?php

namespace App\Library\Services\TodoService\Contracts;

interface ProviderInterface
{
    public function getUrl() : string;

    public function getTasks() : array;

    public function updateTasksFromAPI() : ProviderInterface;
}
