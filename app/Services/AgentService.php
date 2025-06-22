<?php

namespace App\Services;

use App\Repositories\AgentRepository;

class AgentService
{
    public function __construct(private AgentRepository $repository) {}

    public function createAgent(array $data)
    {
        $data['tools'] = json_encode($data['tools']);
        $data['interaction'] = json_encode($data['interaction']);
        return $this->repository->create($data);
    }
} 