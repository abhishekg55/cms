<?php

namespace App\Http\Controllers;

use App\DataTables\ContactDataTable;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Models\Contact;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(ContactDataTable $dataTable)
    {
        return $dataTable->render('index');
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
    public function store(ContactStoreRequest $request)
    {

        $messages = null;

        if (isset($request->validator) && $request->validator->fails()) {
            $messages = '<ul class="list list-unstyled">';
            foreach ($request->validator->errors()->all() as $value) {
                $messages .= '<li>' . $value . '</li>';
            }
            $messages .= '</ul>';
            return response()->json(['message' => $messages], 422);
        }

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_image', 'public');
        }

        $additionalFile = null;
        if ($request->hasFile('additional_file')) {
            $additionalFile = $request->file('additional_file')->store('additional_file', 'public');
        }

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'gender' => $request->gender,
            'profile_image' => $imagePath,
            'additional_file' => $additionalFile,
        ]);

        return response()->json(['message' => 'Contact added successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $contact = Contact::select('name', 'email', 'phone', 'gender', 'profile_image', 'additional_file')->where('id', decrypt($id))->firstOrFail();
            $contact['rowid'] = $id;
            return response()->json(['data' => $contact, 'method' => 'editContactDetail']);
        } catch (Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json(['message' => 'Contact not found!'], 422);
            }
            Log::info($ex->getMessage());
            return response()->json(['message' => 'Something went wrong!'], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactUpdateRequest $request)
    {
        $messages = null;

        if (isset($request->validator) && $request->validator->fails()) {
            $messages = '<ul class="list list-unstyled">';
            foreach ($request->validator->errors()->all() as $value) {
                $messages .= '<li>' . $value . '</li>';
            }
            $messages .= '</ul>';

            return response()->json(['message' => $messages], 422);
        }

        try {

            $contact = Contact::where('id', decrypt($request->id))->firstOrFail();

            $imagePath = $contact->profile_image;

            if ($request->hasFile('profile_image')) {
                if (File::exists(storage_path('app/public/' . $contact->profile_image))) {
                    File::delete(storage_path('app/public/' . $contact->profile_image));
                }
                $imagePath = $request->file('profile_image')->store('profile_image', 'public');
            }

            $contact->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'gender' => $request->gender,
                'profile_image' => $imagePath,
            ]);

            return response()->json(['message' => 'Contact Updated successfully!']);
        } catch (Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json(['message' => 'Contact not found!'], 422);
            }
            Log::info($ex->getMessage());
            return response()->json(['message' => 'Something went wrong!'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
