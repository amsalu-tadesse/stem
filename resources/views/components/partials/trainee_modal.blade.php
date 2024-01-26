@props(['centers',])

<!-- /.modal -->
<div class='modal fade' id='update_modal'>
    <div class='modal-dialog modal-lg'>

        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title'>Update Trainee Detail</h4>
                <button type='button' class='close' data-dismiss='modal' aria-attribute='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <form id='trainee_update_form'>
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
                                <input type='text' class='form-control' id='full_name' name='full_name' placeholder='Enter Full Name'>
                            </div>
                            <div class='form-group'>
                                <label class='col-12'>Id Number</label>
                                <input type='text' class='form-control' id='id_number' name='id_number' placeholder='Enter Id Number'>
                            </div>
                            <div class='form-group'>
                                <label for='centers'>Center</label>
                                <select name='center_id' class='centers_select2 select2 form-control' id='center_id' data-dropdown-css-class='select2-blue'>
                                    <option value=''>Select a centers</option>
                                    @foreach ($centers as $trainee)
                                    <option value='{{$trainee->id }}'>

                                        {{$trainee->name }}
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
                    <input type='hidden' name='trainee_id' id='trainee_id'>
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