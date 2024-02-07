<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Add New Trainee Group' parent='Trainee Group' child='Add New Trainee Group' />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class='card card-info'>
        <div class='card-header'>
            <h3 class='card-title'>Add Trainee Group Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- general form elements -->
        <!-- form start -->
        <form id='trainee_group_form' method='POST' action="{{ route('admin.trainee-groups.store') }}">
            @csrf
            <!-- /.card-body -->
            <!-- row -->
            <div class='card-body row'>
                <!-- left column -->
                <div class='col-md-6'>
                    <div class='form-group'>
                        <label for='groups'>Group</label>
                        <select name='group_id' class='groups_select2 select2 form-control' id='group_id' data-dropdown-css-class='select2-blue'>
                            <option value=''>Select a groups</option>
                            @foreach ($groups as $group)
                            <option value='{{$group->id }}'>
                                {{ $group->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='trainees'>Trainee</label>
                        <select name='trainee_id' class='trainees_select2 select2 form-control' id='trainee_id' data-dropdown-css-class='select2-blue'>
                            <option value=''>Select a trainees</option>
                            @foreach ($trainees as $trainee)
                            <option value='{{$trainee->id }}'>
                                {{$trainee->full_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
    <script>
        $('.groups_select2').select2();
        $('.trainees_select2').select2();
    </script>
    @endpush

</x-layout>