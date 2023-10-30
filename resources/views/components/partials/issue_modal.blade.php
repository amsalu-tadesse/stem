@props(['institutions', 'levels', 'regions', 'zones', 'categories'])

<!-- /.modal -->
<div class="modal fade" id="issue_update_modal" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-xl">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Issue Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="issue_update_form">
                @csrf
                <div class="modal-body">
                    <!-- /.card-body -->
                    <!-- row -->
                    <div class="card-body row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-partials.input-form title="Title" name="title" type="input" />
                                <span class="text-danger error" id="title_error"></span>
                            </div>
                            {{-- <div class="form-group">
                                <label>Responsible Institution</label>
                                <div class="select2-blue">
                                    <select name="responsible_institution" class="responsible_institution_select2"
                                        data-placeholder="Pick User Role(s)" data-dropdown-css-class="select2-blue"
                                        style="width: 100%;" id="responsible_institution">
                                        @foreach ($institutions as $organization)
                                            <option class="{{ $organization->id }}" value="{{ $organization->id }}">
                                                {{ $organization->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger error" id="responsible_institution_error"></span>
                            </div> --}}
                            <div class="form-group">
                                <x-partials.textarea-input-form title="Public Benefit" name="public_benefit"
                                    rows="5" />
                                <span class="text-danger error" id="public_benefit_error"></span>
                            </div>
                        </div>
                        <!--/.col (left) -->

                        <!-- right column -->
                        <div class="col-md-6">
                            <div class="form-group" id="issue_level_parent">
                                <label>Issue Level</label>
                                <div class="select2-blue">
                                    <select name="issue_level" class="issue_update_level_select2"
                                        data-placeholder="Pick Issue Levels"
                                        data-dropdown-css-class="select2-blue" style="width: 100%;"
                                        id="issue_update_organization_level">
                                        @foreach ($levels as $level)
                                            <option class="{{ $level->id }}" value="{{ $level->id }}">
                                                {{ $level->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger error" id="issue_level_error"></span>
                            </div>

                            <div class="form-group" id="issue_region_parent" style="display : none;">
                                <label>Region</label>
                                <div class="select2-blue">
                                    <select name="region_id" class="issue_update_region_select2 select2" data-placeholder="Pick Region"
                                        data-dropdown-css-class="select2-blue" style="width: 100%;" id="issue_update_region">
                                        <option class="0" value="">Select Region</option>
                                        @foreach ($regions as $region)
                                                <option class="{{ $region->id }}" value="{{ $region->id }}">
                                                    {{ $region->name }}
                                                </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger error" id="region_id_error"></span>
                            </div>


                            <div class="form-group" id="issue_zone_parent" style="display : none;">
                                <label>Zone</label>
                                <div class="select2-blue">
                                    <select name="zone_id" class="issue_update_zone_select2 select2" data-placeholder="Pick zone"
                                        data-dropdown-css-class="select2-blue" style="width: 100%;" id="issue_update_zone">
                                        <option value="">Select Zone</option>
                                        @foreach ($zones as $zone)
                                            <option class="{{ $zone->id }}" value="{{ $zone->id }}">
                                                {{ $zone->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger error" id="zone_id_error"></span>
                            </div>



                            <div class="form-group">
                                <x-partials.textarea-input-form title="Private Benefit" name="private_benefit"
                                    rows="5" />
                                <span class="text-danger error" id="private_benefit_error"></span>
                            </div>
                            <!--/.col (right) -->
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <x-partials.textarea-input-form title="Description" name="description" rows="5" />
                                <span class="text-danger error" id="description_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <label for="issue_file_collection">Attached Files</label>

                            <div id="issue_file_collection" class="jumbotron"></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="text-center">
                                        <h4>Attach Files</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <x-partials.input-form title="File Name" name="file_name_update_create" type="input" />
                                                <span class="text-danger error" id="file_name_update_create_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File Category</label>
                                                <div class="select2-blue">
                                                    <select class="form-control issue_document_category_select2"
                                                        name="file_category" data-placeholder="Pick File Category"
                                                        data-dropdown-css-class="select2-blue" style="width: 100%;"
                                                        id="file_update_create_category_id">>
                                                        <option value="">Select File Categroy</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">
                                                                {{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger error" id="file_category_update_create_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-md-8 mb-2">
                                            <input type="file" name="files[]" id="issue_files" multiple />
                                            <div class="text-danger error" id="files_update_create_error"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="button" onclick="upload_issue_attachments()"
                                                id="file_upload_issue_update" name="upload" value="Upload"
                                                class="btn btn-sm btn-success" />
                                        </div>
                                    </div>
                                    <div id="issue_update_file_upload_container_progresss" class="px-3 my-2">

                                    </div>
                                </div>

                                <span class="text-danger error" id="file_collection_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="hidden" name="issue_id" id="issue_update_id">
                        <input type="hidden" name="issue_document_id" id="issue_document_update_id">
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
