<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="Add New FAQ" parent="FAQ" child="Add New FAQ" />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add FAQ Form</h3>
        </div>
        <!-- /.card-header -->
        <!-- general form elements -->
        <!-- form start -->
        <form id="organizationType_form" method="POST" action="{{ route('admin.faqs.store') }}">
            @csrf
            <!-- /.card-body -->
            <!-- row -->
            <div class="card-body row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="form-group">
                        <x-partials.textarea-input-form title="Question" name="question" type="input" />
                    </div>
                    <div class="form-group">
                        <x-partials.textarea-input-form title="Answer" name="answer" />
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
