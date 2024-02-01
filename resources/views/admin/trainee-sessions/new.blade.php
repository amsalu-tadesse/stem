<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Add New Trainee Session' parent='Trainee Session' child='Add New Trainee Session' />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class='card card-info'>
        <div class='card-header'>
            <h3 class='card-title'>Add Trainee Session Form</h3>
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
                        <input type='text' class='form-control' id='name' name='name' placeholder='Enter Name'>
                    </div>
                    <div class='form-group'>
                        <label class='col-12'>Academic Year</label>
                        <input type='text' class='form-control' id='academic_year' name='academic_year' placeholder='Enter Academic Year'>
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class='form-group'>
                        <label>Start Date</label>
                        <div class='input-append input-group'>
                            <div class='input-group-append' data-target='#start_date'>
                                <div class='input-group-text'><i class='fa fa-calendar'></i></div>
                            </div>
                            <input id='start_date' name='start_date' class='form-control' data-provide='datepicker' data-date-format='yyyy-mm-dd' type='text'>

                        </div>
                    </div>
                    <div class='form-group'>
                        <label>End Date</label>
                        <div class='input-append input-group'>
                            <div class='input-group-append' data-target='#end_date'>
                                <div class='input-group-text'><i class='fa fa-calendar'></i></div>
                            </div>
                            <input id='end_date' name='end_date' class='form-control' data-provide='datepicker' data-date-format='yyyy-mm-dd' type='text'>

                        </div>
                    </div>
                </div>


                <!-- Equipment -->
                <div class="col-12" id="equip">
                    <div class='form-group row'>
                        <div class='col-md-6'>
                            <!-- <label for='equipment'>Equipment</label> -->
                            <select name='equipment_id[]' class='equipment_id_select2 select2 form-control' id="equipment_id" data-dropdown-css-class='select2-blue'>
                                <option value=''>Select Equipment</option>
                                @foreach ($equipment as $equip)
                                <option value='{{$equip->id }}'>
                                    {{$equip->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class='col-md-5'>
                            <!-- <label for='quantity'>Quantity</label> -->
                            <input type="text" class="form-control" name="quantity[]" placeholder="enter quantity">
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
    <!-- <script>
        $('.equipment_id_select2').select2();
    </script> -->
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

</x-layout>