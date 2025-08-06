<!-- Top Buttons -->
 <style>
    body { font-family: Cambria, serif; font-size: 11pt; margin: 0; background: #f9f9f9; }
    .top-controls { padding: 10px 40px; background: #fff; border-bottom: 1px solid #ccc; display: flex; justify-content: space-between; align-items: center; }
    .top-controls a, .top-controls button { font-size: 11pt; padding: 6px 12px; border-radius: 4px; text-decoration: none; border: none; }
    .form-border { border: 1px solid #000; padding: 40px; margin: 20px auto; max-width: 800px; background: white; }
    .center { text-align: center; }
    .right { text-align: right; }
    .rights { text-align: right;margin-right: 40px; }
    .truly { text-align: right; margin-right: 160px; }
    .short-input, .signature-input { border: none; border-bottom: 1px solid #000; background-color: transparent; text-align: center; pointer-events: none; }
    .signature-input { width: 230px; display: block; margin-left: auto; }
    .signature-label, .label-course, .label-name, .label-address, .label-contact { text-align: right; font-size: 11pt; margin-top: -5px; }
    .label-course { margin-right: 35px; }
    .label-name { margin-right: 95px; }
    .label-address { margin-right: 90px; }
    .label-contact { margin-right: 60px; }
    .flex-footer { display: flex; justify-content: space-between; margin-top: 40px; }
    .approved { text-align: right; margin-right: 180px; }
    .checkbox-list { list-style: none; padding-left: 0; margin-top: 10px; }
    .checkbox-list li { margin-bottom: 5px; }
    @media print { .top-controls { display: none !important; } }
</style>
<div class="top-controls">
    <div>
         @php
            $status = $application->admin_approved;
        @endphp

        @if ($status !== 1 && $status !== 2)
            <!-- Show Approve/Reject buttons only if still pending -->
            <form action="{{ route('admin.applications.approve', $user->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background-color: #28a745; color: white;">✅ Approve</button>
            </form>
            <form action="{{ route('admin.applications.reject', $user->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background-color: #dc3545; color: white;">❌ Reject</button>
            </form>
        @else
            <!-- Show status only -->
            <span>
                <strong>Status:</strong>
                <span style="color: {{ $status === 1 ? 'green' : 'red' }}">
                    {{ $status === 1 ? 'Approved' : 'Rejected' }}
                </span>
            </span>
        @endif
    </div>
</div>

<!-- Form Border -->
<div class="form-border">
    <div class="center">
        <img src="{{ asset('images/header.png') }}" style="width: 100%; max-width: 700px;">
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
        <input type="text" value="{{ $application->school_year }}" class="short-input" readonly>.
        I am fully aware of the terms and conditions relative to dormitory occupancy and those stipulated in the contract.
    </p>
    <p class="truly">Very truly yours,</p>
    <input type="text" value="{{ $user->name }}" class="signature-input" readonly>
    <p class="signature-label">Signature over printed name</p>
    <input type="text" value="{{ $application->course }}-{{ $application->year_section }}" class="signature-input" readonly>
    <p class="label-course">Course / Year / Section</p>

    <div class="d-flex justify-content-between align-items-start mt-4">
        <p class="pt-2">In case of emergency, please contact:</p>
        <div class="text-end">
            <input type="text" value="{{ $application->emergency_contact_name }}" class="signature-input" readonly>
            <p class="label-name">Name</p>
            <input type="text" value="{{ $application->emergency_contact_address }}" class="signature-input" readonly>
            <p class="label-address">Address</p>
            <input type="text" value="{{ $application->emergency_contact_number }}" class="signature-input" readonly>
            <p class="label-contact">Contact Number</p>
        </div>
    </div>

    <div class="mt-1" style="text-align: left;">
        <p style="vertical-align: top; margin-right: 10px;">Please check your present status:</p>
        <ul class="checkbox-list">
            <li><input type="radio" disabled {{ $application->present_status == 'new_student' ? 'checked' : '' }}> New student / new applicant</li>
            <li><input type="radio" disabled {{ $application->present_status == 'old_new' ? 'checked' : '' }}> Old student but new applicant</li>
            <li><input type="radio" disabled {{ $application->present_status == 'returnee' ? 'checked' : '' }}> Old student / returnee</li>
        </ul>
    </div>

    <p class="mt-4">Noted:</p>
    <p><strong><u>BASILIDES O. GERALDO</u></strong><br>Cashier/Disbursing Officer</p>
    <p class="approved">APPROVED:</p>
    <p class="rights"><strong><u>PETER JUNE D. DADIOS, PhD</u></strong></p>
    <p class="right">Head, Student and Auxiliary Services</p>

    <div class="flex-footer">
        <img src="{{ asset('images/footerl.png') }}" alt="Footer Left" style="height: 60px; margin-top: 15px;">
        <img src="{{ asset('images/footerr.png') }}" alt="Footer Right" style="height: 90px;">
    </div>
</div>