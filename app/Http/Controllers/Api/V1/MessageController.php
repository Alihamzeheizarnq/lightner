<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::latest()->get();

        return apiResponse()
            ->data($messages)
            ->send();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'link' => ['nullable', 'string'],
        ]);

        $message = Message::create($validated);

        return apiResponse()
            ->data($message)
            ->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        return apiResponse()
            ->data($message)
            ->send();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'link' => ['nullable', 'string'],
        ]);

        $message->update($validated);

        return apiResponse()
            ->data($message)
            ->send();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $status = $message->delete();

        return apiResponse()
            ->data([
                'deleted' => $status,
            ])
            ->send();
    }
}
