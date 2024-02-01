@props(['trainee_sessions','equipment',])

    <!-- /.modal -->
    <div class='modal fade' id='update_modal'>
        <div class='modal-dialog modal-lg'>
    
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title'>Update Trainee Session Equipment Detail</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-attribute='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <form id='trainee_session_equipment_update_form'>
                    @csrf
                    <div class='modal-body'>
                        <!-- /.card-body -->
                        <!-- row -->
                        <!-- row -->
            <div class='card-body row'>
                <!-- left column -->
                <div class='col-md-6'>   <div class='form-group'>
                    <label for='trainee_sessions'>Trainee Session</label>
                    <select name='trainee_session_id' class='trainee_sessions_select2 select2 form-control' id='trainee_session_id' data-dropdown-css-class='select2-blue'>
                        <option value='none' selected disabled>Select a trainee_sessions</option>
                        @foreach ($trainee_sessions as  $trainee_session_equipment)
                        <option value='{{$trainee_session_equipment->id }}'>

                        {{$trainee_session_equipment->name }}                        
                        </option>
                        @endforeach
                    </select>
                </div>   <div class='form-group'>
                    <label for='equipment'>Equipment</label>
                    <select name='equipment_id' class='equipment_select2 select2 form-control' id='equipment_id' data-dropdown-css-class='select2-blue'>
                        <option value='none' selected disabled>Select a equipment</option>
                        @foreach ($equipment as  $trainee_session_equipment)
                        <option value='{{$trainee_session_equipment->id }}'>

                        {{$trainee_session_equipment->name }}                        
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
                        <input type='hidden' name='trainee_session_equipment_id' id='trainee_session_equipment_id'>
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
    