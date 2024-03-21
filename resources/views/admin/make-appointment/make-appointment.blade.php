<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title='Make Appointemnt' parent='Appointment' child='List' />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class='card'>
        <div class='card-header'>
            <div class="row d-flex">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group text-center">
                        <label class="py-3" style="font-weight: bold; font-size: 20px;">Appointment
                            Date</label>
                        <div class="form-group">
                            <input type="text"
                                class="form-control appointment-datepicker disabled-input p-3 btn btn-success text-dark"
                                data-date-format="mm/dd/yyyy" id="appointment-datepicker"
                                placeholder="Pick Appointment Date" required readonly>
                            <span id="appointment_date_error" class="text-danger error"></span>
                        </div>
                    </div>
                </div>
                <!--/.col (left) -->
                <div class="col-md-6" style="display: none" id="appointment-time-range">
                    <div class="form-group">
                        <div class="d-flex flex-column justify-content-between align-content-between">
                            <button id="time_2-4" onclick="makeAppointment(this, 2, 4)"
                                class="btn btn-success p-2 my-2">2-4
                                (Morning)</button>
                            <button id="time_4-6" onclick="makeAppointment(this, 4, 6)"
                                class="btn btn-success p-2 my-2">4-69
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
        </div>
        <!-- /.card-header -->
        <div class='card-body'>


            <div class="div">
                <form id="visitor_create_form" class="d-none">
                    @csrf
                    <div class="modal-body row">
                        <!-- /.card-body -->
                        <!-- left column -->
                        <div class="col-md-6 p-2">
                            <div class='form-group p-2'>
                                <label for='institution'>Institution</label>
                                <select name='institution_id' class='institutions_select2 select2 form-control'
                                    id='institution_id' data-dropdown-css-class='select2-blue'>
                                    <option value=''>Select institution</option>
                                    @foreach ($institutions as $institution)
                                        <option value='{{ $institution->id }}'>
                                            {{ $institution->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group p-2">
                                <x-partials.input-form title="Responsible Person" name="responsible_person"
                                    type="input" />
                                <span class="text-danger error" id="responsible_person_error"></span>

                            </div>
                            <div class="form-group p-2">
                                <x-partials.input-form title="Phone Number" name="phone_number" type="tel" />
                                <span class="text-danger error" id="phone_error"></span>
                            </div>
                            <div class='form-group p-2'>
                                <label for='country'>Country</label>
                                <select name='country_id' class='countries_select2 select2 form-control' id='country_id'
                                    data-dropdown-css-class='select2-blue'>
                                    <option value=''>Select country</option>
                                    @foreach ($countries as $country)
                                        <option value='{{ $country->id }}'>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 p-2">
                            <div class='form-group p-2'>
                                <label for='institution_type'>Institution Type</label>
                                <select name='institution_type_id'
                                    class='institution_types_select2 select2 form-control' id='institution_type_id'
                                    data-dropdown-css-class='select2-blue'>
                                    <option value=''>Select institution type</option>
                                    @foreach ($institution_types as $institution_type)
                                        <option value='{{ $institution_type->id }}'>
                                            {{ $institution_type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group p-2">
                                <x-partials.input-form title="Email" name="email" type="email" />
                                <span class="text-danger error" id="email_error"></span>

                            </div>
                            <div class="form-group p-2">
                                <x-partials.input-form title="Number of Visitors" name="visitor_count" type="number" />
                                <span class="text-danger error" id="visitor_count_error"></span>
                            </div>
                            <div class="form-group p-2">
                                <x-partials.textarea-input-form title="Description" name="description" type="text" />
                                <span class="text-danger error" id="visitor_count_error"></span>
                            </div>
                            <input type="hidden" name="selected_date" id="create_selected_date">
                            <input type="hidden" name="selected_day_range" id="create_selected_day_range">

                        </div>
                    </div>
                    <div class="modal-footer justify-content-between p-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        {{-- <input type="hidden" name="course_id" id="course_id"> --}}
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- /.card-body -->
    </div>
    <style>
        .datepicker-days table .disabled-date.day {
            background-color: #bc2020;
            color: #fff;
        }

        .datepicker table tr td.disabled,
        .datepicker table tr td.disabled:hover {
            background: #bc2020;
            color: #fff;
            margin: 2px;
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

        .disabled-input {
            background-color: #f8f9fa;
        }

        .center-bold {
            text-align: center;
            font-weight: bold;
        }
    </style>
    @php
        $visitors = $visitors->map(function ($visitor) {
            return [
                'appointment_date' => $visitor->appointment_date->format('Y-m-d'),
                'visiting_hr' => $visitor->visiting_hr,
            ];
        });
    @endphp
    @push('scripts')
        <script>
            $(document).ready(function() {
                var flashMessage = localStorage.getItem('flashMessage');
                localStorage.removeItem('flashMessage'); // Clear the flash message from Local Storage
                if (flashMessage) {
                    // Display the succcess flash message
                    console.log(flashMessage);
                    toastr.success(flashMessage);
                }

                var errorFlashMessage = localStorage.getItem('errorFlashMessage');
                localStorage.removeItem('errorFlashMessage'); // Clear the flash message from Local Storage
                if (errorFlashMessage) {
                    // Display the succcess flash message
                    console.log(errorFlashMessage);
                    toastr.error(errorFlashMessage);
                }


            });
        </script>

        <script>
            var visitors = @json($visitors);

            var datesForDisable = []

            visitors.forEach(visitor => {
                var current_date = visitor.appointment_date;
                console.log("Current Date => " + current_date);
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
                daysOfWeekDisabled: '0',
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
                $('#visitor_create_form').addClass('d-none');
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
                console.log(visitors);
                visitors.forEach(visitor => {

                    console.log(selected_date, visitor, visitor.appointment_date);
                    if (selected_date == visitor.appointment_date) {
                        if (visitor.visiting_hr == '2-4') {
                            $('#time_2-4').toggleClass('btn-success btn-secondary').text('2-4 (Reserved)').prop(
                                'disabled',
                                true);
                        }
                        if (visitor.visiting_hr == '4-6') {
                            $('#time_4-6').toggleClass('btn-success btn-secondary').text('4-6 (Reserved)').prop(
                                'disabled',
                                true);
                        }
                        if (visitor.visiting_hr == '7-9') {
                            $('#time_7-9').toggleClass('btn-success btn-secondary').text('7-9 (Reserved)').prop(
                                'disabled',
                                true);
                        }
                        if (visitor.visiting_hr == '9-11') {
                            $('#time_9-11').toggleClass('btn-success btn-secondary').text('9-11 (Reserved)')
                                .prop(
                                    'disabled',
                                    true);
                        }
                    }
                });


            });

            function makeAppointment(elemnet, start_time, end_time) {

                $('#organization_name,#institution_id, #institution_type_id, #country_id, #responsible_person, #phone_number, #email, #visitor_count , #description')
                    .val('');
                $('#visitor_create_form').removeClass('d-none');
                $('#create_selected_date').val($('#selected_date').val());
                $('#create_selected_day_range').val(start_time + '-' + end_time);
            }

            $('#visitor_create_form').on('submit', function(e) {
                e.preventDefault();
                $('#institution_id_error, #institution_type_id_error, #country_id_error, #responsible_person_error, #phone_error, #email_error, #visitor_count_error, #appointment_date_error , #description_error')
                    .text('');

                var institution_id = $('#institution_id').val();
                var institution_type_id = $('#institution_type_id').val();
                var country_id = $('#country_id').val();
                var organization_name = $('#organization_name').val();
                var responsible_person = $('#responsible_person').val();
                var phone_number = $('#phone_number').val();
                var email = $('#email').val();
                var visitor_count = $('#visitor_count').val();
                var create_selected_day_range = $('#create_selected_day_range').val();
                var create_selected_date = $('#create_selected_date').val();
                var description = $('#description').val();
                var created_from = 'reserved';


                console.log('submiteed');

                $.ajax({
                    type: "POST",
                    url: "{{ route('visitors.store') }}",
                    data: {
                        'institution_id': institution_id,
                        'institution_type_id': institution_type_id,
                        'country_id': country_id,
                        'visitor_count': visitor_count,
                        'responsible_person': responsible_person,
                        'phone': phone_number,
                        'email': email,
                        'visiting_hr': create_selected_day_range,
                        'appointment_date': create_selected_date,
                        'description': description,
                        'created_from': created_from,

                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            console.log('success');
                            $('#visitor_create_form').addClass('d-none');

                            localStorage.setItem('flashMessage',
                                `You have successfuly made an appointment on ${create_selected_date} from ${create_selected_day_range}`
                            );
                            location.reload();

                        } else {
                            localStorage.setItem('errorFlashMessage',
                                `Visiting Hourse (${create_selected_day_range}) in ${create_selected_date}  has already been reserved, please select another date or visiting hours!`
                            );
                            location.reload();
                        }
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

        <script>
            $("#sendMessage").on("click", function() {
                $('#email_error, #subject_error, #message_error').text(''); //reset for every click
                var name = $("#name").val();
                var email = $("#email").val();
                var subject = $("#subject").val();
                var message = $("#message").val();
                $.ajax({
                    url: "{{ route('contact-us.store') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'name': name,
                        'email': email,
                        'subject': subject,
                        'message': message,
                    },
                    success: function(data) {

                        $("#notify").html(data.success);
                        $("#notify").show();
                        $("input", $(".php-email-form")).val('');
                        $("textarea", $(".php-email-form")).val('');
                    },
                    error: function(error) {
                        console.log('error');
                        if (error.status == 422) {
                            // when status code is 422, it's a validation issue
                            console.log('validation error');
                            $.each(error.responseJSON.errors, function(key, error) {
                                console.log('validation error');
                                console.log(key);
                                $("#" + key + "_error").text(error);
                            });
                        } else {
                            toastr.error('Internal Server Error');
                        }
                    }
                });
            })
        </script>
    @endpush


</x-layout>
