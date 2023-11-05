<x-layout>
    <x-breadcrump title="Add New School" parent="School" child="Add New School" />

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add School Form</h3>
        </div>

        <form id="school_form" method="POST" action="{{ route('admin.schools.store') }}">
            @csrf
            <div class="card-body row">
                <div class="col-md-6">
                    <div class="form-group">
                        <x-partials.input-form title="Name" name="name" type="input" />
                    </div>
                    <div class="form-group">
                        <x-partials.input-form title="Address" name="address" type="input" />
                    </div>
                    <div class="form-group">
                        <label for="school_level">School Level</label>
                        <select id='school_level' class="school_level_select2 select2 form-control"
                            name="school_level" data-placeholder="Pick school_level"
                            data-dropdown-css-class="select2-blue">
                            <option value="none" selected disabled>Select a school_level</option>
                            @foreach ($school_levels as $school_level)
                                <option value="{{ $school_level->id }}"
                                    {{ old('school_level') == $school_level->id ? 'selected' : '' }}>
                                    {{ $school_level->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('school_level')
                            <span class="invalid-feedback d-block">school_level not selected</span>
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
            $('.school_level_select2').select2();
        </script>
        @endpush
</x-layout>
