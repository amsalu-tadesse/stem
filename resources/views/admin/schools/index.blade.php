<x-layout>
    <x-breadcrump title="Schools List" parent="Schools" child="List" />

    <div class="card">
        <div class="card-header">
            <div class="col">
                <div style="display: flex; justify-content:flex-end">
                    <div>
                        @can('schools: create')
                        <a href="{{route('admin.schools.create') }}">
                            <button type="button" class="btn btn-primary">Add New School</button>
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
    <x-partials.school_modal :school_levels="$school_levels" />
    <!-- /#updateModal -->
    <!-- /.content -->
    <!-- Custom Js contents -->
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $('.school_level_select2').select2();
    </script>
    <script>
        //delete row
        function delete_row(element, user_id) {
            var url = "{{ route('admin.schools.destroy', ':id') }}";
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
                                window.LaravelDataTables["schools-table"].ajax.reload();
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
            toastr.success('You have successfuly added a new School.')
        }


        $(document).ready(function() {
            // Update record popup
            $('#schools-table').on('click', '#update_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.schools.edit', ':id') }}";
                url = url.replace(':id', row_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        if (response.success == 1) {
                            var school = response.school;
                            console.log(response);
                            $('#school_id').val(school.id);
                            $('#name').val(school.name);
                            $('#address').val(school.address);
                            if (school.school_level)
                                    $('.school_level_select2').val(school
                                        .school_level).trigger({
                                        type: "change",
                                        user: "program-agent",
                                    });
                            $('#update_modal').modal('show');

                        } else {
                            alert("Invalid ID.");
                        }
                    }
                });
            });
        });


        $('#school_update_form').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            row_id = $('#school_id', $(this)).val()
            console.log(row_id);
            var url = "{{ route('admin.schools.update', ':id') }}";
            url = url.replace(':id', row_id);

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
                        window.LaravelDataTables["schools-table"].ajax.reload();
                        toastr.success('You have successfuly updated a school.')
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