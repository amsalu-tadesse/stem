<x-layout>
    <x-breadcrump title="Add Progress Status" parent="ProjectStatus" child="Add Progress Status" />

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add Progress Status</h3>
        </div>

        <form id="projectStatus_form" method="POST" action="{{ route('admin.project-status.store') }}">
            @csrf
            <div class="card-body row">
                <div class="col-md-6">
                    <div class="form-group">
                        <x-partials.input-form title="Name" name="name" type="input" />
                    </div>
                    <div class="form-group">
                        <x-partials.textarea-input-form title="Description" name="description" type="input" />
                    </div>
                </div>

            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-info float-right mx-3">Submit</button>
            </div>

        </form>

    </div>

</x-layout>