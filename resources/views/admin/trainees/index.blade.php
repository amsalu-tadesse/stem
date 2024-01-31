<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Trainees List' parent='Trainees' child='List' />
    <!-- /.content-header -->
    <!-- /.content-Main -->
    <div class='card'>
        <div class='card-header'>
            <div class="row mx-2">
                <div class="form-group col-md-6">
                    <div class='form-group'>
                        <label for='centers'>Centers</label>
                        <select name='center_id' class='filter_by_centers_select2 select2 form-control' id='center_id' data-dropdown-css-class='select2-blue'>
                            @foreach ($centers as $center)
                            <option value='{{$center->id }}' @if($center->id == '1') selected @endif>
                                {{$center->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class='form-group'>
                        <label for='groups'>Groups</label>
                        <select name='group_id' class='filter_by_group_select2 select2 form-control' id='group_id' data-dropdown-css-class='select2-blue'>
                            <option value=''>select group </option>
                            @foreach ($groups as $group)
                            <option value='{{$group->id }}'>
                                {{$group->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6">
                </div>


                <div class="modal" id="createGroupModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Add Trainees</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <div class='form-group'>
                                    <input type="checkbox" id="showGroups">
                                    <label for="showGroups">Existing Groups</label>
                                    <div style="display: none;" id="group_div">
                                        <select name='group_idd' id="group_idd" class='group_select2 select2 form-control' data-dropdown-css-class='select2-blue'>
                                            <option value=''>select group</option>
                                            @foreach ($groups as $group)
                                            <option value='{{$group->id }}'>
                                                {{$group->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="name_div">
                                        <label for="group_name">Group Name</label>
                                        <input class="form-control" id="group_name" name="name" placeholder="Enter The Group Name..." />
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-info" id="createGroup">Create</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>



            <div class="col">
                <div style='display: flex; justify-content:flex-end'>
                    <div id="createGroupModalPopUp">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createGroupModal">
                            Create Group
                        </button>
                    </div>&nbsp;&nbsp;

                    <div>
                        @can('trainee: create')
                        <a href="{{route('admin.trainees.create') }}">
                            <button type='button' class='btn btn-primary'>Add New Trainee</button>
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
    <x-partials.trainee_modal :centers="$centers" />
    <x-show-modals.trainee_show_modal />
    <!-- /#updateModal -->
    <!-- /.content -->
    <!-- Custom Js contents -->
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $('.centers_select2').select2();
        $('.filter_by_centers_select2').select2();
        $('.group_select2').select2();
        $('.filter_by_group_select2').select2();
    </script>
    <script>
        $('#trainee_filter_button').on('click', function() {
            window.LaravelDataTables["trainees-table"].ajax.reload();
        });

        $('#trainee_reset_button').on('click', function() {
            $('#center_id').val([]).trigger('change');
            console.log('clicked');
            window.LaravelDataTables["trainees-table"].ajax.reload();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#showGroups').change(function() {
                if (this.checked) {
                    $('#group_div').show().val('');
                    $('#name_div').hide();
                    $('#group_name').val('');
                } else {
                    $('#name_div').show().val('');
                    $('#group_div').hide();
                    $('#group_idd').val('');
                }
            });
        });
    </script>

    <script>
        //delete row
        function delete_row(element, row_id) {
            var url = "{{ route('admin.trainees.destroy', ':id') }}";
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
                                window.LaravelDataTables['trainees-table'].ajax.reload();
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

            toastr.success('You have successfuly added a new Trainee')
        }

        $(document).ready(function() {
            // Update record popup
            $('#trainees-table').on('click', '#update_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.trainees.edit', ':id') }}";
                url = url.replace(':id', row_id);

                $('#trainee_update_form :input').val('');
                // AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        var trainee = response.trainee
                        if (response.success == 1) {
                            console.log(trainee);
                            $('#trainee_id').val(trainee.id);
                            $('#full_name').val(trainee.full_name);
                            $('#id_number').val(trainee.id_number);
                            if (trainee.center_id) {
                                $('.centers_select2').val(trainee.center.id).trigger('change');
                            }
                            $('#update_modal').modal('show');

                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });

            //show
            $('#trainees-table').on('click', '#show_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.trainees.show', ':id') }}";
                url = url.replace(':id', row_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        var trainee = response.trainee
                        if (response.success == 1) {
                            console.log(trainee);
                            $('#trainee_id').val(trainee.id);
                            $('#show_modal #full_name').html(trainee.full_name);
                            $('#show_modal #id_number').html(trainee.id_number);
                            if (trainee.center_id) {
                                $('#show_modal #center_id').html(trainee.center.name);
                            }
                            $('#show_modal').modal('show');

                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });

            $("#createGroupModalPopUp").hide();
            $(document).on('change', 'input[name="trainees"]', function() {
                // Check if at least one checkbox with the name "trainees" is checked
                if ($('input[name="trainees"]:checked').length) {
                    console.log('At least one checkbox is checked');
                    $("#createGroupModalPopUp").show();
                } else {
                    console.log('No checkboxes are checked');
                    $("#createGroupModalPopUp").hide();
                }
            });



            $('#createGroup').click(function() {
                var selectedCheckboxes = $('input[name="trainees"]:checked').map(function() {
                    return $(this).val();
                }).get();
                var groupName = $("#group_name").val();
                var group_id = $("#group_idd").val();
                var postData = {
                    selectedCheckboxes: selectedCheckboxes,
                    name: groupName,
                    group_id: group_id,
                };

                // Ajax request
                $.ajax({
                    url: "{{ route('admin.trainee-groups.store') }}",
                    type: 'POST',
                    data: postData,
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            $('#group_name').val('');
                            $('input[name="trainees"]:checked').prop('checked', false);
                            toastr.success('You have successfuly create Group.');
                            $('#createGroupModal').modal('hide');
                            window.LaravelDataTables['trainees-table'].ajax.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage;
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                            $('#createGroupModal').modal('hide');
                        } else {
                            errorMessage = 'An error occurred.';
                        }
                        toastr.error(errorMessage, 'Error', {
                            positionClass: 'toast-top-right',
                            closeButton: true,
                        });

                    }
                });
            });
        });
    </script>
    <script>
        $('#trainee_update_form').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            row_id = $('#trainee_id', $(this)).val()
            console.log(row_id);

            var url = "{{ route('admin.trainees.update', ':id') }}";
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
                        window.LaravelDataTables['trainees-table'].ajax.reload();
                        toastr.success('You have successfuly updated a Trainee.')
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