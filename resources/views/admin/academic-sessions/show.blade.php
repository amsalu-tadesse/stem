<x-layout>
    <x-breadcrump title="{{$academic_session->label}}" parent="Academic Session" child="Academic Session" />

    <div class="card">
        <div class="card-body row">
            <div class="col-6">
                <div class="card-header">
                    <div class="row">
                        <h3>Student List</h3>&nbsp;&nbsp;
                    </div>
                </div>
                <table class="table table-striped" id="studentTable">
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
            <div class="col-6">
                <div class="card-header">
                    <div class="row float-right">
                        <h3>Course List</h3>&nbsp;&nbsp;
                    </div>
                </div>
                <table class="table table-striped" id="courseTable">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Course</th>
                            <th>Instructor</th>
                            <th>Lab Assistant</th>
                        </tr>
                    </thead>

                    <tbody id="userList">
                        @foreach ($courses as $course)
                        <tr id="">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $course->course->name }}</td>
                            <td>{{ $course->instructor->name }}</td>
                            <td>{{ $course->labAssistant->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <x-partials.add_student_modal :student_not_add_in_this_as="$student_not_add_in_this_as" />
        <x-partials.add_instructor_course_modal :coursesNotInInstructorCourse="$coursesNotInInstructorCourse" :lect="$lect" :academic_session="$academic_session" :labAssistantNotInInstructorCourse="$labAssistantNotInInstructorCourse" />

        @push('scripts')
        <script>
            $(document).ready(function() {
                $('#studentTable').DataTable({
                    dom: 'lBfrtip',
                    buttons: [{
                            extend: 'collection',
                            text: 'Export',
                            buttons: ['excel', 'pdf', 'print']
                        },
                        /*{
                            text: 'Add Student',
                            action: function() {
                                openAddStudentModal();
                            },
                            className: 'btn btn-primary'
                        }*/
                    ]
                });
                $('#courseTable').DataTable({
                    dom: 'lBfrtip',
                    buttons: [{
                            extend: 'collection',
                            text: 'Export',
                            buttons: ['excel', 'pdf', 'print']
                        },
                        {
                            text: 'Add Course',
                            action: function() {
                                openAddCourseModal();
                            },
                            className: 'btn btn-primary'
                        }
                    ]
                });
            });

            function openAddCourseModal() {
                $('#add_instructor_course_modal').modal('show');
            }

            function openAddStudentModal() {
                $('#add_student_modal').modal('show');
            }

            $('.course_id_select2').select2();
            $('.lecturer_id_select2').select2();
            $('.lab_assistant_id_select2').select2();
            $('.academicc_session_select2').select2();




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
                            $('#add_instructor_course_modal').modal('toggle');
                            //window.LaravelDataTables["courseTable"].ajax.reload();
                            location.reload();
                            toastr.success('You have successfuly add a instructor-course.')
                        }
                    },
                    error: function(error) {
                        console.log('error');
                    }
                });
            });

            $('#add_student_form').on('submit', function(e) {
                e.preventDefault();
                form_data = $(this).serialize();
                var url = "{{ route('admin.students.update', ':id') }}";
                var studentId = form_data.get('id');
                url = url.replace(':id', studentId);
                console.log(url);
                $.ajax({
                    type: 'PATCH',
                    url: url,
                    data: form_data,
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            console.log(data);
                            $('#add_student_modal').modal('toggle');
                            window.LaravelDataTables["courseTable"].ajax.reload();
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
