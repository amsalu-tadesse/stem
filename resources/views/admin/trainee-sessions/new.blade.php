<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Add New Project' parent='Project' child='Add New Project' />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class='card card-info'>
        <div class='card-header'>
            <h3 class='card-title'>Add Project Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- general form elements -->
        <!-- form start -->
        <form id='trainee_session_form' method='POST' action="{{ route('admin.trainee-sessions.store') }}">
            @csrf
            <!-- /.card-body -->
            <!-- row -->
            <div class='card-body row'>
                <!-- left column -->
                <div class='col-md-6'>
                    <div class='form-group'>
                        <label class='col-12'>Name</label>
                        <input type='text' class='form-control' id='name' name='name'
                            placeholder='Enter Name'>
                    </div>
                    <div class='form-group'>
                        <label class='col-12'>Academic Year</label>
                        <input type='text' class='form-control' id='academic_year' name='academic_year'
                            placeholder='Enter Academic Year'>
                    </div>

                    <div class='form-group'>
                        <label for='center'>Center</label>
                        <select name='center_id' class='centers_select2 select2 form-control' id='center_id'
                            data-dropdown-css-class='select2-blue'>
                            <option value=''>Select center</option>
                            @foreach ($centers as $center)
                                <option value='{{ $center->id }}'>
                                    {{ $center->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='group'>Groups</label>
                        <select name='group_id' class='groups_select2 select2 form-control' id='group_id'
                            data-dropdown-css-class='select2-blue'>
                            <option value=''>Select group</option>
                            @foreach ($groups as $group)
                                <option value='{{ $group->id }}'>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='fund_type'>Fund Type</label>
                        <select name='fund_type_id' class='fund_types_select2 select2 form-control' id='fund_type_id'
                            data-dropdown-css-class='select2-blue'>
                            <option value=''>Select fund_type</option>
                            @foreach ($fund_types as $fund_type)
                                <option value='{{ $fund_type->id }}'>
                                    {{ $fund_type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>



                <div class='col-md-6'>
                    <div class='form-group'>
                        <label>Start Date</label>
                        <div class='input-append input-group'>
                            <div class='input-group-append' data-target='#start_date'>
                                <div class='input-group-text'><i class='fa fa-calendar'></i></div>
                            </div>
                            <input id='start_date' name='start_date' class='form-control' data-provide='datepicker'
                                data-date-format='yyyy-mm-dd' type='text'>

                        </div>
                    </div>
                    <div class='form-group'>
                        <label>End Date</label>
                        <div class='input-append input-group'>
                            <div class='input-group-append' data-target='#end_date'>
                                <div class='input-group-text'><i class='fa fa-calendar'></i></div>
                            </div>
                            <input id='end_date' name='end_date' class='form-control' data-provide='datepicker'
                                data-date-format='yyyy-mm-dd' type='text'>

                        </div>
                    </div>
                    <div class='form-group'>
                        <label class='col-12 '>Objective</label>
                        <textarea rows='4' cols='30' class='form-control' id=objective name='objective'></textarea>
                    </div>
                </div>


                <!-- Equipment -->
                <div class="col-12" id="equip">
                    <div class='form-group row'>
                        <div class='col-md-6'>
                            <!-- <label for='equipment'>Equipment</label> -->
                            <select name='equipment_id[]' class='equipment_id_select2 select2 form-control'
                                id="equipment_id" data-dropdown-css-class='select2-blue'>
                                <option value=''>Select Equipment</option>
                                @foreach ($equipment as $equip)
                                    <option value='{{ $equip->id }}' data-quantity='{{ $equip->current_quantity }}'>
                                        {{ $equip->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class='col-md-5'>
                            <!-- <label for='quantity'>Quantity</label> -->
                            <input type="text" class="form-control quantity-input" name="quantity[]"
                                placeholder="enter amount">
                        </div>

                        <div class='col-md-1'>
                            <!-- <label for='remove' class="col-12">Remove Raw</label> -->
                            <button class="removeFormGroup btn btn-warning">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <button id="addFormGroup" class="btn btn-success">Add Another</button>
            </div>

            <div class='card-footer text-right'>
                <button type='submit' class='btn btn-info float-right mx-3'>Submit</button>
            </div>
            <!-- /.card-footer -->
        </form>
        <!-- /#user_form -->

    </div>
    <!-- /.card -->
    <!-- /.content -->

    <!-- Custom Js contents -->

    @push('scripts')
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
            $('.centers_select2').select2();
            $('.groups_select2').select2();
            $('.fund_types_select2').select2();
        </script>
        <script>
            $(document).ready(function() {
                // Function to validate quantity
                function validateQuantity(input) {
                    var quantity = parseInt(input.val());
                    var selectedQuantity = parseInt(input.closest('.form-group.row').find(
                        '.equipment_id_select2 option:selected').data('quantity'));

                    if (!isNaN(quantity) && quantity > 0 && quantity <= selectedQuantity) {
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

                    // Update the IDs of cloned elements to maintain uniqueness
                    var rowCount = $('.form-group.row').length - 1;
                    newRow.find('.equipment_id_select2').attr('id', 'equipment_id_' + rowCount);
                });

                var equipment = @json($equipment);
                // Event listener for equipment selection made after cloning
                $(document).on('change', '.equipment_id_select2', function() {
                    // Get the selected equipment ID
                    var selectedEquipmentId = $(this).val();

                    // Find the equipment object from the fetched data based on the selected ID
                    var selectedEquipment = equipment.find(function(equipment) {
                        return equipment.id == selectedEquipmentId;
                    });

                    // If equipment is found and it has a measurement relation
                    if (selectedEquipment && selectedEquipment.measurement) {
                        // Get the measurement name from the measurement relation
                        var measurementName = selectedEquipment.measurement.name;

                        // Update the placeholder of the quantity input field with the measurement name
                        $(this).closest('.form-group.row').find('.quantity-input').attr('placeholder',
                            'Enter amounts in ' + measurementName);
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

</x-layout>
