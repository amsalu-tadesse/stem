@props(['centers',])

<!-- /.modal -->
<div class='modal fade' id='update_modal'>
    <div class='modal-dialog modal-lg'>

        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title'>Update Lab Detail</h4>
                <button type='button' class='close' data-dismiss='modal' aria-attribute='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <form id='lab_update_form'>
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
                                <label class='col-12'>Building</label>
                                <input type='text' class='form-control' id='building' name='building' placeholder='Enter building'>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label for='centers'>Center</label>
                                <select name='center_id' class='centers_select2 select2 form-control' id='center_id' data-dropdown-css-class='select2-blue'>
                                    <option value=''>Select a centers</option>
                                    @foreach ($centers as $lab)
                                    <option value='{{$lab->id }}'>

                                        {{$lab->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class='form-group'>
                                <label class='col-12'>Block</label>
                                <input type='text' class='form-control' id='block' name='block' placeholder='Enter block'>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <div class='modal-footer justify-content-between'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                    <input type='hidden' name='lab_id' id='lab_id'>
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