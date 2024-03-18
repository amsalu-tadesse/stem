<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Visitors List' parent='Visitors' child='List' />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class='card'>
        <div class='card-header'>
             <div class="row mx-2 align-items-center">
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="select2-blue">
                            <select name="created_from" id='created_from' class="form-control select2"
                                data-dropdown-css-class="select2-blue"
                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">--All Visitors--</option>
                                <option value="outside">Outside</option>
                                <option value="inside">Inside</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col'>
                <div style='display: flex; justify-content:flex-end'>
                    <div>
                        @can('visitor: create')
                            <a href="{{ route('welcome') }}?redirect=create#appointment">
                                <button type='button' class='btn btn-primary'>Create New Appointment</button>
                            </a>
                        @endcan
                    </div>


                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class='card-body'>
            {{ $dataTable->table(['class' => 'table table-bordered table-striped']) }}
        </div>

        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <x-show-modals.visitor_show_modal />
    <x-partials.visitor_edit_modal />
    <!-- /.content -->
    <!-- Custom Js contents -->
    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        <script>
            $('.centers_select2').select2();
        </script>
        <script>
            //delete row
            function delete_row(element, row_id) {
                var url = "{{ route('admin.visitors.destroy', ':id') }}";
                url = url.replace(':id', row_id);
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
                            type: 'DELETE',
                            url: url,
                            data: {
                                row_id: row_id,
                            },
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                if (data.success) {
                                    window.LaravelDataTables['visitors-table'].ajax.reload();
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

                toastr.success('You have successfuly added a new visitor')
            }

            $(document).ready(function() {
                // Update record popup
                $('#visitors-table').on('click', '#update_row', function() {
                    var row_id = $(this).data('row_id');
                    var url = "{{ route('admin.visitors.edit', ':id') }}";
                    url = url.replace(':id', row_id);

                    $('#trainer_update_form :input').val('');
                    // AJAX request
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log('success');
                            var visitor = response.visitor
                            if (response.success == 1) {
                                console.log(visitor);
                                $('#visitor_id').val(visitor.id);
                                $('#update_modal #actual_visitor').val(visitor.actual_visitor);
                                $('#update_modal').modal('show');

                            } else {
                                alert('Invalid ID.');
                            }
                        }
                    });
                });

                //show
                $('#visitors-table').on('click', '#show_row', function() {
                    var row_id = $(this).data('row_id');
                    var url = "{{ route('admin.visitors.show', ':id') }}";
                    url = url.replace(':id', row_id);

                    // AJAX request
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log('success');
                            var visitor = response.visitor
                            if (response.success == 1) {
                                console.log(visitor);
                                $('#visitor_id').val(visitor.id);
                                $('#show_modal #responsible_person').html(visitor
                                    .responsible_person);
                                $('#show_modal #visitor_count').html(visitor.visitor_count);
                                $('#show_modal #actual_visitor').html(visitor.actual_visitor);
                                $('#show_modal #phone').html(visitor.phone);
                                $('#show_modal #email').html(visitor.email);
                                $('#show_modal #description').html(visitor.description);
                                $('#show_modal #visiting_hr').html(visitor.visiting_hr);
                                $('#show_modal #appointment_date').html(visitor.appointment_date);
                                if (visitor.institution_id) {
                                    $('#show_modal #institution_id').html(visitor.institution.name);
                                }
                                if (visitor.institution_type_id) {
                                    $('#show_modal #institution_type_id').html(visitor
                                        .institution_type.name);
                                }
                                if (visitor.country_id) {
                                    $('#show_modal #country_id').html(visitor.country.name);
                                }

                                $('#show_modal').modal('show');

                            } else {
                                alert('Invalid ID.');
                            }
                        }
                    });
                });
            });


            $('#visitor_update_form').on('submit', function(e) {
                e.preventDefault();
                form_data = $(this).serialize();
                row_id = $('#visitor_id', $(this)).val()
                console.log(row_id);

                var url = "{{ route('admin.visitors.update', ':id') }}";
                url = url.replace(':id', row_id);


                // AJAX request
                $.ajax({
                    url: url,
                    type: 'PATCH',
                    data: form_data,
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            console.log('111111111111111');
                            console.log(data);
                            console.log('2222222222222222');
                            $('#update_modal').modal('toggle');
                            window.LaravelDataTables['visitors-table'].ajax.reload();
                            toastr.success('You have successfuly updated a visitor.')
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
