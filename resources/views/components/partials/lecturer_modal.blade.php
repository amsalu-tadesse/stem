@props(['departments','academic_levels'])

<!-- /.modal -->
<div class="modal fade" id="update_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Lecturer Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="lecturer_update_form">
                @csrf
                <div class="modal-body">
                    <!-- /.card-body -->
                    <!-- row -->
                    <div class="card-body row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-partials.input-form title="Name" name="name" type="input" />
                            </div>
                            <div class="form-group">
                                <x-partials.input-form title="Phone" name="phone" type="input" />
                            </div>

                            <div class="form-group">
                                <label for="department">Department</label>
                                <select id='department' class="department_select2 select2 form-control" name="department" data-placeholder="Pick Department" data-dropdown-css-class="select2-blue">
                                    <option value="none" selected disabled>Select a Department</option>
                                    @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>
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
                                <select id='academic_level' class="academic_level_select2 select2 form-control" name="academic_level" data-placeholder="Pick academic_level" data-dropdown-css-class="select2-blue">
                                    <option value="none" selected disabled>Select a academic_level</option>
                                    @foreach ($academic_levels as $academic_level)
                                    <option value="{{ $academic_level->id }}" {{ old('academic_level') == $academic_level->id ? 'selected' : '' }}>
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
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" name="lecturer_id" id="lecturer_id">
                    <button type="submit" class="btn btn-info">Save changes</button>
                </div>
            </form>
            <!-- /#user_form -->

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->