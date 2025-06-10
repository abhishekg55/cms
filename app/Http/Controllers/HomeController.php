<?php

namespace App\Http\Controllers;

use App\DataTables\ContactDataTable;
use App\Http\Requests\ContactStoreRequest;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;

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
            $contact = Contact::select('name', 'email', 'contact',)->where('id', decrypt($id))->firstOrFail();
            return response()->json(['data' => $contact, 'method' => 'editContactDetail']);
        } catch (Exception $ex) {
            if($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException){
                return response()->json(['message' => 'Contact not found!'], 422);
            }
            return response()->json(['message' => 'Something went wrong!'], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
