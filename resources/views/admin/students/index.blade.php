<x-layout>
    <x-breadcrump title="students List" parent="students" child="List" />

    <div class="card">
        <div class="card-header">
            <div>
                <div class="row mx-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="select2-blue">
                                <select name="school" class="form-control select2" id="school_filter" multiple data-placeholder="-- School --" data-dropdown-css-class="select2-blue" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" id="student_filter_button" class="btn btn-success form-control">Search</button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" id="student_reset_button" class="btn btn-warning form-control">Reset</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col">
                <div style="display: flex; justify-content:flex-end">
                    <div>
                        @can('student: create')
                        <a href="{{route('admin.students.create') }}">
                            <button type="button" class="btn btn-primary">Add New Student</button>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            {{ $dataTable->table(['class' => 'table table-bordered table-striped']) }}
        </div>

        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <!-- /#updateModal -->
    <x-partials.student_modal :schools="$schools" :academic_sessions="$academic_sessions" />
    <!-- /#updateModal -->
    <!-- /.content -->
    <!-- Custom Js contents -->
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $('.school_select2').select2();
        $('#school_filter').select2();
        $('.academic_session_select2').select2();
    </script>
    <script>
        $('#student_filter_button').on('click', function() {
            window.LaravelDataTables["students-table"].ajax.reload();
        });

        $('#student_reset_button').on('click', function() {
            $('#school_filter').val([]).trigger('change');
            console.log('clicked');
            window.LaravelDataTables["students-table"].ajax.reload();
        });
    </script>
    <script>
        //delete row
        function delete_row(element, user_id) {
            var url = "{{ route('admin.students.destroy', ':id') }}";
            url = url.replace(':id', user_id);
            console.log(url);

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mx-1',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {
                            user_id: user_id,
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            if (data.success) {
                                window.LaravelDataTables["students-table"].ajax.reload();
                            }
                        },
                        error: function(error) {
                            if (error.status ==
                                422) { // when status code is 422, it's a validation issue

                            }
                            console.log('debug error here');
                        }
                    })
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            })
        }

        if (@json(session('success_create'))) {
            toastr.success('You have successfuly added a new Student.')
        }


        $(document).ready(function() {
            // Update record popup
            $('#students-table').on('click', '#update_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.students.edit', ':id') }}";
                url = url.replace(':id', row_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        if (response.success == 1) {
                            var student = response.student;
                            console.log(response);
                            $('#student_id').val(student.id);
                            $('#name').val(student.name);
                            $('#age').val(student.age);
                            $('#sex').val(student.sex);
                            $('#grade').val(student.grade);
                            // selected School
                            if (student.school_id)
                                $('.school_select2').val(student
                                    .school).trigger({
                                    type: "change",
                                    user: "program-agent",
                                });
                                // selected session
                            if (student.academic_session)
                                $('.academic_session_select2').val(student
                                    .academic_session).trigger({
                                    type: "change",
                                    user: "program-agent",
                                });
                            $('#update_modal').modal('show');

                        } else {
                            alert("Invalid ID.");
                        }
                    }
                });
            });
        });


        $('#student_update_form').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            row_id = $('#student_id', $(this)).val()
            console.log(row_id);
            var url = "{{ route('admin.students.update', ':id') }}";
            url = url.replace(':id', row_id);

            // AJAX request
            $.ajax({
                url: url,
                type: "PATCH",
                data: form_data,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        console.log(data);
                        $('#update_modal').modal('toggle');
                        window.LaravelDataTables["students-table"].ajax.reload();
                        toastr.success('You have successfuly updated a student.')
                    }
                },
                error: function(error) {
                    console.log('error');
                }
            });

        });
    </script>
    @endpush
    <!-- Custom Js contents -->

</x-layout>