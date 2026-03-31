<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use App\Mail\ReplyToUser;
use App\Mail\MessageToEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Reply::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);
        $reply = new Reply();
        $reply->title = $request->title;
        $reply->message = $request->message;
        $reply->email_reply = $request->email_reply;
        $reply->message_id = $request->message_id;
        $reply->user_id = Auth::id() ?? 1;
        $reply->save();

        try {
            Mail::to($request->email_reply)
                ->send(new MessageToEmail([
                    'title'   => $request->title ?? 'Ответ на ваше сообщение',
                    'message' => $request->message,
                ]));

            return response()->json([
                'success' => true,
                'message' => 'Ответ сохранён и отправлен на почту',
                'reply'   => $reply
            ], 201);

        } catch (\Exception $e) {
        \Log::error('Reply Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

        return response()->json([
            'success' => true,
            'message' => 'Ответ сохранён в базу, но письмо не отправлено',
            'error'   => config('app.debug') ? $e->getMessage() : 'Ошибка отправки почты'
        ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Reply::with('messages')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rmg = Reply::findOrFail($id);
        $rmg->title = $request->title;
        $rmg->message = $request->message;
        $rmg->email_reply = $request->email_reply;
        $rmg->message_id = $request->message_id;
        $rmg->update();
        return $rmg;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Reply::destroy($id);
        return ['ok'=>true];
    }
}
