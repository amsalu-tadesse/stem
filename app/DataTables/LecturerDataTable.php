<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;


class LecturerDataTable extends DataTable
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

             //Department Name
             ->addColumn('departmentname', function ($student) {
                return $student?->departmentname;
            })->orderColumn('departmentname', function ($query, $order) {
                $query->orderBy('departments.name', $order);
            })->filterColumn('departmentname', function ($query, $keyword) {
                $query->where('departments.name', 'LIKE', "%{$keyword}%");
            })

            //Academic Name
             ->addColumn('academiclevelname', function ($student) {
                return $student?->academiclevelname;
            })->orderColumn('academiclevelname', function ($query, $order) {
                $query->orderBy('academic_levels.name', $order);
            })->filterColumn('academiclevelname', function ($query, $keyword) {
                $query->where('academic_levels.name', 'LIKE', "%{$keyword}%");
            })
            ->addColumn('action', function ($lecturer) {
                return view('components.action-buttons', [
                    'row_id' => $lecturer->id,
                    'permission_delete'=>'lecturer: delete',
                     'permission_edit'=>'lecturer: edit',
                     'permission_view'=>'lecturer: view',
                ]);
            })
            ->rawColumns(['no', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Lecturer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Lecturer $model): QueryBuilder
    {
        return $model::leftjoin('academic_levels', 'academic_level_id', '=', 'academic_levels.id')->leftjoin('departments', 'department', '=', 'departments.id')
        ->select(['lecturers.id', 'lecturers.name as name','lecturers.phone as phone','lecturers.email as email', 'departments.name as departmentname','lecturers.created_at',  'academic_levels.name as academiclevelname']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('lecturers-table')
            ->columns($this->getColumns())
            ->orderBy(7)
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
            Column::make('name'),
            Column::make('phone'),
            Column::make('email'),
            Column::make('departmentname')->title('Department'),
            Column::make('academiclevelname')->title('Academic Level'),
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
        return 'Lecturers' . date('YmdHis');
    }
}
