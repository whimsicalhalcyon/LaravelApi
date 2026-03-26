<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $reply = new Reply();
        $reply->title = $request->title;
        $reply->message = $request->message;
        $reply->email_reply = $request->email_reply;
        $reply->message_id = $request->message_id;
        $reply->user_id = Auth::id();
        $reply->save();
        return $reply;
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
