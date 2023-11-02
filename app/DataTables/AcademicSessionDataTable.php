<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\AcademicSession;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class AcademicSessionDataTable extends DataTable
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
            })->addColumn('academic_year', function ($academic_session) {
                return '<a href="' . route('admin.academic-sessions.show', $academic_session->id) . '">' . $academic_session->academic_year . '</a>';
            })->addColumn('start_date', function ($academic_session) {
                $carbonDate = Carbon::parse($academic_session->start_date);
                $formattedDate = $carbonDate->format('Y-m-d');
                return $formattedDate;
            })->addColumn('end_date', function ($academic_session) {
                $carbonDate = Carbon::parse($academic_session->end_date);
                $formattedDate = $carbonDate->format('Y-m-d');
                return $formattedDate;
            })
             ->addColumn('week_type', function ($academic_session) {
                if ($academic_session->week_type == 1) {
                    return "Weekend";
                } else if ($academic_session->week_type == 0) {
                    return "Weekes";
                }
            }) ->addColumn('status', function ($academic_session) {

                $dateToCheck = Carbon::parse($academic_session->end_date); 
                $isDatePassed = $dateToCheck->isPast();
                if ($isDatePassed) {
                    return '<button class="btn btn-danger btn-sm">Closed</button>';
                } else {
                    return '<button class="btn btn-success btn-sm">Open</button>';
                }
                
                // return view('components.action-buttons-for-custom-exception-status', [
                //     'row_id' => $academic_session->id,
                //     'status' => $academic_session->status,
                // ]);
            })
            ->addColumn('action', function ($academic_session) {
                return view('components.action-buttons', [
                    'row_id' => $academic_session->id,
                    'permission_delete' => 'academic-sessions: delete',
                    'permission_edit' => 'academic-sessions: edit',
                    'permission_view' => 'academic-sessions: view',
                ]);
            })

            ->rawColumns(['no','academic_year','status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\School $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AcademicSession $model): QueryBuilder
    {
        return $model::select([
            'id',
            'academic_year',
            'start_date',
            'end_date',
            'week_type',
            'status',
            'created_at',
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
            ->setTableId('academic-sessions-table')
            ->columns($this->getColumns())
            ->orderBy(6)
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
            Column::make('academic_year'),
            Column::make('start_date'),
            Column::make('end_date'),
            Column::make('week_type'),
            Column::make('status'),
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
        return 'AcademicSessions' . date('YmdHis');
    }
}
