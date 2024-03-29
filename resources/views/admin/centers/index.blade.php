<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Centers List' parent='Centers' child='List' />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class='card'>
        <div class='card-header'>
            <div class='col'>
                <div style='display: flex; justify-content:flex-end'>
                    <div>
                        @can('center: create')
                        <a href="{{route('admin.centers.create') }}">
                            <button type='button' class='btn btn-primary'>Add New Center</button>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class='card-body'>
            {{ $dataTable->table(['class' => 'table table-bordered table-striped']) }}
        </div>

        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <!-- /#updateModal -->
    <x-partials.center_modal />
    <x-show-modals.center_show_modal />
    <!-- /#updateModal -->
    <!-- /.content -->
    <!-- Custom Js contents -->
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script></script>
    <script>
        //delete row
        function delete_row(element, row_id) {
            var url = "{{ route('admin.centers.destroy', ':id') }}";
            url = url.replace(':id', row_id);
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
                        type: 'DELETE',
                        url: url,
                        data: {
                            row_id: row_id,
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            if (data.success) {
                                window.LaravelDataTables['centers-table'].ajax.reload();
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

            toastr.success('You have successfuly added a new Center')
        }

        $(document).ready(function() {
            // Update record popup
            $('#centers-table').on('click', '#update_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.centers.edit', ':id') }}";
                url = url.replace(':id', row_id);
                
                $('#center_update_form :input').val('');
                // AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        var center = response.center
                        if (response.success == 1) {
                            console.log(center);
                            $('#center_id').val(center.id);
                            $('#name').val(center.name);
                            $('#description').val(center.description);
                            $('#update_modal').modal('show');

                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });

            //show
            $('#centers-table').on('click', '#show_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.centers.show', ':id') }}";
                url = url.replace(':id', row_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        var center = response.center
                        if (response.success == 1) {
                            console.log(center);
                            $('#center_id').val(center.id);
                            $('#show_modal #name').html(center.name);
                            $('#show_modal #description').html(center.description);
                            $('#show_modal').modal('show');

                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });
        });


        $('#center_update_form').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            row_id = $('#center_id', $(this)).val()
            console.log(row_id);

            var url = "{{ route('admin.centers.update', ':id') }}";
            url = url.replace(':id', row_id);

            // AJAX request
            $.ajax({
                url: url,
                type: 'PATCH',
                data: form_data,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        console.log('111111111111111');
                        console.log(data);
                        console.log('2222222222222222');
                        $('#update_modal').modal('toggle');
                        window.LaravelDataTables['centers-table'].ajax.reload();
                        toastr.success('You have successfuly updated a Center.')
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