@extends('layouts.master')
@section('title', 'Dormitory Agreement Form')
@section('content')
<form method="POST" action="{{ route('student.agreement.store') }}">
@csrf
<!DOCTYPE html>
<html lang="en-PH">
<head>
    <meta charset="UTF-8">
    <title>Dormitory Agreement Form</title>
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
        p {
            margin: 0 0 12px;
        }
        .center {
            text-align: center;
        }
        .right {
            text-align: right;
        }
        .rights { 
            text-align: right;
            margin-right: 40px; }
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
            margin-top: 0px;
            margin-right: 20px;
            font-size: 11pt;
        }
        .approved {
            text-align: right;
            margin-right: 160px;
        }
        .flex-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
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
     @php
        $application = auth()->user()->applicationForm;
    @endphp
    <p class="center"><strong>SLSU Dormitory Agreement</strong></p>

    <p style="text-align:justify;">
    <span style="width:36pt; font-family:Cambria; display:inline-block;">&nbsp;</span>
    <span style="font-family:Cambria;">
        I, 
        <input type="text" name="student_name" value="{{ old('full_name', Auth::user()->name) }}" style="border:none; border-bottom:1px solid #000; width:230px; text-align:center" required>, 
        <input type="text" name="year_section" value="{{ old('year_section', $application->year_section) }}" style="border:none; border-bottom:1px solid #000; width:80px;text-align:center" required>, 
        of 
        <input type="text" name="course" value="{{ old('course', $application->course) }}" style="border:none; border-bottom:1px solid #000; width:180px;text-align:center" required> 
        do hereby agree and conform to the following conditions of the privileges granted to me by the school authorities to reside in the SLSU dormitory.
    </span>
</p>


        <ol style="margin:0pt; padding-left:0pt;">
            <li class="ListParagraph" style="margin-left:49.35pt; margin-bottom:0pt; text-align:justify; line-height:115%; padding-left:4.65pt; font-family:Cambria;">That I shall abide by the dormitory rules, regulation or injunctions promulgated verbally or in writing by the authorities concerned.</li>
            <li class="ListParagraph" style="margin-left:49.35pt; margin-bottom:0pt; text-align:justify; line-height:115%; padding-left:4.65pt; font-family:Cambria;">That I shall pay my dormitory fee promptly and failure to pay for two (2) consecutive months means cancellation of the privilege to stay in the dormitory.</li>
            <li class="ListParagraph" style="margin-left:49.35pt; margin-bottom:0pt; text-align:justify; line-height:115%; padding-left:4.65pt; font-family:Cambria;">That I shall pay the association fee of <span style="text-decoration:line-through;">P</span>10.00 and submit the necessary documents or requirements before I could qualify to reside in the dormitory.</li>
            <li class="ListParagraph" style="margin-left:49.35pt; margin-bottom:0pt; text-align:justify; line-height:115%; padding-left:4.65pt; font-family:Cambria;">That I shall settle all my financial obligations to the dormitory on or before the final examinations of the current semester.</li>
            <li class="ListParagraph" style="margin-left:49.35pt; margin-bottom:0pt; text-align:justify; line-height:115%; padding-left:4.65pt; font-family:Cambria;">That I shall recognize the right of the dormitory authorities to inspect my room, locker or closet and personal belongings when circumstances warrant so.</li>
            <li class="ListParagraph" style="margin-left:49.35pt; margin-bottom:0pt; text-align:justify; line-height:115%; padding-left:4.65pt; font-family:Cambria;">That if I decide to leave the dormitory before the end of semester, I am obliged to pay 50% of the residence fee/rental for the remaining months of the semester.</li>
            <li class="ListParagraph" style="margin-left:49.35pt; margin-bottom:0pt; text-align:justify; line-height:115%; padding-left:4.65pt; font-family:Cambria;">That I shall help maintain the cleanliness &amp; upkeep of the dormitory and its surroundings at all times.</li>
            <li class="ListParagraph" style="margin-left:49.35pt; margin-bottom:0pt; text-align:justify; line-height:115%; padding-left:4.65pt; font-family:Cambria;">In case of dismissal or expulsion from the dormitory, I shall forfeit whatever amount I shall have paid as dormitory fee or rental or in case I vacate the dormitory voluntarily.</li>
            <li class="ListParagraph" style="margin-left:49.35pt; text-align:justify; line-height:115%; padding-left:4.65pt; font-family:Cambria;">That I shall be willing to accept whatever penalty the management or school authorities impose upon me and shall conform to the decision of the same for any violation or infraction of the dormitory rules and regulations.</li>
        </ol>
     <p style="margin-bottom:0pt; text-indent:36pt; text-align:justify;">
        <span style="font-family:Cambria;">
            In witness whereof, I hereby affix my signature on this 
            {{ now()->format('jS \\of F Y') }}
            at SLSU - Bontoc Campus, San Ramon, Bontoc, Southern Leyte.
        </span>
        @if (isset($agreement))
            <input type="hidden" name="date_signed" value="{{ $agreement->date_signed }}">
        @else
            <input type="hidden" name="date_signed" value="{{ now()->toDateString() }}">
        @endif
    </p>
    <input type="text" class="signature-input">
    <p class="signature-label">Signature of Applicant</p>
        <!-- NOTED & APPROVED -->
    <p class="mt-4">Recommending Approval:</p>
    <p><strong><u>BASILIDES O. GERALDO</u></strong><br>
    Cashier/Disbursing Officer</p>

    <p class="approved">APPROVED:</p>
    <p class="rights"><strong><u>PETER JUNE D. DADIOS, PhD</u></strong></p>
    <p class="right">Head, Student and Auxiliary Services</p>



    <div class="flex-footer">
        <img src="{{ asset('images/footerl.png') }}" alt="Footer Left" style="height: 60px;">
        <img src="{{ asset('images/footerr.png') }}" alt="Footer Right" style="height: 90px;">
    </div>
</div>
<div class="no-print text-end mt-4">
    <button type="submit" class="btn btn-success">Submit Agreement</button>
    <button type="button" class="btn btn-outline-primary" onclick="window.print()">🖨️ Print</button>
</div>
</body>
</html>
</form>
@endsection

