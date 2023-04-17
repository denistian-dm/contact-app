<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Session;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contact = Contact::where('user_id', Auth::user()->id)->orderBy('name')->get();

        return Inertia::render('Contact/Index', [
            'contacts' => $contact
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric'
        ]);

        $contact = new Contact($request->all());
        $contact->user()->associate($request->user());
        $contact->save();

        Session::flash('message', 'Success Saved Data');
        Session::flash('severity', 'success');

        return redirect()->route('contact.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric'
        ]);

        $contact->update($request->all());
        Session::flash('message', 'Success Saved Data');
        Session::flash('severity', 'success');

        return redirect()->route('contact.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        Session::flash('message', 'Success Delete Data');
        Session::flash('severity', 'error');

        return redirect()->route('contact.index');
    }
}
