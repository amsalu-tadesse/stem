@props(['roles'])

<!-- /.modal -->
<div class="modal fade" id="update_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Kpi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="kpi_update_form">
                @csrf
                <div class="modal-body">
                    <!-- /.card-body -->
                    <!-- row -->
                    <div class="card-body row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-partials.input-form title="Name" name="name" type="input" />
                                <span id="kpi_update_name_error" class="px-1 invalid-feedback d-block"></span>
                            </div>
                        </div>
                        <!--/.col (left) -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-partials.input-form title="weight" name="weight" type="input" />
                                <span id="kpi_update_weight_error" class="px-1 invalid-feedback d-block"></span>
                            </div>
                        </div>
                        <!-- right column -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-partials.textarea-input-form title="Description" name="description" />
                                <span id="kpi_update_description_error" class="px-1 invalid-feedback d-block"></span>
                            </div>
                        </div>
                        <!--/.col (right) -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" name="kpi_id" id="kpi_id">
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
