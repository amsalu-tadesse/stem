<x-layout>
    <x-breadcrump title="Add New Lecture" parent="Lecture" child="Add New Lecture" />

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add Lecture Form</h3>
        </div>

        <form id="lecturer_form" method="POST" action="{{ route('admin.lecturers.store') }}">
            @csrf
            <div class="card-body row">
                <div class="col-md-6">
                    <div class="form-group">
                        <x-partials.input-form title="Name" name="name" type="input" />
                    </div>
                    <div class="form-group">
                        <x-partials.input-form title="Phone" name="phone" type="input" />
                    </div>

                    <div class="form-group">
                        <label for="department">Department</label>
                        <select id='department' class="department_select2 select2 form-control"
                            name="department" data-placeholder="Pick Department"
                            data-dropdown-css-class="select2-blue">
                            <option value="none" selected disabled>Select a Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ old('department') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department')
                            <span class="invalid-feedback d-block">Department not selected</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <x-partials.input-form title="Email" name="email" type="input" />
                    </div>
                    <div class="form-group">
                        <label for="academic_level">Academic Level</label>
                        <select id='academic_level' class="academic_level_select2 select2 form-control"
                            name="academic_level" data-placeholder="Pick academic_level"
                            data-dropdown-css-class="select2-blue">
                            <option value="none" selected disabled>Select a academic_level</option>
                            @foreach ($academic_levels as $academic_level)
                                <option value="{{ $academic_level->id }}"
                                    {{ old('academic_level') == $academic_level->id ? 'selected' : '' }}>
                                    {{ $academic_level->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_level')
                            <span class="invalid-feedback d-block">academic_level not selected</span>
                        @enderror
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
            $('.academic_level_select2').select2();
            $('.department_select2').select2();
        </script>
        @endpush
</x-layout>