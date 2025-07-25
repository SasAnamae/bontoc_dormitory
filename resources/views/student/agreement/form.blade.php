<div class="card shadow-sm rounded-4">
    <div class="card-body p-4">
        <!-- Agreement Text -->
        <h5 class="fw-bold text-primary mb-3">Dormitory Agreement</h5>
        <div class="border rounded-3 p-3 mb-4" style="background-color: #f8f9fa;">
            <pre class="m-0" style="white-space: pre-wrap; word-wrap: break-word; font-family: inherit;">
DORMITORY AGREEMENT

I, {{ Auth::user()->name }}, {{ Auth::user()->occupantProfile->course_section ?? '__________' }}, do hereby agree and conform to the following conditions of the privileges granted to me by the school authorities to reside in the SLSU dormitory.

1. That I shall abide by the dormitory rules, regulation or injunctions promulgated verbally or in writing by the authorities concerned.
2. That I shall pay my dormitory fee promptly and failure to pay for two (2) consecutive months means cancellation of the privilege to stay in the dormitory.
3. That I shall pay the association fee of P10.00 and submit the necessary documents or requirements before I could qualify to reside in the dormitory.
4. That I shall settle all my financial obligations to the dormitory on or before the final examinations of the current semester.
5. That I shall recognize the right of the dormitory authorities to inspect my room, locker or closet and personal belongings when circumstances warrant so.
6. That if I decide to leave the dormitory before the end of semester, I am obliged to pay 50% of the residence fee/rental for the remaining months of the semester.
7. That I shall help maintain the cleanliness & upkeep of the dormitory and its surroundings at all times.
8. In case of dismissal or expulsion from the dormitory, I shall forfeit whatever amount I shall have paid as dormitory fee or rental or in case I vacate the dormitory voluntarily.
9. That I shall be willing to accept whatever penalty the management or school authorities impose upon me and shall conform to the decision of the same for any violation or infraction of the dormitory rules and regulations.

In witness whereof, I hereby affix my signature on this {{ now()->format('jS \\of F Y') }} at SLSU - Bontoc Campus, San Ramon, Bontoc, Southern Leyte.
            </pre>
        </div>

        <!-- Hidden Fields -->
        <input type="hidden" name="agreement_text" value="DORMITORY AGREEMENT I, {{ Auth::user()->name }}, {{ Auth::user()->occupantProfile->course_section ?? '__________' }} ... (same text as above)">
        <input type="hidden" name="student_name" value="{{ Auth::user()->name }}">
        <input type="hidden" name="course_year" value="{{ Auth::user()->occupantProfile->course_section ?? '' }}">
        <input type="hidden" name="date_signed" value="{{ now()->format('Y-m-d') }}">

        <!-- Submit Button -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success rounded-pill px-4">
                <i class="fas fa-check-circle me-2"></i> Sign Agreement
            </button>
        </div>
    </div>
</div>

