@props(['groups','labs',])

    <!-- /.modal -->
    <div class='modal fade' id='update_modal'>
        <div class='modal-dialog modal-lg'>
    
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title'>Update Group Lab Detail</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-attribute='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <form id='group_lab_update_form'>
                    @csrf
                    <div class='modal-body'>
                        <!-- /.card-body -->
                        <!-- row -->
                        <!-- row -->
            <div class='card-body row'>
                <!-- left column -->
                <div class='col-md-6'>   <div class='form-group'>
                    <label for='groups'>Group</label>
                    <select name='group_id' class='groups_select2 select2 form-control' id='group_id' data-dropdown-css-class='select2-blue'>
                        <option value='none' selected disabled>Select a groups</option>
                        @foreach ($groups as  $group_lab)
                        <option value='{{$group_lab->id }}'>

                        {{$group_lab->name }}                        
                        </option>
                        @endforeach
                    </select>
                </div>   <div class='form-group'>
                    <label for='labs'>Lab</label>
                    <select name='lab_id' class='labs_select2 select2 form-control' id='lab_id' data-dropdown-css-class='select2-blue'>
                        <option value='none' selected disabled>Select a labs</option>
                        @foreach ($labs as  $group_lab)
                        <option value='{{$group_lab->id }}'>

                        {{$group_lab->name }}                        
                        </option>
                        @endforeach
                    </select>
                </div></div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
                    </div>
                    <div class='modal-footer justify-content-between'>
                        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                        <input type='hidden' name='group_lab_id' id='group_lab_id'>
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
    