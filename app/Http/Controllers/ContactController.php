<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;

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
}
