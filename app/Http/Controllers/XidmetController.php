<?php

namespace App\Http\Controllers;

use App\Xidmet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class XidmetController extends Controller
{

    public function elave()
    {
        return view("dashboard.index");
    }
    public function elaveFlkart()
    {
        $dataTable = collect([]);
        $tabnames = DB::select("SELECT  table_name as nm FROM information_schema.tables where table_name like \"%flkart%\";");

        foreach ($tabnames as $tb) {
            $dataTable->push(substr($tb->nm,strlen($tb->nm)-4,4));
        }
        $dataTable=$dataTable->unique();
        return view("dashboard.index", compact('dataTable'));
    }
    public function elaveFlkartPost(Request $request)
    {

        $request->merge(['arxiv'=>isset($request->arxiv) ? 1 :0]);
        $to=$request->to;
        $old="0".strval(substr($to,0,2)-1).substr($to,2,4);
//        dd($old);
        $arxiv=$request->arxiv;

        $path = $request->file('flkart')->store('public/dbf');
        $path2 = $request->file('flkartx')->store('public/dbf');

        $command = escapeshellcmd("python C:\\xampp\htdocs\ish_domain\public\py\\run.py "
            ."C:\\xampp\htdocs\ish_domain\storage\app\\". $path . " "
            ."C:\\xampp\htdocs\ish_domain\storage\app\\".$path2);
        $output = shell_exec($command);
        unlink("C:\\xampp\htdocs\ish_domain\storage\app\\". $path);
        unlink("C:\\xampp\htdocs\ish_domain\storage\app\\". $path2);
        $tflkarx="flkartx".$to;
        $tflkar="flkart".$to;
        if ($arxiv==0){
            $tflkarx="flkartx".$old;
            $tflkar="flkart".$old;
        }
        DB::unprepared("
drop table if exists ".$tflkarx.";
        create table ".$tflkarx."(
          id int auto_increment primary key,
	notel 		int null,
	kodqurum 	int null,
	kodtarif 	int null,
	nonaryad 	int null,
	dtnaryad	date null,
	dtnaryad1	 text null,
	dcorr 			text null,
	summa 		float null,
	abonent		 int null,
	kodist 		int null,
	say 		int null
);

LOAD DATA INFILE "."'C:/xampp/htdocs/ish_domain/public/csv/flkartx.csv'"."
 INTO TABLE ".$tflkarx."
	FIELDS TERMINATED BY ','
	ESCAPED BY ''
	LINES TERMINATED BY '\r\n'
	(
	@notel 	    ,
	@kodqurum   ,
	@kodtarif   ,
	@nonaryad   ,
	@dtnaryad   ,
	@dtnaryad1  ,
	@dcorr 	    ,
	@summa 	    ,
	@abonent	  ,
	@kodist 	  ,
	@say
	)
	set notel 	 	= nullif(@notel,''),
			kodqurum  = nullif(@kodqurum,''),
			kodtarif  = nullif(@kodtarif,''),
			nonaryad  = nullif(@nonaryad,''),
			dtnaryad 	= nullif(@dtnaryad,''),
			dtnaryad1 = nullif(@dtnaryad1,''),
			dcorr 	 	= nullif(@dcorr,''),
			summa 	 	= nullif(@summa,''),
			abonent	 	= nullif(@abonent,''),
			kodist 	 	= nullif(@kodist,''),
			say 			= nullif(@say,'');
        ");

DB::unprepared("
drop table if exists ".$tflkar.";
create table ".$tflkar."
(
id int auto_increment primary key,
	NOTEL 		int null,
	KODQURUM 	int null,
	X_KART 		int null,
	KODTARIF 	int null,
	KODLQOT 	int null,
	ABONENT 	int null,
	ABONENT2 	int null,
	SAYTEL 		int null,
	SUMMA0 		decimal(8,2) null,
	SUMMA 		decimal(8,2) null,
	NONARYAD 	int null,
	UZEL 			int null,
	DTNARYAD 	datetime null,
	DTNARYAD1 datetime null,
	TMNARYAD1 int null,
	DTNARYAD2 datetime null,
	KODXIDMET int null,
	KODIST 		int null
);

LOAD DATA INFILE 'C:/xampp/htdocs/ish_domain/public/csv/flkart.csv'
	INTO TABLE ".$tflkar."
	FIELDS TERMINATED BY ','
	ESCAPED BY ''
	LINES TERMINATED BY '\r\n'
	(
		@NOTEL 	     ,
		@KODQURUM    ,
		@X_KART 	   ,
		@KODTARIF    ,
		@KODLQOT     ,
		@ABONENT     ,
		@ABONENT2    ,
		@SAYTEL 	   ,
		@SUMMA0 	   ,
		@SUMMA 	     ,
		@NONARYAD    ,
	  @UZEL 		   ,
	  @DTNARYAD    ,
	  @DTNARYAD1   ,
	  @TMNARYAD1   ,
	  @DTNARYAD2   ,
	  @KODXIDMET   ,
		@KODIST
	)
	set 		NOTEL 	 	= nullif(@NOTEL 	 ,	''),
					KODQURUM  = nullif(@KODQURUM ,		''),
					X_KART 	  = nullif(@X_KART 	 ,		''),
					KODTARIF  = nullif(@KODTARIF ,			''),
					KODLQOT  	= nullif(@KODLQOT  ,		''),
					ABONENT 	= nullif(@ABONENT ,		''),
					ABONENT2  = nullif(@ABONENT2 ,		''),
					SAYTEL 	 	= nullif(@SAYTEL 	 ,		''),
					SUMMA0 	 	= nullif(@SUMMA0 	 ,			''),
					SUMMA 	 	= nullif(@SUMMA 	 ,		''),
					NONARYAD  = nullif(@NONARYAD ,		''),
					UZEL 		 	= nullif(@UZEL 		 ,		'')  ,
					DTNARYAD  = nullif(@DTNARYAD ,		''),
					DTNARYAD1 = nullif(@DTNARYAD1,		''),
					TMNARYAD1 = nullif(@TMNARYAD1,		''),
					DTNARYAD2 = nullif(@DTNARYAD2,		''),
					KODXIDMET = nullif(@KODXIDMET,		''),
					KODIST 	 	= nullif(@KODIST 	 ,			'');

");
//'C:/xampp/htdocs/ish_domain/public/csv/flkart.csv
        unlink("C:\\xampp\htdocs\ish_domain\public\csv\\flkart.csv");
        unlink("C:\\xampp\htdocs\ish_domain\public\csv\\flkartx.csv");
        return back()->with('success','Flkart və FLKartX uğurla məlumatlar bazasına yazıldı');
    }

    public function deyishPost(Request $request)
    {
        $request->merge(['isX'=>isset($request->isX) ? 1 :0]);
        $upd = Xidmet::find($request->id);
        $add=$upd->ad;
        $upd->ad =$request->ad;
        $upd->kodtarifler= $request->kodtarifler;
        $upd->isX=$request->isX;
        $upd->save();
        return back()->with("success",$add." dəyişdirildi.");
    }
    public function xidmetSil($id)
    {
        Xidmet::find($id)->delete();
        return back();
    }
    public function elavePost(Request $request)
    {
        $request->merge(['isX'=>isset($request->isX) ? 1 :0]);
        $xdmt= new Xidmet;
        $xdmt->ad=$request->ad;
        $xdmt->isX=$request->isX;
        $xdmt->kodtarifler=$request->kodtarifler;
        $xdmt->save();
        return back()->with("success","Xidmət Yadda saxlandı.");
    }
    public function idareFlkart()
    {
        $dataTable = collect([]);
        $tabnames = DB::select("SELECT  table_name as nm FROM information_schema.tables where table_name like \"%flkart%\";");

        foreach ($tabnames as $tb) {
            $dataTable->push(substr($tb->nm,strlen($tb->nm)-4,4));
        }
        $dataTable=$dataTable->unique();
        return view("dashboard.index", compact('dataTable'));
    }
    public function FlkartSil($id)
    {
       $flkart="flkart".$id;
       $flkartx="flkartx".$id;
       DB::select('DROP TABLE IF EXISTS '.$flkart);
       DB::select('DROP TABLE IF EXISTS '.$flkartx);

       return back()->with("success",$flkart.' və '.$flkartx.' silindi!');
    }
}
