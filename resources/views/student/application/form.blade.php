@extends('layouts.master')
@section('title', 'Application for Residency')
@section('content')
<form method="POST" action="{{ route('student.application.store') }}">
@csrf
<!DOCTYPE html>
<html lang="en-PH">
<head>
    <meta charset="UTF-8">
    <title>Application for Residency</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Cambria, serif;
            font-size: 11pt;
            margin: 0;
            line-height: 1.5;
        }
        .form-border {
            border: 1px solid #000;
            padding: 40px;
            margin: 20px auto;
            max-width: 800px;
            background: white;
        }
        p { margin: 0 0 12px; }
        .center { text-align: center; }
        .right { text-align: right; }
        .checkbox-list { list-style: none; padding-left: 0; margin-top: 10px; }
        .checkbox-list li { margin-bottom: 5px; }
        .truly { text-align: right; margin-right: 160px; }
        .short-input {
            width: 120px;
            border: none;
            border-bottom: 1px solid #000;
            text-align: center;
        }
        .signature-input {
            width: 230px;
            border: none;
            border-bottom: 1px solid #000;
            text-align: center;
            display: block;
            margin-left: auto;
        }
        .signature-label {
            text-align: right;
            margin-top: -5px;
            margin-right: 20px;
            font-size: 11pt;
        }
        .label-course {
            text-align: right;
            margin-top: -5px;
            margin-right: 35px;
            font-size: 11pt;
        }
        .label-name {
            text-align: right;
            margin-top: -5px;
            margin-right: 95px;
            font-size: 11pt;
        }
        .label-address {
            text-align: right;
            margin-top: -5px;
            margin-right: 90px;
            font-size: 11pt;
        }
        .label-contact {
            text-align: right;
            margin-top: -5px;
            margin-right: 60px;
            font-size: 11pt;
        }
         .rights { 
            text-align: right;
            margin-right: 40px; }
        .flex-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        .approved {
            text-align: right;
            margin-right: 160px;
        }
        .course-year-section {
            text-align: right;
            margin-top: -5px;
            font-size: 11pt;
            gap: 5px; 
        }

        .course-year-section input {
            width: 109px;
        }

        .course-year-section span {
            font-weight: bold;
            font-size: 14pt;
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

    <p class="center"><strong>OFFICE OF STUDENTS AFFAIRS & SERVICES</strong></p>
    <p class="center"><strong>Application for Residency</strong></p>
    <p class="center">(Good for one term/Semester Only)</p>
    <p>The Dormitory In-Charge</p>
    <p>Office of Students Affairs & Services</p>
    <p>SLSU-Bontoc Campus, Bontoc, So. Leyte</p>
    <p>Madame:</p>

    <p style="text-indent: 36pt;">
        The undersigned wishes to apply as occupant/resident in the SLSU Dormitory during the semester of SY
       <select name="school_year" class="short-input" required>
            <option value="">Select SY</option>
            @foreach ($schoolYears as $year)
                @php
                    $sy_display = $year->format('Y') . ' - ' . $year->copy()->addYear()->format('Y');
                @endphp
                <option value="{{ $year->toDateString() }}" {{ old('school_year', optional($application)->school_year) == $year->toDateString() ? 'selected' : '' }}>
                    {{ $sy_display }}
                </option>
            @endforeach
        </select>.
                I am fully aware of the terms and conditions relative to dormitory occupancy and those stipulated in the contract.
        </p>

    <p class="truly">Very truly yours,</p>
    <input type="text" name="full_name" value="{{ old('full_name', Auth::user()->name) }}" class="signature-input" required>
    <p class="signature-label">Signature over printed name</p>
    <div class="course-year-section">
       <!-- Course Dropdown -->
<select name="course" class="long-input" required>
    <option value="">Select Course</option>
    <option value="BSIT" {{ old('course', optional($application)->course) == 'BSIT' ? 'selected' : '' }}>
        BSIT
    </option>
    <option value="BSMB" {{ old('course', optional($application)->course) == 'BSMB' ? 'selected' : '' }}>
        BSMB
    </option>
    <option value="BSA" {{ old('course', optional($application)->course) == 'BSA' ? 'selected' : '' }}>
        BSA
    </option>
    <option value="BSFI" {{ old('course', optional($application)->course) == 'BSFI' ? 'selected' : '' }}>
        BSFI
    </option>
</select>

<!-- Year Section Dropdown -->
<select name="year_section" class="short-input" required>
    <option value="">Select Year & Section</option>
    @foreach ([1,2,3,4] as $year)
        @foreach (['A','B','C'] as $section)
            @php $value = $year . $section; @endphp
            <option value="{{ $value }}" {{ old('year_section', optional($application)->year_section) == $value ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    @endforeach
</select>

    </div>
    <p class="label-course">Course / Year / Section</p>

    <!-- EMERGENCY CONTACT SECTION -->
    <div class="d-flex justify-content-between align-items-start mt-4">
        <p class="pt-2">In case of emergency, please contact:</p>
        <div class="text-end">
            <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" class="signature-input" required>
            <p class="label-name">Name</p>
            <input type="text" name="emergency_contact_address" value="{{ old('emergency_contact_address') }}" class="signature-input" required>
            <p class="label-address">Address</p>
            <input type="text" name="emergency_contact_number" value="{{ old('emergency_contact_number') }}" class="signature-input" required>
            <p class="label-contact">Contact Number</p>
        </div>
    </div>

    <!-- STATUS RADIO -->
    <div class="mt-1" style="text-align: left;">
        <p style="vertical-align: top; margin-right: 10px;">Please check your present status:</p>
        <ul class="checkbox-list" style="display: inline-block;">
            <li><input type="radio" name="present_status" value="new_student" {{ old('present_status') == 'new_student' ? 'checked' : '' }} required> New student / new applicant</li>
            <li><input type="radio" name="present_status" value="old_new" {{ old('present_status') == 'old_new' ? 'checked' : '' }}> Old student but new applicant</li>
            <li><input type="radio" name="present_status" value="returnee" {{ old('present_status') == 'returnee' ? 'checked' : '' }}> Old student / returnee</li>
        </ul>
    </div>

    <!-- NOTED & APPROVED -->
    <p class="mt-4">Noted:</p>
    <p><strong><u>BASILIDES O. GERALDO</u></strong><br>
    Cashier/Disbursing Officer</p>

    <p class="approved">APPROVED:</p>
    <p class="rights"><strong><u>PETER JUNE D. DADIOS, PhD</u></strong></p>
    <p class="right">Head, Student and Auxiliary Services</p>

    <!-- FOOTER IMAGES -->
    <div class="flex-footer">
        <img src="{{ asset('images/footerl.png') }}" alt="Footer Left" style="height: 60px; object-fit: contain; margin-top: 15px;">
        <img src="{{ asset('images/footerr.png') }}" alt="Footer Right" style="height: 90px; object-fit: contain;">
    </div>
</div>

<!-- OUTSIDE SUBMIT BUTTONS -->
<div class="no-print text-end mt-4">
    <button type="submit" class="btn btn-success">Submit Application</button>
    <button type="button" class="btn btn-outline-primary" onclick="window.print()">🖨️ Print</button>
</div>

</body>
</html>
</form>
@endsection

