<?php

namespace App\Http\Controllers;

use App\DataTables\CustomFieldDataTable;
use App\Http\Requests\CustomFieldCreateRequest;
use App\Http\Requests\CustomFieldUpdateRequest;
use App\Models\CustomField;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CustomFieldDataTable $dataTable)
    {
        return $dataTable->render('custom-fields.index');
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
    public function store(CustomFieldCreateRequest $request)
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

        CustomField::create($request->validated());

        return response()->json(['message' => 'custom Field added successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomField $customField)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $customField = CustomField::select('field_name', 'field_type', 'status')->where('id', decrypt($id))->firstOrFail();
            $customField['rowid'] = $id;
            return response()->json(['data' => $customField, 'method' => 'editCustomFieldDetail']);
        } catch (Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json(['message' => 'Data not found!'], 422);
            }
            Log::info($ex->getMessage());
            return response()->json(['message' => 'Something went wrong!'], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomFieldUpdateRequest $request)
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

            $customField = CustomField::where('id', decrypt($request->id))->firstOrFail();

            $customField->update($request->validated());

            return response()->json(['message' => 'Custom Field Updated successfully!']);
        } catch (Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json(['message' => 'Data not found!'], 422);
            }
            Log::info($ex->getMessage());
            return response()->json(['message' => 'Something went wrong!'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomField $customField)
    {
        //
    }

    public function getCustomFields()
    {
        $customFields = CustomField::where('status', true)->orderBy('field_name')->get();

        $html = '<select class="form-control select" name="field_names[]" data-placeholder="Select Field Name"> <option></option>';
        foreach ($customFields as $key => $value) {

            $html .= '<option value="' . encrypt($value['id']) . '">' . $value['field_name'] . '</option>';
        }
        $html .= '</select>';
        return response()->json(['data' => $html]);
    }
}
