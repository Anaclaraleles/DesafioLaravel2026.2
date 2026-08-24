<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('user')
            ->latest()
            ->paginate(5);
 
        return view('admin.manage-messages', compact('messages'));
    }

    public function create()
    {
        return view('user.message');
    }

    public function store(StoreMessageRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Message::create([
            'user_id' => Auth::id(),
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
        ]);

        return redirect()
            ->route('messages.create')
            ->with('success', 'Mensagem enviada com sucesso! Em breve entraremos em contato.');
    }

    public function reply(Message $message)
    {
        return view('admin.reply-message', compact('message'));
    }
    
    public function replyStore(Request $request, Message $message)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:150'],
            'text' => ['required', 'string', 'max:5000'],
        ]);
 
        $recipientEmail = $request->input('recipient_email', $message->email);
        $recipientName = $request->input('recipient_user', $message->name);
 
        Mail::to($recipientEmail, $recipientName)->send(new Contact([
            'fromName' => auth()->user()->name,
            'fromEmail' => auth()->user()->email,
            'subject' => $data['subject'],
            'message' => $data['text'],
        ]));
 
        $message->update([
            'reply' => $data['text'],
            'replied_by' => Auth::id(),
            'replied_at' => now(),
        ]);
 
        return redirect()
            ->route('messages.index')
            ->with('success', 'Email enviado com sucesso!');
    }
}