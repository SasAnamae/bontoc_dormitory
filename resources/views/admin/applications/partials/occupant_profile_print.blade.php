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
        .input-line, .input-wide {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 200px;
            padding-left: 5px;
        }
        .signature{
            text-align: right;
            margin-top: -5px;
            margin-right: 20px;
            font-size: 11pt;
        }
        .signature-input {
            margin-left: auto;
            width: 250px;
            border-bottom: 1px solid #000;
            text-align: center;
            margin-top: 30px;
        }
        .flex-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        @media print {
            body { margin: 0.5in; }
            button, .no-print { display: none !important; }
        }
    </style>
<div class="form-border">
    <div class="center">
        <img src="{{ asset('images/header.png') }}" alt="Header" style="width: 100%; max-width: 700px;">
    </div>
    <p class="center"><strong>SLSU DORMITORY</strong></p>
    <p class="center"><strong>OCCUPANT’S PROFILE & CLASS SCHEDULE</strong></p>

    @php $application = $profile->user->applicationForm ?? null; @endphp

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td>Occupant's Name:
                <span class="input-line">{{ $profile->user->name ?? '' }}</span>
            </td>
            <td>Course & Section:
                <span class="input-line">
                    {{ $application->course ?? '' }} - {{ $application->year_section ?? '' }}
                </span>
            </td>
        </tr>
        @if ($profile)
        <tr>
            <td>Home Address: <span class="input-wide">{{ $profile->home_address }}</span></td>
        </tr>
        <tr>
            <td>Cellphone Number: <span class="input-line">{{ $profile->cellphone }}</span></td>
            <td>Email Address: <span class="input-line">{{ $profile->user->email ?? '' }}</span></td>
        </tr>
        <tr>
            <td>Birthday: <span class="input-line">{{ \Carbon\Carbon::parse($profile->birthday)->format('F d, Y') }}</span></td>
            <td>Age: <span class="input-line">{{ $profile->age }}</span></td>
        </tr>
        <tr>
            <td>Religion: <span class="input-line">{{ $profile->religion }}</span></td>
            <td>Scholarship: <span class="input-line">{{ $profile->scholarship }}</span></td>
        </tr>
        <tr>
            <td>Blood Type: <span class="input-line">{{ $profile->blood_type }}</span></td>
            <td>Allergies: <span class="input-line">{{ $profile->allergies }}</span></td>
        </tr>
    </table>

    <p style="margin-top: 20px;"><strong>Parents:</strong></p>
    <table style="width: 100%;">
        <tr>
            <td>Father: <span class="input-line">{{ $profile->father_fullname }}</span></td>
            <td>Cellphone No.: <span class="input-line">{{ $profile->father_phone }}</span></td>
        </tr>
        <tr>
            <td>Mother: <span class="input-line">{{ $profile->mother_fullname }}</span></td>
            <td>Cellphone No.: <span class="input-line">{{ $profile->mother_phone }}</span></td>
        </tr>
    </table>

    <p style="margin-top: 20px;"><strong>Electrical Gadget/Appliances in the Dorm:</strong></p>
    <ul style="margin-left: 20px;">
        @foreach ($profile->electrical_appliances_array ?? [] as $appliance)
            <li><span class="input-line">{{ $appliance }}</span></li>
        @endforeach
    </ul>

    <p>Total Payable Monthly: <span class="input-line">{{ $profile->monthly_payable }}</span></p>
 

    <p class="signature" style="margin-top: 30px;">
        I hereby certify that the above information is true and correct.
    </p>
    <div class="signature">
        <div class="signature-input">&nbsp;</div>
        <p>Signature of Occupant</p>
    </div>
  @endif
    <div class="flex-footer">
        <img src="{{ asset('images/footerl.png') }}" alt="Footer Left" style="height: 60px;">
        <img src="{{ asset('images/footerr.png') }}" alt="Footer Right" style="height: 90px;">
    </div>
</div>
