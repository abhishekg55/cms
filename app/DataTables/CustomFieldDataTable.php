<?php

namespace App\DataTables;

use App\Models\CustomField;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class CustomFieldDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<CustomField> $query Results from query() method.
     */
    public function ajax(): JsonResponse
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($query) {
                $editUrl = route('custom-fields.edit', encrypt($query->id));
                return '<div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ph-list"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a href="javascript:void(0)" onclick=editCustomField("' . $editUrl . '") class="dropdown-item">
                                    <i class="ph-pencil me-2"></i>
                                    Edit
                                </a>
                            </div>
                        </div>';
            })
            ->editColumn('created_at', function ($query) {
                return date('d-m-Y h:i A', strtotime($query->created_at));
            })
            ->editColumn('status', function ($query) {
                return $query->status ? 'Active' : 'Inactive';
            })
            ->filterColumn('status', function ($query, $keyword) {
                $value = null;

                // Normalize search input
                $keyword = strtolower(trim($keyword));

                if ($keyword == Str::lower('active')) {
                    $value = 1;
                } else {
                    $value = 0;
                }

                if (!is_null($value)) {
                    $query->where('status', $value);
                }
            })
            ->setRowId('id')
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<CustomField>
     */
    public function query(): QueryBuilder
    {
        $query = CustomField::query();
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('customfield-table')
            ->dom('<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->parameters([
                'responsive' => true, // ✅ Enables responsive behavior
                'autoWidth' => false,
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('field_name'),
            Column::make('field_type'),
            Column::make('status'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CustomFields_' . date('YmdHis');
    }
}
