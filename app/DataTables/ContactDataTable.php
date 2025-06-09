<?php

namespace App\DataTables;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

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
            ->addColumn('action', 'contact.action')
            ->editColumn('profile_image', function ($query) {
                return '<a href="#" class="d-inline-block me-3">
                            <img src="' . storage_path($query->profile_image) . '" class="rounded-circle" width="40" height="40" alt="">
                        </a>';
            })
            ->setRowId('id')
            ->rawColumns(['action', 'profile_image'])
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
            ->columns($this->getColumns())
            ->dom('<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>')
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ])
            ->parameters([
                'buttons' => [
                    'dom' => [
                        'button' => [
                            'className' => 'btn btn-success btn-flat',
                        ],
                    ],
                    'buttons' => [
                        [
                            'extend' => 'excel',
                            'text' => '<span class="icon-file-excel"></span> Excel',
                        ],
                        [
                            'extend' => 'csv',
                            'text' => '<span class="icon-file-excel"></span> CSV',
                        ],
                        [
                            'extend' => 'pdf',
                            'text' => '<span class="icon-file-pdf"></span> PDF',
                        ],
                    ],
                ],
            ]);;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('profile_image'),
            Column::make('name'),
            Column::make('email'),
            Column::make('phone'),
            Column::make('gender'),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
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
