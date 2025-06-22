<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAgentRequest;
use App\Services\AgentService;

class AgentController extends Controller
{
    public function __construct(private AgentService $service) {}

    public function create()
    {
        return view('agents');
    }

    public function store(StoreAgentRequest $request)
    {
        $this->service->createAgent($request->validated());
        return redirect()->route('agents')->with('success', 'AI-ассистент успешно создан!');
    }
} 