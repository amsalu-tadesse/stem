<!-- /.modal -->
<div class="modal fade" id="update_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Academic Session Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="academic_session_update_form">
                @csrf
                <div class="modal-body">
                    <!-- /.card-body -->
                    <!-- row -->
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-partials.input-form title="Academic Year" name="academic_year" type="input" />
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class="input-group date" id="start_date" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#start_date">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#start_date" data-toggle="datetimepicker">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                                <label for="week_type">Week Type</label>
                                <select id='week_type' class="form-control" name="week_type">
                                    <option value="">Select Week Type</option>
                                    <option value="0">Weeks</option>
                                    <option value="1">Weekend</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <div class="input-group date" id="end_date" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#end_date">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#end_date" data-toggle="datetimepicker">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" name="academic_session_id" id="academic_session_id">
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