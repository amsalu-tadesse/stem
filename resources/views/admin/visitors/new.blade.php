<x-layout>
    @push('css')
        <style>
            .datepicker-days table .disabled-date.day {
                background-color: #663399;
                color: #fff;
            }

            .datepicker table tr td.disabled,
            .datepicker table tr td.disabled:hover {
                background: #8447c2;
                color: #fff;
            }


            /* Styles for screens smaller than 600px */
            @media (min-width: 622px) {

                .datepicker,
                .table-condensed {
                    width: 530px;
                    height: 300px;
                    font-size: small;
                }
            }
        </style>
    @endpush
    <!-- Content Header (Page header) -->
    <x-breadcrump title="Add New Zones" parent="Zones" child="Add New Zones" />
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Make Appointment</h3>
        </div>
        <!-- /.card-header -->
        <!-- general form elements -->
        <!-- form start -->
        <!-- row -->
        <div class="card-body row">
            <!-- left column -->
            <div class="col-md-5">
                <div class="form-group text-center">
                    <label>Appointment Date</label>
                    <div class="form-group">
                        <input type="text" class="form-control appointment-datepicker" data-date-format="mm/dd/yyyy"
                            id="appointment-datepicker" placeholder="Pick Appointment Date" required>
                        <span id="appointment_date_error" class="text-danger error"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
            </div>
            <!--/.col (left) -->
            <div class="col-md-5" style="display: none" id="appointment-time-range">
                <div class="form-group">
                    <div class="d-flex flex-column justify-content-between align-content-between">
                        <button id="time_2-4" onclick="makeAppointment(this, 2, 4)"
                            class="btn btn-success p-2 my-2">2-4
                            (Morning)</button>
                        <button id="time_4-6" onclick="makeAppointment(this, 4, 6)"
                            class="btn btn-success p-2 my-2">4-6
                            (Morning)</button>
                        <button id="time_7-9" onclick="makeAppointment(this, 7, 9)"
                            class="btn btn-success p-2 my-2">7-9
                            (Afternoon)</button>
                        <button id="time_9-11" onclick="makeAppointment(this, 9, 11)"
                            class="btn btn-success p-2 my-2">9-11
                            (Afternoon)</button>
                        <input type="hidden" name="selected_date" id="selected_date" value="">
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <!-- /.card-body -->
        <!-- /.card-footer -->
        <!-- /.card-footer -->

    </div>
    <!-- /.card -->
    <x-partials.visitor-modal />

    <!-- /.content -->


    <!-- Custom Js contents -->
    @push('scripts')
        <script>
            var flashMessage = localStorage.getItem('flashMessage');
            localStorage.removeItem('flashMessage'); // Clear the flash message from Local Storage
            if (flashMessage) {
                // Display the flash message
                console.log(flashMessage);
                toastr.success(flashMessage);

            }
        </script>
        <script>
            var visitors = @json($visitors);

            var datesForDisable = []

            visitors.forEach(visitor => {
                var current_date = visitor.appointment_date;
                var counter = 0;
                visitors.forEach(visitor_child => {
                    if (visitor_child.appointment_date == current_date) {
                        counter = counter + 1;
                    }
                });
                if (counter == 4) {

                    datesForDisable.push(current_date);
                }
                console.log('counter->' + counter);
                counter = 0;
            });

            $('#appointment-datepicker').datepicker({
                multidate: true,
                calendarWeeks: true,
                startDate: '0d',
                todayHighlight: true,
                autoclose: true,
                format: 'yyyy-mm-dd', // Specify the desired date format
                beforeShowDay: function(date) {
                    console.log(date.getMonth());
                    dmy = date.getFullYear() + "-" + (date.getMonth() + 1).toString()
                        .padStart(2, '0') + "-" + date.getDate().toString().padStart(2, '0');
                    if (datesForDisable.indexOf(dmy) != -1) {
                        console.log(dmy);
                        return false;
                    } else {
                        return true;
                    }
                }

            }).on('changeDate', function() {
                $('#appointment-time-range').css('display', 'block');
                var selected_date = $(this).val();
                $('#selected_date').val(selected_date);

                $('#time_2-4').removeClass('btn-secondary').addClass('btn-success').text('2-4').prop('disabled',
                                false);
                $('#time_4-6').removeClass('btn-secondary').addClass('btn-success').text('4-6').prop('disabled',
                                false);
                $('#time_7-9').removeClass('btn-secondary').addClass('btn-success').text('7-9').prop('disabled',
                                false);
                $('#time_9-11').removeClass('btn-secondary').addClass('btn-success').text('9-11').prop('disabled',
                                false);

                visitors.forEach(visitor => {
                    if (selected_date === visitor.appointment_date) {
                        if (visitor.visiting_hr == '2-4') {
                            $('#time_2-4').toggleClass('btn-success btn-secondary').text('Reserved').prop('disabled',
                                true);
                        }
                        if (visitor.visiting_hr == '4-6') {
                            $('#time_4-6').toggleClass('btn-success btn-secondary').text('Reserved').prop('disabled',
                                true);
                        }
                        if (visitor.visiting_hr == '7-9') {
                            $('#time_7-9').toggleClass('btn-success btn-secondary').text('Reserved').prop('disabled',
                                true);
                        }
                        if (visitor.visiting_hr == '9-11') {
                            $('#time_9-11').toggleClass('btn-success btn-secondary').text('Reserved').prop('disabled',
                                true);
                        }
                    }
                });


            });

            function makeAppointment(elemnet, start_time, end_time) {
                $('#organization_name, #responsible_person, #phone_number, #email, #visitor_count').val('');
                $('#visitor_create_modal').modal('toggle');
                $('#create_selected_date').val($('#selected_date').val());
                $('#create_selected_day_range').val(start_time + '-' + end_time);
            }

            $('#visitor_create_modal #visitor_create_form').on('submit', function(e) {
                e.preventDefault();
                $('#organization_name_error, #responsible_person_error, #phone_error, #email_error, #visitor_count_error, #appointment_date_error')
                    .text('');

                var organization_name = $('#visitor_create_modal #organization_name').val();
                var responsible_person = $('#visitor_create_modal #responsible_person').val();
                var phone_number = $('#visitor_create_modal #phone_number').val();
                var email = $('#visitor_create_modal #email').val();
                var visitor_count = $('#visitor_create_modal #visitor_count').val();
                var create_selected_day_range = $('#visitor_create_modal #create_selected_day_range').val();
                var create_selected_date = $('#visitor_create_modal #create_selected_date').val();


                console.log('submiteed');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.visitors.store') }}",
                    data: {
                        'organization_name': organization_name,
                        'visitor_count': visitor_count,
                        'responsible_person': responsible_person,
                        'phone': phone_number,
                        'email': email,
                        'visiting_hr': create_selected_day_range,
                        'appointment_date': create_selected_date
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log('success');
                        $('#visitor_create_modal').modal('toggle');
                        // console.log(`#visitor_create_modal #time_${create_selected_day_range}`);
                        // $(`#time_${create_selected_day_range}`).removeClass('btn-success').addClass(
                        //     'btn-secondary').prop('disabled', true);
                        localStorage.setItem('flashMessage',
                            `You have successfuly make an appointment on ${create_selected_date} from ${create_selected_day_range}`
                        );
                        location.reload();
                    },
                    error: function(error) {
                        console.log('error');
                        if (error.status == 422) {
                            // when status code is 422, it's a validation issue
                            console.log('validation error');
                            $.each(error.responseJSON.errors, function(key, error) {
                                console.log('validation error');
                                $("#" + key + "_error").text(error);
                            });
                        } else {
                            toastr.error('Internal Server Error');
                        }
                    }
                });


            });
        </script>
    @endpush

</x-layout>
