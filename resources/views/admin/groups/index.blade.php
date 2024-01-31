<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Trainee Group List' parent='Groups' child='List' />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class='card'>
        <div class="row mx-2">
            <div class="form-group col-md-6">
                <div class='form-group'>
                    <label for='labs'>Labs</label>
                    <select name='lab_id' class='filter_by_labs_select2 select2 form-control' id='lab_id' data-dropdown-css-class='select2-blue'>
                        <option value=''>
                            All
                        </option>
                        @foreach ($labs as $lab)
                        <option value='{{$lab->id }}'>
                            {{$lab->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class='card-header'>
            <div class='col'>
                <div style='display: flex; justify-content:flex-end'>
                    <div id="addToLabModalPopUp">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addToLabModal">
                            Add To Lab
                        </button>
                    </div>&nbsp;&nbsp;
                    <div>
                        @can('group: create')
                        <a href="{{route('admin.groups.create') }}">
                            <button type='button' class='btn btn-primary'>Add New Group</button>
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
    </div>

    <div class="modal" id="addToLabModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Group</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class='form-group'>
                        <label for="showGroups">Labs</label>
                        <div id="group_div">
                            <select name='lab_idd' id="lab_idd" class='labs_select2 select2 form-control' data-dropdown-css-class='select2-blue'>
                                <option value=''>select lab</option>
                                @foreach ($labs as $lab)
                                <option value='{{$lab->id }}'>
                                    {{$lab->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <div id="name_div">
                            <label for="group_name">Group Name</label>
                            <input class="form-control" id="group_name" name="name" placeholder="Enter The Group Name..." />
                        </div> -->
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info" id="createLab">Create</button>
                </div>

            </div>
        </div>
    </div>

    <!-- /#updateModal -->
    <x-partials.group_modal />
    <x-show-modals.group_show_modal />
    <!-- /#updateModal -->
    <!-- /.content -->
    <!-- Custom Js contents -->
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $('.filter_by_labs_select2').select2();
        $('.labs_select2').select2();
    </script>
    <script>
        //delete row
        function delete_row(element, row_id) {
            var url = "{{ route('admin.groups.destroy', ':id') }}";
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
                                window.LaravelDataTables['groups-table'].ajax.reload();
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

            toastr.success('You have successfuly added a new Group')
        }

        $(document).ready(function() {
            // Update record popup
            $('#groups-table').on('click', '#update_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.groups.edit', ':id') }}";
                url = url.replace(':id', row_id);

                $('#group_update_form :input').val('');
                // AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        var group = response.group
                        if (response.success == 1) {
                            console.log(group);
                            $('#group_id').val(group.id);
                            $('#name').val(group.name);
                            $('#update_modal').modal('show');

                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });

            //show
            $('#groups-table').on('click', '#show_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.groups.show', ':id') }}";
                url = url.replace(':id', row_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        var group = response.group
                        if (response.success == 1) {
                            console.log(group);
                            $('#group_id').val(group.id);
                            $('#show_modal #name').html(group.name);
                            $('#show_modal').modal('show');

                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });


            $("#addToLabModalPopUp").hide();
            $(document).on('change', 'input[name="groups"]', function() {
                // Check if at least one checkbox with the name "groups" is checked
                if ($('input[name="groups"]:checked').length) {
                    console.log('At least one checkbox is checked');
                    $("#addToLabModalPopUp").show();
                } else {
                    console.log('No checkboxes are checked');
                    $("#addToLabModalPopUp").hide();
                }
            });

            $('#createLab').click(function() {
                var selectedCheckboxes = $('input[name="groups"]:checked').map(function() {
                    return $(this).val();
                }).get();
                var lab_id = $("#lab_idd").val();
                var postData = {
                    selectedCheckboxes: selectedCheckboxes,
                    lab_id: lab_id,
                };

                // Ajax request
                $.ajax({
                    url: "{{ route('admin.group-labs.store') }}",
                    type: 'POST',
                    data: postData,
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            $('input[name="groups"]:checked').prop('checked', false);
                            toastr.success('You have successfuly add groups.');
                            $('#addToLabModal').modal('hide');
                            window.LaravelDataTables['groups-table'].ajax.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage;
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                            $('#addToLabModal').modal('hide');
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
        $('#group_update_form').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            row_id = $('#group_id', $(this)).val()
            console.log(row_id);

            var url = "{{ route('admin.groups.update', ':id') }}";
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
                        window.LaravelDataTables['groups-table'].ajax.reload();
                        toastr.success('You have successfuly updated a Group.')
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