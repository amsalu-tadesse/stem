@props(['categories'])
<!-- /.modal -->
<div class="modal fade" id="kpi_document_update_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update KPI Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="warning_container">
                <!-- /.card-body -->
                <h5 class="text-warning text-center"></h5>
                <!-- row -->
                <div class="card-body row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-partials.input-form title="FileName" name="file_name_update" type="input" />
                            <span class="text-danger error" id="file_name_update_error"></span>
                        </div>
                        <div class="form-group">
                            <label>File Category</label>
                            <div class="select2-blue">
                                <select class="form-control kpi_file_category_update_select2" name="file_category_id_update"
                                    data-placeholder="Pick File Category" data-dropdown-css-class="select2-blue"
                                    style="width: 100%;" id="kpi_file_category_update_select2">>
                                    <option value="">Select File Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger error" id="file_category_id_update_error"></span>
                        </div>
                        <div class="form-group">
                            <x-partials.textarea-input-form title="Description" name="description_update" />
                            <span class="text-danger error" id="description_update_error"></span>

                        </div>
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->
                </div>
                <!-- /.row -->
                <!-- /.card-body -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="hidden" name="document_id_update" id="document_id_update" value="0">
                <button id="save_update_document" class="btn btn-info">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
