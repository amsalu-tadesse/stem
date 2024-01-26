<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\Lab;
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

class LabDataTable extends DataTable
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
            })->addColumn('name', function ($academic_session) {
                return '<a href="' . route('admin.list', $academic_session->id) . '">' . $academic_session->name . '</a>';
            })
            ->addColumn('centerName', function ($user) {
                return $user?->centerName;
            })
            ->orderColumn('centerName', function ($query, $order) {
                $query->orderBy('centerName', $order);
            })->filterColumn('centerName', function ($user, $keyword) {
                $sql = "centers.name like ?";
                $user->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($lab) {
                return view('components.action-buttons', [
                    'row_id' => $lab->id,
                    'show' => true,
                    'permission_delete' => 'lab: delete',
                    'permission_edit' => 'lab: edit',
                    'permission_view' => 'lab: view',
                ]);
            })
            ->rawColumns(['no', 'action','name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Lab $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Lab $model): QueryBuilder
    {
        // return $model->newQuery();
        return $model::leftjoin('centers', 'center_id', '=', 'centers.id')->select([
            'labs.id',
            'labs.created_at',
            'labs.name',
            'labs.building',
            'labs.block',
            'labs.center_id',
            'centers.name as centerName',
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
            ->setTableId('labs-table')
            ->columns($this->getColumns())
            ->orderBy(6)
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
            Column::make('name'),
            Column::make('building'),
            Column::make('block'),
            Column::make('centerName')->title('Center'),
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
        return "labs" . date('YmdHis');
    }
}
