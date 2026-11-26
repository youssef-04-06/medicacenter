<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prescription</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 14px; }
        h1 { margin-bottom: 0; }
        .meta { margin-bottom: 16px; color: #4b5563; }
        .card { border: 1px solid #e5e7eb; padding: 16px; border-radius: 6px; }
        .line { margin: 8px 0; }
    </style>
</head>
<body>
    <h1>HospiBridge Prescription</h1>
    <p class="meta">Generated on {{ now()->format('Y-m-d H:i') }}</p>

    <div class="card">
        <div class="line"><strong>Patient:</strong> {{ $patient->name }} ({{ $patient->email }})</div>
        <div class="line"><strong>Doctor:</strong> {{ $prescription->doctor->name ?? 'N/A' }}</div>
        <div class="line"><strong>Appointment ID:</strong> {{ $appointment->id }}</div>
        <div class="line"><strong>Date:</strong> {{ $appointment->schedule->date ?? 'N/A' }}</div>
        <div class="line"><strong>Time:</strong> {{ $appointment->schedule->start_time ?? 'N/A' }}</div>
    </div>

    <h3>Prescription Details</h3>
    <div class="card" style="white-space: pre-wrap;">{{ $prescription->content }}</div>
</body>
</html>
