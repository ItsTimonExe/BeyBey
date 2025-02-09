<?php

        namespace App\Http\Controllers\Admin;

        use App\Http\Controllers\Controller;
        use App\Models\Contact;
        use Inertia\Inertia;
        use Illuminate\Http\Request;

        class AdminContact extends Controller
        {
            public function index()
            {
                $contacts = Contact::all();
                return Inertia::render('Admin/Contact/Index', [
                    'contacts' => $contacts
                ]);
            }

            public function show($id)
            {
                $contact = Contact::findOrFail($id);
                return Inertia::render('Admin/Contact/Show', [
                    'contact' => $contact
                ]);
            }

            public function store(Request $request)
            {
                $contact = Contact::create($request->all());
                return redirect()->route('admin.contacts.index');
            }

            public function update(Request $request, $id)
            {
                $contact = Contact::findOrFail($id);
                $contact->update($request->all());
                return redirect()->route('admin.contacts.index');
            }

            public function destroy($id)
            {
                Contact::destroy($id);
                return redirect()->route('admin.contacts.index');
            }
        }
