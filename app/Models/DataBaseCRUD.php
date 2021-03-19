<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
//use DataTables;

class DataBaseCRUD extends DB {

    public static function insertData($table,$data) {
        $query  =   DB::table($table)->insert($data);
        return $query;
    }

    public static function tableData($select = NULL,$table = NULL,$limit = NULL,$like = NULL,$order = NULL,$join = NULL,$where = NULL,$where2 = NULL,$group_by = NULL) {
        $query  =   DB::table($table)->distinct();
        $query->select(DB::raw($select));
        if ($join) {
            for ($i=0; $i<sizeof($join['data']) ; $i++) { 
                $query->join($join['data'][$i]['table'],$join['data'][$i]['IDprimary'],'=',$join['data'][$i]['IDsecondary']);
            }
        }
        if ($where) {
            for ($i=0; $i<sizeof($where['data']) ; $i++) { 
                $query->where($where['data'][$i]['column'],'=',$where['data'][$i]['param']);
            }
        }
        if ($where2) {
            $query->where($where2);
        }
        if ($like) {
            for ($i=0; $i<sizeof($like['data']) ; $i++) {
                ($like['data'][$i]['param']==NULL) ? '':$query->where(DB::raw('lower(CONCAT_WS(" ", '.$like['data'][$i]['column'].'))','like',strtolower($like['data'][$i]['param'])));
            }
        }
        if ($limit) {
            ($limit['finish']==NULL || ($limit['start'])==NULL) ? '':$query->offset($limit['finish'])->limit($limit['start']);
        }
        if ($order) {
            for ($i=0; $i<sizeof($order['data']) ; $i++) {
                ($order['data'][$i]['column']==NULL) ? '':$query->orderBy($order['data'][$i]['column'], $order['data'][$i]['type']);
            }
        }
        if ($group_by) {
            $query->groupBy($group_by);
        }
        $results    =   $query->get();
        if($results->count() > 0) { return $results; } 
        else { return false; }
    }

    public static function showData($select,$table,$join,$where) {
        $query  =   DB::table($table)->distinct();
        $query->select(DB::raw($select));
        if ($join) {
            for ($i=0; $i<sizeof($join['data']) ; $i++) { 
                $query->join($join['data'][$i]['table'],$join['data'][$i]['IDprimary'],'=',$join['data'][$i]['IDsecondary']);
            }
        }
        if ($where) {
            for ($i=0; $i<sizeof($where['data']) ; $i++) { 
                $query->where($where['data'][$i]['column'],'=',$where['data'][$i]['param']);
            }
        }
        $results    =   $query->get();
        if($results->count() > 0) { return $results; } 
        else { return false; }
    }

    public static function updateData($table,$where,$data){
        $query  =   DB::table($table);
        if ($where) {
            for ($i=0; $i<sizeof($where['data']) ; $i++) { 
                $query->where($where['data'][$i]['column'],'=',$where['data'][$i]['param']);
            }
        }
        $query->update($data);
        return $query;
    }

    public static function checkData($table,$where){
        $query  =   DB::table($table);
        if ($where) {
            for ($i=0; $i<sizeof($where['data']) ; $i++) { 
                $query->where($where['data'][$i]['column'],$where['data'][$i]['param']);
            }
        }
        $results    =   $query->get();
        if($results->count() > 0) { return true; } 
        else { return false; }
    }
}