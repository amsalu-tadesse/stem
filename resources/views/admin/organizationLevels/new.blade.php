<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="Add New Organization Level" parent="Organization Levels" child="Add New Organization Level" />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add Organization Level Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- general form elements -->
        <!-- form start -->
        <form id="organizationType_form" method="POST" action="{{ route('admin.organization-levels.store') }}">
            @csrf
            <!-- /.card-body -->
            <!-- row -->
            <div class="card-body row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <x-partials.input-form title="Name" name="name" type="input" />
                    </div>
                    <div class="form-group">
                        <x-partials.textarea-input-form title="Description" name="description" />
                    </div>
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
            <!-- /.card-body -->
            <!-- /.card-footer -->
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-info float-right mx-3">Submit</button>
            </div>
            <!-- /.card-footer -->
        </form>
        <!-- /#user_form -->

    </div>
    <!-- /.card -->
    <!-- /.content -->

    <!-- Custom Js contents -->

</x-layout>
