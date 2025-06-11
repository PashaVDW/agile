<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\Request;

class newsletterController extends Controller
{
    private MailService $mailService;
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }
    public function index()
    {
        return view('admin.newsletter.index');
    }

    public function sendNewsletter(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:10240',
        ]);

        $pdf = $request->file('pdf');

        // verander dit naar wat ander zodra je kan inschrijven
        $recepients = User::all()->pluck('email')->toArray();
        //
        $this->mailService->sendNewsletter($recepients, $pdf);

        return back()->with('success', 'Nieuwsbrief verzonden!');
    }
}
