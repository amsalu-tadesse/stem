<?php

use Illuminate\Support\Facades\Auth;

return [
    'menu_1'                 =>  [
        'name'                 => 'User Managments',
        'menu_icon'           => 'fa-user',
        'permissions'           => ['role: list', 'user: list'],

        'menu_item'            =>
        [


            [
                'title'        => 'Roles',
                'url'          => 'admin.roles.index',
                'permission'   => 'role: list'

            ],

            [
                'title'      =>  'Users',
                'url'        =>  'admin.users.index',
                'permission' => 'user: list'
            ]
        ]
    ],

    'menu_2'                 =>  [
        'name'                 => 'Organizations',
        'menu_icon'           => 'fa-building',
        'permissions'           => ['organization-level: list', 'organization-type: list', 'organization: list'],
        'menu_item'            =>
        [
            [
                'title'        => 'Organization Levels',
                'url'          => 'admin.organization-levels.index',
                'permission'   => 'organization-level: list'

            ],
            [
                'title'        => 'Organization Types',
                'url'          => 'admin.organization-types.index',
                'permission'   => 'organization-type: list'

            ],
            [
                'title'      =>  'Organizations',
                'url'        =>  'admin.organizations.index',
                'permission'   => 'organization: list'
            ],

        ]
    ],
    'menu_3'                 =>  [
        'name'                 => 'Regions & Zones',
        'menu_icon'           => 'fas fa-globe',
        'permissions'           => ['region: list', 'zone: list'],
        'menu_item'            =>
        [
            [
                'title'      =>  'Regions',
                'url'        =>  'admin.regions.index',
                'permission'   => 'region: list'
            ],
            [
                'title'      =>  'Zones',
                'url'        =>  'admin.zones.index',
                'permission'   => 'zone: list'
            ],

        ]
    ],

    'menu_4'                 =>  [
        'name'                 => 'Settings',
        'menu_icon'           => 'fas fa-cog',
        'permissions'           => ['kpi: list', 'email: list', 'setting: list', 'help: list'],
        'menu_item'            =>
        [

            [
                'title'      =>  'Email Templates',
                'url'        =>  'admin.emails.index',
                'permission'   => 'email: list'
            ],

            [
                'title'      =>  'Configuration',
                'url'        =>  'admin.settings.index',
                'permission'   => 'setting: list'
            ],

            [
                'title'      =>  'Helps',
                'url'        =>  'admin.helps.index',
                'permission'   => 'help: list'
            ],

        ]
    ],
    'menu_5'                 =>  [
        'name'                 => 'Log & Exceptions',
        'menu_icon'           => 'fa-bug',
        'permissions'           => ['audit: list', 'custom-exception: list'],
        'menu_item'            =>
        [
            [
                'title'      =>  'Activity Log',
                'url'        =>  'admin.audit.index',
                'permission'   => 'audit: list'
            ],
            [
                'title'      =>  'Custom Exception',
                'url'        =>  'admin.custom-exceptions.index',
                'permission'   => 'custom-exception: list'
            ],
        ],

    ],
    'menu_6'                 =>  [
        'name'                 => 'Analysis',
        'menu_icon'           => 'fas fa-chart-pie',
        'permissions'           => ['analysis: show'],
        'menu_item'            =>
        [
            [
                'title'      =>  'Visualize',
                'url'        =>  'admin.analysis',
                'permission'   => 'analysis: show'
            ],

        ],

    ],
    'menu_7'                 =>  [
        'name'                 => 'Others',
        'menu_icon'           => 'fas fa-ellipsis-h',
        'permissions'           => ['subscription: list', 'f-a-q: list', 'contact-us: list', 'site-admin: list'],
        'menu_item'            =>
        [
            [
                'title'      =>  'Subscriptions',
                'url'        =>  'subscriptions.index',
                'permission'   => 'subscription: list'
            ],

            [
                'title'      =>  'Contact Us',
                'url'        =>  'admin.contact-us.index',
                'permission'   => 'contact-us: list'
            ],
            [
                'title'      =>  'Site Admin',
                'url'        =>  'admin.siteAdmins.index',
                'permission'   => 'site-admin: list'
            ],
        ],

    ],
    'menu_8'                 =>  [
        'name'                 => 'Stem',
        'menu_icon'           => 'fas fa-ellipsis-h',
        'permissions'           => ['school-levels: list', 'schools: list', 'academic-levels: list', 'departments: list', 'lecturers: list', 'students: list', 'courses: list', 'academic-sessions: list', 'instructer-courses:list', 'visitor: list'],
        'menu_item'            =>
        [
            [
                'title'      =>  'Schools',
                'url'        =>  'admin.schools.index',
                'permission'   => 'schools: list'
            ],
            [
                'title'      =>  'School Levels',
                'url'        =>  'admin.school-levels.index',
                'permission'   => 'school-levels: list'
            ],
            [
                'title'      =>  'Academic Levels',
                'url'        =>  'admin.academic-levels.index',
                'permission'   => 'academic-levels: list'
            ],
            [
                'title'      =>  'Departments',
                'url'        =>  'admin.departments.index',
                'permission'   => 'departments: list'
            ],
            [
                'title'      =>  'Lecturers',
                'url'        =>  'admin.lecturers.index',
                'permission'   => 'lecturers: list'
            ],
            [
                'title'      =>  'Students',
                'url'        =>  'admin.students.index',
                'permission'   => 'students: list'
            ],
            [
                'title'      =>  'Courses',
                'url'        =>  'admin.courses.index',
                'permission'   => 'courses: list'
            ],
            [
                'title'      =>  'Academic Sessions',
                'url'        =>  'admin.academic-sessions.index',
                'permission'   => 'courses: list'
            ],
            [
                'title'      =>  'Payroll',
                'url'        =>  'admin.instructer-courses.index',
                'permission'   => 'instructer-courses: list'
            ],
            [
                'title'      =>  'Visitors',
                'url'        =>  'admin.visitors.index',
                'permission'   => 'visitor: list'
            ],
        ],

    ],
];
