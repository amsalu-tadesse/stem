@props(['labs','equipment_types'])

<!-- /.modal -->
<div class='modal fade' id='update_modal'>
    <div class='modal-dialog modal-lg'>

        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title'>Update Equipment Detail</h4>
                <button type='button' class='close' data-dismiss='modal' aria-attribute='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <form id='equipment_update_form'>
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
                                <input type='text' class='form-control' id='name' name='name' placeholder='Enter Name'>
                            </div>
                            <div class='form-group'>
                                <label class='col-12'>Quantity</label>
                                <input type='text' class='form-control' id='count' name='count' placeholder='Enter quantity'>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label for='lab'>Lab</label>
                                <select name='lab_id' class='labs_select2 select2 form-control' id='lab_idd' data-dropdown-css-class='select2-blue'>
                                    <option value=''>select type</option>
                                    @foreach ($labs as $lab)
                                    <option value='{{$lab->id }}'>
                                        {{$lab->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class='form-group'>
                                <label for='equipment_types'>Equipment Type</label>
                                <select name='equipment_type_id' class='equipment_type_select2 select2 form-control' id='equipment_type_id' data-dropdown-css-class='select2-blue'>
                                    <option value=''>select type</option>
                                    @foreach ($equipment_types as $equip)
                                    <option value='{{$equip->id }}'>
                                        {{$equip->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class='col-md-12'>
                            <div class='form-group'>
                                <label class='col-12 '>Description</label>
                                <textarea rows='4' cols='30' class='form-control' id=description name='description'></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <div class='modal-footer justify-content-between'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                    <input type='hidden' name='equipment_id' id='equipment_id'>
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