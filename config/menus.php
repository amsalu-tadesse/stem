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
        'name'                 => 'STEM',
        'menu_icon'           => 'fas fa-book',
        'permissions'           => ['school-level: list', 'school: list', 'academic-level: list', 'department: list', 'lecturer: list', 'student: list', 'course: list', 'academic-session: list', 'instructor-course:list'],
        'menu_item'            =>
        [
            [
                'title'      =>  'Academic Sessions',
                'url'        =>  'admin.academic-sessions.index',
                'permission'   => 'academic-session: list'
            ],
            [
                'title'      =>  'Students',
                'url'        =>  'admin.students.index',
                'permission'   => 'student: list'
            ],

            [
                'title'      =>  'Lecturers',
                'url'        =>  'admin.lecturers.index',
                'permission'   => 'lecturer: list'
            ],

            [
                'title'      =>  'Courses',
                'url'        =>  'admin.courses.index',
                'permission'   => 'course: list'
            ],

            [
                'title'      =>  'Payroll',
                'url'        =>  'admin.instructor-courses.index',
                'permission'   => 'instructor-course: list'
            ],
            [
                'title'      =>  'School Levels',
                'url'        =>  'admin.school-levels.index',
                'permission'   => 'school-level: list'
            ],

            [
                'title'      =>  'Schools',
                'url'        =>  'admin.schools.index',
                'permission'   => 'school: list'
            ],
            [
                'title'      =>  'Academic Levels',
                'url'        =>  'admin.academic-levels.index',
                'permission'   => 'academic-level: list'
            ],
            [
                'title'      =>  'Departments',
                'url'        =>  'admin.departments.index',
                'permission'   => 'department: list'
            ],

        ],

    ],
    'menu_3'                 =>  [
        'name'                 => 'Innov & Incub.',
        'menu_icon'           => 'fas fa-lightbulb',
        'permissions'           => [ 'center: list', 'trainee: list', 'group: list', 'equipment-type: list','trainee-session-equipment: list','trainer: list','fund-type: list','measurement: list','projectStatus: list'],
        'menu_item'            =>
        [
            [
                'title'      =>  'Centers',
                'url'        =>  'admin.centers.index',
                'permission'   => 'center: list'
            ],
            [
                'title'      =>  'Labs',
                'url'        =>  'admin.labs.index',
                'permission'   => 'lab: list'
            ],
            [
                'title'      =>  'Equipment Types',
                'url'        =>  'admin.equipment-types.index',
                'permission'   => 'equipment-type: list'
            ],
            [
                'title'      =>  'Equipment',
                'url'        =>  'admin.equipment.index',
                'permission'   => 'equipment: list'
            ],
            [
                'title'      =>  'Trainers',
                'url'        =>  'admin.trainers.index',
                'permission'   => 'trainer: list'
            ],
            [
                'title'      =>  'Trainees',
                'url'        =>  'admin.trainees.index',
                'permission'   => 'trainee: list'
            ],
            [
                'title'      =>  'Groups',
                'url'        =>  'admin.groups.index',
                'permission'   => 'group: list'
            ],


            [
                'title'      =>  'Projects',
                'url'        =>  'admin.trainee-sessions.index',
                'permission'   => 'trainee-session: list'
            ],
            [
                'title'      =>  'Fund Types',
                'url'        =>  'admin.fund-types.index',
                'permission'   => 'fund-type: list'
            ],

            [
                'title'      =>  'Project Status',
                'url'        =>  'admin.project-status.index',
                'permission'   => 'projectStatus: list'
            ],
            [
                'title'      =>  'Measurements',
                'url'        =>  'admin.measurements.index',
                'permission'   => 'measurement: list'
            ]

        ],

    ],


    'menu_4'                 =>  [
        'name'                 => 'Museum',
        'menu_icon'           => 'fas fa-cog',
        'permissions'           => ['make-appointment: create','country: list', 'visitor: list','institution: list','institution-type: list'],
        'menu_item'            =>
        [
            [
                'title'      =>  'Visitos',
                'url'        =>  'admin.visitors.index',
                'permission'   => 'visitor: list'
            ],
            [
                'title'      =>  'Make Appointment',
                'url'        =>  'admin.make-appointment.index',
                'permission'   => 'make-appointment: create'
            ],
            [
                'title'      =>  'Countries List',
                'url'        =>  'admin.countries.index',
                'permission'   => 'country: list'
            ],
            [
                'title'      =>  'Institutions',
                'url'        =>  'admin.institutions.index',
                'permission'   => 'institution: list'
            ],
            [
                'title'      =>  'Institution Types',
                'url'        =>  'admin.institution-types.index',
                'permission'   => 'institution-type: list'
            ],

        ],

    ],

    'menu_5'                 =>  [
        'name'                 => 'Applicants',
        'menu_icon'           => 'fas fa-cog',
        'permissions'           => [  'lecturer: list', 'student: list', 'course: list', 'academic-session: list', 'instructor-course:list','country: list'],
        'menu_item'            =>
        [

            [
                'title'      =>  'Applicants List',
                'url'        =>  'admin.applicantList',
                'permission'   => 'applicant: list'
            ],

        ],

    ],

];
