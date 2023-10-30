@props(['issue'])

<!-- /.modal -->
<div class="modal fade" id="issue_event_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modal_title" class="modal-title">Create Event</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="issue_event_create_form">
                <div class="modal-body">
                    <!-- /.card-body -->
                    <!-- row -->
                    <div class="card-body row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-partials.input-form title="Topic" name="topic" type="input" />
                                <span id="issue_event_topic_error" class="px-1 invalid-feedback d-block"></span>
                            </div>
                        </div>
                        <!--/.col (left) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Event Start - End Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control responsive-daterangepicker"
                                        id="issue_event_daterange" placeholder="Event start date - end date" required>
                                    <span id="issue_event_start_end_date_error" class="px-1 invalid-feedback d-block"></span>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <!-- Date range -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-partials.textarea-input-form title="Address" name="address" rows="3" />
                                <span id="issue_event_address_error" class="px-1 invalid-feedback d-block"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group px-3">
                                <label for="issue_event_status">Event Status</label>
                                <div>
                                    <input type="checkbox" name="status" id="issue_event_status" checked
                                        data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <x-partials.textarea-input-form title="Meeting Link" name="link" rows="3" />
                                <span id="issue_event_link_error" class="px-1 invalid-feedback d-block"></span>
                            </div>
                        </div>
                        <!-- right column -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-partials.textarea-input-form title="Description" name="description" rows="5" />
                                <span id="issue_event_description_error" class="px-1 invalid-feedback d-block"></span>
                            </div>
                        </div>
                        <!--/.col (right) -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" name="issue_id" id="issue_id" value="{{ $issue->id }}">
                    <input type="hidden" id="event_id">
                    <button id="issue_event_create_button" type="submit" class="btn btn-info create_event_button update_event_button">Create</button>
                </div>
            </form>
            <!-- /#user_form -->

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
