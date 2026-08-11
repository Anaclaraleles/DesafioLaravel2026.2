<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request){
        // $recipientEmail = $request->input('recipient_email'); 
        // $recipientName = $request->input('recipient_user');
        
        $sent = Mail::to('ana@gmail.com', 'ana')->send(new Contact([
                'fromName' => $request->input('name'),
                'fromEmail' => $request->input('email'),
                'subject' => $request->input('subject'),
                'message' => $request->input('message'),
            ]));
        var_dump('email sent', $sent);
    } 
}
