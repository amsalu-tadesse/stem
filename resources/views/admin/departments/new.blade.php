<x-layout>
    <x-breadcrump title="Add New Department" parent="Department" child="Add New Department" />

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add Department Form</h3>
        </div>

        <form id="department_form" method="POST" action="{{ route('admin.departments.store') }}">
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