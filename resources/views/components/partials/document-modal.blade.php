@props(['issue', 'categories'])
<!-- /.modal -->
<div class="modal fade" id="document_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add KPI Information</h4>
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
                            <x-partials.input-form title="FileName" name="file_name" type="input" />
                            <span class="text-danger error" id="file_name_error"></span>
                        </div>
                        <div class="form-group">
                            <label>File Category</label>
                            <div class="select2-blue">
                                <select class="form-control kpi_file_category_select2" name="file_category_id"
                                    data-placeholder="Pick File Category" data-dropdown-css-class="select2-blue"
                                    style="width: 100%;" id="kpi_file_category_select2">>
                                    <option value="">Select File Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger error" id="file_category_id_error"></span>
                        </div>
                        <div class="form-group">
                            <x-partials.textarea-input-form title="Description" name="description" />
                            <span class="text-danger error" id="description_error"></span>

                        </div>
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <form id="file_upload_form" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <h4>Attach Files</h4>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="file" name="files[]" id="files" multiple />
                                    </div>
                                    <div class="col-md-3">
                                        <input type="submit" name="upload" value="Upload"
                                            class="btn btn-sm btn-success" />
                                    </div>
                                </div>
                            </form>
                            <input type="hidden" id="kpi_id" name="kpi_id" value="{{ $issue->kpi }}">
                            <input type="hidden" id="issue_id" name="issue_id" value="{{ $issue->id }}">
                        </div>
                    </div>
                    <!--/.col (right) -->

                </div>
                <!-- /.row -->
                <!-- /.card-body -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="hidden" name="document_id" id="document_id" value="0">
                <button id="save_document" class="btn btn-info">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
