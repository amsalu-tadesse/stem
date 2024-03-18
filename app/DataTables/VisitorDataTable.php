<?php

namespace App\DataTables;

use App\Constants\Constants;
use App\Models\Visitor;
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

class VisitorDataTable extends DataTable
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
              ->addColumn('countryName', function ($visitor) {
                return $visitor?->countryName;
            })
            ->orderColumn('countryName', function ($query, $order) {
                $query->orderBy('countryName', $order);
            })->filterColumn('countryName', function ($visitor, $keyword) {
                $sql = "countries.name like ?";
                $visitor->whereRaw($sql, ["%{$keyword}%"]);
            })
              ->addColumn('institutionName', function ($visitor) {
                return $visitor?->institutionName;
            })
            ->orderColumn('institutionName', function ($query, $order) {
                $query->orderBy('institutionName', $order);
            })->filterColumn('institutionName', function ($visitor, $keyword) {
                $sql = "institutions.name like ?";
                $visitor->whereRaw($sql, ["%{$keyword}%"]);
            })
              ->addColumn('institutionTypeName', function ($visitor) {
                return $visitor?->institutionTypeName;
            })
            ->orderColumn('institutionTypeName', function ($query, $order) {
                $query->orderBy('institutionTypeName', $order);
            })->filterColumn('institutionTypeName', function ($visitor, $keyword) {
                $sql = "institution_types.name like ?";
                $visitor->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->addColumn('actual_visitor', function ($visitor) {
                if($visitor->actual_visior = null){
                    return 0;
                }
                else{
                return $visitor->actual_visitor;
                }
            })
            ->addColumn('created_from', function ($visitor) {
                if($visitor->created_from == 'Outside'){
                    return "<span class='badge badge-warning'>Outside</span>";
                }
                else{
                    return "<span class='badge badge-success'>Inside</span>";
                }
            })

            ->addColumn('action', function ($visitor) {
                return view('components.action-buttons', [
                    'row_id' => $visitor->id,
                    'show' => true,
                    'permission_delete' => 'visitor: delete',
                    'permission_edit' => 'visitor: edit',
                    'permission_view' => 'visitor: view',
                ]);
            })
            ->rawColumns(['no','created_from', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Visitor $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Visitor $model): QueryBuilder
    {
         $query = $model::leftjoin('institutions','institution_id','=','institutions.id')->leftjoin('institution_types','institution_type_id','=','institution_types.id')->leftjoin('countries','country_id','=','countries.id')->select([
            'visitors.id',
            'visitors.created_at',
            'visitors.visitor_count',
            'visitors.actual_visitor',
            'visitors.created_from',
            'institutions.name as institutionName',
            'institution_types.name as institutionTypeName',
            'countries.name as countryName',
        ]);

         if (request()->has('created_from') && request()->filled('created_from')) {
            $query->where('visitors.created_from', '=', request('created_from'));
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('visitors-table')
            ->columns($this->getColumns())
            ->orderBy(8)
             ->ajax([
                'url' => route('admin.visitors.index'),
                'data' => 'function(d) {
                d.created_from = $("#created_from").val(); 
            }',
            ])
            ->initComplete('function(settings, json) {
            var table = $("#visitors-table").DataTable();

            $("#created_from").on("change", function() {
                table.ajax.reload();
                  });
             }')
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
            Column::make('institutionName')->title('Institution'),
            Column::make('institutionTypeName')->title('Institution Type'),
            Column::make('countryName')->title('Country'),
            Column::make('visitor_count')->title('Expected Visitors'),
            Column::make('actual_visitor')->title('Actual Visitors'),
            Column::make('created_from'),
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
        return "visitors" . date('YmdHis');
    }
}
