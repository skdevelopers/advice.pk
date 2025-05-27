<?php

namespace App\DataTables;

use App\Models\Society;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class SocietiesDataTable extends SuperDataTable
{

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Society::with('city')->select('societies.*');
    }

    /**
     * Table ID on the <table> element.
     */
    protected function getTableId(): string
    {
        return 'societies-table';
    }

    /**
     * Return the <Column> element.
     */
    protected function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('society_name')->title('Society Name'),
            Column::make('city.name')->title('City'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(true)
                ->printable(true)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    /**
     * @return string|null
     */
    protected function actionsView(): ?string
    {
        return 'admin.societies.partials.actions';
    }


}
