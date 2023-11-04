<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="Users List" parent="Users" child="List" />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class="card">
        <div class="card-header">
            <div>

                <div class="row mx-2">
                    <div class="form-group col-md-6">
                        <div class="select2-blue">
                            <select name="user_group" id='user_group_filter' class="form-control select2" multiple
                                data-placeholder="User groups" data-dropdown-css-class="select2-blue"
                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">--All User Groups--</option>
                                <option value="superadmin">Superadmins</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex row col-md-6 px-md-3 pl-3 pr-1">
                    <div class="col-md-4 mt-2">
                        <button type="button" id="user_filter_button"
                            class="btn btn-success form-control">Search</button>
                    </div>
                    <div class="col-md-4 mt-2">
                        <button type="button" id="user_reset_button"
                            class="btn btn-warning form-control">Reset</button>
                    </div>
                </div>
            </div>

            <div class="col mt-5">
                <div style="display: flex; justify-content:flex-end">
                    <div>
                    @can('user: create')
                    <a href="{{ route('admin.users.create') }}">
                        <button type="button" class="btn btn-primary">Add New User</button></a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            {{ $dataTable->table(['class' => 'table table-bordered table-striped']) }}
        </div>

        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <!-- /#updateModal -->
    <x-partials.modal :roles="$roles" :organizations="$organizations" />
    <x-show-modals.user-modal />
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
            $('.role_select2').select2();
            $('.organization_select2').select2();

            // filtering user based on usergroup, organization and organization levels
            $('#user_group_filter').select2();
            $('#organization_filter').select2();
            $('#organization_level_filter').select2();
        </script>

        <script>
            $('#user_filter_button').on('click', function() {
                window.LaravelDataTables["users-table"].ajax.reload();
            });

            $('#user_reset_button').on('click', function() {
                $('#user_group_filter, #organization_filter, #organization_level_filter').val([]).trigger('change');
                console.log('clicked');
                window.LaravelDataTables["users-table"].ajax.reload();
            });
        </script>

        <script>
            //delete row
            function delete_row(element, user_id) {
                var url = "{{ route('admin.users.destroy', ':id') }}";
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
                                    window.LaravelDataTables["users-table"].ajax.reload();
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
                            "Your imaginary file is safe :)",
                            'error'
                        )
                    }
                })
            }

            if (@json(session('success_create'))) {

                toastr.success('You have successfuly added a new user.')
            }


            //Show user
            // $(document).ready(function() {

            // });



            //update User
            $(document).ready(function() {
                // Update record popup
                $('#users-table').on('click', '#update_row', function() {
                    var row_id = $(this).data('row_id');
                    var url = "{{ route('admin.users.edit', ':id') }}";
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
                                $('#user_id').val(response.user_id);
                                $('#first_name').val(response.first_name);
                                $('#middle_name').val(response.middle_name);
                                $('#last_name').val(response.last_name);
                                $('#email').val(response.email);
                                $('#mobile').val(response.mobile);

                                // select organizations
                                if (response.organization_id) {

                                    $('.organization_select2').val(response.organization_id)
                                        .trigger('change');
                                } else {
                                    $('.organization_select2').val('').trigger('change');
                                }

                                if (response.is_superadmin == 1) {
                                    $('#is_superadmin').prop('checked', true);
                                } else {
                                    $('#is_superadmin').prop('checked', false);
                                }
                                if (response.status == 1) {
                                    $("input[data-bootstrap-switch]").each(function() {
                                        $(this).bootstrapSwitch('state', true);
                                    });
                                } else {
                                    $("input[data-bootstrap-switch]").each(function() {
                                        $(this).bootstrapSwitch('state', false);
                                    });
                                }
                                roles = @json($roles);
                                role_index = [];

                                //get role index
                                $.each(roles, function(index, role) {
                                    role_index.push(role['id']);
                                })

                                //get selected roles
                                selected_roles = []
                                $.each(response.user_roles, function(value, index) {
                                    if ($.inArray(index, role_index) != -1) {
                                        selected_roles.push(index);
                                    }
                                });
                                if (selected_roles) $('.role_select2').val(selected_roles).trigger(
                                    'change'); // Notify any JS components that the value changed

                                $('#update_modal').modal('show');

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

                //show user
                $('#users-table').on('click', '#show_row', function() {
                    var row_id = $(this).data('row_id');
                    var url = "{{ route('admin.users.show', ':id') }}";
                    url = url.replace(':id', row_id);

                    // AJAX request
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                            console.log('success');
                            var user = data.user;
                            if (data.success == 1) {
                                console.log(user);
                                $('#show_modal #user_id').html(user.id);
                                var firstName = user.first_name;
                                var middleName = user.middle_name;
                                var lastName = user.last_name;
                                var fullName = firstName + ' ' + middleName + ' ' + lastName;
                                $('#show_modal #full_name').html(fullName);
                                $('#show_modal #email').html(user.email);
                                $('#show_modal #mobile').html(user.mobile);
                                var is_super = user.is_superadmin == 1 ? "YES" : "NO"
                                $('#show_modal #is_superadmin').html(is_super);
                                $('#show_modal #created_by').html(data.getCreatedBy);
                                $('#show_modal #created_at').html(user.created_at);
                                var status = user.status == 1 ? "ACTIVE" : "INACTIVE"
                                $('#show_modal #status').html(status);
                                var password_changed = user.password_changed == 1 ? "YES" : "NO"
                                $('#show_modal #password_changed').html(password_changed);
                                $('#show_modal #organization_id').html(user.organization ? user
                                    .organization.name : '');
                                $('#show_modal #organization_level').html(data.organization_level);

                                var selected_roles = [];
                                $.each(user.roles, function(index, value) {
                                    selected_roles.push(
                                        '<span class="badge badge-success">' + value
                                        .name + '</span>');
                                });
                                selected_roles_string = selected_roles.join(' ')
                                $('#show_modal #user_roles').html(selected_roles_string);
                                $('#show_modal #email_verified_at').html(user.email_verified_at);
                                $('#show_modal').modal('show');

                            } else {
                                alert("Invalid ID.");
                            }
                        },
                        error: function(error) {
                            if (error.status == 422) {
                                // when status code is 422, it's a validation issue
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


            $('#user_update_form').on('submit', function(e) {
                e.preventDefault();
                form_data = $(this).serialize();
                user_id = $('#user_id', $(this)).val()
                console.log(user_id, form_data['user_id']);

                // var user_id = form_data['user_id']
                var url = "{{ route('admin.users.update', ':id') }}";
                url = url.replace(':id', user_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: "PATCH",
                    data: form_data,
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            console.log(data);
                            $('#update_modal').modal('toggle');
                            window.LaravelDataTables["users-table"].ajax.reload();
                            toastr.success('You have successfuly updated a user.')
                        }
                    },
                    error: function(error) {
                        console.log('error');
                    }
                });

            });
        </script>
    @endpush
    <!-- Custom Js contents -->
</x-layout>
