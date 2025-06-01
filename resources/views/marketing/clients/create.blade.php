<!DOCTYPE html>
<html>
<head>
    <title>Create Client</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f2ff;
            margin: 0;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #b3d9ff;
        }
        h2 {
            text-align: center;
            color: #007acc;
        }
        label {
            font-weight: bold;
            color: #005c99;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007acc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .success {
            background-color: #d4edda;
            padding: 10px;
            color: green;
            border: 1px solid green;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="{{ route('clients.index') }}" style="text-decoration: none; color: #007acc;">← Back to Client List</a>
    <h2>Create Client</h2>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('clients.store') }}" method="POST">
        @csrf

        <label for="client_name">Client Name:</label>
        <input type="text" name="client_name" required>

        <label for="contact_number">Contact Number:</label>
        <input type="text" name="contact_number" required>

        <label for="project_name">Project Name:</label>
        <input type="text" name="project_name" required>

        <label for="project_type">Project Type:</label>
        <select name="project_type" required>
            <option value="">-- Select Type --</option>
            <option value="web">Web</option>
            <option value="mobile">Mobile</option>
        </select>

        <label for="technology">Technology:</label>
        <input type="text" name="technology" required>

        <label for="reminder_date">Reminder Date:</label>
        <input type="date" name="reminder_date" required>

        <!-- Cost Field -->
        <div class="mb-4">
            <label class="block text-gray-700">Project Cost (LKR)</label>
            <input type="number" name="cost" step="0.01" class="w-full border rounded p-2" placeholder="e.g. 50000.00" value="{{ old('cost') }}">
        </div>

        <!-- Note Field -->
        <div class="mb-4">
            <label class="block text-gray-700">Note</label>
            <textarea name="note" class="w-full border rounded p-2" placeholder="Additional notes...">{{ old('note') }}</textarea>
        </div>

        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>
