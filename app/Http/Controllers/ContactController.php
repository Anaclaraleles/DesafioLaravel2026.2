<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Mail\Contact;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->filled('user_id')
            ? \App\Models\User::findOrFail($request->query('user_id'))
            : null;

        return view('admin.contact', compact('user'));
    }

    public function store(Request $request){
        $recipientEmail = $request->input('recipient_email'); 
        $recipientName = $request->input('recipient_user');
        
        Mail::to($recipientEmail, $recipientName)->send(new Contact([
            'fromName'  => auth()->user()->name,
            'fromEmail' => auth()->user()->email,
            'subject'   => $request->input('subject'),
            'message'   => $request->input('text'),
        ]));
        
        return back()->with('success', 'Email enviado com sucesso!');
    } 

    public function reply(Message $message)
    {
        return view('admin.manage-messages', compact('message'));
    }
 
    public function replyStore(Request $request, Message $message)
    {
        $data = $request->validate([
            'reply' => ['required', 'string', 'max:5000'],
        ]);
 
        Mail::to($message->email, $message->name)->send(new Contact([
            'fromName' => auth()->user()->name,
            'fromEmail' => auth()->user()->email,
            'subject' => 'Resposta à sua mensagem',
            'message' => $data['reply'],
        ]));
 
        $message->update([
            'reply' => $data['reply'],
            'replied_by' => Auth::id(),
            'replied_at' => now(),
        ]);
 
        return redirect()
            ->route('admin.manage-messages')
            ->with('success', 'Resposta enviada com sucesso!');
    }
}
