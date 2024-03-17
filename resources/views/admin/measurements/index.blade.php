<x-layout>
        <!-- Content Header (Page header) -->
        <x-breadcrump title='Measurements List' parent='Measurements' child='List' />
        <!-- /.content-header -->
    
        <!-- /.content-Main -->
        <div class='card'>
            <div class='card-header'>
                <div class='col'>
                    <div style='display: flex; justify-content:flex-end'>
                        <div>
                        @can('measurement: create')
                        <a href="{{route('admin.measurements.create') }}">
                            <button type='button' class='btn btn-primary'>Add New Measurement</button>
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
        <x-partials.measurement_modal />
        <x-show-modals.measurement_show_modal />
        <!-- /#updateModal -->
        <!-- /.content -->
        <!-- Custom Js contents -->
        @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        <script></script>
        <script>


            //delete row
            function delete_row(element, row_id) {
                var url = "{{ route('admin.measurements.destroy', ':id') }}";
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
                                    window.LaravelDataTables['measurements-table'].ajax.reload();
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
    
                toastr.success('You have successfuly added a new Measurement')
            }
    
            $(document).ready(function() {
                // Update record popup
                $('#measurements-table').on('click', '#update_row', function() {
                    var row_id = $(this).data('row_id');
                    var url = "{{ route('admin.measurements.edit', ':id') }}";
                    url = url.replace(':id', row_id);
    
                    // AJAX request
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log('success');
                            var measurement = response.measurement
                            if (response.success == 1) {
                                console.log(measurement);
                                $('#measurement_id').val(measurement.id);
$('#name').val(measurement.name);
$('#description').val(measurement.description);
 $('#update_modal').modal('show');
    
                            } else {
                                alert('Invalid ID.');
                            }
                        }
                    });
                });

                //show
                $('#measurements-table').on('click', '#show_row', function() {
                    var row_id = $(this).data('row_id');
                    var url = "{{ route('admin.measurements.show', ':id') }}";
                    url = url.replace(':id', row_id);
    
                    // AJAX request
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log('success');
                            var measurement = response.measurement
                            if (response.success == 1) {
                                console.log(measurement);
                                $('#measurement_id').val(measurement.id);$('#show_modal #name').html(measurement.name);
$('#show_modal #description').html(measurement.description);
 $('#show_modal').modal('show');
    
                            } else {
                                alert('Invalid ID.');
                            }
                        }
                    });
                });
            });
    
    
            $('#measurement_update_form').on('submit', function(e) {
                e.preventDefault();
                form_data = $(this).serialize();
                row_id = $('#measurement_id', $(this)).val()
                console.log(row_id);

                var url = "{{ route('admin.measurements.update', ':id') }}";
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
                            window.LaravelDataTables['measurements-table'].ajax.reload();
                            toastr.success('You have successfuly updated a Measurement.')
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
    