<?php

namespace App\DataTables;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class ContactDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Contact> $query Results from query() method.
     */
    public function ajax(): JsonResponse
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($query) {
                $editUrl = route('contact.edit', encrypt($query->id));
                $mergeUrl = route('contact.merge', encrypt($query->id));
                return '<div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ph-list"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a href="javascript:void(0)" onclick=editContact("' . $editUrl . '") class="dropdown-item">
                                    <i class="ph-pencil me-2"></i>
                                    Edit
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="' . $mergeUrl . '" class="dropdown-item">
                                    <i class="ph-link me-2"></i>
                                    Merge Contact
                                </a>
                            </div>
                        </div>';
            })
            ->editColumn('name', function ($query) {
                return '<div class="d-flex align-items-center">
                            <a href="' . asset('storage/' . $query->profile_image) . '" class="d-inline-block me-3" target="_blank">
                                <img src="' . asset('storage/' . $query->profile_image) . '" class="rounded-circle" width="40" height="40" alt="' . $query->name . '">
                            </a>
                            <div>
                                <a href="javascript:void(0)" class="text-body fw-semibold">' . $query->name . '</a>
                                <div class="d-flex align-items-center text-muted fs-sm">
                                    ' . $query->email . '
                                </div>
                            </div>
                        </div>';
            })
            ->editColumn('created_at', function ($query) {
                return date('d-m-Y h:i A', strtotime($query->created_at));
            })
            ->editColumn('gender', function ($query) {
                return $query->gender_string;
            })
            ->filterColumn('gender', function ($query, $keyword) {
                $value = null;

                // Normalize search input
                $keyword = strtolower(trim($keyword));

                if ($keyword == Str::lower('male')) {
                    $value = 0;
                } else {
                    $value = 1;
                }

                if (!is_null($value)) {
                    $query->where('gender', $value);
                }
            })
            ->setRowId('id')
            ->rawColumns(['action', 'name'])
            ->make(true);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Contact>
     */
    public function query(): QueryBuilder
    {
        $query = Contact::query();
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('contactTable')
            ->responsive(true)
            ->columns($this->getColumns())
            ->dom('<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>')
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
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
            Column::make('email')
                ->visible(false)
                ->searchable(),
            Column::make('name'),
            Column::make('phone'),
            Column::make('gender'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Contact_' . date('YmdHis');
    }
}
