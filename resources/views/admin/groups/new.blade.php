<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Add New Group' parent='Group' child='Add New Group' />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class='card card-info'>
        <div class='card-header'>
            <h3 class='card-title'>Add Group Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- general form elements -->
        <!-- form start -->
        <form id='group_form' method='POST' action="{{ route('admin.groups.store') }}">
            @csrf
            <!-- /.card-body -->
            <!-- row -->
            <div class='card-body row'>
                <!-- left column -->
                <div class='col-md-6'><div class='form-group'>
                         <label class='col-12'>Name</label>
                             <input type='text' class='form-control' id='name' name='name' placeholder='Enter Name'>
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
    <script></script>
      @endpush

</x-layout>
