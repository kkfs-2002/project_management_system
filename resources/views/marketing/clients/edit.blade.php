<!DOCTYPE html>
<html>
<head>
    <title>Edit Client</title>
    <style>
        body { font-family: Arial; background-color: #e6f2ff; padding: 40px; }
        .container { max-width: 600px; background: white; padding: 30px; border-radius: 10px; margin: auto; box-shadow: 0 0 10px #b3d9ff; }
        h2 { text-align: center; color: #007acc; }
        label { display: block; margin-top: 10px; color: #005c99; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #007acc; color: white; padding: 10px 20px; border: none; border-radius: 5px; margin-top: 20px; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('clients.index') }}" style="color: #007acc;">← Back</a>
    <h2>Edit Client</h2>
    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf @method('PUT')

        <label>Client Name</label>
        <input type="text" name="client_name" value="{{ $client->client_name }}" required>

        <label>Contact Number</label>
        <input type="text" name="contact_number" value="{{ $client->contact_number }}" required>

        <label>Project Name</label>
        <input type="text" name="project_name" value="{{ $client->project_name }}" required>

        <label>Project Type</label>
        <select name="project_type" required>
            <option value="web" {{ $client->project_type == 'web' ? 'selected' : '' }}>Web</option>
            <option value="mobile" {{ $client->project_type == 'mobile' ? 'selected' : '' }}>Mobile</option>
        </select>

        <label>Technology</label>
        <input type="text" name="technology" value="{{ $client->technology }}" required>

        <label>Reminder Date</label>
        <input type="date" name="reminder_date" value="{{ $client->reminder_date }}" required>

        <label>Cost</label>
        <input type="number" name="cost" step="0.01" value="{{ old('cost', $client->cost) }}" class="w-full border rounded p-2">

        <label>Note</label>
        <textarea name="note" class="w-full border rounded p-2">{{ old('note', $client->note) }}</textarea>

        <button type="submit">Update Client</button>
    </form>
</div>
</body>
</html>
