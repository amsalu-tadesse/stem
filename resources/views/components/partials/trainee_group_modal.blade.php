@props(['groups','trainees',])

<!-- /.modal -->
<div class='modal fade' id='update_modal'>
    <div class='modal-dialog modal-lg'>

        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title'>Update Trainee Group Detail</h4>
                <button type='button' class='close' data-dismiss='modal' aria-attribute='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <form id='trainee_group_update_form'>
                @csrf
                <div class='modal-body'>
                    <!-- /.card-body -->
                    <!-- row -->
                    <!-- row -->
                    <div class='card-body row'>
                        <!-- left column -->
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label for='groups'>Group</label>
                                <select name='group_id' class='groups_select2 select2 form-control' id='group_id' data-dropdown-css-class='select2-blue'>
                                    <option value='none' selected disabled>Select a groups</option>
                                    @foreach ($groups as $trainee_group)
                                    <option value='{{$trainee_group->id }}'>
                                        {{$trainee_group->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class='form-group'>
                                <label for='trainees'>Trainee</label>
                                <select name='trainee_id' class='trainees_select2 select2 form-control' id='trainee_id' data-dropdown-css-class='select2-blue'>
                                    <option value='none' selected disabled>Select a trainees</option>
                                    @foreach ($trainees as $trainee_group)
                                    <option value='{{$trainee_group->id }}'>

                                        {{$trainee_group->full_name }}
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
                    <input type='hidden' name='trainee_group_id' id='trainee_group_id'>
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