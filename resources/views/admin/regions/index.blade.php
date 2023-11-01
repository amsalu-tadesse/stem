<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="Regions List" parent="Regions" child="List" />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class="card">
        <div class="card-header">
            <div class="col">
                <div style="display: flex; justify-content:flex-end">
                    <div>
                    @can('region: create')
                    <a href="{{route('admin.regions.create') }}">
                        <button type="button" class="btn btn-primary">Add New Region</button>
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
    <x-partials.region_modal />
    <!-- /#updateModal -->
    <!-- /.content -->
    <!-- Custom Js contents -->
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $("input[type='checkbox']").each(function() {
            $(this).prop('checked', $(this).prop('checked'));
        });
    </script>
    <script>
        //delete row
        function delete_user(element, user_id) {
            var url = "{{ route('admin.regions.destroy', ':id') }}";
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
                                window.LaravelDataTables["regions-table"].ajax.reload();
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

            toastr.success('You have successfuly added a new Region.')
        }
        $(document).ready(function() {
            // Update record popup
            $('#regions-table').on('click', '#update_user', function() {
                var user_id = $(this).data('user_id');
                var url = "{{ route('admin.regions.edit', ':id') }}";
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
                            $('#region_id').val(response.region_id);
                            $('#name').val(response.name);
                            $('#ordering').val(response.ordering);
                            if (response.is_cityadministration == 1) {
                                $("input[type='checkbox']").each(function() {
                                    $(this).prop('checked', true);
                                });
                            } else {
                                $("input[type='checkbox']").each(function() {
                                    $(this).prop('checked', false);
                                });
                            }

                            $('#update_modal').modal('show');

                        } else {
                            alert("Invalid ID.");
                        }
                    }
                });
            });
        });


        $('#region_update_form').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            user_id = $('#region_id', $(this)).val()
            console.log(user_id);

            // var user_id = form_data['user_id']
            var url = "{{ route('admin.regions.update', ':id') }}";
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
                        window.LaravelDataTables["regions-table"].ajax.reload();
                        toastr.success('You have successfuly updated a Region.')
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
