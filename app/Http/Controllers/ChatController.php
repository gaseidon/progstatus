<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ChatService;

class ChatController extends Controller
{
    private ChatService $service;

    public function __construct(ChatService $service)
    {
        $this->service = $service;
    }

    public function show()
    {
        $agents = $this->service->getUserAgents();
        return view('chat', compact('agents'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
        $userMessage = $request->input('message');
        $assistantReply = $this->service->sendToExternalAI($userMessage);
        return response()->json(['content' => $assistantReply]);
    }
} 