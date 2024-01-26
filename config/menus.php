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


    'menu_8'                 =>  [
        'name'                 => 'Stem',
        'menu_icon'           => 'fas fa-book',
        'permissions'           => ['school-level: list', 'school: list', 'academic-level: list', 'department: list', 'lecturer: list', 'student: list', 'course: list', 'academic-session: list', 'instructor-course:list', 'visitor: list', 'payroll: list','trainer: list','equipment: list','lab: list','center: list','trainee: list'],
        'menu_item'            =>
        [
            [
                'title'      =>  'Academic Sessions',
                'url'        =>  'admin.academic-sessions.index',
                'permission'   => 'course: list'
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
        ],

    ],
    'menu_9'                 =>  [
        'name'                 => 'Setting',
        'menu_icon'           => 'fas fa-cog',
        'permissions'           => ['school-level: list', 'school: list', 'academic-level: list', 'department: list', 'lecturer: list', 'student: list', 'course: list', 'academic-session: list', 'instructor-course:list', 'visitor: list'],
        'menu_item'            =>
        [
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
];
