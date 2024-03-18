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

        .center-bold {
            text-align: center;
            font-weight: bold;
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
                    <li><a class="" href="/">Home</a></li>
                    <li><a href="/#appointment">Make Appointment</a></li>
                    <li><a href="/#visitors">Visitors</a></li>
                    <li><a href="/#contact">Contact</a></li>
                    <li><a class="active" href="{{ route('online-applicant') }}">Online Application</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex justify-content-center align-items-center">
        <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100">

            <h1>Inside Every Child is a Scientist.<br></h1>
            <h2 class="text-info" style="font-weight: bold;">Welcome to Addis Ababa Science & Technology University STEM
                Center Appointment Portal</h2>
            {{-- <a href="courses.html" class="btn-get-started">Get Started</a> --}}
        </div>
    </section><!-- End Hero -->

    <main id="main">
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="text-center my-3">
                        <h2 class="text-info text-uppercase">Online Application</h2>
                    </div>
                </div>
                <div class="card p-5">
                    <div class="row my-4">
                        <form id="sendApplication" enctype="multipart/form-data">

                            <div class="col-md-12 mt-5 mt-lg-0 d-flex align-items-stretch ">

                                <div class="php-email-form">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Applicant Name</label>
                                            <input type="text" name="applicant_name" class="form-control"
                                                id="applicant_name">
                                            <span class="text-danger error" id="name_error"></span>
                                            @error('applicant_name')
                                                <span class="text-danger error" id="phone_error">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Applicant Phone Number</label>
                                            <input type="number" class="form-control" name="applicant_phone_number"
                                                id="applicant_phone_number">
                                            <span class="text-danger error" id="applicant_phone_number_error"></span>
                                            @error('applicant_phone_number')
                                                <span class="text-danger error" id="phone_error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Research Title</label>
                                            <input type="text" class="form-control" name="research_title"
                                                id="research_title">
                                            <span class="text-danger error" id="research_error"></span>
                                            @error('research_title')
                                                <span class="text-danger error" id="">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Statment of Problem</label>
                                        <textarea class="form-control" name="statement_of_problem" id="statement_of_problem" rows="10"></textarea>
                                        <span class="text-danger error" id="statement_of_problem_error"></span>
                                        @error('statement_of_problem_error')
                                            <span class="text-danger error" id="">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Total Cost</label>
                                            <input type="text" name="total_cost" class="form-control"
                                                id="total_cost">
                                            <span class="text-danger error" id="total_cost_error"></span>

                                            @error('total_cost')
                                                <span class="text-danger error" id="">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Project Duration In Month</label>
                                            <input type="number" class="form-control" name="project_duration"
                                                id="project_duration">
                                            <span class="text-danger error" id="project_duration_error"></span>

                                            @error('project_duration')
                                                <span class="text-danger error" id="">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">File Attachement</label>
                                            <input type="file" class="form-control" name="file_attachement"
                                                id="file_attachement">
                                            <span class="text-danger error" id="file_attachement_error"></span>
                                            @error('file_attachement')
                                                <span class="text-danger error" id="">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="my-3">
                                        <div class="loading">Loading</div>
                                        <div class="error-message"></div>
                                        <div class="sent-message">Your message has been sent. Thank you!</div>
                                    </div>
                                    <div class="text-center">

                                        <div class="alert alert-success" id="notify" style="display: none;">

                                        </div>

                                        <button type="submit" id="btnId">Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section> <!-- End Contact Section -->





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

                                <strong>Phone:</strong> <a
                                    href="tel:{{ $site_admin->telephone }}">{{ $site_admin->telephone }}</a><br>
                                <strong>Email:</strong> <a
                                    href="mailto:{{ $site_admin->email }}">{{ $site_admin->email }}</a> <br>
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
                                <li><i class="bx bx-chevron-right"></i> <a href="https://moe.gov.et/"
                                        target="_blank">
                                        <h6> Ministry of Education(MoE)</h6>
                                    </a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="http://www.mint.gov.et/"
                                        target="_blank">
                                        <h6> Ministry of innovation and technology</h6>
                                    </a></li>
                                <li><i class="bx bx-chevron-right"></i><a href="http://www.astu.edu.et"
                                        target="_blank">
                                        <h6> Adama Science &amp; Technology University(ASTU)</h6>
                                    </a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="http://www.aau.edu.et/"
                                        target="_blank">
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
            $('#sendApplication').on("submit", function(e) {
                e.preventDefault();
                $("#notify").html("");
                $("#notify").hide();



                var formData = new FormData(this);
                var isValid = true;

                // Validate each form field
                if ($('#applicant_name').val().trim() === '') {
                    $('#name_error').text('Applicant Name is required');
                    isValid = false;
                } else {
                    $('#name_error').text('');
                }

                if ($('#applicant_phone_number').val().trim() === '') {
                    $('#applicant_phone_number_error').text('Applicant Phone Number is required');
                    isValid = false;
                } else {
                    $('#applicant_phone_number_error').text('');
                }


                if ($('#research_title').val().trim() === '') {
                    $('#research_error').text('Applicant Research Title is required');
                    isValid = false;
                } else {
                    $('#research_error').text('');
                }

                if ($('#statement_of_problem').val().trim() === '') {
                    $('#statement_of_problem_error').text('Statement of Problem is required');
                    isValid = false;
                } else {
                    $('#statement_of_problem_error').text('');
                }

                if ($('#total_cost').val().trim() === '') {
                    $('#total_cost_error').text('Total Cost is required');
                    isValid = false;
                } else {
                    $('#total_cost_error').text('');
                }

                if ($('#project_duration').val().trim() === '') {
                    $('#project_duration_error').text('Project Duration in month is required');
                    isValid = false;
                } else {
                    $('#project_duration_error').text('');
                }

                if ($('#file_attachement').val().trim() === '') {
                    $('#file_attachement_error').text('File is  required');
                    isValid = false;
                } else {
                    $('#file_attachement_error').text('');
                }
                var isValid = true;

                if (isValid) {
                    $.ajax({
                        url: 'application-submit',
                        type: "POST",
                        data: formData,
                        dataType: 'json',
                        contentType: false, // Ensure proper content type for file uploads
                        processData: false,
                        success: function(data) {

                            $("#notify").html(data.message);
                            $("#notify").show();
                            $("input", $(".php-email-form")).val('');
                            $("textarea", $(".php-email-form")).val('');
                        },
                        error: function(error) {
                            if (error.status == 422) {
                                // when status code is 422, it's a validation issue
                                console.log('validation error');
                                $.each(error.responseJSON.errors, function(key, error) {
                                    console.log('validation error');
                                    console.log(key);
                                    $("#" + key + "_error").html(error[
                                        0]); // Use .html() method to set HTML content
                                });
                            }
                        }

                    });
                }
            });
        </script>



</body>

</html>
