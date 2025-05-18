<?php

namespace App\Http\Controllers;

use App\Imports\LeadsImport;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class LeadController extends Controller
{
    public function index()
    {
        return response()->json(Lead::with('assignedStaff')->latest()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'position' => 'nullable|string',
            'company' => 'nullable|string',
            'website' => 'nullable|url',
            'tags' => 'nullable|string',
            'value' => 'nullable|numeric',
            'assigned_to' => 'nullable|exists:users,id',
            'source' => 'nullable|exists:leads_source,id',
            'country' => 'nullable|exists:countries,id',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip' => 'nullable|string',
            'status' => 'nullable|string',
            'description' => 'nullable|string',
            'converted_to_client' => 'nullable|boolean',
            'contacted_at' => 'nullable|date',
            'language' => ['nullable', Rule::in(['English', 'Lithuanian', 'Default'])],
            'is_public' => ['nullable', Rule::in(['Yes', 'No'])],
        ]);

        $lead = Lead::create($data);

        return response()->json($lead, 201);
    }

    public function show(Lead $lead)
    {
        return response()->json($lead->load('assignedStaff'));
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'position' => 'nullable|string',
            'company' => 'nullable|string',
            'website' => 'nullable|url',
            'tags' => 'nullable|string',
            'value' => 'nullable|numeric',
            'assigned_to' => 'nullable|exists:users,id',
            'source' => 'nullable|exists:leads_source,id',
            'country' => 'nullable|exists:countries,id',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip' => 'nullable|string',
            'status' => 'nullable|string',
            'description' => 'nullable|string',
            'converted_to_client' => 'nullable|boolean',
            'contacted_at' => 'nullable|date',
            'language' => ['nullable', Rule::in(['English', 'Lithuanian', 'Default'])],
            'is_public' => ['nullable', Rule::in(['Yes', 'No'])],
        ]);

        $lead->update($data);

        return response()->json($lead);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return response()->json(['message' => 'Lead deleted']);
    }

    public function import(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|file|mimes:csv,xlsx,xls',
        // ]);

        Excel::import(new LeadsImport, $request->file('file'));

        return response()->json(['message' => 'Leads imported successfully']);
    }
}
