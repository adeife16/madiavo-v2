<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Http\Request;

class ClientContactController extends Controller
{
    // List all contacts for a client
    public function index(Client $client)
    {
        return response()->json([
            'contacts' => $client->contacts
        ]);
    }

    // Create a new contact for a client
    public function store(Request $request, Client $client)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'email' => 'required|email|unique:client_contacts,email',
            'phone' => 'nullable|string',
            'position' => 'nullable|string',
            'is_primary' => 'boolean'
        ]);

        // If is_primary is set, unset other primary contacts for this client
        if (!empty($validated['is_primary']) && $validated['is_primary']) {
            $client->contacts()->update(['is_primary' => false]);
        }

        $contact = $client->contacts()->create($validated);

        return response()->json([
            'message' => 'Contact created successfully',
            'contact' => $contact
        ], 201);
    }

    // Show a single contact
    public function show(Client $client, ClientContact $contact)
    {
        if ($contact->client_id !== $client->id) {
            return response()->json(['message' => 'Contact not found for this client'], 404);
        }

        return response()->json(['contact' => $contact]);
    }

    // Update a contact
    public function update(Request $request, Client $client, ClientContact $contact)
    {
        if ($contact->client_id !== $client->id) {
            return response()->json(['message' => 'Contact not found for this client'], 404);
        }

        $validated = $request->validate([
            'first_name' => 'sometimes|required|string',
            'last_name' => 'nullable|string',
            'email' => 'sometimes|required|email|unique:client_contacts,email,' . $contact->id,
            'phone' => 'nullable|string',
            'position' => 'nullable|string',
            'is_primary' => 'boolean'
        ]);

        // If is_primary is updated to true, unset others
        if (!empty($validated['is_primary']) && $validated['is_primary']) {
            $client->contacts()->update(['is_primary' => false]);
        }

        $contact->update($validated);

        return response()->json([
            'message' => 'Contact updated successfully',
            'contact' => $contact
        ]);
    }

    // Delete a contact
    public function destroy(Client $client, ClientContact $contact)
    {
        if ($contact->client_id !== $client->id) {
            return response()->json(['message' => 'Contact not found for this client'], 404);
        }

        $contact->delete();

        return response()->json(['message' => 'Contact deleted successfully']);
    }
}
