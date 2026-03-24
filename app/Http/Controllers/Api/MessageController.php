<?php

namespace App\Http\Controllers\Api;

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
        return Message::with(['replies'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = new Message();
        $message->title = $request->title;
        $message->message = $request->message;
        $message->save();

        return $message;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Message::with('replies')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $msg = Message::findOrFail($id);
        $msg->title;
        $msg->message;
        $msg->update();
        return $msg;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Message::destroy($id);
        return ['ok' => true];
    }
}
