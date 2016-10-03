<?php

namespace App\Toolbox;

use Closure;
use Yajra\Datatables\Facades\Datatables;

trait DataTable
{

    /**
     * returns DataTable valid response
     * @param  mixed $where
     * @return array
     */
    public static function dataTable($where = NULL, $with=[], $select=[])
    {
        if (!$select) {
            $select = (isset(self::$visibleOnTable)) ? self::$visibleOnTable : '*';
        }

        if ($where instanceof Closure) {

            $dataTable = Datatables::usingEloquent(
                static::select($select)->where($where)->with($with)
            );

        } elseif ($where === true) {

            $dataTable = Datatables::usingCollection(
                static::select($select)->with($with)->get()
            );

        } else {

            $dataTable = Datatables::usingEloquent(
                static::select($select)->where('user_id', '=', auth()->id())->with($with)
            );

        }

        return $dataTable->make(true);
    }
}