@props(['roles'])

<!-- /.modal -->
<div class="modal fade" id="update_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Region Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="region_update_form">
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

                            <div class="form-group" id="is_cityadministration"> <!-- Add an ID for easy targeting -->
                                <label for="status">Is city administration</label>
                                <div class="px-3">
                                    <input type="checkbox" name="is_cityadministration" id="is_cityadministration">
                                </div>

                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <x-partials.input-form title="Ordering" name="ordering" type="input" />
                                </div>
                            </div> -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" name="region_id" id="region_id">
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