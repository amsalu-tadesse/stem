<?php

namespace App\DataTables;

use App\Models\School;
use App\Models\Student;
use App\Models\Lecturer;
use App\Constants\Constants;
use function Termwind\render;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

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

      
            // ->addColumn('no', function () use (&$index_column) {
            //     return '<input class="form-check-input" type="checkbox" name="check" value="' . $index_column . '">' . ++$index_column; ;
            // })
  ->addColumn('no', function ($student) use (&$index_column){
      return '<input class="form-check-input" type="checkbox" name="check" value="' . $student?->id. '">' . ++$index_column; ;
                return ;
            })
                
            // ->addColumn('no', function () use(&$index_column){
            //     return ++$index_column;
            // })

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
                    'permission_delete'=>'student: delete',
                     'permission_edit'=>'student: edit',
                     'permission_view'=>'student: view',
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
        ->leftjoin('academic_sessions', 'academic_session', '=', 'academic_sessions.id')
        ->select(['students.id', 'students.name as name','students.age as age','students.grade as grade', 'students.sex as sex','students.created_at',  'schools.name as schoolname','academic_sessions.label as label']);
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

                    Button::make('pdf')->text('Certficate')->action('
                    function checking () {
                        var checkedCheckboxes = $("input[name=\'check\']:checked");
            
                        if (checkedCheckboxes.length > 0) {
                            console.log("Yes");

                            var checkedValues = [];
                            checkedCheckboxes.each(function() {
                                checkedValues.push($(this).val());
                            });
            
                            window.location.href="/admin/certificate?values=" + checkedValues.join(",");
                        } else {
                           
                            console.log("No checkboxes are checked.");
                        }
                    }
                    checking();
                '),

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
            Column::make('label')->title('Academic Session'),
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
