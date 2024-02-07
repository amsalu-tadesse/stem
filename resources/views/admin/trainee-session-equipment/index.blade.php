<x-layout>
        <!-- Content Header (Page header) -->
        <x-breadcrump title='Trainee Session Equipment List' parent='Trainee Session Equipment' child='List' />
        <!-- /.content-header -->
    
        <!-- /.content-Main -->
        <div class='card'>
            <div class='card-header'>
                <div class='col'>
                    <div style='display: flex; justify-content:flex-end'>
                        <div>
                        @can('trainee-session-equipmentt: create')
                        <a href="{{route('admin.trainee-session-equipment.create') }}">
                            <button type='button' class='btn btn-primary'>Add New Trainee Session Equipment</button>
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
        <x-partials.trainee_session_equipment_modal:trainee_sessions="$trainee_sessions":equipment="$equipment" />
        <x-show-modals.trainee_session_equipment_show_modal />
        <!-- /#updateModal -->
        <!-- /.content -->
        <!-- Custom Js contents -->
        @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        <script>$('.trainee_sessions_select2').select2();$('.equipment_select2').select2();</script>
        <script>


            //delete row
            function delete_row(element, row_id) {
                var url = "{{ route('admin.trainee-session-equipment.destroy', ':id') }}";
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
                                    window.LaravelDataTables['trainee-session-equipment-table'].ajax.reload();
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
    
                toastr.success('You have successfuly added a new Trainee Session Equipment')
            }
    
            $(document).ready(function() {
                // Update record popup
                $('#trainee-session-equipment-table').on('click', '#update_row', function() {
                    var row_id = $(this).data('row_id');
                    var url = "{{ route('admin.trainee-session-equipment.edit', ':id') }}";
                    url = url.replace(':id', row_id);
    
                    // AJAX request
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log('success');
                            var trainee_session_equipment = response.trainee_session_equipment
                            if (response.success == 1) {
                                console.log(trainee_session_equipment);
                                $('#trainee_session_equipment_id').val(trainee_session_equipment.id);
$('#trainee_session_id').val(trainee_session_equipment.trainee_session_id);
$('#equipment_id').val(trainee_session_equipment.equipment_id);
 $('#update_modal').modal('show');
    
                            } else {
                                alert('Invalid ID.');
                            }
                        }
                    });
                });

                //show
                $('#trainee-session-equipment-table').on('click', '#show_row', function() {
                    var row_id = $(this).data('row_id');
                    var url = "{{ route('admin.trainee-session-equipment.show', ':id') }}";
                    url = url.replace(':id', row_id);
    
                    // AJAX request
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log('success');
                            var trainee_session_equipment = response.trainee_session_equipment
                            if (response.success == 1) {
                                console.log(trainee_session_equipment);
                                $('#trainee_session_equipment_id').val(trainee_session_equipment.id);$('#show_modal #trainee_session_id').html(trainee_session_equipment.trainee_session_id);
$('#show_modal #equipment_id').html(trainee_session_equipment.equipment_id);
 $('#show_modal').modal('show');
    
                            } else {
                                alert('Invalid ID.');
                            }
                        }
                    });
                });
            });
    
    
            $('#trainee_session_equipment_update_form').on('submit', function(e) {
                e.preventDefault();
                form_data = $(this).serialize();
                row_id = $('#trainee_session_equipment_id', $(this)).val()
                console.log(row_id);

                var url = "{{ route('admin.trainee-session-equipment.update', ':id') }}";
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
                            window.LaravelDataTables['trainee-session-equipment-table'].ajax.reload();
                            toastr.success('You have successfuly updated a Trainee Session Equipment.')
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
    