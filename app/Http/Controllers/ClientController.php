<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('Marketing.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('Marketing.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required',
            'contact_number' => 'required',
            'project_name' => 'required',
            'project_type' => 'required|in:web,mobile',
            'technology' => 'required',
            'reminder_date' => 'nullable|date',
            'note' => 'nullable|string',
            'cost' => 'nullable|numeric',
        ]);

        $validated['status'] = $request->filled('cost') ? 'success' : 'pending';

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        return view('Marketing.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'client_name' => 'required',
            'contact_number' => 'required',
            'project_name' => 'required',
            'project_type' => 'required|in:web,mobile',
            'technology' => 'required',
            'reminder_date' => 'nullable|date',
            'note' => 'nullable|string',
            'cost' => 'nullable|numeric',
        ]);

        $validated['status'] = $request->filled('cost') ? 'success' : 'pending';

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted.');
    }
}