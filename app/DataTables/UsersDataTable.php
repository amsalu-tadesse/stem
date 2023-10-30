<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\User;
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

class UsersDataTable extends DataTable
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
            ->filterColumn('fullname', function ($user, $keyword) {
                $sql = "CONCAT(users.first_name,' ',users.middle_name,' ',users.last_name)  like ?";
                $user->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('status', function ($user) {
                if ($user->status == 1) {
                    return '<span id="nikebtn" class="fa fa-check-circle" style="color: green;"></span>';
                } else {
                    return '<span  id="xbtn" class="fa fa-times-circle" style="color: red;"></span>';
                }
            })->orderColumn('status', '-status $1')
            ->addColumn('organization', function ($user) {
                return $user?->organization;
            })
            ->orderColumn('organization', function ($query, $order) {
                $query->orderBy('organization', $order);
            })->filterColumn('organization', function ($user, $keyword) {
                $sql = "organizations.name like ?";
                $user->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('organizationLevel', function ($user) {
                return $user?->organizationLevel;
            })
            ->orderColumn('organizationLevel', function ($query, $order) {
                $query->orderBy('organizationLevel', $order);
            })->filterColumn('organizationLevel', function ($user, $keyword) {
                $sql = "organization_levels.name like ?";
                $user->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('roles', function ($user) {
                $user_roles = $user->roles
                    ->map(function ($role) {
                        return '<span class="badge badge-success">' . $role->name . '</span>';
                    })
                    ->implode(' ');

                // if ($user->is_superadmin == 1) {
                //     return '<span class="badge badge-success">Superadmin</span>' . ' ' . $user_roles;
                // }
                return $user_roles;
            })
            //custom filtering with global filtering
            ->filter(function ($query) {
                if ((request()->has('user_group_filter') and request()->filled('user_group_filter'))) {
                    if (in_array('superadmin', request()->input('user_group_filter'))) {
                        $query->where('users.is_superadmin', '=', 1);
                    }

                    //need to have roles
                    $request_role_ids = array_diff(request()->input('user_group_filter'), ['superadmin']);
                    if (!empty($request_role_ids)) {
                        $query->with('roles')->whereHas('roles', function ($query) use ($request_role_ids) {
                            $query->whereIn('roles.id', $request_role_ids);
                        });
                    }
                }
                if (request()->has('organization_filter') and request()->filled('organization_filter')) {
                    $query->whereIn('organization_id', request('organization_filter'));
                }
                if (request()->has('organization_level_filter') and request()->filled('organization_level_filter')) {
                    $query->with('organization')->whereHas('organization', function ($query) {
                        $query->whereIn('organizations.organization_level_id', request('organization_level_filter'));
                    });
                }
            }, true)
            ->addColumn('action', function ($user) {
                return view('components.action-buttons', [
                    'row_id' => $user->id, 'show' => true,
                    'permission_delete' => 'user: delete',
                    'permission_edit' => 'user: edit',
                    'permission_view' => 'user: view',
                ]);
            })
            ->rawColumns(['no', 'organization', 'organizationLevel', 'status', 'roles', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        // return $model->newQuery();
        // return $model::select(['id', DB::raw("CONCAT(users.first_name,' ',users.middle_name,' ',users.last_name) as fullname"), 'email', 'status', 'is_superadmin', 'created_at']);

        return $model::leftjoin('organizations', 'organization_id', '=', 'organizations.id')
            ->leftjoin('organization_levels', 'organization_level_id', '=', 'organization_levels.id')

            // 'organizationLevel'
            // ->join('contacts', 'users.id', '=', 'contacts.user_id')

            ->select(['users.id', DB::raw("CONCAT(users.first_name,' ',users.middle_name,' ',users.last_name) as fullname"), 'users.email', 'users.status', 'is_superadmin', 'users.created_at', 'organizations.name AS organization', 'organization_levels.name as organizationLevel']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            // ->minifiedAjax()
            ->ajax([
                'url' => route('admin.users.index'), // Update the route name to match your route definition
                'data' => 'function(d) {
                    d.user_group_filter = $("#user_group_filter").val();
                    d.organization_filter = $("#organization_filter").val();
                    d.organization_level_filter = $("#organization_level_filter").val();
                }',
            ])
            ->orderBy(8)
            ->selectStyleSingle()
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
            Column::make('fullname')
                ->title('Full Name')
                ->addClass('text-wrap'),
            Column::make('email')->title('Email Address'),
            Column::make('organization')->title('Organization'),
            Column::make('organizationLevel')->title('Level'),
            Column::make('status')
                ->exportable(false)
                ->printable(true)
                ->addClass('text-center'),
            Column::make('roles')
                ->title('Roles')
                ->addClass('text-center')
                ->orderable(false),
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
        return 'Users_' . date('YmdHis');
    }
}
