<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ $site_admin->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

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
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

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
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="{{ route('welcome') }}">{{ $site_admin->name }}</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo me-auto"><img src="frontend/assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="active" href="#">Home</a></li>
                    <li><a href="#appointment">Make Appointment</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
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
        <section id="appointment" class="about">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="text-center my-3">
                        <h2 class="text-info text-uppercase">Make Appointment</h2>
                    </div>
                    <!-- /.card-header -->
                    <div>
                        <p>{{ $site_admin->aboutus }}</p>
                    </div>
                    <!-- row -->
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
            </div>
        </section>
        <!-- /.card -->
        {{-- <section id="about" class="about">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-12 pt-4 pt-lg-0 order-2 order-lg-1 content">
                        <h2 class="text-uppercase text-center text-info">About Stem</h2>
                        <p class="">
                            An electronic public-private portal is a web-based platform that facilitates
                            communication, collaboration, and information exchange between public and
                            private entities. It serves as a digital gateway where users can access and
                            share resources, interact with each other, and engage in various activities
                            electronically.
                        </p>
                    </div>
                </div>

            </div>
        </section><!-- End About Section --> --}}

        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-12 pt-4 pt-lg-0 order-2 order-lg-1 content text-center">
                        <h2 class="text-uppercase text-info">Contact</h2>
                        <p>Contact us. Tell us what you have in your mind about our service. Your feedbacks and comments
                            help us toimprove our services.</p>
                    </div>
                </div>
                <div class="card p-5">
                    <div class="row my-4">
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="info">
                                <div class="address">
                                    <i class="bi bi-geo-alt"></i>
                                    <h4>Location:</h4>
                                    <p>{{ $site_admin->address }}</p>
                                </div>

                                <div class="email">
                                    <i class="bi bi-envelope"></i>
                                    <h4>Email:</h4>
                                    <p>{{ $site_admin->email }}</p>
                                </div>

                                <div class="phone">
                                    <i class="bi bi-phone"></i>
                                    <h4>Call:</h4>
                                    <p>{{ $site_admin->telephone }}</p>
                                </div>

                                <iframe
                                    src="{{ $site_admin->location }}"
                                    class="my-4" style="border:0; width: 100%; height: 290px;" allowfullscreen=""
                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>

                        </div>

                        <div class="col-lg-6 mt-5 mt-lg-0 d-flex align-items-stretch ">
                            <div class="php-email-form">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Your Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            required="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="name">Your Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            required="">
                                            <span class="text-danger error" id="email_error"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="subject"
                                        required="">
                                        <span class="text-danger error" id="subject_error"></span>

                                </div>
                                <div class="form-group">
                                    <label for="name">Message</label>
                                    <textarea class="form-control" name="message" id="message" rows="10" required=""></textarea>
                                    <span class="text-danger error" id="message_error"></span>
                                </div>
                                <div class="my-3">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Your message has been sent. Thank you!</div>
                                </div>
                                <div class="text-center">

                                    <div class="alert alert-success" id="notify" style="display: none;">

                                    </div>

                                    <button type="submit" id="sendMessage">Send Message</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- End Contact Section -->
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-5 footer-contact">
                        <h3 style="font-weight: 600;color: #37517e;text-transform: uppercase;"><a
                                href="http://aastu.edu.et">AASTU</a></h3>
                        <p>
                            {{ $site_admin->address }}
                            ETHIOPIA <br><br>

                            <strong>Phone:</strong> <a href="tel:{{ $site_admin->telephone }}">{{ $site_admin->telephone }}</a><br>
                            <strong>Email:</strong> <a href="mailto:{{ $site_admin->email }}">{{ $site_admin->email }}</a> <br>
                        </p>
                    </div>

                    <div class="col-lg-2 col-md-2 footer-links">
                        <h4>QUICK LINKS</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i><a href="http://elearning.aastu.edu.et/"
                                    target="_blank">
                                    <h6> E-Learning</h6>
                                </a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="koha.aastu.edu.et/" target="_blank">
                                    <h6> E-Library</h6>
                                </a></li>
                            <li><i class="bx bx-chevron-right"></i><a href="http://studentinfo.aastu.edu.et/"
                                    target="_blank">
                                    <h6> Student Info</h6>
                                </a></li>
                        </ul>
                    </div>
                    <div class="col-lg-5 col-md-5 footer-links px-sm-4">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="https://moe.gov.et/" target="_blank">
                                    <h6> Ministry of Education(MoE)</h6>
                                </a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="http://www.mint.gov.et/"
                                    target="_blank">
                                    <h6> Ministry of innovation and technology</h6>
                                </a></li>
                            <li><i class="bx bx-chevron-right"></i><a href="http://www.astu.edu.et" target="_blank">
                                    <h6> Adama Science &amp; Technology University(ASTU)</h6>
                                </a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="http://www.aau.edu.et/" target="_blank">
                                    <h6> Addis Ababa University(AAU)</h6>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container d-md-flex py-4">

            <div class="me-md-auto text-center text-md-start">
                <div class="copyright">
                    &copy; Copyright <strong><span><a href="http://aastu.edu.et" target="_blank"
                                rel="noopener noreferrer">AASTU</a></span></strong>. All Rights Reserved
                </div>
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/ -->
                    {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
                </div>
            </div>
            <div class="social-links text-center text-md-right pt-3 pt-md-0">
                <a href="{{ $site_admin->twitter }}" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="{{ $site_admin->facebook }}" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="{{ $site_admin->youtube }}" class="youtube"><i class="bx bxl-youtube"></i></a>
                <a href="{{ $site_admin->linkedin }}" class="linkedin"><i class="bx bxl-linkedin"></i></a>
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
    <!-- Toastr -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>


    <!-- Custom Javascript -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

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
                url: "{{ route('visitors.store') }}",
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
                    if (response.success) {
                        console.log('success');
                        $('#visitor_create_modal').modal('toggle');
                        localStorage.setItem('flashMessage',
                            `You have successfuly make an appointment on ${create_selected_date} from ${create_selected_day_range}`
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

</body>

</html>
