<?php

namespace App\Services;

use App\Repositories\AgentRepository;

class AgentService
{
    public function __construct(private AgentRepository $repository) {}

    public function createAgent(array $data)
    {
        $data['tools'] = json_encode($data['tools'], JSON_UNESCAPED_UNICODE);
        $data['interaction'] = json_encode($data['interaction'], JSON_UNESCAPED_UNICODE);
        return $this->repository->create($data);
    }
} 