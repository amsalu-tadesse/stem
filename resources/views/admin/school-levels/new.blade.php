<x-layout>
    <x-breadcrump title="Add New School Level" parent="School Level" child="Add New School Level" />

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add School Level Form</h3>
        </div>

        <form id="school_level_form" method="POST" action="{{ route('admin.school-levels.store') }}">
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