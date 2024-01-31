<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\Group;
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

class GroupDataTable extends DataTable
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
            ->addColumn('no', function ($group) use (&$index_column) {
                return '<input class="form-check-input" type="checkbox" id="' . 'id_' . $group->id . '" name="groups" value="' . $group->id . '">' . ++$index_column;
            })->orderColumn('labName', function ($query, $order) {
                $query->orderBy('labName', $order);
            })->filterColumn('labName', function ($group, $keyword) {
                $sql = "labs.name like ?";
                $group->whereRaw($sql, ["%{$keyword}%"]);
            })->orderColumn('traineeCount', function ($query, $order) {
                $query->orderByRaw('COUNT(trainee_groups.id) ' . $order);
            })->filterColumn('traineeCount', function ($query, $keyword) {
                $query->havingRaw('COUNT(trainee_groups.id) = ?', [$keyword]);
            })


            // custom filter
            ->filter(function ($query) {
                if (request()->has('lab_id') && request()->filled('lab_id')) {
                    $query->where('labs.id', '=', request('lab_id'));
                }
            }, true)

            ->addColumn('action', function ($group) {
                return view('components.action-buttons', [
                    'row_id' => $group->id,
                    'show' => true,
                    'permission_delete' => 'group: delete',
                    'permission_edit' => 'group: edit',
                    'permission_view' => 'group: view',
                ]);
            })
            ->rawColumns(['no', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Group $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Group $model): QueryBuilder
    {
        return $model::leftJoin('group_labs', 'group_id', '=', 'groups.id')
            ->leftJoin('labs', 'labs.id', '=', 'group_labs.lab_id')
            ->leftJoin('trainee_groups', 'trainee_groups.group_id', '=', 'groups.id')
            ->select([
                'groups.id',
                'groups.created_at',
                'groups.name',
                'labs.id as labId',
                'labs.name as labName',
                DB::raw('COUNT(trainee_groups.id) as traineeCount'),
            ])
            ->groupBy('groups.id', 'groups.created_at', 'groups.name', 'labId', 'labName');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('groups-table')
            ->columns($this->getColumns())
            ->orderBy(5)
            ->minifiedAjax()
            ->selectStyleSingle()
            ->ajax([
                'url' => route('admin.groups.index'),
                'data' => 'function(d) {
                    d.lab_id = $("#lab_id").val();
                }',
            ])
            ->initComplete('function(settings, json) {
                var table = $("#groups-table").DataTable();
                
                // Attach an event listener for changes to dynamically update the lab_id and group_id
                $("#lab_id").on("change", function() {
                    table.ajax.reload();
                });
            }')
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
            Column::make('labName')->title('Lab'),
            Column::make('traineeCount')->title('Trainees'),
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
        return "groups" . date('YmdHis');
    }
}
