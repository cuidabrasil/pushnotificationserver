<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'users.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->select(
                'users.*'
            )
            ->where(function($query) {
                return null;
            });
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px'])
            ->parameters([
                'dom'     => 'Bfrtip',
                'order'   => [[0, 'desc']],
                'buttons' => [
                    [ 'extend' => 'export', 'text' => '<i class="fa fa-download"></i> Exportar <i class="fa fa-caret-down" aria-hidden="true"></i>' ],
                    [ 'extend' => 'print', 'text' => '<i class="fa fa-print"></i> Imprimir' ],
                    [ 'extend' => 'reload', 'text' => '<i class="fa fa-refresh"></i> Recarregar' ],
                ],
                'language' => [
                    'url' => url('https://cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json'),
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name'=> ['title' => 'Nome', 'data' => 'name'],
            'email'=> ['title' => 'E-Mail', 'email' => 'title'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'usersdatatable_' . time();
    }
}
