<x-layout>
    <x-breadcrump title='Equipment List' parent='Equipment' child='List' />
    <div class='card'>
        <div class='card-header'>

            <div class='col'>
                <div style='display: flex; justify-content:flex-end'>
                    <div>
                        @can('equipment: create')
                        <button type='button' class='btn btn-primary' onclick='addEquipment()'>Add New Equipment</button>
                        @endcan
                    </div>
                </div>

            </div>
        </div>
        <div class='card-body'>
            {{ $dataTable->table(['class' => 'table table-bordered table-striped']) }}
        </div>
    </div>
    <x-partials.equipment_on_lab_modal :equipment_types="$equipment_types" />
    <x-partials.add_equipment_modal :lab="$lab" :equipment_types="$equipment_types" />
    <x-show-modals.equipment_show_modal />
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $('.labs_select2').select2();
        $('.filter_by_lab_select2').select2();
        $('.equipment_types_on_add_select2').select2();
        $('.equipment_typess_select2').select2();
    </script>
    <script>
        //delete row
        function delete_row(element, row_id) {
            var url = "{{ route('admin.equipment.destroy', ':id') }}";
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
                                window.LaravelDataTables['equipment-on-lab-table'].ajax.reload();
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

            toastr.success('You have successfuly added a new Equipment')
        }

        $(document).ready(function() {
            // Update record popup
            $('#equipment-on-lab-table').on('click', '#update_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.equipment.edit', ':id') }}";
                url = url.replace(':id', row_id);

                $('#equipment_on_lab_update_form :input').val('');
                // AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        var equipment = response.equipment
                        if (response.success == 1) {
                            console.log(equipment);
                            $('#equipment_id').val(equipment.id);
                            $('#name').val(equipment.name);
                            $('#count').val(equipment.count);
                            $('#description').val(equipment.description);
                            if (equipment.lab_id) {
                                $('.labs_select2').val(equipment.lab.id).trigger('change');
                            }
                            if (equipment.equipment_type_id) {
                                $('.equipment_typess_select2').val(equipment.equipment_type.id).trigger('change');
                            }
                            $('#update_modal').modal('show');

                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });

            //show
            $('#equipment-on-lab-table').on('click', '#show_row', function() {
                var row_id = $(this).data('row_id');
                var url = "{{ route('admin.equipment.show', ':id') }}";
                url = url.replace(':id', row_id);

                // AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('success');
                        var equipment = response.equipment
                        if (response.success == 1) {
                            console.log(equipment);
                            $('#equipment_id').val(equipment.id);
                            $('#show_modal #name').html(equipment.name);
                            $('#show_modal #count').html(equipment.count);
                            $('#show_modal #description').html(equipment.description);
                            if (equipment.lab_id) {
                                $('#show_modal #lab_id').html(equipment.lab.name);
                            }
                            if (equipment.equipment_type_id) {
                                $('#show_modal #equipment_type_id').html(equipment.equipment_type.name);
                            }
                            $('#show_modal').modal('show');

                        } else {
                            alert('Invalid ID.');
                        }
                    }
                });
            });
        });


        $('#equipment_on_lab_update_form').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            row_id = $('#equipment_id', $(this)).val()
            console.log(row_id);

            var url = "{{ route('admin.equipment.update', ':id') }}";
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
                        window.LaravelDataTables['equipment-on-lab-table'].ajax.reload();
                        toastr.success('You have successfuly updated a Equipment.')
                    }
                },
                error: function(error) {
                    console.log('error');
                }
            });

        });
    </script>
    <script>
        function addEquipment() {
            $('#add_equipment_modal').modal('show');
        }
    </script>
    
    <script>
        $('#add_equipment_form_modal').on('submit', function(e) {
            e.preventDefault();
            form_data = $(this).serialize();
            var url = "{{ route('admin.equipment.store') }}";
            console.log(url);
            $.ajax({
                type: 'POST',
                url: url,
                data: form_data,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        console.log(data);
                        $('#add_equipment_modal').modal('toggle');
                        window.LaravelDataTables['equipment-on-lab-table'].ajax.reload();
                        toastr.success('You have successfuly add a Equipment.')
                        $('#add_equipment_form_modal :input').val('');
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