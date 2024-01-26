<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Add New Equipment' parent='Equipment' child='Add New Equipment' />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class='card card-info'>
        <div class='card-header'>
            <h3 class='card-title'>Add Equipment Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- general form elements -->
        <!-- form start -->
        <form id='equipment_form' method='POST' action="{{ route('admin.equipment.store') }}">
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
                </div>
                <div class='col-md-6'>
                    <div class='form-group'>
                        <label for='lab'>lab</label>
                        <select name='lab_id' class='labs_select2 select2 form-control' id='lab_id' data-dropdown-css-class='select2-blue'>
                            <option value=''>Select a lab</option>
                            @foreach ($labs as $lab)
                            <option value='{{$lab->id }}'>
                                {{$lab->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class='col-md-12'>
                    <div class='form-group'>
                        <label class='col-12 '>Description</label>
                        <textarea rows='4' cols='30' class='form-control' id=description name='description'></textarea>
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
        $('.labs_select2').select2();
    </script>
    @endpush

</x-layout>