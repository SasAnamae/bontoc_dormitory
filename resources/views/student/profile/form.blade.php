<div class="card shadow-sm rounded-4 mb-4">
    <div class="card-body">
        <h5 class="fw-bold text-primary mb-3">Personal Information</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="course_section" class="form-label fw-semibold">Course & Section</label>
                <input type="text" name="course_section" id="course_section" class="form-control rounded-pill"
                       value="{{ old('course_section', $profile->course_section ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="home_address" class="form-label fw-semibold">Home Address</label>
                <input type="text" name="home_address" id="home_address" class="form-control rounded-pill"
                       value="{{ old('home_address', $profile->home_address ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="cellphone" class="form-label fw-semibold">Cellphone Number</label>
                <input type="text" name="cellphone" id="cellphone" class="form-control rounded-pill"
                       value="{{ old('cellphone', $profile->cellphone ?? Auth::user()->cellphone ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" id="email" class="form-control rounded-pill"
                       value="{{ old('email', $profile->email ?? Auth::user()->email ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="birthday" class="form-label fw-semibold">Birthday</label>
                <input type="date" name="birthday" id="birthday" class="form-control rounded-pill"
                       value="{{ old('birthday', $profile->birthday ?? '') }}" required>
            </div>
            <div class="col-md-3">
                <label for="age" class="form-label fw-semibold">Age</label>
                <input type="number" name="age" id="age" class="form-control rounded-pill"
                       value="{{ old('age', $profile->age ?? '') }}" required>
            </div>
            <div class="col-md-3">
                <label for="religion" class="form-label fw-semibold">Religion</label>
                <input type="text" name="religion" id="religion" class="form-control rounded-pill"
                       value="{{ old('religion', $profile->religion ?? '') }}">
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm rounded-4 mb-4">
    <div class="card-body">
        <h5 class="fw-bold text-primary mb-3">Parents Information</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="father_fullname" class="form-label fw-semibold">Father’s Full Name</label>
                <input type="text" name="father_fullname" id="father_fullname" class="form-control rounded-pill"
                       value="{{ old('father_fullname', $profile->father_fullname ?? '') }}">
            </div>
            <div class="col-md-6">
                <label for="father_phone" class="form-label fw-semibold">Father’s Contact Number</label>
                <input type="text" name="father_phone" id="father_phone" class="form-control rounded-pill"
                       value="{{ old('father_phone', $profile->father_phone ?? '') }}">
            </div>
            <div class="col-md-6">
                <label for="mother_fullname" class="form-label fw-semibold">Mother’s Full Name</label>
                <input type="text" name="mother_fullname" id="mother_fullname" class="form-control rounded-pill"
                       value="{{ old('mother_fullname', $profile->mother_fullname ?? '') }}">
            </div>
            <div class="col-md-6">
                <label for="mother_phone" class="form-label fw-semibold">Mother’s Contact Number</label>
                <input type="text" name="mother_phone" id="mother_phone" class="form-control rounded-pill"
                       value="{{ old('mother_phone', $profile->mother_phone ?? '') }}">
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm rounded-4 mb-4">
    <div class="card-body">
      <h5 class="fw-bold text-primary mb-3">Additional Details</h5>
        <div class="row g-3 mb-4">
            <div class="col-12">
                <label class="form-label fw-semibold">Electrical Appliances</label>
                @php
                    $appliances = ['Laptop', 'Rice Cooker', 'Electric Fan', 'Kettle', 'Blender'];
                    $selectedAppliances = old('electrical_appliances', $profile->electrical_appliances ?? '');
                    $selectedArray = is_string($selectedAppliances) ? explode(',', $selectedAppliances) : [];
                    $otherAppliance = collect($selectedArray)->filter(fn($item) => !in_array($item, $appliances))->first();
                @endphp
                <div class="row g-2">
                    @foreach ($appliances as $appliance)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="electrical_appliances[]" 
                                    value="{{ $appliance }}"
                                    id="appliance_{{ $loop->index }}"
                                    {{ in_array($appliance, $selectedArray) ? 'checked' : '' }}>
                                <label class="form-check-label" for="appliance_{{ $loop->index }}">
                                    {{ $appliance }}
                                </label>
                            </div>
                        </div>
                    @endforeach

                    <!-- Others checkbox -->
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="electrical_appliances[]" value="Others"
                                id="appliance_others"
                                {{ $otherAppliance ? 'checked' : '' }}>
                            <label class="form-check-label" for="appliance_others">
                                Others
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Input for other appliance -->
                <div class="mt-2" id="otherApplianceInput" style="{{ $otherAppliance ? '' : 'display:none;' }}">
                    <input type="text" name="other_appliance" class="form-control rounded-pill mt-2"
                        placeholder="Specify other appliance"
                        value="{{ $otherAppliance }}">
                </div>
            </div>
            <div class="col-md-6">
                <label for="total_monthly" class="form-label fw-semibold">Total Monthly Income (₱)</label>
                <input type="number" name="total_monthly" id="total_monthly" class="form-control rounded-pill" step="0.01"
                    value="{{ old('total_monthly', $profile->total_monthly ?? '') }}">
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const othersCheckbox = document.getElementById('appliance_others');
        const otherInput = document.getElementById('otherApplianceInput');

        othersCheckbox.addEventListener('change', function () {
            if (this.checked) {
                otherInput.style.display = 'block';
            } else {
                otherInput.style.display = 'none';
                otherInput.querySelector('input').value = '';
            }
        });
    });
</script>