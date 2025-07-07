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
        $user = Auth::user();
        $chats = $user->chats()->with('agent')->get();
        $agents = $this->service->getUserAgents();
        return view('chat', ['agents' => $agents, 'chats' => $chats]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'chat_id' => 'required|exists:chats,id',
        ]);
        $userMessage = $request->input('message');
        $chat = \App\Models\Chat::where('id', $request->chat_id)
            ->where('user_id', Auth::id())
            ->with('agent')
            ->firstOrFail();

        $chat->messages()->create([
            'role' => 'user',
            'content' => $userMessage,
        ]);

        $assistantReply = $this->service->sendToExternalAI($userMessage, $chat);

        $chat->messages()->create([
            'role' => 'assistant',
            'content' => $assistantReply,
        ]);

        return response()->json(['content' => $assistantReply]);
    }

    public function apiCreate(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'agent_id' => 'required|exists:agents,id',
        ]);
        $chat = \App\Models\Chat::create([
            'user_id' => Auth::id(),
            'agent_id' => $request->agent_id,
            'title' => $request->title,
        ]);
        return response()->json(['success' => true, 'chat' => $chat]);
    }

    public function apiMessages(\App\Models\Chat $chat)
    {
        // Проверяем, что чат принадлежит пользователю
        if ($chat->user_id !== Auth::id()) {
            abort(403);
        }
        $messages = $chat->messages()->orderBy('created_at')->get(['role', 'content', 'created_at']);
        return response()->json(['messages' => $messages]);
    }

    public function clearHistory(\App\Models\Chat $chat)
    {
        if ($chat->user_id !== Auth::id()) {
            abort(403);
        }
        $chat->messages()->delete();
        return response()->json(['success' => true]);
    }
} 