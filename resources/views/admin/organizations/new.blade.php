<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="Add New Organization" parent="Organization" child="Add New Organization" />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add Organization Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- general form elements -->
        <!-- form start -->
        <form id="organization_form" method="POST" action="{{ route('admin.organizations.store') }}">
            @csrf
            <!-- /.card-body -->
            <!-- row -->
            <div class="card-body row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <x-partials.input-form title="Name" name="name" type="input" />
                    </div>
                    <div class="form-group">
                        <label for="organization_type">Organization Type</label>
                        <select id='organization_type' class="organization_type_select2 select2 form-control"
                            name="organization_type_id" data-placeholder="Pick Organization Type"
                            data-dropdown-css-class="select2-blue">
                            <option value="none" selected disabled>Select a Type</option>
                            @foreach ($organization_types as $organization_type)
                                <option value="{{ $organization_type->id }}"
                                    {{ old('organization_type_id') == $organization_type->id ? 'selected' : '' }}>
                                    {{ $organization_type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('organization_type_id')
                            <span class="invalid-feedback d-block">Organization type not selected</span>
                        @enderror
                    </div>

                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">
                    <div class="select2-blue form-group" id="organization_level_parent">
                        <label for="organization_level">Organization Level</label>
                        <select id="organization_level" onchange="showSecondDropdown(this)"
                            class="organization_level_select2 select2 form-control" name="organization_level_id"
                            data-placeholder="Pick Organization Level" data-dropdown-css-class="select2-blue">
                            <option value="">Select Organization Level</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}"
                                    {{ old('organization_level_id') == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}</option>
                            @endforeach
                        </select>
                        @error('organization_level_id')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div class="form-group"
                        style="display: {{ $errors->has('cityadmin_id') ? 'block' : 'none' }}; margin-top:47px;">
                        <select id="cityadmin_id" class="form-control" name="cityadmin_id">
                            <option value="">Select City Adminstration</option>
                            @foreach ($regions as $region)
                                @if ($region->is_cityadministration)
                                    <option value="{{ $region->id }}">
                                        {{ $region->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('cityadmin_id')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    <div class="select2-blue form-group" id="organization_region_parent"
                        style="display: {{ old('region_id') || $errors->has('region_id') ? 'block' : 'none' }}; margin-top:47px;">
                        <select id="organization_region" class="organization_region_select2 select2 form-control"
                            name="region_id" data-placeholder="Pick Region" data-dropdown-css-class="select2-blue">
                            <option value="">Select Region</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}"
                                    {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}</option>
                            @endforeach
                        </select>
                        @error('region_id')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="select2-blue form-group" id="organization_zone_parent"
                        style="display: {{ old('zone_id') || $errors->has('zone_id') ? 'block' : 'none' }}; margin-top:47px;">
                        <select id="organization_zone" class="organization_zone_select2 select2 form-control"
                            name="zone_id" data-placeholder="Pick Zone" data-dropdown-css-class="select2-blue">
                            <option value="">Select Zone</option>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('zone_id')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
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
            <!-- /.card-footer -->
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-info float-right mx-3">Submit</button>
            </div>
            <!-- /.card-footer -->
        </form>
        <!-- /#user_form -->

    </div>
    <!-- /.card -->
    <!-- /.content -->

    <!-- Custom Js contents -->
    @push('scripts')
        <script>
            $('.organization_type_select2').select2();
            $('.organization_level_select2').select2();
            $('.organization_region_select2').select2();
            $('.organization_zone_select2').select2();
        </script>
        <script>
            function showSecondDropdown(element) {
                //edit toogle region zone federal 
                var region_parent = $('#organization_region_parent');
                var zone_parent = $('#organization_zone_parent');

                if ($(element).val() === "2") {
                    $('.organization_region_select2').val(null).trigger('change');
                    zone_parent.css('display', 'none');
                    region_parent.css('display', 'block');
                } else if ($(element).val() === "3") {
                    $('.organization_region_select2').val(null).trigger('change');
                    $('.organization_zone_select2').val(null).trigger('change');
                    region_parent.css('display', 'block');
                    zone_parent.css('display', 'block');
                    console.log('zonallll');
                } else {
                    $('.organization_region_select2').val(null).trigger('change');
                    $('.organization_zone_select2').val(null).trigger('change');
                    region_parent.css('display', 'none');
                    zone_parent.css('display', 'none');
                    $(element).parent().show();
                }
            }


            var zonesData = @json($zones);

            $('#organization_region').change(function() {
                var selectedRegionId = $(this).val();
                var zoneSelect = $('#organization_zone');
                // Clear existing options
                zoneSelect.empty();
                // Populate the Zone dropdown based on the selected Region if the issue level is zonal
                if (selectedRegionId !== "" && $('#organization_level').val() == 3) {
                    zonesData.forEach(function(zone) {
                        if (zone.region_id == selectedRegionId) {
                            zoneSelect.append($('<option>', {
                                value: zone.id,
                                text: zone.name
                            }));
                        }
                    });
                    zoneSelect.show();
                }
            });
        </script>
    @endpush

</x-layout>
