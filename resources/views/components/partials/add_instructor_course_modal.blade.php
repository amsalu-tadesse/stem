@props(['instructorsNotInInstructorCourse','coursesNotInInstructorCourse','academic_session'])

<!-- /.modal -->
<div class="modal fade" id="add_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Instructor-Course</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_instructor_course_form">
                @csrf
                <div class="modal-body">
                    <!-- /.card-body -->
                    <!-- row -->
                    <div class="card-body row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="course_id">Course</label>
                                <select id='course_id' class="course_id_select2 select2 form-control" name="course_id" data-placeholder="Pick course_id" data-dropdown-css-class="select2-blue">
                                    <option value="none" selected disabled>Select a course</option>
                                    @foreach ($coursesNotInInstructorCourse as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                <span class="invalid-feedback d-block">course not selected</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lecturer_id">Instructor</label>
                                <select id='lecturer_id' class="lecturer_id_select2 select2 form-control" name="lecturer_id" data-placeholder="Pick lecturer_id" data-dropdown-css-class="select2-blue">
                                    <option value="none" selected disabled>Select a lecturer</option>
                                    @foreach ($instructorsNotInInstructorCourse as $lecturer)
                                    <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>
                                        {{ $lecturer->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('lecturer_id')
                                <span class="invalid-feedback d-block">lecturer not selected</span>
                                @enderror
                            </div>
                            <input type="hidden" name="academic_session_id" value="{{$academic_session->id}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Add</button>
                </div>
            </form>
            <!-- /#user_form -->

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->