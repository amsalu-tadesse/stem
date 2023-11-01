<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="Organizations List" parent="Organizations" child="List" />
    <!-- /.content-header -->
    <!-- /.content-Main -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="row mx-2">
                    <!-- Organization select2 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="select2-blue">
                                <select name="organization_type" class="form-control select2"
                                    id="organization_type_filter" multiple data-placeholder="Organization Types"
                                    data-dropdown-css-class="select2-blue" style="width: 100%;" tabindex="-1"
                                    aria-hidden="true">
                                    @foreach ($organization_types as $organization_type)
                                        <option value="{{ $organization_type->id }}">{{ $organization_type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Organization select2 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="select2-blue">
                                <select name="organization_level" class="form-control select2"
                                    id="organization_level_filter" multiple data-placeholder="Organization Levels"
                                    data-dropdown-css-class="select2-blue" style="width: 100%;" tabindex="-1"
                                    aria-hidden="true">
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex row col-md-6 px-md-3 pl-3 pr-1">
                    <div class="col-md-4 mt-2">
                        <button type="button" id="organization_filter_button"
                            class="btn btn-success form-control">Search</button>
                    </div>
                    <div class="col-md-4 mt-2">
                        <button type="button" id="organization_reset_button"
                            class="btn btn-warning form-control">Reset</button>
                    </div>
                    {{-- <div class="col-md-4 mt-2">
                        <a class="btn btn-primary form-control" id="activity_log">
                            <span class="fa fa-eye">&nbsp</span>Show
                        </a>
                    </div> --}}
                </div>
            </div>

            <div class="col mt-5">
                {{-- <h3 class="card-title">Organizations List Table</h3> --}}
                <div style="display: flex; justify-content:flex-end">
                    <div>
                        @can('organization: create')
                            <a href="{{ route('admin.organizations.create') }}">
                                <button type="button" class="btn btn-primary">Add New Organization </button>
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- /.card-header -->
        <div class="card-body">
            {{ $dataTable->table(['class' => 'table table-bordered table-striped']) }}
        </div>

        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <!-- /#updateModal -->
    <x-partials.organization_modal :types="$organization_types" :levels="$levels" :regions="$regions" :zones="$zones" />
    <x-show-modals.organization_show_modal />
    <!-- /#updateModal -->
    <!-- /.content -->
    <!-- Custom Js contents -->
    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

        <script>
            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });
            //Initialize Select2 Elements
            $('.organization_level_select2').select2();

            //region and zone
            $('.organization_region_select2').select2();
            $('.organization_zone_select2').select2();

            //initialize both organization type and level select2
            $('#organization_type_filter').select2();
            $('#organization_level_filter').select2();
        </script>

        <!-- filtering organization by type and level  -->
        <script>
            $('#organization_filter_button').on('click', function() {
                window.LaravelDataTables["organizations-table"].ajax.reload();
            });

            $('#organization_reset_button').on('click', function() {
                $('#organization_type_filter, #organization_level_filter').val([]).trigger('change');
                console.log('clicked');
                window.LaravelDataTables["organizations-table"].ajax.reload();
            });
        </script>
        <script>
            //delete row
            function delete_user(element, user_id) {
                var url = "{{ route('admin.organizations.destroy', ':id') }}";
                url = url.replace(':id', user_id);
                console.log(url);

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-1',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: url,
                            data: {
                                user_id: user_id,
                            },
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                                if (data.success) {
                                    window.LaravelDataTables["organizations-table"].ajax.reload();
                                }
                            },
                            error: function(error) {
                                if (error.status ==
                                    422) { // when status code is 422, it's a validation issue

                                }
                                console.log('debug error here');
                            }
                        })
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Your imaginary file is safe :)',
                            'error'
                        )
                    }
                })
            }

            if (@json(session('success_create'))) {

                toastr.success('You have successfuly added a new Organization.')
            }

            var zonesData = @json($zones);

            $(document).ready(function() {
                // Update record popup
                $('#organizations-table').on('click', '#update_user', function() {
                    var user_id = $(this).data('user_id');
                    var url = "{{ route('admin.organizations.edit', ':id') }}";
                    url = url.replace(':id', user_id);

                    // AJAX request
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: 'json',
                        success: function(response) {
                            console.log('success');

                            if (response.success == 1) {
                                // console.log(response);
                                $('#organization_id').val(response.organization.id);
                                $('#name').val(response.organization.name);
                                $('#description').val(response.organization.description);

                                // select organization types
                                if (response.organization.organization_type_id)
                                    $('.organization_type_select2').val(response.organization
                                        .organization_type_id).trigger({
                                        type: "change",
                                        user: "program-agent",
                                    });

                                // select zone
                                if (response.organization.zone_id) {

                                    //-------------------------------------------
                                    console.log('here inside region change');
                                    var selectedRegionId = response.organization.region_id;
                                    var zoneSelect = $('.organization_zone_select2');
                                    // Clear existing options
                                    zoneSelect.empty();
                                    // Populate the Zone dropdown based on the selected Region if the issue level is zonal
                                    if (selectedRegionId !== "" && response.organization
                                        .organization_level_id == 3) {
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
                                    //-------------------------------------------


                                    $('.organization_zone_select2').val(response.organization
                                            .zone_id)
                                        .trigger({
                                            type: "change",
                                            user: "program-agent",
                                        });
                                    $('#organization_zone_parent').css('display', 'block');
                                } else {
                                    $('#organization_zone_parent').css('display',
                                        'none');
                                    $('.organization_zone_select2').val('').trigger({
                                        type: "change",
                                        user: "program-agent",
                                    });

                                }

                                // select region
                                if (response.organization.region_id) {
                                    $('.organization_region_select2').val(
                                            response.organization.region_id)
                                        .trigger({
                                            type: "change",
                                            user: "program-agent",
                                        });
                                    $('#organization_region_parent').css('display', 'block');
                                } else {

                                    $('#organization_region_parent').css('display',
                                        'none');
                                    $('.organization_region_select2').val('').trigger({
                                        type: "change",
                                        user: "program-agent",
                                    });

                                }

                                // select Organization Level
                                if (response.organization.organization_level_id) $(
                                    '.organization_level_select2').val(
                                    response.organization.organization_level_id).trigger({
                                    type: "change",
                                    user: "program-agent",
                                });
                                else $('#organization_organization_level').val('').trigger({
                                    type: "change",
                                    user: "program-agent",
                                });

                                $('#organization_update_modal').modal('toggle');

                            } else {
                                toastr.error('Bad Requst to the server');
                            }
                        },
                        error: function(error) {

                            toastr.error('Something wrong with the server!');
                        }
                    });
                });

                // update
                $('#organizations-table').on('click', '#show_row', function() {
                    var row_id = $(this).data('row_id');
                    var url = "{{ route('admin.organizations.show', ':id') }}";
                    url = url.replace(':id', row_id);

                    // AJAX request
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: 'json',
                        success: function(response) {
                            console.log('success');

                            if (response.success == 1) {
                                console.log(response);
                                $('#show_modal #name').html(response.name);
                                $('#show_modal #description').html(response.description);
                                // $('#show_row #created_by').val(response.getCreatedBy);
                                $('#show_modal #created_at').html(response.created_at);
                                $('#show_modal #organizationType').html(response
                                    .organization_type_id);
                                $('#show_modal #organizationLevel').html(response
                                    .organization_level_id);
                                $('#show_modal #region_id').html(response.region_id);
                                $('#show_modal #zone_id').html(response.zone_id);
                                $('#show_modal').modal('show');

                            } else {
                                alert("Invalid ID.");
                            }
                        },
                        error: function(error) {
                            if (error.status ==
                                422) { // when status code is 422, it's a validation issue
                                console.log('validation error');
                                $.each(error.responseJSON.errors, function(key, error) {
                                    console.log('validation error');
                                    $("#" + key + "_error").text(error);
                                });
                            }
                            console.log('error');
                        }
                    });
                });
            });


            $('#organization_update_form').on('submit', function(e) {
                e.preventDefault();
                form_data = $(this).serialize();
                user_id = $('#organization_id', $(this)).val()
                console.log(user_id);

                // var user_id = form_data['user_id']
                var url = "{{ route('admin.organizations.update', ':id') }}";
                url = url.replace(':id', user_id);

                $('.error').text('');

                // AJAX request
                $.ajax({
                    url: url,
                    type: "PATCH",
                    data: form_data,
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            console.log(data);
                            $('#organization_update_modal').modal('toggle');
                            window.LaravelDataTables["organizations-table"].ajax.reload();
                            toastr.success('You have successfuly updated a Organization.')
                        }
                    },
                    error: function(error) {
                        console.log('error');
                        if (error.status == 422) { // when status code is 422, it's a validation issue
                            console.log('validation error');
                            $.each(error.responseJSON.errors, function(key, error) {
                                console.log('validation error');
                                $("#" + key + "_error").text(error);
                            });
                        } else {

                            toastr.error('Something wrong with the server!');
                        }
                    }
                });

            });

            //organization edit toggle organization levels federal, regional, and zonal
            $('#organization_update_modal #organization_level').on('change', function(event) {
                console.log('change event->');
                console.log(event); // "click"

                // get into this if the change is made by mouse interaction, not by program-agent
                if (typeof event.user == 'undefined') {
                    console.log('change inside');
                    var region_parent = $('#organization_region_parent');
                    var zone_parent = $('#organization_zone_parent');

                    if ($(this).val() === "2") {
                        $('.organization_region_select2').val(null).trigger('change');
                        zone_parent.css('display', 'none');
                        region_parent.css('display', 'block');
                    } else if ($(this).val() === "3") {
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
                        $(this).parent().show();
                    }
                }
            });

            //populate the zones with in the selected region in edit modal

            $('#organization_update_modal #organization_region').on('change', function(event) {
                if (typeof event.user == 'undefined') {
                    console.log('here inside region change');
                    var selectedRegionId = $(this).val();
                    var zoneSelect = $('.organization_zone_select2');

                    zoneSelect.empty();

                    if (selectedRegionId !== "" && $('.organization_level_select2').val() == 3) {
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
                }
            });



            function authorizeOrganization(element, user_id) {
                var url = "{{ route('admin.organizations.authorize', ':id') }}";
                url = url.replace(':id', user_id);
                console.log(url);

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-1',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to authorize this entity?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: url,
                            data: {
                                user_id: user_id,
                            },
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                                if (data.success) {
                                    window.LaravelDataTables["organizations-table"].ajax.reload();
                                }
                            },
                            error: function(error) {
                                if (error.status ==
                                    422) { // when status code is 422, it's a validation issue

                                }
                            }
                        })

                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'No change has been done',
                            'error'
                        )
                    }
                })
            }


            function unAuthorizeOrganization(element, user_id) {
                var url = "{{ route('admin.organizations.unauthorize', ':id') }}";
                url = url.replace(':id', user_id);
                console.log(url);

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-1',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to deny authorization this entity?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: url,
                            data: {
                                user_id: user_id,
                            },
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                                if (data.success) {
                                    window.LaravelDataTables["organizations-table"].ajax.reload();
                                }
                            },
                            error: function(error) {
                                if (error.status ==
                                    422) { // when status code is 422, it's a validation issue

                                }
                            }
                        })

                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'No change has been done',
                            'error'
                        )
                    }
                })
            }
        </script>
    @endpush
    <!-- Custom Js contents -->


</x-layout>
