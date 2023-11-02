<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Mentor Bootstrap Template - Index</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('frontend/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('frontend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('frontend/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css"
        rel="stylesheet">

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
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="index.html">STEM</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo me-auto"><img src="frontend/assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="active" href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="courses.html">Courses</a></li>
                    <li><a href="trainers.html">Trainers</a></li>
                    <li><a href="events.html">Events</a></li>
                    <li><a href="pricing.html">Pricing</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex justify-content-center align-items-center">
        <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100">
            <h1>Learning Today,<br>Leading Tomorrow</h1>
            <h2>We are team of talented designers making websites with Bootstrap</h2>
            {{-- <a href="courses.html" class="btn-get-started">Get Started</a> --}}
        </div>
    </section><!-- End Hero -->

    <main id="main">
        <div class="row p-5">
            <div class="text-center">
                <h2 class="text-info">Make Appointment</h2>
            </div>
            <!-- /.card-header -->
            <!-- general form elements -->
            <!-- form start -->
            <!-- row -->
            <div class="row d-flex">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group text-center">
                        <label class="py-3">Appointment Date</label>
                        <div class="form-group">
                            <input type="text" class="form-control appointment-datepicker"
                                data-date-format="mm/dd/yyyy" id="appointment-datepicker"
                                placeholder="Pick Appointment Date" required>
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
        </div>
        <!-- /.card -->
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>Mentor</h3>
                        <p>
                            A108 Adam Street <br>
                            New York, NY 535022<br>
                            United States <br><br>
                            <strong>Phone:</strong> +1 5589 55488 55<br>
                            <strong>Email:</strong> info@example.com<br>
                        </p>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>Join Our Newsletter</h4>
                        <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                        <form action="" method="post">
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="container d-md-flex py-4">

            <div class="me-md-auto text-center text-md-start">
                <div class="copyright">
                    &copy; Copyright <strong><span>Mentor</span></strong>. All Rights Reserved
                </div>
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/ -->
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </div>
            <div class="social-links text-center text-md-right pt-3 pt-md-0">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <x-partials.visitor-modal />


    <div id="preloader"></div>
    {{-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> --}}

    <!-- Vendor JS Files -->
    <script src="{{ asset('frontend/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>


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
                        $('#time_2-4').toggleClass('btn-success btn-secondary').text('Reserved').prop(
                            'disabled',
                            true);
                    }
                    if (visitor.visiting_hr == '4-6') {
                        $('#time_4-6').toggleClass('btn-success btn-secondary').text('Reserved').prop(
                            'disabled',
                            true);
                    }
                    if (visitor.visiting_hr == '7-9') {
                        $('#time_7-9').toggleClass('btn-success btn-secondary').text('Reserved').prop(
                            'disabled',
                            true);
                    }
                    if (visitor.visiting_hr == '9-11') {
                        $('#time_9-11').toggleClass('btn-success btn-secondary').text('Reserved').prop(
                            'disabled',
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

</body>

</html>
