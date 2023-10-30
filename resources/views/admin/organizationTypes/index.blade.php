<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="Organization Types List" parent="Organization Types" child="List" />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class="card">
        <div class="card-header">
            <div class="col">
                {{-- <h3 class="card-title">Organization Types List Table</h3> --}}
                <div style="display: flex; justify-content:flex-end">
                    <div>
                    @can('organization-type: create')
                    <a href="{{route('admin.organization-types.create') }}">
                        <button type="button" class="btn btn-primary">Add New Organization Type</button>
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
    <x-partials.organizationType_modal />
    <x-show-modals.organizationType_show_modal />
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
        //delete user
        function delete_user(element, user_id) {
            var url = "{{ route('admin.organization-types.destroy', ':id') }}";
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
                                window.LaravelDataTables["organizationTypes-table"].ajax.reload();
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

            toastr.success('You have successfuly added a new Organization Type.')
        }

        $(document).ready(function() {
            // Update record popup
            $('#organizationTypes-table').on('click', '#update_user', function() {
                var user_id = $(this).data('user_id');
                var url = "{{ route('admin.organization-types.edit', ':id') }}";
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
                            $('#organizationType_id').val(response.organizationType_id);
                            $('#name').val(response.name);
                            $('#description').val(response.description);
                            $('#update_modal').modal('show');

                        } else {
                            alert("Invalid ID.");
                        }
                    }
                });
            });
            $('#organizationTypes-table').on('click', '#show_row', function() {
                var user_id = $(this).data('row_id');
                var url = "{{ route('admin.organization-types.show', ':id') }}";
                url = url.replace(':id', user_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log('success');
                        var organizationType = data.organizationType;
                        if (data.success == 1) {
                            console.log(organizationType);
                            $('#show_modal #organizationType_id').html(organizationType.organizationType_id);
                            $('#show_modal #name').html(organizationType.name);
                            $('#show_modal #description').html(organizationType.description);
                            $('#show_modal #created_by').html(data.getCreatedBy);
                            $('#show_modal #created_at').html(organizationType.created_at);
                            $('#show_modal').modal('show');
                        } else {
                            alert("Invalid ID.");
                        }
                    }
                });
            });
        });


        $('#organizationType_update_form').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            user_id = $('#organizationType_id', $(this)).val()
            console.log(user_id);

            // var user_id = form_data['user_id']
            var url = "{{ route('admin.organization-types.update', ':id') }}";
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
                        window.LaravelDataTables["organizationTypes-table"].ajax.reload();
                        toastr.success('You have successfuly updated a Organization Type.')
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
