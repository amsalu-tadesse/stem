<!-- /.modal -->
<div class="modal fade" id="visitor_create_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Make Appointment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="visitor_create_form">
                @csrf
                <div class="modal-body">
                    <!-- /.card-body -->
                    <!-- row -->
                    <div class="card-body row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-partials.input-form title="Organization Name" name="organization_name" type="input" />
                                <span class="text-danger error" id="organization_name_error"></span>
                            </div>
                            <div class="form-group">
                                <x-partials.input-form title="Responsible Person" name="responsible_person" type="input" />
                                <span class="text-danger error" id="responsible_person_error"></span>

                            </div>
                            <div class="form-group">
                                <x-partials.input-form title="Phone Number" name="phone_number" type="tel" />
                                <span class="text-danger error" id="phone_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-partials.input-form title="Email" name="email" type="email" />
                                <span class="text-danger error" id="email_error"></span>

                            </div>
                            <div class="form-group">
                                <x-partials.input-form title="Number of Visitors" name="visitor_count" type="number" />
                                <span class="text-danger error" id="visitor_count_error"></span>
                            </div>
                            <input type="hidden" name="selected_date" id="create_selected_date">
                            <input type="hidden" name="selected_day_range" id="create_selected_day_range">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{-- <input type="hidden" name="course_id" id="course_id"> --}}
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