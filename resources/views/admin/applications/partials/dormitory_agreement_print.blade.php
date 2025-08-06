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
<div class="form-border">
    <div class="center">
        <img src="{{ asset('images/header.png') }}" alt="Header" style="width: 100%; max-width: 700px;">
    </div>
    @if ($agreement)
    
    <p class="center"><strong>SLSU Dormitory Agreement</strong></p>

    <p style="text-align:justify;">
        <span style="font-family:Cambria;">
            I, 
            <strong><u>{{ $agreement->student_name }}</u></strong>, 
            <strong><u>{{ $agreement->year_section }}</u></strong> of 
            <strong><u>{{ $agreement->course }}</u></strong> 
            do hereby agree and conform to the following conditions of the privileges granted to me by the school authorities to reside in the SLSU dormitory.
        </span>
    </p>

    <ol style="margin:0pt; padding-left:0pt;">
        <li style="margin-left:50px; text-align:justify;">That I shall abide by the dormitory rules, regulation or injunctions promulgated verbally or in writing by the authorities concerned.</li>
        <li style="margin-left:50px; text-align:justify;">That I shall pay my dormitory fee promptly and failure to pay for two (2) consecutive months means cancellation of the privilege to stay in the dormitory.</li>
        <li style="margin-left:50px; text-align:justify;">That I shall pay the association fee of <span style="text-decoration:line-through;">P</span>10.00 and submit the necessary documents or requirements before I could qualify to reside in the dormitory.</li>
        <li style="margin-left:50px; text-align:justify;">That I shall settle all my financial obligations to the dormitory on or before the final examinations of the current semester.</li>
        <li style="margin-left:50px; text-align:justify;">That I shall recognize the right of the dormitory authorities to inspect my room, locker or closet and personal belongings when circumstances warrant so.</li>
        <li style="margin-left:50px; text-align:justify;">That if I decide to leave the dormitory before the end of semester, I am obliged to pay 50% of the residence fee/rental for the remaining months of the semester.</li>
        <li style="margin-left:50px; text-align:justify;">That I shall help maintain the cleanliness &amp; upkeep of the dormitory and its surroundings at all times.</li>
        <li style="margin-left:50px; text-align:justify;">In case of dismissal or expulsion from the dormitory, I shall forfeit whatever amount I shall have paid as dormitory fee or rental or in case I vacate the dormitory voluntarily.</li>
        <li style="margin-left:50px; text-align:justify;">That I shall be willing to accept whatever penalty the management or school authorities impose upon me and shall conform to the decision of the same for any violation or infraction of the dormitory rules and regulations.</li>
    </ol>

    <p style="text-align:justify; text-indent:36pt;">
        <span style="font-family:Cambria;">
            In witness whereof, I hereby affix my signature on this 
            {{ \Carbon\Carbon::parse($agreement->date_signed)->format('jS \\of F Y') }}
            at SLSU - Bontoc Campus, San Ramon, Bontoc, Southern Leyte.
        </span>
    </p>

    <p class="signature-input" style="border-bottom:1px solid #000; width:230px; margin-left:auto; margin-right:0;">&nbsp;</p>
    <p class="signature-label">Signature of Applicant</p>

    <p class="mt-4">Recommending Approval:</p>
    <p><strong><u>BASILIDES O. GERALDO</u></strong><br>Cashier/Disbursing Officer</p>

    <p class="approved">APPROVED:</p>
    <p class="rights"><strong><u>PETER JUNE D. DADIOS, PhD</u></strong></p>
    <p class="right">Head, Student and Auxiliary Services</p>
    @endif
    <div class="flex-footer">
        <img src="{{ asset('images/footerl.png') }}" alt="Footer Left" style="height: 60px;">
        <img src="{{ asset('images/footerr.png') }}" alt="Footer Right" style="height: 90px;">
    </div>
</div>
