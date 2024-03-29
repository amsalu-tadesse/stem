<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\TraineeSession;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

use Carbon\Carbon;

class TraineeSessionDataTable extends DataTable
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
            ->addColumn('status', function ($academic_session) {
                $dateToCheck = Carbon::parse($academic_session->end_date);
                $isDatePassed = $dateToCheck->isPast();
                if ($isDatePassed) {
                    return '<span class="badge badge-danger">Closed</span>';
                } else {
                    return '<span class="badge badge-success">Active</span>';
                }
            })

            ->addColumn('project_status', function ($academic_session) {
                if ($academic_session->project_status) {
                    return '<div role="button" onclick="changeProjectStatus(this, ' . $academic_session->id . ', '.$academic_session->project_status.')" class="badge badge-primary p-2">'.ucwords($academic_session?->projectStatus?->name).'</div>';
                }
                else{
                   return '<div role="button" onclick="changeProjectStatus(this, ' . $academic_session->id . ', '.$academic_session->project_status.')" class="badge badge-primary p-2">Project Status</div>';
                }
            })
            ->addColumn('action', function ($trainee_session) {
                return view('components.action-buttons', [
                    'row_id' => $trainee_session->id,
                    'show' => true,
                    'permission_delete' => 'trainee-session: delete',
                    'permission_edit' => 'trainee-session: edit',
                    'permission_view' => 'trainee-session: view',
                ]);
            })
            ->rawColumns(['no', 'status', 'project_status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\TraineeSession $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TraineeSession $model): QueryBuilder
    {
        // return $model->newQuery();
        return $model::with('projectStatus')->select(['id', 'created_at', 'name', 'academic_year', 'start_date', 'end_date', 'status', 'project_status']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('trainee-sessions-table')
            ->columns($this->getColumns())
            ->orderBy(7)
            ->minifiedAjax()
            ->selectStyleSingle()
            ->dom(
                "'<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-6'B>
                           <'col-sm-12 col-md-4'f>><'row'<'col-sm-12'tr>>
                           <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>'",
            )
            ->responsive(true)
            ->processing(true)
            ->autoWidth(false)
            ->buttons([
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
            ])
            ->lengthMenu(Constants::PAGE_NUMBER()) // Customize the options here
            ->language([
                'lengthMenu' => '_MENU_ records per page', // Customize the attribute
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [Column::computed('no')->title('No')->exportable(false)->addClass('text-center')->orderable(false), Column::make('name'), Column::make('academic_year'), Column::make('start_date'), Column::make('end_date'), Column::make('status'), Column::make('project_status'), Column::computed('action')->exportable(false)->printable(true)->addClass('text-center')->orderable(false), Column::make('created_at')->visible(false)];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'trainee_sessions' . date('YmdHis');
    }
}
