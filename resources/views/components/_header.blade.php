<style>
    #popup-settings-list {
        display: none;
        position: absolute;
        right: 10px;
        top: 50px;
        background-color: white;
        padding: 10px;
        /* border: 1px solid #ccc; */
    }

    #popup-settings-list ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    #popup-settings-list li {
        padding: 5px;
    }

    #popup-settings-list li:hover {
        background-color: #f5f5f5;
    }
</style>
<!-- Navbar -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Public page</a>
            </li>

        </ul>

        <ul class="navbar-nav ml-auto">
             <li class="nav-item d-none d-sm-inline-block">
                <p class="nav-link">Stem</p>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            {{-- <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li> --}}



            <li class="nav-item" id="profile-picture-icon">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-user"></i>
                </a>
            </li>
            <li>

                <div id="popup-settings-list">
                    <ul>

                        @php
                        $user = Auth::user();
                        echo '<li>'.$user->first_name.'</li>';
                        echo '<li style="color:green"> ' . $user?->organization?->organizationLevel->name . '
                                </li>';
                        @endphp

                        <details class="my-roles" style="color: blue">
                            <summary>My Roles</summary>
                            <ul>

                                @php
                                $roles = $user?->roles;
                                if ($roles) {
                                foreach ($roles as $role) {
                                echo '<li><a style="color:green"> ' . $role?->name . '</li></a>';
                                }

                                }



                                @endphp

                            </ul>
                        </details>




                        <li><a href="{{ route('admin.profile') }}">Profile setting</a></li>
                        <li><a href="/logout">Sign Out</a></li>
                    </ul>
                </div>
            </li>


        </ul>
    </nav>
</div>
<!-- /.navbar -->

<script>
    document.getElementById("profile-picture-icon").addEventListener("click", function() {
        var popupSettingsList = document.getElementById("popup-settings-list");

        if (popupSettingsList.style.display === "none") {
            popupSettingsList.style.display = "block";
        } else {
            popupSettingsList.style.display = "none";
        }
    });

    const detailsElement = document.querySelector('.my-roles');

    detailsElement.addEventListener('toggle', event => {
        if (event.target.open) {} else {}
    });
</script>
