<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .patient-info { margin-bottom: 20px; }
        .prescription { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Clinic Prescription</h1>
        <h2>{{ $examination->patient->name }}</h2>
    </div>

    <div class="patient-info">
        <p><strong>Patient:</strong> {{ $examination->patient->name }}</p>
        <p><strong>Email:</strong> {{ $examination->patient->email }}</p>
        <p><strong>Phone:</strong> {{ $examination->patient->phone }}</p>
        <p><strong>Date of Birth:</strong> {{ $examination->patient->date_of_birth->format('d/m/Y') }}</p>
        <p><strong>Doctor:</strong> {{ $examination->doctor->name }}</p>
        <p><strong>Date:</strong> {{ $examination->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="prescription">
        <h3>Diagnosis:</h3>
        <p>{{ $examination->diagnosis }}</p>

        <h3>Prescription:</h3>
        <p>{{ $examination->prescription_text }}</p>

        @if($examination->sick_letter)
        <h3>Sick Letter</h3>
        <p>Patient is excused from work/school for medical reasons.</p>
        @endif
    </div>
</body>
</html>
