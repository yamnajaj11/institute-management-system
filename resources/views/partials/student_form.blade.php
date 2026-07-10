<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
        <h5 class="card-title fw-bold mb-3">{{ isset($student) ? __('admin.edit_student') : __('admin.add_new') }}</h5>
        
        <form action="{{ isset($student) ? route('admin.students.update', $student->id) : route('admin.students.store') }}" method="POST">
            @csrf
            @if(isset($student))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="student_id" class="form-label">{{ __('admin.student_id') }}</label>
                    <input type="text" class="form-control rounded-pill @error('student_id') is-invalid @enderror" id="student_id" name="student_id" value="{{ old('student_id', $student->student_id ?? '') }}" required>
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">{{ __('admin.name') }}</label>
                    <input type="text" class="form-control rounded-pill @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $student->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">{{ __('admin.password') }}</label>
                    <input type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" id="password" name="password" {{ isset($student) ? '' : 'required' }}>
                    @if(isset($student))
                        <small class="text-muted">{{ __('admin.leave_password_blank') }}</small>
                    @endif
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="gender" class="form-label">{{ __('admin.gender') }}</label>
                    <select class="form-select rounded-pill @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                        <option value="">{{ __('admin.select_gender') }}</option>
                        <option value="male" {{ old('gender', $student->gender ?? '') == 'male' ? 'selected' : '' }}>{{ __('admin.male') }}</option>
                        <option value="female" {{ old('gender', $student->gender ?? '') == 'female' ? 'selected' : '' }}>{{ __('admin.female') }}</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="father_name" class="form-label">{{ __('admin.father_name') }}</label>
                    <input type="text" class="form-control rounded-pill @error('father_name') is-invalid @enderror" id="father_name" name="father_name" value="{{ old('father_name', $student->father_name ?? '') }}">
                    @error('father_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="mother_name" class="form-label">{{ __('admin.mother_name') }}</label>
                    <input type="text" class="form-control rounded-pill @error('mother_name') is-invalid @enderror" id="mother_name" name="mother_name" value="{{ old('mother_name', $student->mother_name ?? '') }}">
                    @error('mother_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">{{ __('admin.phone_number') }}</label>
                    <input type="text" class="form-control rounded-pill @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $student->phone ?? '') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">{{ __('admin.address') }}</label>
                    <input type="text" class="form-control rounded-pill @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $student->address ?? '') }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm transition-transform duration-300 hover:-translate-y-1">
                    {{ isset($student) ? __('admin.update_student') : __('admin.add_student') }}
                </button>
            </div>
        </form>
    </div>
</div>
