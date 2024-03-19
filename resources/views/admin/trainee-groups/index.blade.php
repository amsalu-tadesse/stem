<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Trainee Groups List' parent='Trainee Groups' child='List' />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class='card'>
        <div class='card-header'>
            <div class='col'>
                <div style='display: flex; justify-content:flex-end'>
                    <div>
                        @can('trainee-groupp: create')
                        <a href="{{route('admin.trainee-groups.create') }}">
                            <button type='button' class='btn btn-primary'>Add New Trainee Group</button>
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
    <x-partials.trainee_group_modal :groups="$groups" :trainees="$trainees" />
    <x-show-modals.trainee_group_show_modal />
    <x-partials.project_status_modal :project_statuses="$project_statuses" />

    <!-- /#updateModal -->
    <!-- /.content -->
    <!-- Custom Js contents -->
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $('.groups_select2').select2();
        $('.trainees_select2').select2();
    </script>
    <script>
    let triggered_button = null;
    function changeProjectStatus(e, trainee_session_id) {
        triggered_button = $(e);
        $('#project_status_modal #trainee_session_id').val(trainee_session_id);
        $('.project_status_select2').val(null).trigger('change');
        $('#project_status_modal').modal('show');
    }

    $('#project_status_form').on('submit', function(e) {
        e.preventDefault();
        var url = "{{ route('admin.trainee-session-update-project-status', ':id') }}";
        url = url.replace(':id', $('#project_status_modal #trainee_session_id').val());

        var form = (this).serialize();

        $.ajax({
            type: "GET",
            url: url,
            data: form,
            dataType: "json",
            success: function (response) {
                $('span', triggered_button).text(response.status.name);
                $('#project_status_modal').modal('hide');
            }
        });


    });
        //delete row
        function delete_row(element, row_id) {
            var url = "{{ route('admin.trainee-groups.destroy', ':id') }}";
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
                                window.LaravelDataTables['trainee-groups-table'].ajax.reload();
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

            toastr.success('You have successfuly added a new Trainee Group')
        }

        $(document).ready(function() {
            // Update record popup
            $('#trainee-groups-table').on('click', '#update_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.trainee-groups.edit', ':id') }}";
                url = url.replace(':id', row_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        var trainee_group = response.trainee_group
                        if (response.success == 1) {
                            console.log(trainee_group);
                            $('#trainee_group_id').val(trainee_group.id);
                            if (trainee_group.group_id) {
                                $('.groups_select2').val(trainee_group.group.id).trigger('change');
                            }
                            if (trainee_group.trainee_id) {
                                $('.trainees_select2').val(trainee_group.trainee.id).trigger('change');
                            }
                            $('#update_modal').modal('show');

                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });

            //show
            $('#trainee-groups-table').on('click', '#show_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.trainee-groups.show', ':id') }}";
                url = url.replace(':id', row_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        var trainee_group = response.trainee_group
                        if (response.success == 1) {
                            console.log(trainee_group);
                            $('#trainee_group_id').val(trainee_group.id);
                            if(trainee_group.group_id){
                                $('#show_modal #group_id').html(trainee_group.group.name);
                            }
                            if(trainee_group.trainee_id){
                                $('#show_modal #trainee_id').html(trainee_group.trainee.full_name);
                            }
                            $('#show_modal').modal('show');

                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });
        });


        $('#trainee_group_update_form').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            row_id = $('#trainee_group_id', $(this)).val()
            console.log(row_id);

            var url = "{{ route('admin.trainee-groups.update', ':id') }}";
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
                        window.LaravelDataTables['trainee-groups-table'].ajax.reload();
                        toastr.success('You have successfuly updated a Trainee Group.')
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