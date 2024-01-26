@props(['centers'])

<!-- /.modal -->
<div class='modal fade' id='update_modal'>
    <div class='modal-dialog modal-lg'>

        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title'>Update Trainer Detail</h4>
                <button type='button' class='close' data-dismiss='modal' aria-attribute='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <form id='trainer_update_form'>
                @csrf
                <div class='modal-body'>
                    <!-- /.card-body -->
                    <!-- row -->
                    <!-- row -->
                    <div class='card-body row'>
                        <!-- left column -->
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label class='col-12'>Full Name</label>
                                <input type='text' class='form-control' id='full_name' name='full_name' placeholder='Enter full_name'>
                            </div>
                            <div class='form-group'>
                                <label for='centers'>Center</label>
                                <select name='center_id' class='centers_select2 select2 form-control' id='center_id' data-dropdown-css-class='select2-blue'>
                                    <option value=''>Select a center</option>
                                    @foreach ($centers as $ceneter)
                                    <option value='{{$ceneter->id }}'>
                                        {{$ceneter->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--/.col (left) -->
                    </div>
                    <!-- /.row -->
                </div>
                <div class='modal-footer justify-content-between'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                    <input type='hidden' name='trainer_id' id='trainer_id'>
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