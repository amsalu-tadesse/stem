<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\Lecturer;
use App\Models\School;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

use function Termwind\render;

class StudentDataTable extends DataTable
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
            ->addColumn('no', function () use(&$index_column){
                return ++$index_column;
            })

            //school Name
            ->addColumn('schoolname', function ($student) {
                return $student?->schoolname;
            })->orderColumn('schoolname', function ($query, $order) {
                $query->orderBy('schools.name', $order);
            })->filterColumn('schoolname', function ($query, $keyword) {
                $query->where('schools.name', 'LIKE', "%{$keyword}%");
            })

            ->addColumn('action', function ($student) {
                return view('components.action-buttons', [
                    'row_id' => $student->id,
                    'permission_delete'=>'students: delete',
                     'permission_edit'=>'students: edit',
                     'permission_view'=>'students: view',
                ]);
            })
             ->filter(function ($query) {
                if (request()->has('school_filter') and request()->filled('school_filter')) {
                    $query->whereIn('school_id', request('school_filter'));
                }
            }, true)
            ->rawColumns(['no', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Student $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Student $model): QueryBuilder
    {

        return $model::leftjoin('schools', 'school_id', '=', 'schools.id')
        ->select(['students.id', 'students.name as name','students.age as age','students.grade as grade', 'students.sex as sex','students.created_at',  'schools.name as schoolname']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('students-table')
            ->columns($this->getColumns())
            ->orderBy(7)
            // ->minifiedAjax()
            ->ajax([
                'url' => route('admin.students.index'), 
                'data' => 'function(d) {
                    d.school_filter = $("#school_filter").val();
                }',
            ])
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
            Column::make('name'),
            Column::make('age'),
            Column::make('sex'),
            Column::make('grade'),
            Column::make('schoolname')->title('School'),
            Column::computed('action')
                ->exportable(false)
                ->printable(true)
                ->addClass('text-center')
                ->orderable(false),
            Column::make('created_at')->visible(false)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Students' . date('YmdHis');
    }
}
