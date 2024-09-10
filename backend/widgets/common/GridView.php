<?php
namespace backend\widgets\common;


class GridView extends \yii\grid\GridView
{
    public $layout = '{items}
        <div class="f-r" id="dynamic-table_paginate"> {summary}</div>
        <div class="f-r" id="dynamic-table_paginate">{pager}</div>
        ';

    public $pager = [
        'options' => [
            'class' => 'pagination'
        ]
    ];

    public $tableOptions = [
        'class' => 'table table-striped table-bordered table-hover'
    ];

    public $summary = '{begin}-{end}， Totals: {totalCount} Records，Total {pageCount} page';
}