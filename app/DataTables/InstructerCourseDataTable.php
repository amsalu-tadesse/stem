<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\Department;
use App\Models\InstructorCourse;
use App\Models\School;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

use function Termwind\render;

class InstructerCourseDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $index_column = 0;
        return (new EloquentDataTable($query))
            ->addColumn('no', function () use (&$index_column) {
                return ++$index_column;
            })

            ->rawColumns(['no']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\InstructorCourse $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(InstructorCourse $model): QueryBuilder
    {

        return $model::leftJoin('lecturers', 'lecturer_id', '=', 'lecturers.id')
            ->leftJoin('courses', 'course_id', '=', 'courses.id')
            ->leftJoin('academic_sessions', 'academic_session_id', '=', 'academic_sessions.id')
            ->select(['instructor_courses.id', 'instructor_courses.created_at', 'lecturers.name as lecturer_name',  'courses.name AS course_name','courses.lecture_hr_per_week AS lecture_hr_per_week','academic_sessions.start_date','academic_sessions.end_date','academic_sessions.week_type','academic_sessions.start_date','academic_sessions.label','academic_sessions.academic_year',
            \DB::raw('DATEDIFF(academic_sessions.end_date, academic_sessions.start_date) + 1 AS total_days'),


            \DB::raw("DATEDIFF(academic_sessions.end_date, academic_sessions.start_date) + 1 -
            ((DATEDIFF(academic_sessions.end_date, academic_sessions.start_date) +
            WEEKDAY(academic_sessions.start_date) + 1) DIV 7 * 2) -
            CASE WHEN WEEKDAY(academic_sessions.start_date) = 6 THEN 1 ELSE 0 END -
            CASE WHEN WEEKDAY(academic_sessions.end_date) = 5 THEN 1 ELSE 0 END AS week_days_count"),


    ]);
    }




    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('instructor-course-table')
            ->columns($this->getColumns())
            ->orderBy(3)
            ->minifiedAjax()
            ->selectStyleSingle()
            ->dom("<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-6'B>
                           <'col-sm-12 col-md-4'f>><'row'<'col-sm-12'tr>>
                           <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>")
            ->responsive(true)
            ->processing(true)
            ->autoWidth(false)
            ->buttons(
                [
                    [
                        'extend' => 'csvHtml5',
                        'text' => 'CSV',
                        'exportOptions' => [
                            'columns' => ':visible',
                        ],
                    ],
                    [
                        'extend' => 'excelHtml5',
                        'text' => 'Excel',
                        'exportOptions' => [
                            'columns' => ':visible',
                        ],
                    ],
                    [
                        'extend' => 'pdfHtml5',
                        'text' => 'PDF',
                        'exportOptions' => [
                            'columns' => ':visible',
                        ],
                    ],

                    [
                        'extend' => 'print',
                        'text' => 'Print',
                        'exportOptions' => [
                            'columns' => ':visible',
                        ],
                    ],
                    'colvis',
                ]
            )
            ->lengthMenu(Constants::PAGE_NUMBER()) // Customize the options here
            ->language([
                'lengthMenu' => '_MENU_ records per page', // Customize the label
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::computed('no')->title('No')
                ->exportable(false)
                ->addClass('text-center')
                ->orderable(false),
            Column::make('label')->title("Session"),
            Column::make('course_name')->title("course"),
            Column::make('lecturer_name')->title("Instructor"),
            Column::computed('week_type')->title("Week type")
            ->data('function(row) {
                if(row.week_type==0)
                {
                    return "Week days";
                }
                return "Weekend";

            }'),
            Column::make('lecture_hr_per_week')->title("Lecture hours/week"),
            Column::make('week_days_count')->title("Week Days count"),
            Column::computed('difference')->title("Weekends count")
            ->data('function(row) {
                return row.total_days - row.week_days_count;
            }'),

            Column::make('total_days')->title("Total days")->visible(false),
            Column::computed('payment')->title("Payment(ETB)")
            ->data('function(row) {

                var weekDayCount = row.week_days_count;
                var weekends_count = row.total_days - row.week_days_count;

                if(row.week_type==0)
                {
                    var rate_per_day = row.lecture_hr_per_week/7;
                    return (rate_per_day*weekDayCount).toFixed(2);
                }
                var rate_per_day = row.lecture_hr_per_week/2;
                return (rate_per_day*weekends_count).toFixed(2);

            }'),





            // Column::make('created_at')->visible(false)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Departments' . date('YmdHis');
    }
}
