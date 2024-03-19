<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Project List' parent='Project' child='List' />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class='card'>
        <div class='card-header'>
            <div class='col'>
                <div style='display: flex; justify-content:flex-end'>
                    <div>
                        @can('trainee-session: create')
                            <a href="{{ route('admin.trainee-sessions.create') }}">
                                <button type='button' class='btn btn-primary'>Add New Project</button>
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
    <x-partials.trainee_session_modal :equipment="$equipment" :centers="$centers" :groups="$groups" :fund_types="$fund_types" />
    <x-show-modals.trainee_session_show_modal />
    <x-partials.project_status_modal :project_statuses="$project_statuses" />

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
            $('.project_status_select2').select2();
        </script>
        <script>
            $('.centers_select2').select2();
            $('.groups_select2').select2();
            $('.fund_types_select2').select2();
        </script>
        <script>

            function changeProjectStatus(e, trainee_session_id, project_status) {
                $('#project_status_modal #trainee_session_id').val(trainee_session_id);
                let p_status = null;
                if (project_status) {
                    p_status = project_status;
                }
                $('.project_status_select2').val(p_status).trigger('change');
                $('#project_status_modal').modal('show');
            }

            $('#project_status_form').on('submit', function(e) {
                e.preventDefault();
                var url = "{{ route('admin.trainee-session-update-project-status', ':id') }}";
                url = url.replace(':id', $('#project_status_modal #trainee_session_id').val());

                // var formData = $(this).serialize();

                 var formData = new FormData(this);
                var form = $(this).serializeArray();
                 formData.append('file', $('#file')[0].files[0]);
                 console.log($('#file')[0].files[0]);

                formData.append('project_status', $('#project_status').val());

                 
                console.log('this is formated data');
                console.log(formData);

             

                $.ajax({
                    type: "POST",
                    url: url,
                     data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting contentType
                    dataType: "json",
                    success: function(response) {
                        $('#project_status_modal').modal('hide');
                        window.LaravelDataTables['trainee-sessions-table'].ajax.reload();

                    },
                    error: function (error){
                        if (error.status == 422) { // when status code is 422, it's a validation issue
                                console.log('validation error');
                                $.each(error.responseJSON.errors, function(key, error) {
                                    console.log('validation error');
                                    $("#" + key + "_error").text(error);
                                });
                            }
                    }
                });


            });
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
                                $('#objective').val(trainee_session.objective);
                                $('#status').val(trainee_session.status);

                                if (trainee_session.center_id) {
                                    $('.centers_select2').val(trainee_session.center.id).trigger(
                                        'change');;
                                }

                                if (trainee_session.group_id) {
                                    $('.groups_select2').val(trainee_session.group.id).trigger(
                                        'change');
                                }
                                if (trainee_session.fund_type_id) {
                                    $('.fund_types_select2').val(trainee_session.fund_type.id)
                                        .trigger(
                                            'change');
                                }

                                //remove all the cloned rows without refreshing the page
                                $('#equip .form-group.row:not(:first)').remove();

                                // Clone and append rows based on equipment data
                                if (response.equipment && response.equipment.length > 0) {
                                    // Set values on the original row
                                    $('#equip .form-group.row:first select').val(response.equipment[
                                        0].id);
                                    // Set value and data-quantity attribute on the original row
                                    var originalRow = $('#equip .form-group.row:first');
                                    originalRow.find('input[name="quantity[]"]')
                                        .val(trainee_session.trainee_session_equipment[0].quantity)
                                        .attr('data-quantity', trainee_session
                                            .trainee_session_equipment[0].quantity);



                                    // Clone and append the rest of the rows
                                    for (var i = 1; i < response.equipment.length; i++) {
                                        var newRow = $(".form-group.row:first").clone();
                                        newRow.find('select option[value="' + response.equipment[i]
                                            .id + '"]').prop('selected', true);

                                        var newRow = $('#equip .form-group.row').eq(i);
                                        newRow.find('input[name="quantity[]"]').data('quantity',
                                            trainee_session.trainee_session_equipment[i]
                                            .quantity);

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
                                $('#show_modal #objective').html(trainee_session.objective);

                                if (trainee_session.center_id) {
                                    $('#show_modal #center_id').html(trainee_session.center.name);
                                }
                                if (trainee_session.group_id) {
                                    $('#show_modal #group_id').html(trainee_session.group.name);
                                }
                                if (trainee_session.fund_type_id) {
                                    $('#show_modal #fund_type_id').html(trainee_session.fund_type
                                        .name);
                                }
                                if (response.equipment && response.equipment.length > 0) {
                                    var equipmentHtml = '<span class="badge badge-success">' +
                                        response.equipment[0].name + '</span>';

                                    for (var i = 1; i < response.equipment.length; i++) {
                                        equipmentHtml +=
                                            '&nbsp;<span class="badge badge-success">' + response
                                            .equipment[i].name + '</span>';
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
                // Function to validate quantity
                function validateQuantity(input) {
                    var quantity = parseInt(input.val());
                    var selectedQuantity = parseInt(input.closest('.form-group.row').find(
                        '.equipment_id_select2 option:selected').data('quantity'));
                    var originalQuantity = parseInt(input.closest('.form-group.row').find('.quantity-input').data(
                        'quantity'));

                    var total = selectedQuantity + originalQuantity;


                    console.log(quantity);
                    console.log(selectedQuantity);
                    console.log(originalQuantity);
                    console.log(total);

                    if (!isNaN(quantity) && quantity > 0 && quantity <= total) {
                        input.removeClass('is-invalid');
                        input.siblings('.invalid-feedback').text("");
                        return true;
                    } else {
                        input.addClass('is-invalid');
                        input.siblings('.invalid-feedback').text(
                            "Please enter a valid quantity less than or equal to the available quantity.");
                        return false;
                    }
                }

                // Quantity validation for existing and dynamically added rows
                $('#equip').on('input', '.quantity-input', function() {
                    validateQuantity($(this));
                });

                // Form submission validation
                $('form').submit(function(event) {
                    var valid = true;
                    $('.quantity-input').each(function() {
                        if (!validateQuantity($(this))) {
                            valid = false;
                        }
                    });
                    if (!valid) {
                        event.preventDefault();
                        return false;
                    }
                });

                // Add new form group
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

                // Remove form group
                $("#equip").on('click', '.removeFormGroup', function() {
                    $(this).closest('.form-group.row').remove();
                });
            });
        </script>

        <script>
            var labs = {!! json_encode($labs) !!}; // Assuming labs data is available
            var group_labs = {!! json_encode($group_labs) !!}; // Assuming group_labs data is available
            var groups = {!! json_encode($groups) !!}; // Assuming groups data is available
            $('#center_id').on('change', function() {
                var selectedCenter = $(this).val();
                var groupSelect = $('#group_id');
                groupSelect.empty();

                if (selectedCenter !== "") {
                    // Find lab IDs associated with the selected center
                    var labIds = labs.filter(function(lab) {
                        return lab.center_id == selectedCenter;
                    }).map(function(lab) {
                        return lab.id;
                    });

                    // Find group IDs associated with the lab IDs
                    var groupIds = [];
                    group_labs.forEach(function(groupLab) {
                        if (labIds.includes(groupLab.lab_id)) {
                            groupIds.push(groupLab.group_id);
                        }
                    });

                    // Filter groups based on group IDs
                    var filteredGroups = groups.filter(function(group) {
                        return groupIds.includes(group.id);
                    });

                    // Populate group dropdown with filtered groups
                    filteredGroups.forEach(function(group) {
                        groupSelect.append($('<option>', {
                            value: group.id,
                            text: group.name
                        }));
                    });
                    groupSelect.show();
                }
            });
        </script>
    @endpush
    <!-- Custom Js contents -->

</x-layout>
