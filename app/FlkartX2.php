<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FlkartX2 extends Model
{
    protected $table = "flkartx0419";
    public $timestamps = false;
    public function getTableName(){
        return $this->table;
    }
    public function getTable()
    {   $dataTable = collect([]);
        $tabnames = DB::select("SELECT  table_name as nm FROM information_schema.tables where table_name like \"%flkart%\";");
        foreach ($tabnames as $tb) {
            $dataTable->push(substr($tb->nm, strlen($tb->nm) - 4, 4));
        }
        $dataTable = $dataTable->unique();

        return "flkartx".$dataTable[sizeof($dataTable)-1];
    }
}
