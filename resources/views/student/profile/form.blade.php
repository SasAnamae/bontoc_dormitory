@extends('layouts.master')
@section('title', 'Occupant Profile')
@section('content')

<form method="POST" action="{{ route('student.profile.store') }}">
@csrf

<!DOCTYPE html>
<html lang="en-PH">
<head>
    <meta charset="UTF-8">
    <title>Occupant Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Cambria, serif;
            font-size: 11pt;
            margin: 0;
            line-height: 1.5;
        }
        .center {
            text-align: center;
        }
        .form-border {
            border: 1px solid #000;
            padding: 40px;
            margin: 20px auto;
            max-width: 800px;
            background: white;
        }
        p, td, th {
            margin: 0;
        }
        input {
            border: none;
            border-bottom: 1px solid #000;
            font-family: Cambria, serif;
            font-size: 11pt;
        }
        .input-line {
            width: 200px;
        }
        .input-wide {
            width: 300px;
        }
        .signature{
            text-align: right;
            margin-top: -5px;
            margin-right: 20px;
            font-size: 11pt;
        }
        .signature-input {
            width: 250px;
            border-bottom: 1px solid #000;
            text-align: center;
            margin-top: 30px;
        }
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .schedule-table th, .schedule-table td {
            border: 1px solid #000;
            text-align: center;
            padding: 4px;
        }
        .flex-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
         .course-year-section {
            text-align: center;
            margin-top: -5px;
            font-size: 11pt;
            gap: 5px; 
        }
        .input-short {
            text-align: center;
            width: 60px;
            border: none;
            border-bottom: 1px solid #000;
            font-family: Cambria, serif;
            font-size: 11pt;
        }

        @media print {
            body { margin: 0.5in; }
            input, select { border: none !important; }
            button, .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="form-border">
    <div class="center">
        <img src="{{ asset('images/header.png') }}" alt="Header" style="width: 100%; max-width: 700px;">
    </div>
    <p class="center"><strong>SLSU DORMITORY</stron  g></p>
    <p class="center"><strong>OCCUPANT’S PROFILE & CLASS SCHEDULE</strong></p>

    <table style="width: 100%; margin-top: 20px;">
        @php
            $application = auth()->user()->applicationForm;
        @endphp
        <tr>
            <td>Occupant's Name: <input type="text" name="full_name" value="{{ auth()->user()->name }}" required></td>
            <td colspan="2">
                Course & Section:
                <input type="text" name="course" value="{{ old('course', $application->course ?? '') }}" class="input-short" placeholder="Course" required>
                -
                <input type="text" name="year_section" value="{{ old('year_section', $application->year_section ?? '') }}" class="input-short" placeholder="Year/Section" required>
            </td>

        </tr>
        <tr>
            <td>Home Address: <input type="text" name="home_address" value="{{ old('home_address', $profile->home_address ?? '') }}" class="input-wide" required></td>
        </tr>
        <tr>
            <td>Cellphone Number: <input type="text" name="cellphone" value="{{ old('cellphone', $profile->cellphone ?? '') }}" class="input-line" required></td>
            <td>Email Address: <input type="email" name="email" value="{{ auth()->user()->email }}" class="input-line"></td>
        </tr>
        <tr>
            <td>Birthday: <input type="date" name="birthday" value="{{ old('birthday', $profile->birthday ?? '') }}" class="input-line"></td>
            <td>Age: <input type="number" name="age" value="{{ old('age', $profile->age ?? '') }}" class="input-line"></td>
        </tr>
        <tr>
            <td>Religion: <input type="text" name="religion" value="{{ old('religion', $profile->religion ?? '') }}" class="input-line"></td>
            <td>Scholarship: <input type="text" name="scholarship" value="{{ old('scholarship', $profile->scholarship ?? '') }}" class="input-line"></td>
        </tr>
        <tr>
            <td>Blood Type: <input type="text" name="blood_type" value="{{ old('blood_type', $profile->blood_type ?? '') }}" class="input-line"></td>
            <td>Allergies: <input type="text" name="allergies" value="{{ old('allergies', $profile->allergies ?? '') }}" class="input-line"></td>
        </tr>
    </table>

    <p style="margin-top: 20px;"><strong>Parents:</strong></p>
    <table style="width: 100%;">
        <tr>
            <td>Father: <input type="text" name="father_fullname" value="{{ old('father_fullname', $profile->father_fullname ?? '') }}" class="input-line"></td>
            <td>Cellphone No.: <input type="text" name="father_phone" value="{{ old('father_phone', $profile->father_phone ?? '') }}" class="input-line"></td>
        </tr>
        <tr>
            <td>Mother: <input type="text" name="mother_fullname" value="{{ old('mother_fullname', $profile->mother_fullname ?? '') }}" class="input-line"></td>
            <td>Cellphone No.: <input type="text" name="mother_phone" value="{{ old('mother_phone', $profile->mother_phone ?? '') }}" class="input-line"></td>
        </tr>
    </table>
    
<p style="margin-top: 20px;"><strong>Electrical Gadget/Appliances in the Dorm:</strong></p>
<ul style="margin-left: 20px;">
    <li><input type="text" name="electrical_appliances[]" value="{{ old('electrical_appliances.0', $profile->electrical_appliances_array[0] ?? '') }}" class="input-line"></li>
    <li><input type="text" name="electrical_appliances[]" value="{{ old('electrical_appliances.1', $profile->electrical_appliances_array[1] ?? '') }}" class="input-line"></li>
    <li><input type="text" name="electrical_appliances[]" value="{{ old('electrical_appliances.2', $profile->electrical_appliances_array[2] ?? '') }}" class="input-line"></li>
</ul>




    <p>Total Payable Monthly: <input type="text" name="total_monthly" value="{{ old('total_monthly', $profile->monthly_payable ?? '') }}" class="input-line"></p>

    <p class="signature" style="margin-top: 30px;">
        I hereby certify that the above information is true and correct.
    </p>
    <div class="signature">
        <input type="text" class="signature-input">
        <p>Signature of Occupant</p>
    </div>

    <div class="flex-footer">
        <img src="{{ asset('images/footerl.png') }}" alt="Footer Left" style="height: 60px;">
        <img src="{{ asset('images/footerr.png') }}" alt="Footer Right" style="height: 90px;">
    </div>
</div>



<div class="no-print text-end mt-4">
    <button type="submit" class="btn btn-success">Save Profile</button>
    <button type="button" class="btn btn-outline-primary" onclick="window.print()">🖨️ Print</button>
</div>

</body>
</html>
</form>

@endsection

