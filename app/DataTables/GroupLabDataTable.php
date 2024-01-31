<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\GroupLab;
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

class GroupLabDataTable extends DataTable
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
            })->orderColumn('labName', function ($query, $order) {
                $query->orderBy('labName', $order);
            })->filterColumn('labName', function ($group, $keyword) {
                $sql = "labs.name like ?";
                $group->whereRaw($sql, ["%{$keyword}%"]);
            })->orderColumn('groupName', function ($query, $order) {
                $query->orderBy('groupName', $order);
            })->filterColumn('groupName', function ($group, $keyword) {
                $sql = "groups.name like ?";
                $group->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($group_lab) {
                return view('components.action-buttons', [
                    'row_id' => $group_lab->id,
                    'show' => true,
                    'permission_delete' => 'group-lab: delete',
                    'permission_edit' => 'group-lab: edit',
                    'permission_view' => 'group-lab: view',
                ]);
            })
            ->rawColumns(['no', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\GroupLab $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(GroupLab $model): QueryBuilder
    {
        // return $model->newQuery();
        return $model::leftjoin('labs','lab_id','=','labs.id')->leftjoin('groups','group_id','=','groups.id')->select([
            'group_labs.id',
            'group_labs.created_at',
            'group_labs.group_id',
            'group_labs.lab_id',
            'labs.name as labName',
            'groups.name as groupName',
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
            ->setTableId('group-labs-table')
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
            Column::make('labName')->title('Lab'),
            Column::make('groupName')->title('Group'),
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
        return "group_labs" . date('YmdHis');
    }
}
