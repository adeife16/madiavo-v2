<?php

namespace App\Http\Controllers;

use App\Imports\ClientsImport;
use App\Models\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        return response()->json(Client::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'nullable|string|max:191',
            'phonenumber' => 'nullable|string|max:30',
            'vat' => 'nullable|string|max:50',
            'country' => 'required|integer',
            'city' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:15',
            'state' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:191',
            'website' => 'nullable|string|max:150',
            'billing_street' => 'nullable|string|max:200',
            'billing_city' => 'nullable|string|max:100',
            'billing_state' => 'nullable|string|max:100',
            'billing_zip' => 'nullable|string|max:100',
            'billing_country' => 'nullable|integer',
            'shipping_street' => 'nullable|string|max:200',
            'shipping_city' => 'nullable|string|max:100',
            'shipping_state' => 'nullable|string|max:100',
            'shipping_zip' => 'nullable|string|max:100',
            'shipping_country' => 'nullable|integer',
            'group_id' => 'nullable|integer',

            // Add other fields as needed
        ]);

        $validated['datecreated'] = now();

        $client = Client::create($validated);

        return response()->json([
            'message' => 'Client added successfully',
            'client' => $client,
        ], 201);
    }

    public function importFromCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls',
        ]);

        $import = new ClientsImport;
        Excel::import($import, $request->file('file'));

        if (! empty($import->imported)) {
            DB::table('clients')->insert($import->imported);
        }

        return response()->json([
            'message' => 'Import completed',
            'imported' => count($import->imported),
            'failed' => $import->errors,
        ]);
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);

        return response()->json($client);
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->update($request->all());

        return response()->json([
            'message' => 'Client updated successfully',
            'client' => $client,
        ]);
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json([
            'message' => 'Client deleted successfully'
        ]);
    }
}
