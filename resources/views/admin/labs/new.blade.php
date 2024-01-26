<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Add New Lab' parent='Lab' child='Add New Lab' />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class='card card-info'>
        <div class='card-header'>
            <h3 class='card-title'>Add Lab Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- general form elements -->
        <!-- form start -->
        <form id='lab_form' method='POST' action="{{ route('admin.labs.store') }}">
            @csrf
            <!-- /.card-body -->
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