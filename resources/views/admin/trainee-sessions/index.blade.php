<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Trainee Sessions List' parent='Trainee Sessions' child='List' />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class='card'>
        <div class='card-header'>
            <div class='col'>
                <div style='display: flex; justify-content:flex-end'>
                    <div>
                        @can('trainee-session: create')
                        <a href="{{route('admin.trainee-sessions.create') }}">
                            <button type='button' class='btn btn-primary'>Add New Trainee Session</button>
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
    <x-partials.trainee_session_modal :equipment="$equipment" />
    <x-show-modals.trainee_session_show_modal />
    <!-- /#updateModal -->
    <!-- /.content -->
    <!-- Custom Js contents -->
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $(function() {
            $('#start_date').datetimepicker({
                pickTime: false
            });
            $('#end_date').datetimepicker({
                pickTime: false
            });

        });
    </script>
    <script>
        $('.equipment_idd_select2').select2();
    </script>
    <script>
        //delete row
        function delete_row(element, row_id) {
            var url = "{{ route('admin.trainee-sessions.destroy', ':id') }}";
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
                                window.LaravelDataTables['trainee-sessions-table'].ajax.reload();
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

            toastr.success('You have successfuly added a new Trainee Session')
        }

        $(document).ready(function() {
            // Update record popup
            $('#trainee-sessions-table').on('click', '#update_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.trainee-sessions.edit', ':id') }}";
                url = url.replace(':id', row_id);

                $('#trainee_session_update_form :input').val('');
               
                // AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        var trainee_session = response.trainee_session
                        if (response.success == 1) {
                            console.log(trainee_session);
                            console.log(response.equipment);
                            console.log(response.trainee_session_equip);
                            $('#trainee_session_id').val(trainee_session.id);
                            $('#name').val(trainee_session.name);
                            $('#academic_year').val(trainee_session.academic_year);
                            $('#start_date').val(trainee_session.start_date);
                            $('#end_date').val(trainee_session.end_date);
                            $('#status').val(trainee_session.status);

                            //remove all the cloned rows without refreshing the page
                            $('#equip .form-group.row:not(:first)').remove();
                            
                            // Clone and append rows based on equipment data
                            if (response.equipment && response.equipment.length > 0) {
                                // Set values on the original row
                                $('#equip .form-group.row:first select').val(response.equipment[0].id);
                                $('#equip .form-group.row:first input[name="quantity[]"]').val(trainee_session.trainee_session_equipment[0].quantity);

                                // Clone and append the rest of the rows
                                for (var i = 1; i < response.equipment.length; i++) {
                                    var newRow = $(".form-group.row:first").clone();
                                    newRow.find('select option[value="' + response.equipment[i].id + '"]').prop('selected', true);
                                    newRow.find('input[name="quantity[]"]').val(trainee_session.trainee_session_equipment[i].quantity);

                                    // Append the new row
                                    $('#equip').append(newRow);
                                }
                            }
                            $('#update_modal').modal('show');

                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });

            //show
            $('#trainee-sessions-table').on('click', '#show_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.trainee-sessions.show', ':id') }}";
                url = url.replace(':id', row_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        var trainee_session = response.trainee_session
                        if (response.success == 1) {
                            console.log(trainee_session);
                            console.log(response.equipment);
                            $('#trainee_session_id').val(trainee_session.id);
                            $('#show_modal #name').html(trainee_session.name);
                            $('#show_modal #academic_year').html(trainee_session.academic_year);
                            $('#show_modal #start_date').html(trainee_session.start_date);
                            $('#show_modal #end_date').html(trainee_session.end_date);

                            if (response.equipment && response.equipment.length > 0) {
                                var equipmentHtml = '<span class="badge badge-success">' + response.equipment[0].name + '</span>';

                                for (var i = 1; i < response.equipment.length; i++) {
                                    equipmentHtml += '&nbsp;<span class="badge badge-success">' + response.equipment[i].name + '</span>';
                                }

                                $('#show_modal #equipment').html(equipmentHtml);
                            }


                            var status = trainee_session.status;
                            if (status == 1) {
                                $('#show_modal #status').html('Active');
                            } else {
                                $('#show_modal #status').html('Inactive');
                            }
                            $('#show_modal').modal('show');

                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });
        });


        $('#trainee_session_update_form').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            row_id = $('#trainee_session_id', $(this)).val()
            console.log(row_id);

            var url = "{{ route('admin.trainee-sessions.update', ':id') }}";
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
                        window.LaravelDataTables['trainee-sessions-table'].ajax.reload();
                        toastr.success('You have successfuly updated a Trainee Session.')
                    }
                },
                error: function(error) {
                    console.log('error');
                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $("#addFormGroup").click(function(event) {
                event.preventDefault();
                var newRow = $(".form-group.row:first").clone();
                newRow.find('input, select').val('');
                $("#equip").append(newRow);

                var rowCount = $('.form-group.row').length - 1;
                if (rowCount > 0) {
                    newRow.find('.equipment_id_select2').attr('id', 'equipment_id_' + rowCount);
                }
            });

            // Remove the corresponding row when the remove button is clicked
            $("#equip").on('click', '.removeFormGroup', function() {
                $(this).closest('.form-group.row').remove();
            });
        });
    </script>
    @endpush
    <!-- Custom Js contents -->

</x-layout>