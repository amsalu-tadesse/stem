@props(['student_not_add_in_this_as'])

<!-- /.modal -->
<div class="modal fade" id="add_student_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Student</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_student_form">
                @csrf
                <div class="modal-body">
                    <!-- /.card-body -->
                    <!-- row -->
                    <div class="card-body row">
                        <!-- left column -->
                        <div class="col-md-6">
                        
                            <div class="form-group">
                                <label for="academic_session">Student</label>
                                <select id='academic_session' class="academicc_session_select2 select2 form-control" name="academic_session" data-placeholder="Pick academic_session" data-dropdown-css-class="select2-blue">
                                    <option value="none" selected disabled>Select a student</option>
                                    @foreach ($student_not_add_in_this_as as $student)
                                    <option value="{{ $student->id }}">
                                        {{ $student->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('academic_session')
                                <span class="invalid-feedback d-block">student not selected</span>
                                @enderror
                            </div>
                           
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