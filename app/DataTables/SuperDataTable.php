<?php

namespace App\DataTables;

use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

abstract class SuperDataTable extends DataTable
{
    /**
     * Build DataTable class.
     * @throws Exception
     */
    public function dataTable($query): EloquentDataTable
    {
        $dt = datatables()->eloquent($query);

        // Optional: child can define a Blade partial for actions
        if ($view = $this->actionsView()) {
            $dt->addColumn('action', fn($row) => view($view, ['row' => $row])->render());
            $dt->rawColumns(['action']);
        }

        return $dt;
    }

    /**
     * Child must return the Eloquent\Builder query.
     */
    abstract public function query();

    /**
     * Child can override to point to a Blade view for the "action" column.
     */
    protected function actionsView(): ?string
    {
        return null;
    }

    /**
     * Configure the HTML builder: table ID, columns, AJAX, and global params.
     */
    public function html(): Builder
    {
        return $this->builder()
            ->setTableId($this->getTableId())
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->parameters([
                'processing' => true,
                'serverSide' => true,
                'responsive' => true,
                'autoWidth' => false,
                // you can add global buttons, lengthMenu, language here...
            ]);
    }

    /**
     * Configure the HTML builder: table ID, in Child Class params.
     */
    protected function filename(): string
    {
        // e.g. getTableId() returns "societies-table"
        $table = $this->getTableId();
        // strip off "-table" suffix if you like:
        $name  = str_replace('-table', '', $table);

        return 'Advice_' . $name . '_' . date('YmdHis');
    }


    /**
     * Child must return the HTML ID of the table.
     */
    abstract protected function getTableId(): string;

    /**
     * Child must return an array of Column definitions.
     */
    abstract protected function getColumns(): array;
}
