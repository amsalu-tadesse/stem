<x-layout>
    <x-breadcrump title="Add New Academic Level" parent="Academic Level" child="Add New Academic Level" />

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add Academic Level Form</h3>
        </div>

        <form id="academic_level_form" method="POST" action="{{ route('admin.academic-levels.store') }}">
            @csrf
            <div class="card-body row">
                <div class="col-md-6">
                    <div class="form-group">
                        <x-partials.input-form title="Name" name="name" type="input" />
                    </div>
                    <div class="form-group">
                        <x-partials.input-form title="Price" name="price" type="input" />
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select id='type' class="form-control" name="type">
                            <option value="">Select Type</option>
                            <option value="0">Instructor</option>
                            <option value="1">Lab Assistant</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-info float-right mx-3">Submit</button>
            </div>

        </form>

    </div>

</x-layout>
