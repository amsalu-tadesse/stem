<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use ReflectionClass;
use Illuminate\Support\Str;
use App\Constants\Constants;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Symfony\Component\Finder\SplFileInfo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $emails_setting = [
            'email:on_user_signup' => [
                'subject' => 'Registration was successful',
                'body' => 'Dear {user}, <br> You have been successfully registered on ' . Constants::APP_NAME . '. Please use your email and the following password to login into the system.
                <br> We strongly advise you to change your default password. <br><br> Link: {link} <br> Password: <b> {password} </b>',
                'status' => 1,
            ],
            'email:on_user_registration' => [
                'subject' => 'Registration was successful',
                'body' => 'Dear {user}, <br> You have been successfully registered on ' . Constants::APP_NAME . '. Please use your email and the following password to login into the system.
                <br> We strongly advise you to change your default password. <br><br> Link: {link} <br> Password: <b> {password} </b>',
                'status' => 1,
            ],
            'email:on_reset_password' => [
                'subject' => 'Reset Password',
                'body' => 'Dear {user}, <br> You can reset your password for ' . Constants::APP_NAME . ' with the following link. <br> link: {link}',
                'status' => 1,
            ],
            'email:on_contact_us' => [
                'subject' => 'Your message has been received',
                'body' => 'Dear {user} <br> Thank you for Your message on ' . Constants::APP_NAME . ' platform. We always appreciate feedback and suggestions.',
                'status' => 1,
            ],


        ];

        foreach ($emails_setting as $code => $subject_body) {
            \App\Models\Email::factory()->create([
                'code' => $code,
                'subject' => $subject_body['subject'],
                'body' => $subject_body['body'],
                'status' => $subject_body['status'],
            ]);
        }


        $permissions = [

            'user',
            'role',
            'school-level',
            'school',
            'department',
            'academic-level',
            'lecturer',
            'student',
            'course',
            'academic-session',
            'instructor-course',
            'visitor'
        ];
        $permission_activities = [
            'list',
            'view',
            'create',
            'edit',
            'delete',
            // 'restore',
        ];



        $permission_counter = 0;
        $arrayOfPermissionNames = [];
        foreach ($permissions as  $permission) {

            foreach ($permission_activities as $activity) {
                $permission_counter++;
                $arrayOfPermissionNames[] = $permission . ': ' . $activity;
            }
        }


        //other non CRUD permissions
        $arrayOfPermissionNames[] = 'payroll: list';

        // $arrayOfPermissionNames[] = 'access-domain: zonal';



        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());


        $roles = [
            'Instructor',
            'Super Admin',
        ];



        foreach ($roles as $role) {
            $myrole = Role::create([
                'name' => $role,
                'code' => $role
            ]);

            // if ($role == 'Super Admin') {
            // $myrole->givePermissionTo(Permission::all());
            // }
        }


        $initial_users = [
            [
                'first_name' => 'Super Admin',
                'middle_name' => '',
                'last_name' => '',
                'mobile' => '09876543',
                'status' => 1,
                'email' => 'admin@gmail.com',
                'password_changed' => 1,
                'is_superadmin' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'first_name' => 'Belete',
                'middle_name' => 'Degu',
                'last_name' => 'Mola',
                'mobile' => '09876547',
                'status' => 1,
                'email' => 'belete@gmail.com',
                'password_changed' => 1,
                'is_superadmin' => 0,
                'created_by' => 1,
                'updated_by' => 1,
            ],


        ];

        foreach ($initial_users as $user) {
            $createdUser = \App\Models\User::factory()->create([
                'first_name' => $user['first_name'],
                'middle_name' => $user['middle_name'],
                'last_name' => $user['last_name'],
                'mobile' => $user['mobile'],
                'password' => "12345678",
                'password_changed' => $user['password_changed'],
                'status' => $user['status'],
                'is_superadmin' => $user['is_superadmin'],
                'created_by' => $user['created_by'],
                'updated_by' => $user['updated_by'],
                'email' => $user['email'],
            ]);



            if ($user['is_superadmin']) {
                $role = Role::findByName('Super Admin');
                $role->givePermissionTo(Permission::all());
                $createdUser->assignRole($role);
            } else if ($user['email'] == 'belete@gmail.com') {
                $createdUser->assignRole("Instructor");
            }

            /*if ($role) {
                $createdUser->assignRole($role);
            }*/
        }

        $settings = [

            [
                'code' => 'allow_user_signup',
                'name' => 'allow user signup',
                'value1' => '0',
                'value2' => 'null',
                'type' => 0,

            ],
            [
                'code' => 'allow_telegram_message',
                'name' => 'allow telegram message',
                'value1' => '1',
                'value2' => 'null',
                'type' => 0,

            ],
            [
                'code' => 'page_number',
                'name' => 'page_number',
                'value1' => '10,25,50,100,300,500',
                'value2' => 'null',
                'type' => 1,

            ],
            [
                'code' => 'privacy_policy',
                'name' => 'privacy policy',
                'value1' => 'value2',
                'value2' => 'We may collect personal information, such as your name, email address, and contact details, when you voluntarily submit it to us through our website. We will not sell, rent, or share your personal information with third parties without your consent, except as required by law',
                'type' => 2,

            ],
            [
                'code' => 'terms_and_conditions',
                'name' => 'terms and conditions',
                'value1' => 'value3',
                'value2' => 'Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.',
                'type' => 2,

            ],

        ];

        foreach ($settings as $setting) {

            \App\Models\Setting::factory()->create(
                [
                    'code' => $setting['code'],
                    'name' => $setting['name'],
                    'value1' => $setting['value1'],
                    'value2' => $setting['value2'],
                    'type' => $setting['type'],
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            );
        }


        $helps = [
            [
                'title' => 'Users List help',
                'url' => null,
                'body' => 'This page shows the list of users in the system. According the logged in user privileges buttons  for registering users, edit and delete could be visible. By default the page shows only ten latest users. You change the number of users per page by clicking on records per page box on the left top side. you can search users by their name or by email. You can also use the top filtering boxes to get the goups of user under a given category. e.g users under some organizations or users under Federa/Regional/Zonal. or others. you can download the list being visible by the formats provided on the top of the table. (CSV,Excel,PDF,Print) ',
                'route' => 'admin.users.index',
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Roles List help',
                'url' => null,
                'body' => 'This page shows the list of Roles in the system. The visibility of the create Role and the yes or no buttons, which allows the user to either give permission  or prohbit permission for users group as well as deleting users group(roles), depends on the privileges of the logged-in user. By default the page shows only ten latest roles. You can change the number of users per page by clicking on records per page box on the left top side. you can search users by their permissions.  Additionally can download the list being visible by the formats provided on the top of the table. (CSV,Excel,PDF,Print) ',
                'route' => 'admin.roles.index',
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],

            [
                'title' => '  helps List help',
                'url' => null,
                'body' => "This page shows the list of helps in the system. According the logged in user privileges buttons for editing existing helps, show all the detail of helps and deleting helps could be visible." . PHP_EOL . " By default the page shows only ten latest helps. You can change the number of helps per page by clicking on 'records per page' box on the left top side. Also, you can search helps by their name,url or by their route." . PHP_EOL . " Additionally, you can download the list being visible by the formats provided on the top of the table. (CSV,Excel,PDF,Print) ",
                'route' => 'admin.helps.index',
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            //

            [
                'title' => 'Contact Us List help',
                'url' => null,
                'body' => "This page presents a comprehensive list of Contact Us within the system. The visibility of button for editing existing details depends on the privileges of the logged-in user." . PHP_EOL . " By default, the page shows the ten latest Contact Us. However, you can change the number of Contact Us displayed per page by clicking on the 'records per page' box located on the top left side of the page." . PHP_EOL . " You also have the ability to search for Contact Us by their name,email or by their subject, allowing you to quickly find specific Contact Us of interest." . PHP_EOL . " Additionally, you can download the visible list of Contact Us in various formats provided at the top of the table. The available formats include CSV, Excel, PDF, and Print.",
                'route' => "admin.contact-us.index",
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Site admin help',
                'url' => null,
                'body' => "This page presents a site admin of the system. The visibility of button for update existing details of site admin depends on the privileges of the logged-in user." . PHP_EOL . " By default, the page shows the details of the site admin.",
                'route' => "admin.site-admin.index",
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Dashboard help',
                'url' => null,
                'body' => "Dashboard page is a landing page for every logged in user. ",
                'route' => "admin.dashboard",
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Profile help',
                'url' => null,
                'body' => "Your account settings page offers simple, one-click control. You can enhance security by changing your password and fine-tune your profile with options to update your name, profile photo, educational background and other details.",
                'route' => "admin.profile",
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],

        ];

        foreach ($helps as $help) {

            \App\Models\Help::factory()->create(
                [
                    'title' => $help['title'],
                    'url' => $help['url'],
                    'body' => $help['body'],
                    'route' => $help['route'],
                    'active' => $help['active'],
                    'created_by' => $help['created_by'],
                    'updated_by' => $help['updated_by'],
                ]
            );
        }

        $siteAdmins = [

            [
                'name' => Constants::APP_NAME,
                'aboutus' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iure non blanditiis, impedit earum sapiente laudantium commodi doloribus mollitia? Eos omnis totam sint dolore vitae autem, dolorum repudiandae! Iusto quos consequuntur provident ea quas fuga recusandae vel quia assumenda, id, sequi blanditiis placeat ipsa labore doloremque delectus officiis esse, obcaecati est exercitationem! Nesciunt iusto voluptatibus sapiente atque possimus aperiam dolores a vitae nostrum cumque, minus in iure ipsum animi quod aut fugiat saepe expedita labore sunt velit sed, eveniet ratione. Nihil deleniti hic accusamus aspernatur, aut autem, corporis quod, repellendus vero iste nisi! Culpa, adipisci id. Vel sapiente ratione impedit quibusdam!',
                'location' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7883.880124860577!2d38.809753!3d8.885165!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b82a7e392203f%3A0xb05f440eacc98f9f!2sAddis%20Ababa%20Science%20and%20Technology%20University!5e0!3m2!1sen!2sus!4v1699017266770!5m2!1sen!2sus',
                'address' => '3Km North of Tirunesh-Beijing Hospital or Addis Ababa to Adama Expressway, Koye Roundabout (turn to left for 1km), Akaki Kality Sub-City, Addis Ababa,',
                'email' => 'info@gmail.com',
                'telephone' => '+251115513990',
                'facebook' => 'https://www.facebook.com/people/Ethiopian-Ministry-of-Trade-and-Regional-Integration/100076055062908/',
                'twitter' => 'https://twitter.com/ethiopia_trade',
                'youtube' => 'https://www.youtube.com/channel/UCQkxxIQ8dOfifvERD0ngKSQ',
                'intro_video' => 'https://www.youtube.com/watch?v=OP9kq5X9k0M',
                'linkedin' => 'https://www.linkedin.com/in/ethiopian-ministry-of-trade-and-industry-4234841b9?originalSubdomain=et',
            ],
        ];

        foreach ($siteAdmins as $siteAdmin) {

            \App\Models\SiteAdmin::factory()->create(
                [
                    'name' => $siteAdmin['name'],
                    'aboutus' => $siteAdmin['aboutus'],
                    'location' => $siteAdmin['location'],
                    'address' => $siteAdmin['address'],
                    'email' => $siteAdmin['email'],
                    'telephone' => $siteAdmin['telephone'],
                    'facebook' => $siteAdmin['facebook'],
                    'twitter' => $siteAdmin['twitter'],
                    'youtube' => $siteAdmin['youtube'],
                    'intro_video' => $siteAdmin['intro_video'],
                    'linkedin' => $siteAdmin['linkedin'],
                ]
            );
        }

        $arr = [
            ['name' => 'Tigray', 'ordering' => 3, 'is_cityadministration' => 0, 'zones' => ['Central Tigray', 'East Tigray', 'North West Tigray', 'South Tigray', 'South East Tigray', 'West Tigray', 'Mekelle']],
            ['name' => 'Afar', 'ordering' => 4, 'is_cityadministration' => 0, 'zones' => ['Awsi Rasu', 'Kilbet Rasu', 'Gabi Rasu', 'Fanti Rasu', 'Hari Rasu', 'Mahi Rasu', 'Argobba']],
            ['name' => 'Amhara', 'ordering' => 5, 'is_cityadministration' => 0, 'zones' => [' Agew Awi', 'East Gojjam', 'Oromia zone', '  North Gondar', 'North Shewa', ' North Wollo', '  South Gondar', ' South Wollo', ' Wag Hemra', 'West Gojjam', 'Bahir Dar ']],
            ['name' => 'Oromia', 'ordering' => 6, 'is_cityadministration' => 0, 'zones' => ['Arsi Zone', 'Bale Zone', 'Borena Zone', 'Buno Bedele Zone', 'East Hararghe Zone', 'East Shewa Zone', 'East Welega Zone', 'Guji Zone', 'Horo Guduru Welega Zone', 'Illu Aba Bora Zone', 'Jimma Zone', 'Kelam Welega Zone', 'North Shewa Zone', 'Southwest Shewa Zone', 'West Arsi Zone', 'West Guji Zone', 'West Hararghe Zone', 'West Shewa Zone', 'West Welega Zone', 'Oromia Special Zone Surrounding Finfinne']],
            ['name' => 'Somali', 'ordering' => 7, 'is_cityadministration' => 0, 'zones' => ['Afder Zone', 'Dhawa Zone', 'Dollo Zone', 'Erer Zone', 'Fafan Zone', 'Jarar Zone', 'Korahe Zone', 'Liben Zone', 'Nogob Zone', 'Shabelle Zone', 'Sitti Zone']],
            ['name' => 'Benishangul-Gumuz', 'ordering' => 8, 'is_cityadministration' => 0, 'zones' => ['Asosa', 'Kamashi', 'Metekel']],
            ['name' => 'Southern Nations, Nationalities, and Peoples', 'ordering' => 9, 'is_cityadministration' => 0, 'zones' => ['Gamo Zone', 'Gofa Zone', 'Gedeo Zone', 'Gurage Zone', 'Hadiya Zone', 'Kembata Tembaro Zone', 'Silte Zone', 'Debub Omo Zone', 'Wolayita Zone', 'Alaba Zone', 'Amaro special woreda', 'Alle Special Woreda', 'Basketo special woreda	', 'Burji special woreda', 'Dirashe special woreda', 'Konso Zone', 'Yem special woreda']],
            ['name' => 'Gambela', 'ordering' => 10, 'is_cityadministration' => 0, 'zones' => []],
            ['name' => 'Harari', 'ordering' => 11, 'is_cityadministration' => 0, 'zones' => []],
            ['name' => 'Sidama', 'ordering' => 12, 'is_cityadministration' => 0, 'zones' => ['Aleta Chuko', 'Aleta Wendo', 'Arbegona', 'Aroresa', 'Hawassa Zuria', 'Bensa', 'Bona Zuria', 'Boricha', 'Bursa', 'Chere', 'Dale', 'Dara', 'Gorche', 'Hawassa', 'Hula', 'Loko Abaya', 'Malga', 'Shebedino', 'Wensho', 'Wondo Genet']],
            ['name' => 'South West Ethiopia Peoples', 'ordering' => 13, 'is_cityadministration' => 0, 'zones' => ['	Bench Maji Zone', 'Dawro Zone', 'Keffa Zone', 'Sheka Zone', 'West Omo Zone', 'Konta Zone']],
            ['name' => 'Addis Ababa', 'ordering' => 1, 'is_cityadministration' => 1, 'zones' => ['Addis Ketema', '	Akaky Kaliti', 'Arada', 'Bole', 'Gullele', 'Kirkos', 'Kolfe Keranio', 'Lideta', 'Nifas Silk-Lafto', 'Yeka']],
            ['name' => 'Dire Dawa', 'ordering' => 2, 'is_cityadministration' => 1, 'zones' => ['Dire Dawa city', 'Gurgura']],
        ];




        $cc = 0;
        foreach ($arr as $key => $val) {
            $cc++;
            \App\Models\Region::factory()->create(
                [
                    'name' => $val['name'],
                    'ordering' => $val['ordering'],
                    'is_cityadministration' => $val['is_cityadministration'],
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            );

            $zones = $val['zones'];

            foreach ($zones as $zone) {

                \App\Models\Zone::factory()->create(
                    [
                        'name' => $zone,
                        'region_id' => $cc,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ]
                );
            }
        };


        $users = User::all();

        foreach ($users as $k => $user) {
            $user->save();
        }
        $academic_levels = [
            [
                'type' => 0,
                'name' => 'Full Professor',
                'price' => '200',
            ],
            [
                'type' => 0,
                'name' => 'Associate Professor',
                'price' => '200',
            ],
            [
                'type' => 0,
                'name' => 'Assistant Lectures',
                'price' => '150',
            ],
            [
                'type' => 0,
                'name' => 'Lecturer',
                'price' => '165',
            ],
            [
                'type' => 0,
                'name' => 'Assistant Lecturer',
                'price' => '200',
            ],
            [
                'type' => 1,
                'name' => 'CARA2',
                'price' => '100',
            ],
            [
                'type' => 1,
                'name' => 'CARA1',
                'price' => '100',
            ],
            [
                'type' => 1,
                'name' => 'SARA',
                'price' => '100',
            ],
            [
                'type' => 1,
                'name' => 'ARA',
                'price' => '100',
            ],


        ];

        foreach ($academic_levels as $academic_level) {

            \App\Models\AcademicLevel::factory()->create(
                [
                    'type' => $academic_level['type'],
                    'name' => $academic_level['name'],
                    'price' => $academic_level['price'],
                ]
            );
        }
        $school_levels = [
            [
                'name' => 'Elementary School',
                'description' => 'Elementary School',
            ],
            [
                'name' => 'Junior School',
                'description' => 'Junior School',
            ],
            [
                'name' => 'High School',
                'description' => 'High School',
            ],
            [
                'name' => 'Preparatory School',
                'description' => 'Preparatory School',
            ],
        ];

        foreach ($school_levels as $school_level) {

            \App\Models\SchoolLevel::factory()->create(
                [
                    'name' => $school_level['name'],
                    'description' => $school_level['description'],
                ]
            );
        }
        $schools = [
            [
                'name' => 'Addis Global Academy',
                'address' => 'Bole Airport',
                'school_level' => 1,
            ],
            [
                'name' => 'British International School',
                'address' => 'Bole Bridge',
                'school_level' => 2,
            ],
            [
                'name' => 'Bole Community School',
                'address' => 'Bole Homes',
                'school_level' => 3,
            ],
        ];

        foreach ($schools as $school) {

            \App\Models\School::factory()->create(
                [
                    'name' => $school['name'],
                    'address' => $school['address'],
                    'school_level' => $school['school_level'],
                ]
            );
        }
        $departments = [
            [
                'name' => 'Department1',
                'description' => 'Description of Department1',
            ],
            [
                'name' => 'Department2',
                'description' => 'Description of Department1',
            ],
            [
                'name' => 'Department3',
                'description' => 'Description of Department3',
            ],
        ];

        foreach ($departments as $department) {

            \App\Models\Department::factory()->create(
                [
                    'name' => $department['name'],
                    'description' => $department['description'],
                ]
            );
        }

        $academic_sessions = [
            [
                'label' => 'Session 2021',
                'academic_year' => '2023/24',
                'start_date' => '2023-11-03 11:31:38',
                'end_date' => '2024-11-03 11:31:38',
                'week_type' => 0,
            ],
            [
                'label' => 'Session 2022',
                'academic_year' => '2024/25',
                'start_date' => '2024-11-03 11:31:38',
                'end_date' => '2025-11-03 11:31:38',
                'week_type' => 1,
            ],
            [
                'label' => 'Session 2023',
                'academic_year' => '2025/26',
                'start_date' => '2025-11-03 11:31:38',
                'end_date' => '2026-11-03 11:31:38',
                'week_type' => 0,
            ],
        ];

        foreach ($academic_sessions as $academic_session) {

            \App\Models\AcademicSession::factory()->create(
                [
                    'label' => $academic_session['label'],
                    'academic_year' => $academic_session['academic_year'],
                    'start_date' => $academic_session['start_date'],
                    'end_date' => $academic_session['end_date'],
                    'week_type' => $academic_session['week_type'],
                ]
            );
        }


        /*$students = [
            [
                'name' => 'Getasew Tilahun',
                'age' => '25',
                'grade' => '12',
                'sex' => 'M',
                'school_id' => 2,
                'academic_session' => 1,
            ],
            [
                'name' => 'Yunlong Jambo',
                'age' => '13',
                'grade' => '7',
                'sex' => 'M',
                'school_id' => 1,
                'academic_session' => 2,
            ],
            [
                'name' => 'Ermiyas Temesgen',
                'age' => '25',
                'grade' => '11',
                'sex' => 'M',
                'school_id' => 3,
                'academic_session' => 3,
            ],
        ];

        foreach ($students as $student) {

            \App\Models\Student::factory()->create(
                [
                    'name' => $student['name'],
                    'age' => $student['age'],
                    'sex' => $student['sex'],
                    'grade' => $student['grade'],
                    'school_id' => $student['school_id'],
                    'academic_session' => $student['academic_session'],
                ]
            );
        }*/




        $lecturers = [
            [
                'name' => 'Amsalu Tadesse',
                'department' => 1,
                'academic_level_id' => 1,
                'phone' => '+25190657348',
                'email' => 'tadesseamsalu@gmail.com',
            ],
            [
                'name' => 'Yonthan Demlie',
                'department' => 2,
                'academic_level_id' => 2,
                'phone' => '+251941000262',
                'email' => 'yon21@gmail.com',
            ],
            [
                'name' => 'Ermiyas Temesgen',
                'department' => 3,
                'academic_level_id' => 5,
                'phone' => '+251843955',
                'email' => 'ermi@gmail.com',
            ],
            [
                'name' => 'Yaried Kidus',
                'department' => 3,
                'academic_level_id' => 6,
                'phone' => '+251843955',
                'email' => 'yaried12@gmail.com',
            ],
        ];

        foreach ($lecturers as $lecturer) {

            \App\Models\Lecturer::factory()->create(
                [
                    'name' => $lecturer['name'],
                    'department' => $lecturer['department'],
                    'phone' => $lecturer['phone'],
                    'academic_level_id' => $lecturer['academic_level_id'],
                    'email' => $lecturer['email'],
                ]
            );
        }
        $courses = [
            [
                'name' => 'Chemistry',
                'lecture_hr_per_week' => 20,
                'lab_hr_per_week' => 10,
            ],
            [
                'name' => 'Biology',
                'lecture_hr_per_week' => 15,
                'lab_hr_per_week' => 5,
            ],
            [
                'name' => 'Physics',
                'lecture_hr_per_week' => 15,
                'lab_hr_per_week' => 10,
            ],
        ];

        foreach ($courses as $course) {

            \App\Models\Course::factory()->create(
                [
                    'name' => $course['name'],
                    'lecture_hr_per_week' => $course['lecture_hr_per_week'],
                    'lab_hr_per_week' => $course['lab_hr_per_week'],
                ]
            );
        }


        \App\Models\InstructorCourse::factory()->create([
            'course_id' => 1,
            'lecturer_id' => 1,
            'lab_assistant_id' => 1,
            'academic_session_id' => 1,
        ]);

        $students = 100;

        \App\Models\Student::factory()->count($students)->create();


        for ($i = 1; $i < $students; $i++) {
            \App\Models\StudentInstructorCourse::factory()->create([
                'student_id' => $i,
                'instructor_course_id' => 1,
                'mark' => 40,
                'pass' => 1,
            ]);
        }
    }
}
