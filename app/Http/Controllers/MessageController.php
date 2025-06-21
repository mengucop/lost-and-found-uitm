<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class MessageController extends Controller
{
    public function show($itemId, $userId)
{
    $authId = Auth::guard('students')->id();

    // Mark unread messages as read
    Message::where('item_id', $itemId)
        ->where('sender_id', $userId)
        ->where('receiver_id', $authId)
        ->whereNull('read_at')
        ->update(['read_at' => now()]);

    // Fetch all messages for this item and user pair
    $messages = Message::where('item_id', $itemId)
        ->where(function ($query) use ($authId, $userId) {
            $query->where([
                ['sender_id', '=', $authId],
                ['receiver_id', '=', $userId]
            ])->orWhere([
                ['sender_id', '=', $userId],
                ['receiver_id', '=', $authId]
            ]);
        })
        ->orderBy('created_at')
        ->get();

    return view('chat', compact('messages', 'itemId', 'userId'));
}


    public function send(Request $request)
{
    $authId = Auth::guard('students')->id();

    $request->validate([
        'item_id' => 'required',
        'receiver_id' => 'required',
        'message' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('chat_images', 'public');
    }

    // ✅ Log inputs to Laravel log file
    \Log::info('Uploaded Image:', [$request->file('image')]);
    \Log::info('Text Message:', [$request->message]);

    if (!$request->message && !$imagePath) {
        return redirect()->back()->withErrors(['message' => 'Message or image is required.']);
    }

    Message::create([
        'item_id' => $request->item_id,
        'sender_id' => $authId,
        'receiver_id' => $request->receiver_id,
        'message' => $request->message ?? '',
        'image' => $imagePath,
    ]);

    return redirect()->back();
}
public function decision(Request $request, $itemId)
{
    $authEmail = session('student')['email'] ?? null;
    $item = \App\Models\Item::findOrFail($itemId);

    if ($item->from !== $authEmail) {
        return back()->withErrors(['Unauthorized decision.']);
    }

    if ($request->decision === 'approve') {
        $item->status = 'Archived';
    } elseif ($request->decision === 'reject') {
        $item->status = 'Unresolved';
    }

    $item->save();

    return redirect()->route('claim')->with('status', 'Decision recorded.');
}



}

