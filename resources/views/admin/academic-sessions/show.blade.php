<x-layout>
    <x-breadcrump title="{{ $academic_session->label }}" parent="Academic Session" child="Academic Session" />
    <!-- Button trigger modal -->

    <!-- Add Mark Modal -->
    <div class="modal fade" id="addMarkModal" tabindex="-1" role="dialog" aria-labelledby="addMarkModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMarkModalLabel">Add Mark</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="studentMarkTable">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Student Name</th>
                                <th>Mark</th>
                            </tr>
                        </thead>
                        <tbody>




                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-marks-btn">Save Changes</button>
                    <button class="btn btn-primary d-none loader" disabled type="button">
                        <span class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </div>
        </div>
    </div>

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
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->grade }}</td>
                                <td>{{ $student->school->name }}</td>
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
                            <th>Mark</th>
                        </tr>
                    </thead>

                    <tbody id="userList">
                        @foreach ($courses as $course)
                            <tr id="">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $course->course->name }}</td>
                                <td>{{ $course->instructor->name }}</td>
                                <td>{{ $course->labAssistant->name }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm add-mark-btn" data-toggle="modal"
                                        data-target="#addMarkModal" data-instructor-course-id="{{ $course->id }}">Add
                                        Mark</a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <x-partials.add_student_modal :student_not_add_in_this_as="$student_not_add_in_this_as" />
        <x-partials.add_instructor_course_modal :coursesNotInInstructorCourse="$coursesNotInInstructorCourse" :lect="$lect" :academic_session="$academic_session"
            :labAssistantNotInInstructorCourse="$labAssistantNotInInstructorCourse" />

        @push('scripts')
            <script></script>
            <script>
                let academic = @json($academic_session);
                let academic_session = academic.id
                $(document).ready(function() {
                    // Initialize DataTable with pagination
                    var table = $("#studentMarkTable").DataTable({
                        "paging": true, // Enable pagination
                        "pageLength": 10, // Set number of records per page
                        "searching": false, // Optional: Disable searching feature
                        // Other DataTable options and configurations
                    });
                    $('.add-mark-btn').click(function(event) {
                        event.preventDefault();

                        var courseId = $(this).data(
                            'instructor-course-id'); // Get the course ID from data attribute
                        var url = '/admin/get-student-course';

                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {
                                course_id: courseId,
                                academic_session: academic_session,
                            },
                            success: function(response) {
                                // Clear existing table rows
                                $('#studentMarkTable tbody').empty();

                                // Initialize existingMarksMap
                                var existingMarksMap = {};

                                // Iterate over each existing mark
                                $.each(response.existing_marks, function(index, existingMarkArray) {
                                    // Check if existingMarkArray is an array
                                    if (Array.isArray(existingMarkArray)) {
                                        // Iterate over each existing mark object in the array
                                        existingMarkArray.forEach(function(existingMark) {
                                            var studentId = existingMark.student_id;
                                            if (!existingMarksMap[studentId]) {
                                                existingMarksMap[studentId] = [];
                                            }
                                            existingMarksMap[studentId].push(
                                                existingMark.mark);
                                        });
                                    } else {
                                        console.error("existingMarkArray is not an array:",
                                            existingMarkArray);
                                    }
                                });


                                $.each(response.students.students, function(index, student) {
                                    var studentId = student.id;
                                    var markValues = existingMarksMap[studentId] || [];
                                    var markValue = markValues.length > 0 ? markValues.join(
                                        ', ') : '';



                                    // Construct HTML for the table row
                                    var rowHtml = '<tr>' +
                                        '<td>' + (index + 1) + '</td>' +
                                        '<td>' + student.name + '</td>' +
                                        '<td>' +
                                        '<input type="text" name="marks[' + student.id +
                                        ']" class="form-control" ' +
                                        'data-student-id="' + student.id +
                                        '" placeholder="Enter Mark" ' +
                                        'value="' + markValue + '">' +
                                        '</td>' +
                                        '</tr>';

                                    // Append the row to the table
                                    table.row.add($(rowHtml)).draw();

                                });
                            },
                            error: function(xhr, status, error) {
                                // Handle error
                                console.error('AJAX request failed');
                            },
                            complete: function() {

                            }
                        });
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                    $('.add-mark-btn').on('click', function() {
                        var courseId = $(this).data('instructor-course-id');
                        $('#addMarkModal').find('.modal-footer .save-marks-btn').data('course-id', courseId);

                        // Clear previous data from modal inputs
                        $('#studentMarkTable tbody tr').each(function() {
                            var studentId = $(this).find('input[type="text"]').data('student-id');
                            var mark = $(this).find('input[type="text"]').val();
                            console.log("Student ID: " + studentId + ", Mark: " + mark);
                        });
                    });

                    $('.save-marks-btn').on('click', function() {
                        var courseId = $(this).data('course-id');
                        $(".save-marks-btn").toggleClass("d-none");
                        $(".loader").toggleClass("d-none");
                        console.log(courseId);

                        var marksData = [];

                        $('#studentMarkTable tbody tr').each(function() {
                            var studentId = $(this).find('input[type="text"]').data('student-id');
                            var mark = $(this).find('input[type="text"]').val();

                            marksData.push({
                                studentId: studentId,
                                mark: mark,
                                courseId: courseId
                            });
                        });

                        $.ajax({
                            url: '/admin/save-marks', // Adjust the URL to match your server endpoint
                            type: 'POST',
                            data: {
                                marksData: marksData
                            },
                            success: function(response) {
                                window.location.reload();

                                console.log(response); // Handle success response
                            },
                            error: function(xhr, status, error) {
                                $(".save-marks-btn").toggleClass("d-none");
                                $(".loader").toggleClass("d-none");
                                console.error(error); // Handle error
                            }
                        });
                    });
                });
            </script>
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
