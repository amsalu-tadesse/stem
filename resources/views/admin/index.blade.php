<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="STEM" parent="Dashboard" child="List" />
    <div class="card">
        <div class="card-header">
            <h5> Welcome to Addis Ababa Science & Technology University STEM Administration Page </h5>

        </div>

        <div class="card-body text-justify">
            <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $students }}</h3>
                            <p>Stem Students</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $lectures }}</h3>

                            <p>Stem Lecturer</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $courses }}</h3>
                            <p>Stem Courses</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $trainee }}</h3>

                            <p>Innov & Incub Trainee</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $trainers }}</h3>

                            <p>Innov & Incub Traineer</p>

                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box" style="background-color: rgb(0, 238, 255)">
                        <div class="inner">
                            <h3>{{ $projects }}</h3>
                            <p>Innov & Incub Projects</p>

                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box" style="background-color: rgb(212, 21, 126)">
                        <div class="inner">
                            <h3>{{ $labs }}</h3>
                            <p>Innov & Incub Labs</p>

                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $visitors }}</h3>

                            <p>Museum Visitor</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-layout>
