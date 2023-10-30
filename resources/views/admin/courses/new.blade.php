<x-layout>
    <x-breadcrump title="Add New Course" parent="Course" child="Add New Course" />

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add Course Form</h3>
        </div>

        <form id="course_form" method="POST" action="{{ route('admin.courses.store') }}">
            @csrf
            <div class="card-body row">
                <div class="col-md-6">
                    <div class="form-group">
                        <x-partials.input-form title="Name" name="name" type="input" />
                    </div>
                    <div class="form-group">
                        <x-partials.input-form title="Lecture Hr/Week" name="lecture_hr_per_week" type="input" />
                    </div>
                    <div class="form-group">
                        <x-partials.input-form title="Lab Hr/Week" name="lab_hr_per_week" type="input" />
                    </div>
                </div>

            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-info float-right mx-3">Submit</button>
            </div>

        </form>

    </div>

</x-layout>