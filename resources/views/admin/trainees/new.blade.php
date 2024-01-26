<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Add New Trainee' parent='Trainee' child='Add New Trainee' />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class='card card-info'>
        <div class='card-header'>
            <h3 class='card-title'>Add Trainee Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- general form elements -->
        <!-- form start -->
        <form id='trainee_form' method='POST' action="{{ route('admin.trainees.store') }}">
            @csrf
            <!-- /.card-body -->
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
                            @foreach ($centers as $center)
                            <option value='{{$center->id }}'>
                                {{$center->name }}
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
        $('.centers_select2').select2();
    </script>
    @endpush

</x-layout>