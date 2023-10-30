<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

use function Termwind\render;

class OrganizationDataTable extends DataTable
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
            //organization type
            ->addColumn('organizationType', function ($organization) {
                return $organization?->organizationType;
            })->orderColumn('organizationType', function ($query, $order) {
                $query->orderBy('organizationType', $order);
            })->filterColumn('organizationType', function ($organization, $keyword) {
                $sql = "organization_types.name like ?";
                $organization->whereRaw($sql, ["%{$keyword}%"]);
            })
            //organization level
            ->addColumn('organizationLevel', function ($organization) {
                return $organization?->organizationLevel;
            })->orderColumn('organizationLevel', function ($query, $order) {
                $query->orderBy('organizationLevel', $order);
            })->filterColumn('organizationLevel', function ($organization, $keyword) {
                $sql = "organization_levels.name like ?";
                $organization->whereRaw($sql, ["%{$keyword}%"]);
            })

            // show level name which City Admin, Region, Zone
            ->addColumn('levelname', function ($organization) {
                if ($organization->organization_level_id == 1 || $organization->organization_level_id == 2) {
                    return $organization?->region;
                } elseif ($organization->organization_level_id == 3) {
                    return $organization?->zone;
                } else {
                    return '';
                }
            })->orderColumn('organization_level_id', function ($query, $order) {
                $query->orderBy('organization_level_id', $order);
            })->filterColumn('levelname', function ($query, $keyword) {
                $query->where(function ($subquery) use ($keyword) {
                    $subquery->where('regions.name', 'like', '%' . $keyword . '%')
                        ->orWhere('zones.name', 'like', '%' . $keyword . '%');
                });
            })



            //custom filtering with global filtering
            ->filter(function ($query) {
                if (request()->has('organization_type_filter') and request()->filled('organization_type_filter')) {
                    $query->whereIn('organization_type_id', request('organization_type_filter'));
                }
                if (request()->has('organization_level_filter') and request()->filled('organization_level_filter')) {
                    $query->whereIn('organization_level_id', request('organization_level_filter'));
                }
            }, true)

              //status
             ->addColumn('status', function ($organization) {
                return view('components.action-buttons-for-organization', [
                    'row_id' => $organization->id,
                    'status' => $organization->status,
                    ]);

            })->orderColumn('status', function ($query, $order) {
                $query->orderBy('status', $order);
            })->filterColumn('status', function ($organization, $keyword) {
                $sql = "organizations.status = ?";
                $organization->whereRaw($sql, ["{$keyword}"]);
            })

            ->addColumn('action', function ($organization) {
                return view('components.action-buttons', [
                    'row_id' => $organization->id,
                     'show' => true,
                     'permission_delete'=>'organization: delete',
                     'permission_edit'=>'organization: edit',
                     'permission_view'=>'organization: view',
                    ]);
            })
            ->rawColumns(['no', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Organization $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Organization $model): QueryBuilder
    {
        // return $model->newQuery();
        return $model::leftjoin('organization_types', 'organization_type_id', '=', 'organization_types.id')
            ->leftjoin('organization_levels', 'organization_level_id', '=', 'organization_levels.id')
            ->leftjoin('regions', 'region_id', '=', 'regions.id')
            ->leftjoin('zones', 'zone_id', '=', 'zones.id')

            // 'organizationLevel'
            // ->join('contacts', 'users.id', '=', 'contacts.user_id')

            ->select(['organizations.id', 'organizations.name as name', 'organizations.created_at', 'organization_level_id', 'organization_types.name AS organizationType', 'organization_levels.name AS organizationLevel', 'regions.name AS region', 'zones.name AS zone', 'organizations.status as status']);
        // return $model::select([
        //     'id',
        //     'name',
        //     'description',
        //     'created_at'
        // ]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('organizations-table')
            ->columns($this->getColumns())
            ->orderBy(7)
            // ->minifiedAjax()
            // ->selectStyleSingle()
            ->ajax([
                'url' => route('admin.organizations.index'), // Update the route name to match your route definition
                'data' => 'function(d) {
                    d.organization_type_filter = $("#organization_type_filter").val();
                    d.organization_level_filter = $("#organization_level_filter").val();
                }',
            ])
            ->dom(
                "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-6'B>
                           <'col-sm-12 col-md-4'f>><'row'<'col-sm-12'tr>>
                           <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            )
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
            Column::make('no')
                ->title('No')
                ->addClass('text-center')
                ->orderable(false),
            Column::make('name')->title('Name'),
            Column::make('organizationType', 'organizationType')
                ->title('Organization Type')
                ->addClass('text-center'),
            Column::make('organizationLevel', 'organizationLevel')
                ->title('Organization Level')
                ->addClass('text-center'),
            Column::make('levelname', 'levelname')
                ->title('Region/Zone')
                ->addClass('text-center'),
            Column::make('status', 'status')
                ->title('Status')
                ->addClass('text-center'),
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
        return 'Organizations_' . date('YmdHis');
    }
}
