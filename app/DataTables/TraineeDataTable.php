<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\Trainee;
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

class TraineeDataTable extends DataTable
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
            ->addColumn('no', function ($trainee) use (&$index_column) {
                return '<input class="form-check-input" type="checkbox" id="' . 'id_' . $trainee->id . '" name="trainees" value="' . $trainee->id . '">' . ++$index_column;
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
            ->orderColumn('groupName', function ($query, $order) {
                $query->orderBy('groupName', $order);
            })->filterColumn('groupName', function ($user, $keyword) {
                $sql = "groups.name like ?";
                $user->whereRaw($sql, ["%{$keyword}%"]);
            })

            // custom filter
            ->filter(function ($query) {
                if (request()->has('center_id') && request()->filled('center_id')) {
                    $query->where('centers.id', '=', request('center_id'));
                }
            }, true)
            ->filter(function ($query) {
                if (request()->has('group_id') && request()->filled('group_id')) {
                    $query->where('groups.id', '=', request('group_id'));
                }
            }, true)

            ->addColumn('action', function ($trainee) {
                return view('components.action-buttons', [
                    'row_id' => $trainee->id,
                    'show' => true,
                    'permission_delete' => 'trainee: delete',
                    'permission_edit' => 'trainee: edit',
                    'permission_view' => 'trainee: view',
                ]);
            })
            ->rawColumns(['no', 'full_name', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Trainee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Trainee $model): QueryBuilder
    {
        return $model::leftjoin('centers', 'center_id', '=', 'centers.id')
            ->leftjoin('trainee_groups', 'trainee_id', '=', 'trainees.id')
            ->leftjoin('groups', 'trainee_groups.group_id', '=', 'groups.id')
            ->select([
                'trainees.id',
                'trainees.created_at',
                'trainees.full_name',
                'trainees.grouped as group',
                'trainees.id_number',
                'groups.name as groupName',
                'groups.id as groupId',
                'trainees.center_id',
                'centers.id as centerid',
                'centers.name as centerName',
            ])
            ->when(request()->filled('center_id'), function ($query) {
                $query->where('centers.id', '=', request('center_id'));
            })
            ->when(request()->filled('group_id'), function ($query) {
                $query->where('groups.id', '=', request('group_id'));
            });
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('trainees-table')
            ->columns($this->getColumns())
            ->orderBy(6)
            ->minifiedAjax()
            ->selectStyleSingle()
            ->ajax([
                'url' => route('admin.trainees.index'),
                'data' => 'function(d) {
                    d.center_id = $("#center_id").val();
                    d.group_id = $("#group_id").val();
                }',
            ])
            ->initComplete('function(settings, json) {
                var table = $("#trainees-table").DataTable();
                
                // Set the default value for center_id
                var defaultCenterId = 1;
                $("#center_id").val(defaultCenterId);
                
                // Attach an event listener for changes to dynamically update the center_id and group_id
                $("#center_id, #group_id").on("change", function() {
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
            Column::make('full_name'),
            Column::make('id_number'),
            Column::make('centerName')->title('Center'),
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
        return "trainees" . date('YmdHis');
    }
}
