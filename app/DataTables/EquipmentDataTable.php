<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\Equipment;
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

class EquipmentDataTable extends DataTable
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
            ->addColumn('labName', function ($user) {
                return $user?->labName;
            })
            ->orderColumn('labName', function ($query, $order) {
                $query->orderBy('labName', $order);
            })->filterColumn('labName', function ($user, $keyword) {
                $sql = "labs.name like ?";
                $user->whereRaw($sql, ["%{$keyword}%"]);
            })
            // custom filter
            ->filter(function ($query) {
                if (request()->has('lab_id') && request()->filled('lab_id')) {
                    $query->where('labs.id', '=', request('lab_id'));
                }
            }, true)
            ->addColumn('action', function ($equipment) {
                return view('components.action-buttons', [
                    'row_id' => $equipment->id,
                    'show' => true,
                    'permission_delete' => 'equipment: delete',
                    'permission_edit' => 'equipment: edit',
                    'permission_view' => 'equipment: view',
                ]);
            })
            ->rawColumns(['no', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Equipment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Equipment $model): QueryBuilder
    {
        // return $model->newQuery();
        return $model::leftjoin('labs','lab_id','=','labs.id')->select([
            'equipment.id',
            'equipment.created_at',
            'equipment.name',
            'equipment.description',
            'labs.id as labId',
            'labs.name as labName',
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
            ->setTableId('equipment-table')
            ->columns($this->getColumns())
            ->orderBy(4)
            ->minifiedAjax()
            ->selectStyleSingle()
            ->ajax([
                'url' => route('admin.equipment.index'),
                'data' => 'function(d) {
                    d.lab_id = $("#lab_id").val();
                }',
            ])
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
            Column::make('labName')->title('lab'),
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
        return "equipment" . date('YmdHis');
    }
}
