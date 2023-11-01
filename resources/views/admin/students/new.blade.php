<x-layout>
    <x-breadcrump title="Add New student" parent="student" child="Add New student" />

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add student Form</h3>
        </div>

        <form id="student_form" method="POST" action="{{ route('admin.students.store') }}">
            @csrf
            <div class="card-body row">
                <div class="col-md-6">
                    <div class="form-group">
                        <x-partials.input-form title="Name" name="name" type="input" />
                    </div>
                    <div class="form-group">
                        <x-partials.input-form title="Age" name="age" type="input" />
                    </div>
                    <div class="form-group">
                        <label for="sex">Sex</label>
                        <select id='sex' class="form-control" name="sex">
                            <option value="">Select your Sex</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <x-partials.input-form title="Grade" name="grade" type="input" />
                    </div>
                    <div class="form-group">
                        <label for="school">School</label>
                        <select id='school' class="school_select2 select2 form-control" name="school" data-placeholder="Pick school" data-dropdown-css-class="select2-blue">
                            <option value="none" selected disabled>Select a school</option>
                            @foreach ($schools as $school)
                            <option value="{{ $school->id }}" {{ old('school') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('school')
                        <span class="invalid-feedback d-block">school not selected</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="academic_session">Academic Session</label>
                        <select id='academic_session' class="academic_session_select2 select2 form-control" name="academic_session" data-placeholder="Pick academic_session" data-dropdown-css-class="select2-blue">
                            <option value="none" selected disabled>Select a academic session</option>
                            @foreach ($academic_sessions as $academic_session)
                            <option value="{{ $academic_session->id }}" {{ old('academic_session') == $academic_session->id ? 'selected' : '' }}>
                                {{ $academic_session->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('academic_session')
                        <span class="invalid-feedback d-block">academic_session not selected</span>
                        @enderror
                    </div>
                </div>
            </div>
    </div>

    <div class="card-footer text-right">
        <button type="submit" class="btn btn-info float-right mx-3">Submit</button>
    </div>

    </form>

    </div>
    @push('scripts')
    <script>
        $('.school_select2').select2();
        $('.academic_session_select2').select2();
    </script>
    @endpush
</x-layout>