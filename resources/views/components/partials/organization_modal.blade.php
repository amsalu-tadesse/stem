@props(['types', 'levels', 'regions', 'zones'])

<!-- /.modal -->
<div class="modal fade" id="organization_update_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Organization Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="organization_update_form">
                @csrf
                <div class="modal-body">
                    <!-- /.card-body -->
                    <!-- row -->
                    <div class="card-body row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-partials.input-form title="Name" name="name" type="input" />
                                <span class="text-danger error" id="name_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="organization_type">Organization Type</label>
                                <div class="select2-blue">
                                    <select id='organization_type'
                                        class="organization_type_select2 select2 form-control"
                                        data-placeholder="Pick Organization Type" data-dropdown-css-class="select2-blue"
                                        name="organization_type_id">
                                        <option value="" selected disabled>Select a Type</option>
                                        @foreach ($types as $organization_type)
                                            <option value="{{ $organization_type->id }}">
                                                {{ $organization_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger error" id="organization_type_id_error"></span>

                            </div>

                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Organization Level</label>
                                <div class="select2-blue">
                                    <select name="organization_level_id" class="organization_level_select2 select2"
                                        data-placeholder="Pick Issue Levels"
                                        data-dropdown-css-class="select2-blue" style="width: 100%;"
                                        id="organization_level">
                                        @foreach ($levels as $level)
                                            <option class="{{ $level->id }}" value="{{ $level->id }}">
                                                {{ $level->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger error" id="organization_level_id_error"></span>
                            </div>
                            {{-- <div class="form-group">
                                <label>City Administration</label>
                                <div class="select2-blue">
                                    <select class="form-control organization_city_admin_select2" name="cityadmin_id"
                                        data-placeholder="Pick City Administration"
                                        data-dropdown-css-class="select2-blue" style="width: 100%;" id="cityadmin_id">>
                                        <option value="">Select City Adminstration</option>
                                        @foreach ($regions as $region)
                                            @if ($region->is_cityadministration)
                                                <option value="{{ $region->id }}">
                                                    {{ $region->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="form-group" id="organization_region_parent" style="display : none;">
                                <label>Region</label>
                                <div class="select2-blue">
                                    <select name="region_id" class="organization_region_select2 select2"
                                        data-placeholder="Pick Region" data-dropdown-css-class="select2-blue"
                                        style="width: 100%;" id="organization_region">
                                        <option value="">Select Region</option>
                                        @foreach ($regions as $region)
                                            <option class="{{ $region->id }}" value="{{ $region->id }}">
                                                {{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger error" id="region_id_error"></span>
                            </div>
                            <div class="form-group" id="organization_zone_parent" style="display : none;">
                                <label>Zone</label>
                                <div class="select2-blue">
                                    <select name="zone_id" class="organization_zone_select2 select2"
                                        data-placeholder="Pick zone" data-dropdown-css-class="select2-blue"
                                        style="width: 100%;" id="organization_zone">
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
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-partials.textarea-input-form title="Description" name="description" />
                            </div>
                        </div>
                        <!--/.col (right) -->

                    </div>
                    <!-- /.row -->
                    <!-- /.card-body -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" name="organization_id" id="organization_id">
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
