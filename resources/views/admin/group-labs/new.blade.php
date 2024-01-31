<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Add New Group Lab' parent='Group Lab' child='Add New Group Lab' />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class='card card-info'>
        <div class='card-header'>
            <h3 class='card-title'>Add Group Lab Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- general form elements -->
        <!-- form start -->
        <form id='group_lab_form' method='POST' action="{{ route('admin.group-labs.store') }}">
            @csrf
            <!-- /.card-body -->
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
    <script>$('.groups_select2').select2();$('.labs_select2').select2();</script>
      @endpush

</x-layout>
