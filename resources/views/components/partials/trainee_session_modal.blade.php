@props(['equipment', 'centers', 'groups', 'fund_types'])

<!-- /.modal -->
<div class='modal fade' id='update_modal'>
    <div class='modal-dialog modal-lg'>

        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title'>Update Trainee Session Detail</h4>
                <button type='button' class='close' data-dismiss='modal' aria-attribute='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <form id='trainee_session_update_form'>
                @csrf
                <div class='modal-body'>
                    <!-- /.card-body -->
                    <!-- row -->
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
                                <select name='fund_type_id' class='fund_types_select2 select2 form-control'
                                    id='fund_type_id' data-dropdown-css-class='select2-blue'>
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
                                    <input id='start_date' name='start_date' class='form-control'
                                        data-provide='datepicker' data-date-format='yyyy-mm-dd' type='text'>

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
                                            <option value='{{ $equip->id }}'
                                                data-quantity='{{ $equip->current_quantity }}'>
                                                {{ $equip->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class='col-md-5'>
                                    <!-- <label for='quantity'>Quantity</label> -->
                                    <input type="text" class="form-control quantity-input" name="quantity[]"
                                        placeholder="enter quantity">
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
                        <!--/.col (left) -->
                    </div>
                    <!-- /.row -->
                </div>
                <div class='modal-footer justify-content-between'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                    <input type='hidden' name='trainee_session_id' id='trainee_session_id'>
                    <button type='submit' class='btn btn-info'>Save changes</button>
                </div>
            </form>
            <!-- /#user_form -->

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
