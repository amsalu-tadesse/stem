<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="FAQs Lists" parent="FAQs" child="List" />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class="card">
        <div class="card-header">
            <div class="col">

                <div style="display: flex; justify-content:flex-end">
                    <div>
                        @can('f-a-q-create')
                        <a href="{{route('admin.faqs.create') }}">
                            <button type="button" class="btn btn-primary">Add New FAQs</button>
                        </a>
                        @endcan

                    </div>
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
    <x-partials.faq_modal />
    <!-- /#updateModal -->
    <!-- /.content -->
    <!-- Custom Js contents -->
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        //delete faq
        function delete_user(element, user_id) {
            var url = "{{ route('admin.faqs.destroy', ':id') }}";
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
                                window.LaravelDataTables["faqs-table"].ajax.reload();
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

            toastr.success('You have successfuly added a new FAQ.')
        }

        $(document).ready(function() {
            // Update record popup
            $('#faqs-table').on('click', '#update_user', function() {
                var user_id = $(this).data('user_id');
                var url = "{{ route('admin.faqs.edit', ':id') }}";
                url = url.replace(':id', user_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');

                        if (response.success == 1) {
                            console.log(response);
                            $('#faq_id').val(response.faq_id);
                            $('#question').val(response.question);
                            $('#answer').val(response.answer);
                            $('#update_modal').modal('show');

                        } else {
                            alert("Invalid ID.");
                        }
                    }
                });
            });
        });


        $('#faq_update_form').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            user_id = $('#faq_id', $(this)).val()
            console.log(user_id);

            // var user_id = form_data['user_id']
            var url = "{{ route('admin.faqs.update', ':id') }}";
            url = url.replace(':id', user_id);

            // AJAX request
            $.ajax({
                url: url,
                type: "PATCH",
                data: form_data,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#update_modal').modal('toggle');
                        window.LaravelDataTables["faqs-table"].ajax.reload();
                        toastr.success('You have successfuly updated a FAQ.')
                    }
                },
                error: function(error) {
                    console.log('error');
                }
            });

        });
    </script>
    @endpush

</x-layout>
