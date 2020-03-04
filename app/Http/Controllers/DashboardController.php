<?php

namespace App\Http\Controllers;

use App\Flkart;
use App\FlkartX2;
use App\Hesabat;
use App\Xidmet;
use function Complex\add;
use Illuminate\Http\Request;
use App\Charts\InfoChart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class DashboardController extends Controller
{
    public function main()
    {
        return view('welcome');
    }

    public function index()
    {
        return redirect('/dashboard/melumat');
    }

    public function statistika()
    {

        return view("dashboard.index");
    }

    public function ayliq(Request $request)
    {
//        if ($request->all()){
//            dd($request->all());
//        }
        $xidmetler = Xidmet::all();
        $dataTable = collect([]);
        $tabnames = DB::select("SELECT  table_name as nm FROM information_schema.tables where table_name like \"%flkart%\";");
        foreach ($tabnames as $tb) {
            $dataTable->push(substr($tb->nm,strlen($tb->nm)-4,4));
        }
        $dataTable=$dataTable->unique();

        $evvel =$request->evvel;
        $son = $request->son;
        $chart = new InfoChart;
        $chart->labels([substr($evvel,0,2).'-20'.substr($evvel,2,4),
            substr($son,0,2).'-20'.substr($son,2,4),])->
        title("Xidmətlərin Interval Ərzində Dəyişimi", 14, '#000', true, "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif");

        $data = collect([]);

        $interval = $request->only(['evvel','son']);

        $cleared = $request->except(["submit", "_token", "evvel", "son"]);

        $eflkart= "flkart".$evvel;
        $sflkart= "flkart".$son;
        $eflkartx= "flkartx".$evvel;
        $sflkartx= "flkartx".$son;

        foreach ($cleared as $key => $value) {
            $data2 = collect([]);
            $valarr = explode(',', $key);
            $tablename = 'flkartx0419';

            if ($value ==="M = Q"){
//                dd($cleared);
                $beforeMonth = DB::table($eflkart)->select(DB::raw('count(NOTEL) as cnt'))
                    ->where('abonent', '=','1')
                    ->where('abonent2', '=','2')
                    ->get()->pluck('cnt');

                $all = DB::table($sflkart)->select(DB::raw('count(NOTEL) as cnt'))
                    ->where('abonent', '=','1')
                    ->where('abonent2', '=','2')
                    ->get()->pluck('cnt');

                $sum = DB::table($sflkart)
                    ->select(DB::raw('cast(sum(summa0) as decimal(16,2)) as cnt'))
                    ->where('abonent', '=','1')
                    ->where('abonent2', '=','2')
                    ->get()->pluck('cnt');

                $difference = intval($all[0]) - intval($beforeMonth[0]);
//                dd(intval($beforeMonth[0]));
                $chart->dataset( strval($value), 'bar', collect([intval($beforeMonth[0]), intval($all[0])]))
                    ->backgroundColor('#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6))
                    ->fill(false);

                $data2['ay_ev'] = $beforeMonth[0];
                $data2['ay_ax'] = $all[0];
                $data2['ay_ferq'] = $difference;
                $data2['xtq'] = $value;
                $data2['sum'] = floor(intval($sum[0]));
            }else{
                $xidmet = Xidmet::where('ad',$value)->first()->isX;
                $tbev='';
                $tbso ='';
                $say='say';
                $summa = 'summa';
                if($xidmet==1){
                    $tbev=$eflkartx;
                    $tbso=$sflkartx;
                    $say='say';
                    $summa = 'summa';
                }else{
                    $tbev=$eflkart;
                    $tbso=$sflkart;
                    $say='saytel';
                    $summa = 'summa0';
                }
                $beforeMonth = DB::table($tbev)->select(DB::raw('sum(CASE WHEN '.$say.'=0 or  '.$say.' is null THEN 1 ELSE '.$say.' END) as cnt'))
                    ->whereIn('kodtarif', $valarr);
//                    ->get()->pluck('cnt');
                if ($xidmet==0){
                    $beforeMonth->whereIn('abonent', [1,2]);
                }
                $all = DB::table($tbso)->select(DB::raw('sum(CASE WHEN '.$say.'=0 or  '.$say.' is null THEN 1 ELSE '.$say.' END) as cnt'))
                    ->whereIn('kodtarif', $valarr);
//                    ->get()->pluck('cnt');
                if ($xidmet==0){
                    $all->whereIn('abonent', [1,2]);
                }
                $sum = DB::table($tbso)->select(DB::raw('cast(sum('.$summa.') as decimal(16,2)) as cnt'))
                    ->whereIn('kodtarif', $valarr);
//                    ->get()->pluck('cnt');
                if ($xidmet==0){
                    $sum->whereIn('abonent', [1,2]);
                }
                $beforeMonth=$beforeMonth->get()->pluck('cnt');
                $all=$all->get()->pluck('cnt');
                $sum=$sum->get()->pluck('cnt');

                $difference = intval($all[0]) - intval($beforeMonth[0]);
                $chart->dataset($value , 'bar', collect([intval($beforeMonth[0]), intval($all[0])]))
                    ->backgroundColor('#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6))
                    ->fill(false);

                $data2['ay_ev'] = $beforeMonth[0];
                $data2['ay_ax'] = $all[0];
                $data2['ay_ferq'] = $difference;
                $data2['xtq'] = $value;
                $data2['sum'] = $sum[0];
            }

            $data->push($data2);
        }

        return view("dashboard.index", compact('chart', 'data', 'xidmetler','dataTable','interval'));
    }

    public function melumat(Request $request)
    {
        $query = Input::get('query');
        if ($query == null) {
            $all = FlkartX2::simplePaginate(7);
            return view("dashboard.index", compact('all'));
        } else {
            $all = FlkartX2::where('notel', 'LIKE', '%' . $query . '%')->simplePaginate(7);
//            $all = FlkartX2::simplePaginate(7);
            return view("dashboard.index", compact('all'));
        }
    }
    public function xidmetevler(Request $request){
        $xidmetler = Xidmet::whereIn("ad",["GPON","Simsiz Telefon","CDMA"])->get();
        $flkar=new Flkart();
        if ($request->has('xidmet')){
            $valarr = explode(',', $request->xidmet);

            $ntl = DB::table("".$flkar->getTableName())->select('notel as ntl')
                ->whereIn('KODTARIF',$valarr)
                ->whereIn('ABONENT',['1','2'])->pluck('ntl');
            $res = DB::table('flabun2')->selectRaw('notel, kodkuce, ev,adabune')
                ->whereIn('notel',$ntl)->orderBy('kodkuce')->orderBy('ev')->get();

            return view("dashboard.index", compact('res','xidmetler'));
        }

        return view("dashboard.index", compact('xidmetler'));
    }
    public function hesabatlar()
    {
        $query = Input::get('query');
        if ($query == null) {
            $hesabatlar = Hesabat::orderBy("id","desc")->simplePaginate(1);
            return view("dashboard.index",compact('hesabatlar'));
        } else {
            $hesabatlar = Hesabat::where('hesab_ad', 'LIKE', '%' . $query . '%')->orderBy("id","desc")->simplePaginate(1);
            return view("dashboard.index",compact('hesabatlar'));
        }
    }
    public function hesabatSil($id)
    {
        Hesabat::find($id)->delete();
        return back();
    }
}
