@props(['project_statuses'])

<!-- /.modal -->
<div class="modal fade" id="project_status_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Project Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="project_status_form" method="POST" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <div class="modal-body">
                    <!-- /.card-body -->
                    <!-- row -->
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Project Status</label>
                                <div class="select2-blue">
                                    <select name="project_status" class="project_status_select2 select2"
                                        data-placeholder="Pick Project Status" data-dropdown-css-class="select2-blue"
                                        style="width: 100%;" id="project_status">
                                        <option value="">Select Project Status</option>
                                        @foreach ($project_statuses as $status)
                                            <option class="{{ $status->id }}" value="{{ $status->id }}">
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger error" id="project_status_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="file">Choose a file:</label>
                                <input type="file" name="file" id="file" />
                                
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" name="trainee_session_id" id="trainee_session_id">
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
