<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\TraineeGroup;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

use function Termwind\render;

class TraineeGroupDataTable extends DataTable
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
            ->orderColumn('groupName', function ($query, $order) {
                $query->orderBy('groupName', $order);
            })->filterColumn('groupName', function ($user, $keyword) {
                $sql = "groups.name like ?";
                $user->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->orderColumn('traineeName', function ($query, $order) {
                $query->orderBy('traineeName', $order);
            })->filterColumn('traineeName', function ($user, $keyword) {
                $sql = "trainees.full_name like ?";
                $user->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($trainee_group) {
                return view('components.action-buttons', [
                    'row_id' => $trainee_group->id,
                    'show' => true,
                    'permission_delete' => 'trainee-group: delete',
                    'permission_edit' => 'trainee-group: edit',
                    'permission_view' => 'trainee-group: view',
                ]);
            })
            ->rawColumns(['no', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\TraineeGroup $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TraineeGroup $model): QueryBuilder
    {
        // return $model->newQuery();
        return $model::leftjoin('groups','group_id','groups.id')->leftjoin('trainees','trainee_id','trainees.id')->select([
            'trainee_groups.id',
            'trainee_groups.created_at',
            'groups.name as groupName',
            'trainees.full_name as traineeName',
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
            ->setTableId('trainee-groups-table')
            ->columns($this->getColumns())
            ->orderBy(4)
            ->minifiedAjax()
            ->selectStyleSingle()
            ->dom("'<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-6'B>
                           <'col-sm-12 col-md-4'f>><'row'<'col-sm-12'tr>>
                           <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>'")
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
        return [
            Column::computed('no')->title('No')
                ->exportable(false)
                ->addClass('text-center')
                ->orderable(false),
            Column::make('groupName')->title('Group'),
            Column::make('traineeName')->title('Trainee'),
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
        return "trainee_groups" . date('YmdHis');
    }
}
