<x-layout>
    <x-breadcrump title="Detail of Academic Session" parent="Academic Session" child="Academic Session" />

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><span style="font-weight: bold;">{{ $academic_session->academic_year }}</span> Academic Session</h3>
        </div>
        <div class="card-body row">
            <div class="col-7">
                <div class="card-header">
                    <div class="col">
                        <div>
                            @can('courses: create')
                            <a href="">
                                <button type="button" class="btn btn-primary">Add Student</button>
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>School</th>
                        </tr>
                    </thead>

                    <tbody id="userList">
                        @foreach ($academic_session->students as $student)
                        <tr id="">
                            <td>{{$loop->iteration }}</td>
                            <td>{{$student->name }}</td>
                            <td>{{$student->grade}}</td>
                            <td>{{$student->school->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-5">
                <div class="card-header">
                    <div class="col">
                        <div>

                            <button id="addCourseButton" type="button" class="btn btn-primary">Add Course</button>

                        </div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Course</th>
                            <th>Instructor</th>
                        </tr>
                    </thead>

                    <tbody id="userList">
                        @foreach ($courses as $course)
                        <tr id="">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $course->course->name }}</td>
                            <td>{{ $course->instructor->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <x-partials.add_instructor_course_modal :coursesNotInInstructorCourse="$coursesNotInInstructorCourse" :instructorsNotInInstructorCourse="$instructorsNotInInstructorCourse" :academic_session="$academic_session" />

        @push('scripts')
        <script>
            function openAddCourseModal() {
                $('#add_modal').modal('show');
            }
            $(document).ready(function() {
                $('#addCourseButton').click(function() {
                    openAddCourseModal();
                });
            });

            $('.course_id_select2').select2();
            $('.lecturer_id_select2').select2();



            $('#add_instructor_course_form').on('submit', function(e) {
                e.preventDefault();
                form_data = $(this).serialize();
                var url = "{{ route('admin.instructor-courses.store') }}";
                console.log(url);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: form_data,
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            console.log(data);
                            $('#add_modal').modal('toggle');
                            window.LaravelDataTables["academic-sessions-table"].ajax.reload();
                            toastr.success('You have successfuly add a instructor-course.')
                        }
                    },
                    error: function(error) {
                        console.log('error');
                    }
                });
            });
        </script>
        @endpush
        <style>
            table {
                border-collapse: collapse;
                width: 50%;
                float: left;
                margin-right: 20px;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }
        </style>

</x-layout>