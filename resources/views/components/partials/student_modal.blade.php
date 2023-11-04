@props(['schools','academic_sessions'])

<!-- /.modal -->
<div class="modal fade" id="update_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Student Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="student_update_form">
                @csrf
                <div class="modal-body">
                    <!-- /.card-body -->
                    <!-- row -->
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
                                <select id='school' class="school_select2 select2 form-control" name="school_id" data-placeholder="Pick school" data-dropdown-css-class="select2-blue">
                                    <option value="none" selected disabled>Select a school</option>
                                    @foreach ($schools as $school)
                                    <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('school_id')
                                <span class="invalid-feedback d-block">school not selected</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="academic_session">Academic Session</label>
                                <select id='academic_session' class="academic_session_select2 select2 form-control" name="academic_session" data-placeholder="Pick academic_session" data-dropdown-css-class="select2-blue">
                                    <option value="none" selected disabled>Select a academic_session</option>
                                    @foreach ($academic_sessions as $academic_session)
                                    <option value="{{ $academic_session->id }}" {{ old('academic_session') == $academic_session->id ? 'selected' : '' }}>
                                        {{ $academic_session->label }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('academic_session')
                                <span class="invalid-feedback d-block">academic session not selected</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" name="student_id" id="student_id">
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