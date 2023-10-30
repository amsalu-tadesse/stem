
<!-- /.modal -->
<div class="modal fade" id="show_modal">
    <div class="modal-dialog modal-xl">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Working Group Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- /.card-body -->
                <!-- row -->
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <x-partials.textarea-input-for-show-modals name="name" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <x-partials.textarea-input-for-show-modals name="description"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Organization Level</label>
                        <div class="col-sm-10">
                            <x-partials.textarea-input-for-show-modals name="organizationLevel" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Region</label>
                        <div class="col-sm-10">
                            <x-partials.textarea-input-for-show-modals name="region_id" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Zone</label>
                        <div class="col-sm-10">
                            <x-partials.textarea-input-for-show-modals name="zone_id"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Created By</label>
                        <div class="col-sm-10">
                            <x-partials.textarea-input-for-show-modals name="created_by"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Created At</label>
                        <div class="col-sm-10">
                            <x-partials.textarea-input-for-show-modals name="created_at"/>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- /.card-body -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info show-button" data-dismiss="modal">Close</button>
            </div>
            <!-- /#user_form -->

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
