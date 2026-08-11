<?php

return [
    /*
     * DataTables search options.
     */
    'search' => [
        'smart' => true,
        'multi_term' => true,
        'case_insensitive' => true,
        'use_wildcards' => false,
        'starts_with' => false,
    ],

    /*
     * Keep DT_Row_Index to match existing admin datatable views.
     */
    'index_column' => 'DT_Row_Index',

    /*
     * Engines compatible with yajra/laravel-datatables-oracle v10.
     */
    'engines' => [
        'eloquent' => Yajra\DataTables\EloquentDataTable::class,
        'query' => Yajra\DataTables\QueryDataTable::class,
        'collection' => Yajra\DataTables\CollectionDataTable::class,
        'resource' => Yajra\DataTables\ApiResourceDataTable::class,
    ],

    'builders' => [
        Illuminate\Database\Eloquent\Relations\Relation::class => 'eloquent',
        Illuminate\Database\Eloquent\Builder::class => 'eloquent',
        Illuminate\Database\Query\Builder::class => 'query',
        Illuminate\Support\Collection::class => 'collection',
    ],

    'nulls_last_sql' => ':column :direction NULLS LAST',

    'error' => env('DATATABLES_ERROR', null),

    'columns' => [
        'excess' => ['rn', 'row_num'],
        'escape' => '*',
        'raw' => ['action', 'aksi', 'gambar'],
        'blacklist' => ['password', 'remember_token'],
        'whitelist' => '*',
    ],

    'json' => [
        'header' => [],
        'options' => 0,
    ],

    'callback' => ['$', '$.', 'function'],
];
