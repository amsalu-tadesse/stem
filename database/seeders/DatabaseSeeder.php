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
                'body' => 'Dear {user} <br> Thank you for Your message on EPPD platform. We always appreciate feedback and suggestions.',
                'status' => 1,
            ],
            'email:on_subscribe' => [
                'subject' => 'You have subscribed successfully',
                'body' => 'Dear {user}, <br> Thank you for Your subscription on EPPD platform. <br> Click on the following links, If you wish to unsubscribe, {link}',
                'status' => 1,

            ],
            'email:on_issue_created' => [
                'subject' => 'New Issue Created: {issue_title}',
                'body' => 'Dear {user} <br> We are writing to inform you that a new issue has been created in Electronic Public Private Dialog Portal - FDRE.',
                'status' => 1,
            ],
            /* 'email:on_request_institutions_for_comment' => [
                'subject' => 'Request for comment',
                'body' => 'Greetings, <br> We need your institution to comment on the draft document shared below. <br> Draft link: {link}',
            ],

            'email:on_request_personnel_for_comment' => [
                'subject' => 'Request for comment',
                'body' => 'Dear {user}, <br> You have been assigned to comment the draft shared below. <br> Draft link: {link}',
            ],

            'email:on_document_creation' => [
                'subject' => 'Draft document created',
                'body' => 'Dear {user}, <br> <br> You have successfully created a new draft document. please check it from the link provided below. <br> Draft link: {link}',
            ],

            'email:on_comment_open' => [
                'subject' => 'Draft document has been opened for comment',
                'body' => 'Dear {user}, <br> Your document has been opened for comment. <br> Draft link: {link}',
            ],
            'email:on_comment_close' => [
                'subject' => 'Draft document commenting session has been closed',
                'body' => 'Dear {user}, <br> Your draft document commenting session has been closed. <br> Draft link: {link}',
            ],
            'email:on_assignment_for_comment_replies' => [
                'subject' => 'Assigned as comment replier',
                'body' => 'Dear {user}, <br> You have been assigned as comment replier for the following draft. <br> Draft link: {link}',
            ],
            'email:on_assignment_as_commenter' => [
                'subject' => 'Assigned as commenter',
                'body' => 'Dear {user}, <br> You have been assigned to give your comments on the following draft content. <br> Draft link: {link}',
            ],*/

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
            'contact-us',
            'custom-exception',
            'email',
            'event',
            'f-a-q',
            'file-category',
            'help',
            'issue',
            'issue-request',
            'kpi',
            'organization',
            'organization-level',
            'organization-type',
            'region',
            'setting',
            'site-admin',
            'subscription',
            'user',
            'working-group',
            'zone',
            'role',
            'school-levels',
            'schools',
            'departments',
            'academic-levels',
            'lecturers',
            'students',
            'courses',
            'academic-sessions',
            'instructer-courses',
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
        $arrayOfPermissionNames[] = 'issue: update implementation status';
        $arrayOfPermissionNames[] = 'issue: attach additional files';
        $arrayOfPermissionNames[] = 'analysis: show';

        // $arrayOfPermissionNames[] = 'access-domain: zonal';



        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());


        $roles = [

            'MOTRI-MOI',
            'BMO-MDA-CSO',
            'CF Coordination Secretariat',
            'Working Groups',
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
                'organization_id' => 1,
                'password_changed' => 1,
                'is_superadmin' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'first_name' => 'MOTRI',
                'middle_name' => 'User',
                'last_name' => '',
                'mobile' => '090964343',
                'password_changed' => 1,
                'status' => 1,
                'organization_id' => 1,
                'is_superadmin' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'email' => 'motri@gmail.com',
            ],

            [
                'first_name' => 'BMO',
                'middle_name' => 'User',
                'last_name' => 'User',
                'mobile' => '0977777052',
                'password_changed' => 1,
                'status' => 1,
                'organization_id' => 2,
                'is_superadmin' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'email' => 'bmo@gmail.com',
            ],
            [
                'first_name' => 'CF Coordination Secretariat',
                'middle_name' => '-',
                'last_name' => 'User',
                'mobile' => '090964383',
                'password_changed' => 1,
                'status' => 1,
                'organization_id' => 3,
                'is_superadmin' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'email' => 'cfc@gmail.com',
            ],
            [
                'first_name' => 'Working',
                'middle_name' => 'Group',
                'last_name' => 'User',
                'mobile' => '090934343',
                'password_changed' => 1,
                'status' => 1,
                'organization_id' => 1,
                'is_superadmin' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'email' => 'workinggroup@gmail.com',
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
                $createdUser->assignRole("CF Coordination Secretariat");
            } else if ($user['email'] == 'bmo@gmail.com') {
                $createdUser->assignRole("BMO-MDA-CSO");
            } else if ($user['email'] == 'motri@gmail.com') {
                $createdUser->assignRole("MOTRI-MOI");
            } else if ($user['email'] == 'cfc@gmail.com') {
                $createdUser->assignRole("CF Coordination Secretariat");
            } else if ($user['email'] == 'workinggroup@gmail.com') {
                $createdUser->assignRole("Working Groups");
            }

            /*if ($role) {
                $createdUser->assignRole($role);
            }*/
        }

        $organization_types = [

            [
                'name' => 'BMO - Business Membership Organization',
                'description' => '...of business structure, practices, and processes to enhance efficiency and maximize profit. It refers to the management of functions that a business needs to run effectively day-to-day, including: Overseeing multiple departments and providing goals.',
            ],
            [
                'name' => 'MDA - Ministries Departements Agancies',
                'description' => '...of business structure, practices, and processes to enhance efficiency and maximize profit. It refers to the management of functions that a business needs to run effectively day-to-day, including: Overseeing multiple departments and providing goals.',
            ],
            [
                'name' => 'CSO - Civil Society',
                'description' => '...of business structure, practices, and processes to enhance efficiency and maximize profit. It refers to the management of functions that a business needs to run effectively day-to-day, including: Overseeing multiple departments and providing goals.',

            ],
        ];


        foreach ($organization_types as $type) {

            \App\Models\OrganizationType::factory()->create(
                [
                    'name' => $type['name'],
                    'description' => $type['description'],
                    // 'created_by' => 1,
                    // 'updated_by' => 1,
                ]
            );
        }
        $organization_levels = [

            [
                'name' => 'Federal',
                'description' => 'From the Federal Democratic Republic of Ethiopia',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Regional',
                'description' => 'From all Ethioan regions',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Zonal',
                'description' => 'From all Ethiopian zones',
                'created_by' => 1,
                'updated_by' => 1,
            ]
        ];

        foreach ($organization_levels as $level) {

            \App\Models\OrganizationLevel::factory()->create(
                [
                    'name' => $level['name'],
                    'description' => $level['description'],
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            );
        }
        $organizations = [
            [
                'name' => 'ECCSA',
                'description' => 'Operations management',
                'organization_type_id' => 1,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'AACCSA',
                'description' => 'Only the federal government can regulate interstate and foreign commerce.',
                'organization_type_id' => 1,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'OCCSA',
                'description' => 'Operations management ',
                'organization_type_id' => 1,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'EWEA',
                'description' => 'Operations management ',
                'organization_type_id' => 1,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'EUBFE',
                'description' => 'Operations management ',
                'organization_type_id' => 1,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'EYEA',
                'description' => 'Operations management',
                'organization_type_id' => 1,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Public Servants Social Security Agency',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ethiopian Construction Authority',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'F.D.R.E AUTHORITY FOR CIVIL SOCIETY ORGANIZATIONS',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ethiopian Coffee and Tea authority',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ethiopian Environmental Protection Authority',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Addis Ababa City Infrastructure Integration,Construction permit and Control Authority',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Petroleum and Energy Authority',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ethiopian Media Authority',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Accounting and Auditing Board of Ethiopia',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ethiopian Investment Commission',
                'description' => 'Operations management',
                'organization_type_id' => 1,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Federal Civil Service Commission',
                'description' => 'Operations management',
                'organization_type_id' => 1,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ethiopian Management Institute',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ministry of Transport and Logistics',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ministry Of Foreign Affairs',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ministry of Labor and Skill',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ministry of Peace',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ministry of Tourism',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ministry of Innovation and Technology',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ministry of Industry',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ministry of Justice',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ministry Of Trade and Regional Integration',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ministry of Finance',
                'description' => 'Operations management',
                'organization_type_id' => 2,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'Ethiopian Diaspora Service',
                'description' => 'Operations management',
                'organization_type_id' => 3,
                'organization_level_id' => 1,
            ],
            [
                'name' => 'System(E-service) Support Center',
                'description' => 'Operations management',
                'organization_type_id' => 3,
                'organization_level_id' => 1,
            ],
        ];

        foreach ($organizations as $organization) {

            \App\Models\Organization::factory()->create(
                [
                    'name' => $organization['name'],
                    'organization_type_id' => $organization['organization_type_id'],
                    'organization_level_id' => $organization['organization_level_id'],
                    'description' => $organization['description'],
                    // 'created_by' => 1,
                    // 'updated_by' => 1,
                ]
            );
        }






        $settings = [

            [
                'code' => 'allow_user_signup',
                'name' => 'allow user signup',
                'value1' => '1',
                'value2' => 'null',
                'type' => 0,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'code' => 'allow_telegram_message',
                'name' => 'allow telegram message',
                'value1' => '1',
                'value2' => 'null',
                'type' => 0,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'code' => 'page_number',
                'name' => 'page_number',
                'value1' => '10,25,50,100,300,500',
                'value2' => 'null',
                'type' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'code' => 'privacy_policy',
                'name' => 'privacy policy',
                'value1' => 'value2',
                'value2' => 'We may collect personal information, such as your name, email address, and contact details, when you voluntarily submit it to us through our website. We will not sell, rent, or share your personal information with third parties without your consent, except as required by law',
                'type' => 2,
                'created_by' => 2,
                'updated_by' => 2,
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
                'created_by' => 3,
                'updated_by' => 3,
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
                    'created_by' => $setting['created_by'],
                    'updated_by' => $setting['updated_by'],
                ]
            );
        }
        $faqs = [

            [
                'question' => 'What is an electronic public-private portal?',
                'answer' => 'An electronic public-private portal is a web-based platform that facilitates communication, collaboration, and information exchange between public and private entities. It serves as a digital gateway where users can access and share resources, interact with each other, and engage in various activities electronically.',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'question' => 'What are the advantages of using an electronic public-private portal?',
                'answer' => 'Some advantages of using an electronic public-private portal include:
                Convenient access: Users can access the portal anytime and from anywhere with an internet connection.
Efficient information exchange: Electronic portals enable quick and seamless sharing of documents, files, and data among users.
Improved collaboration: Users can collaborate on projects, communicate, and work together electronically, enhancing efficiency and productivity.
Centralized platform: The portal serves as a centralized hub where users can find relevant information, resources, and services.
Enhanced security: Electronic portals can implement robust security measures to protect sensitive data and ensure secure communication.',
                'created_by' => 2,
                'updated_by' => 2,
            ],
            [
                'question' => ' What features are typically found in electronic public-private portals?',
                'answer' => 'Common features of electronic public-private portals include:

                User authentication and access control: Ensuring that only authorized individuals or organizations can access specific areas or resources within the portal.
                Document management: Allowing users to upload, download, and share documents, files, and other digital assets.
                Communication tools: Enabling users to send messages, participate in discussions, and collaborate within the portal.
                Task and workflow management: Supporting the organization and tracking of tasks, assignments, and workflows.
                Reporting and analytics: Providing tools for generating reports and analyzing data collected within the portal.
                Integration capabilities: Integrating with other software systems or platforms to enhance functionality and data exchange.',
                'created_by' => 3,
                'updated_by' => 3,
            ],
            [
                'question' => 'How are electronic public-private portals used in government settings?',
                'answer' => 'In government settings, electronic public-private portals can be used for various purposes, such as:

                    Facilitating collaboration between government agencies, private organizations, and citizens.
                    Streamlining government processes, such as permit applications, license renewals, and information requests.
                    Sharing public data and information with the public or specific stakeholders.
                    Coordinating emergency response efforts and disseminating critical information during crises.
                    Supporting public-private partnerships and initiatives, such as economic development programs.',
                'created_by' => 4,
                'updated_by' => 4,
            ],
            [
                'question' => 'Are there any challenges in implementing electronic public-private portals?',
                'answer' => 'Implementing electronic public-private portals may come with challenges, including:

                Technical complexities: Developing and maintaining a robust and user-friendly portal can require significant technical expertise.
                Data security and privacy: Ensuring that sensitive data is protected and privacy regulations are adhered to.
                User adoption: Encouraging users to embrace the portal and utilize its features effectively.
                Interoperability: Integrating the portal with existing systems and platforms used by different entities.
                Training and support: Providing adequate training and support for users to navigate and utilize the portal effectively.',
                'created_by' => 4,
                'updated_by' => 4,
            ],
            [
                'question' => ' Can electronic public-private portals be customized to specific needs?',
                'answer' => "Yes, electronic public-private portals can be customized to meet specific needs. Organizations can tailor the portal's features, user interface, and functionality to align with their requirements. Customization may involve branding, adapting workflows, integrating with existing systems, and incorporating specific modules or tools.",
                'created_by' => 4,
                'updated_by' => 4,
            ],
            [
                'question' => 'How do electronic public-private portals ensure data security?',
                'answer' => "Electronic public-private portals employ various measures to ensure data security, such as: Encryption: Encrypting data in transit and at rest to protect it from unauthorized access.
                User access controls: Implementing authentication mechanisms and access controls to ensure only authorized users can access specific data or features.
                Regular security updates: Keeping the portal's software and systems up to date with the latest security patches.
                Auditing and monitoring: Monitoring user activities, logging events, and conducting regular security audits to identify and address potential vulnerabilities.
                Secure data storage: Employing secure data storage practices, including backups and disaster recovery plans, to prevent data loss or unauthorized access.
                Compliance with regulations: Adhering to relevant data security and privacy regulations, such as GDPR or HIPAA, depending on the nature of the data being handled.",
                'created_by' => 4,
                'updated_by' => 4,
            ],
        ];

        foreach ($faqs as $faq) {

            \App\Models\FAQ::factory()->create(
                [
                    'question' => $faq['question'],
                    'answer' => $faq['answer'],
                    'created_by' => $faq['created_by'],
                    'updated_by' => $faq['updated_by'],
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
                'title' => 'Organization Levels List help',
                'url' => null,
                'body' => 'This page shows the list of Organization levels in the system. According the logged in user privileges buttons for create new organization level, edit and delete could be visible. By default the page shows only ten latest organization levels. You change the number of organiation levels per page by clicking on records per page box on the left top side. You can search organization levels by their name .You can download the list being visible by the formats provided on the top of the table. (CSV,Excel,PDF,Print) ',
                'route' => 'admin.organization-levels.index',
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Organization Types List help',
                'url' => null,
                'body' =>
                'This page shows the list of Organization types in the system. According the logged in user privileges buttons for create new organization type, edit and delete could be visible. By default the page shows only ten latest organization types. You can change the number of organiation types per page by clicking on records per page box on the left top side. You can search organization types by their name .Additionally,you can download the list being visible by the formats provided on the top of the table. (CSV,Excel,PDF,Print) ',
                'body' => 'This page shows the list of Organization types in the system. According the logged in user privileges buttons for create new organization type, edit and delete could be visible. By default the page shows only ten latest organization types. You can change the number of organiation types per page by clicking on records per page box on the left top side. You can search organization types by their name .Additionally,you can download the list being visible by the formats provided on the top of the table. (CSV,Excel,PDF,Print) ',
                'route' => "admin.organization-types.index",
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Organizations List help',
                'url' => null,
                'body' => 'This page displays a list of organizations in the system. Depending on the privileges of the logged-in user, buttons for adding new organizations, editing existing organizations, and deleting organizations could be visible. By default, the page shows the ten latest organizations.You can change the number of organizations displayed per page by clicking on the "records per page" box located on the top left side of the page. Additionally, you can search for organizations by their name, organization type, organization level, or region/zone. The top filtering boxes can be used to group organizations based on specific categories, such as organization types or organization levels.Furthermore, you have the option to download the visible list of organizations in various formats provided at the top of the table, including CSV, Excel, PDF, and Print.',
                'route' => 'admin.organizations.index',
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Issues List  help ',
                'url' => null,
                'body' => 'This page displays a list of issues in the system. Depending on the privileges of the logged-in user, buttons for adding new issues, editing existing issues, and deleting issues could be visible. By default, the page shows the ten latest issues. You can change the number of issues displayed per page by clicking on the "records per page" box located on the top left side of the page. Additionally, you can search for issues by their name, responsible person or responsible institution. The top filtering boxes can be used to group issues based on specific categories, such as organizations ,state of issue,stage of the issue or by using issue create range. Furthermore, you have the option to download the visible list of issues in various formats provided at the top of the table, including CSV, Excel, PDF, and Print.',
                'route' => 'admin.issues.index',
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Working Groups List  ',
                'url' => null,
                'body' => 'This page displays a list of working groups in the system. Depending on the privileges of the logged-in user, buttons for adding new working groups, editing existing working groups, and deleting working groups could be visible. By default, the page shows the ten latest working groups. You can change the number of working groups displayed per page by clicking on the "records per page" box located on the top left side of the page. Additionally, you can search for working groups by their name or by their organization levels.Furthermore, you have the option to download the visible list of working groups in various formats provided at the top of the table, including CSV, Excel, PDF, and Print.',
                'route' => 'admin.working-groups.index',
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Issue Requests List help  ',
                'url' => null,
                'body' => 'This page displays a list of issue requests in the system. The visibility of the "Respond" button, which allows the user to either approve or reject the requested issue, depends on the privileges of the logged-in user. By default, the page shows the ten latest issue requests. Also, you can modify the number of issue requests displayed per page by clicking on the "records per page" box located on the top left side of the page.Additionally, you have the ability to search for issue requests based on their name, responsible person, or the responsible institution associated with the request.Moreover, you can download the visible list of issue requests in various formats provided at the top of the table. The available formats include CSV, Excel, PDF, and Print',
                'route' => 'admin.issues.issue_request',
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Regions List help',
                'url' => null,
                'body' => 'This page displays a list of regions in the system. The visibility of buttons for creating a new region, editing existing regions, and deleting regions depends on the privileges of the logged-in user.  By default, the page shows the ten latest regions. However, you can change the number of regions displayed per page by clicking on the "records per page" box located on the top left side of the page.  You also have the ability to search for regions by their name, allowing you to quickly find specific regions of interest.  Additionally, you can download the visible list of regions in various formats provided at the top of the table. The available formats include CSV, Excel, PDF, and Print.',
                'route' => "admin.regions.index",
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Zones List help',
                'url' => null,
                'body' => "This page displays a list of zones in the system. The visibility of buttons for creating a new zone, editing existing zones, and deleting zones depends on the privileges of the logged-in user. By default, the page shows the ten latest zones. However, you can change the number of zones displayed per page by clicking on the 'records per page' box located on the top left side of the page.  You also have the ability to search for regions by their name, allowing you to quickly find specific zones of interest." . PHP_EOL . " Additionally, you can select a region from the top left side box to view all the zones that exist in that particular region. This allows you to filter the list and focus on zones within a specific region." . PHP_EOL . " Furthermore, you can download the visible list of zones in various formats provided at the top of the table. The available formats include CSV, Excel, PDF, and Print.",
                'route' => "admin.zones.index",
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'KPIs List help',
                'url' => null,
                'body' => "This page presents a comprehensive list of KPIs within the system. The visibility of buttons for creating a new KPI, editing existing KPIs, and deleting KPIs depends on the privileges of the logged-in user." . PHP_EOL . " By default, the page shows the ten latest KPIs. However, you can change the number of KPIs displayed per page by clicking on the 'records per page' box located on the top left side of the page. You also have the ability to search for kpis by their name, allowing you to quickly find specific KPIs of interest." . PHP_EOL . " Additionally, you can download the visible list of KPIs in various formats provided at the top of the table. The available formats include CSV, Excel, PDF, and Print.",
                'route' => "admin.kpis.index",
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Emails List help',
                'url' => null,
                'body' => "This page presents a comprehensive list of emails within the system. The visibility of button for editing existing details(subject and body) depends on the privileges of the logged-in user." . PHP_EOL . " By default, the page shows the ten latest emails. However, you can change the number of emails displayed per page by clicking on the 'records per page' box located on the top left side of the page." . PHP_EOL . " You also have the ability to search for emails by their code or by their subject, allowing you to quickly find specific emails of interest." . PHP_EOL . " Additionally, you can download the visible list of emails in various formats provided at the top of the table. The available formats include CSV, Excel, PDF, and Print.",
                'route' => "admin.emails.index",
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Configurations List help',
                'url' => null,
                'body' => "This page shows the list of configurations in the system. According the logged in user privileges button for edit could be visible." . PHP_EOL . " By default the page shows only ten latest configurations. You can change the number of configurations per page by clicking on 'records per page' box on the left top side. Also, you can search configurations by their name." . PHP_EOL . " Additionally, you can download the list being visible by the formats provided on the top of the table. (CSV,Excel,PDF,Print) ",
                'route' => 'admin.settings.index',
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => '  File Categories List help',
                'url' => null,
                'body' => "This page shows the list of file categories in the system. According the logged in user privileges buttons for creating a new file category, editing existing file categories, and deleting file categories could be visible." . PHP_EOL . " By default the page shows only ten latest file categories. You can change the number of file categories per page by clicking on 'records per page' box on the left top side. Also, you can search file categories by their name." . PHP_EOL . " Additionally, you can download the list being visible by the formats provided on the top of the table. (CSV,Excel,PDF,Print) ",
                'route' => 'admin.file-categories.index',
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
                'title' => 'Custom Exceptions  help',
                'url' => null,
                'body' => "This page presents a comprehensive list of custom exceptions within the system. The visibility of button for clear all custom exceptions, view description and delete custom exception   depends on the privileges of the logged-in user." . PHP_EOL . " By default, the page shows the ten latest custom exceptions. However, you can change the number of custom exceptions displayed per page by clicking on the 'records per page' box located on the top left side of the page." . PHP_EOL . " You also have the ability to search for custom exceptions by  their title, allowing you to quickly find specific custom exceptions of interest." . PHP_EOL . " Additionally, you can download the visible list of custom exception in various formats provided at the top of the table. The available formats include CSV, Excel, PDF, and Print.",
                'route' => "admin.custom-exceptions.index",
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Subscriptions List help',
                'url' => null,
                'body' =>  "This page presents a comprehensive list of subscription within the system. The visibility of   button for deleting subscription depends on the privileges of the logged-in user." . PHP_EOL .
                    "By default, the page shows the ten latest  subscriptions. However, you can change the number of  subscriptions displayed per page by clicking on the 'records per page' box located on the top left side of the page." . PHP_EOL .
                    "You also have the ability to search for  subscriptions by their email, allowing you to quickly find specific  subscriptions of interest." . PHP_EOL .
                    "Additionally, you can download the visible list of  subscriptions in various formats provided at the top of the table. The available formats include CSV, Excel, PDF, and Print.",
                'route' => "subscriptions.index",
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'FAQs List  help',
                'url' => null,
                'body' => "This page presents a comprehensive list of FAQs within the system. The visibility of button for creating FAQ, editing existing FAQs and deleting FAQs depends on the privileges of the logged-in user." . PHP_EOL . " By default, the page shows the ten latest FAQs. However, you can change the number of FAQs displayed per page by clicking on the 'records per page' box located on the top left side of the page." . PHP_EOL . " You acan also search for FAQs by their questions, allowing you to quickly find specific FAQs of interest." . PHP_EOL . " Additionally, you can download the visible list of FAQs in various formats provided at the top of the table. The available formats include CSV, Excel, PDF, and Print.",
                'route' => "admin.faqs.index",
                'active' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
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
            [
                'title' => 'Analysis',
                'url' => null,
                'body' => "This Page presents overview of issues. You can filter issues by their level (Federal, Regional, Zonal) and view all status issues using the 'All Status' checkbox. It's your command center for quick issue management.. By default, the page shows the overview of issues.",
                'route' => "admin.analysis",
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
                'name' => 'EPPD',
                'aboutus' => '
                An electronic public-private portal is a web-based platform that facilitates communication, collaboration, and information exchange between public and private entities. It serves as a digital gateway where users can access and share resources, interact with each other, and engage in various activities electronically.
                ',
                'location' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7880.724309874413!2d38.75270387770995!3d9.030689800000008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b85f23d0aecdb%3A0x5368a36524cc3e5a!2sFDRE%20Ministry%20of%20Trade%20and%20Industry!5e0!3m2!1sen!2spl!4v1694002069266!5m2!1sen!2spl" width="600" height="450" style="border:0;"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
                'address' => 'Woreda 09 basha wolde chilot, Arada Sub City, Addis Ababa,',
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
            $user->organization_id = $k + 1;
            $user->save();
        }
        $academic_levels = [
            [
                'type' => 0,
                'name' => 'Assistatnt Lectures',
                'price' => '150',
            ],
            [
                'type' => 0,
                'name' => 'Lecturer',
                'price' => '165',
            ],
            [
                'type' => 0,
                'name' => 'Assistant proffesor',
                'price' => '200',
            ],
            [
                'type' => 0,
                'name' => 'Full Professor',
                'price' => '200',
            ],
            [
                'type' => 1,
                'name' => 'ARA',
                'price' => '100',
            ],
            [
                'type' => 1,
                'name' => 'SARA',
                'price' => '100',
            ],
            [
                'type' => 1,
                'name' => 'CARA1',
                'price' => '100',
            ],
            [
                'type' => 1,
                'name' => 'CARA2',
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
                'name' => 'High School',
                'description' => 'High School',
            ],
            [
                'name' => 'Preparatory',
                'description' => 'Preparatory',
            ],
        ];
    }
}
