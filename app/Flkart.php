<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Flkart extends Model
{
    protected $table = "flkart0419";
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

        return "flkart".$dataTable[sizeof($dataTable)-1];
    }
}

