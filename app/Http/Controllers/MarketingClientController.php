<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;

class MarketingClientController extends Controller
{
    // Dashboard page
    public function dashboard()
    {
        return view('marketing.dashboard');
    }

    // View all clients
    public function index()
    {
        $clients = Client::orderBy('created_at', 'desc')->get();
        return view('marketing.clients.index', compact('clients'));
    }

    // Show create client form
    public function create()
    {
        return view('marketing.clients.create');
    }

    // Store new client
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'project_name' => 'nullable|string|max:255',
            'project_type' => 'nullable|in:Web,Mobile',
            'technology' => 'nullable|string|max:255',
            'reminder_date' => 'nullable|date',
            'note' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'payment_status' => 'required|in:No Payment,Advance,Full',
        ]);

        // Auto-set status based on payment_status
        $validated['status'] = in_array($validated['payment_status'], ['Advance', 'Full']) ? 'active' : 'inactive';

        Client::create($validated);

        return redirect()->route('marketing.clients.index')->with('success', 'Client added successfully!');
    }

    // Show edit form
    public function edit(Client $client)
    {
        return view('marketing.clients.edit', compact('client'));
    }

    // Update client
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'project_name' => 'nullable|string|max:255',
            'project_type' => 'nullable|in:Web,Mobile',
            'technology' => 'nullable|string|max:255',
            'reminder_date' => 'nullable|date',
            'note' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'payment_status' => 'required|in:No Payment,Advance,Full',
        ]);

        // Auto-set status based on payment_status
        $validated['status'] = in_array($validated['payment_status'], ['Advance', 'Full']) ? 'active' : 'inactive';

        $client->update($validated);

        return redirect()->route('marketing.clients.index')->with('success', 'Client updated successfully!');
    }

    // Delete client
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('marketing.clients.index')->with('success', 'Client deleted successfully!');
    }

    // Filter by status
    public function status($type)
    {
        $clients = Client::where('status', $type)->get();
        return view('marketing.clients.index', compact('clients'));
    }

    // Clients with reminder dates
    public function reminders()
    {
        $clients = Client::whereNotNull('reminder_date')
                         ->orderBy('reminder_date', 'asc')
                         ->get();

        return view('marketing.clients.reminders', compact('clients'));
    }
}
