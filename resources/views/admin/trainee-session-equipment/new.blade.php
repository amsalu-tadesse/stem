<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Add New Trainee Session Equipment' parent='Trainee Session Equipment' child='Add New Trainee Session Equipment' />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class='card card-info'>
        <div class='card-header'>
            <h3 class='card-title'>Add Trainee Session Equipment Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- general form elements -->
        <!-- form start -->
        <form id='trainee_session_equipment_form' method='POST' action="{{ route('admin.trainee-session-equipment.store') }}">
            @csrf
            <!-- /.card-body -->
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
            <!-- /.card-body -->
            <!-- /.card-footer -->
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
    <script>$('.trainee_sessions_select2').select2();$('.equipment_select2').select2();</script>
      @endpush

</x-layout>
