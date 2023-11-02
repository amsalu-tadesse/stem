<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="Organization Levels List" parent="Organization Level" child="List" />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class="card">
        <div class="card-header">
            <div class="col">
                {{-- <h3 class="card-title">Organization Level List Table</h3> --}}
                <div style="display: flex; justify-content:flex-end">
                    <div>
                    @can('organization-level: create')
                    <a href="{{route('admin.organization-levels.create') }}">
                        <button type="button" class="btn btn-primary">Add New Organization Level</button>
                    </a>
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
    <x-partials.organizationLevel_modal />
    <x-show-modals.organizationLevel_show_modal />
    <!-- /#updateModal -->
    <!-- /.content -->
    <!-- Custom Js contents -->
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    </script>
    <script>
        //delete row
        function delete_user(element, user_id) {
            var url = "{{ route('admin.organization-levels.destroy', ':id') }}";
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
                                window.LaravelDataTables["organizationLevels-table"].ajax.reload();
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

            toastr.success('You have successfuly added a new Organization Levels.')
        }

        $(document).ready(function() {
            // Update record popup
            $('#organizationLevels-table').on('click', '#update_user', function() {
                var user_id = $(this).data('user_id');
                var url = "{{ route('admin.organization-levels.edit', ':id') }}";
                url = url.replace(':id', user_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');

                        if (response.success == 1) {
                            console.log(response);
                            $('#organizationLevel_id').val(response.organizationLevel_id);
                            $('#name').val(response.name);
                            $('#description').val(response.description);
                            $('#update_modal').modal('show');

                        } else {
                            alert("Invalid ID.");
                        }
                    }
                });
            });
            $('#organizationLevels-table').on('click', '#show_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.organization-levels.show', ':id') }}";
                url = url.replace(':id', row_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log('success');
                        var organizationLevel = data.organizationLevel;
                        if (data.success == 1) {
                            console.log(organizationLevel);
                            $('#show_modal #organizationLevel_id').html(organizationLevel.organizationLevel_id);
                            $('#show_modal #name').html(organizationLevel.name);
                            $('#show_modal #description').html(organizationLevel.description);
                            $('#show_modal #created_by').html(data.getCreatedBy);
                            $('#show_modal #created_at').html(organizationLevel.created_at);
                            $('#show_modal').modal('show');
                        } else {
                            alert("Invalid ID.");
                        }
                    }
                });
            });
        });


        $('#organizationLevel_update_form').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            user_id = $('#organizationLevel_id', $(this)).val()
            console.log(user_id);

            // var user_id = form_data['user_id']
            var url = "{{ route('admin.organization-levels.update', ':id') }}";
            url = url.replace(':id', user_id);

            // AJAX request
            $.ajax({
                url: url,
                type: "PATCH",
                data: form_data,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        console.log("111111111111111");
                        console.log(data);
                        console.log("2222222222222222");
                        $('#update_modal').modal('toggle');
                        window.LaravelDataTables["organizationLevels-table"].ajax.reload();
                        toastr.success('You have successfuly updated a Organization Level.')
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
