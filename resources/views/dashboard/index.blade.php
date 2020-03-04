@extends('layout.header')

@section('content')
    <ul id="slide-out" class="sidenav sidenav-fixed" STYLE="
    header, main, footer,{
      padding-left: 300px;
    };

    padding-top:60px;

    @media only screen and (max-width : 992px) {
      header, main, footer {
        padding-left: 0;
      }
    }">
        <li id="aaaa"><a><h4><b class="">Idarə Paneli</b></h4></a></li>
        <li class="{{request()->segment(count(request()->segments()))=="melumat" ? "activem": ""}}"><a
                    href="/dashboard/melumat"><i class="material-icons green-text">format_list_bulleted</i>Melumat</a></li>
        <li class="{{request()->segment(count(request()->segments()))=="statistika" ? "activem": ""}}"><a
                    href="/dashboard/statistika"><i class="material-icons blue-text">create</i>Statistika Hazirla</a></li>
        <li class="{{request()->segment(count(request()->segments()))=="elave" ? "activem": ""}}"><a
                    href="/dashboard/elave"><i class="material-icons " style="color:#fff176 ;">control_point</i>Melumatların İdarəsi</a></li>
        <li class="{{request()->segment(count(request()->segments()))=="hesabatlar" ? "activem": ""}}"><a
                    href="/dashboard/hesabatlar"><i class="material-icons red-text">storage</i>Mənim Hesabatlarım</a></li>
    </ul>
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>

    <div class="mbody" >
        {{--@if(request()->segment(count(request()->segments()))=="user")--}}
        @if(request()->segment(count(request()->segments()))=="melumat")
            <div class="row">
                <nav>
                    <div class="nav-wrapper">
                        <form action="/dashboard/melumat" method="GET">
                            {{--@csrf--}}
                            <div class="input-field">
                                <input id="search" type="search" name="query" required placeholder="Nömrəni daxil edin"
                                       onfocus="$('.xclose').toggleClass('white-text')"
                                       onblur="$('.xclose').toggleClass('white-text')">
                                <label class="label-icon" for="query"><i
                                            class="material-icons white-text xclose">search</i></label>
                                <i class="material-icons white-text xclose"
                                   onclick="window.location.href = '/dashboard/melumat';">close</i>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>
            <table>
                <thead>
                <tr>
                    <th>NoTel</th>
                    <th>TarifKod</th>
                    <th>Summa</th>
                    <th>Say</th>
                </tr>
                </thead>

                <tbody>

                @foreach($all as $row)
                    <tr>
                        <td>{{$row->notel}}</td>
                        <td>{{$row->kodtarif}}</td>
                        <td>{{$row->summa}}</td>
                        <td>{{$row->say}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row center">
                {{$all->links()}}
            </div>
        @endif
        @if(request()->segment(count(request()->segments()))=="elave" or request()->segment(count(request()->segments())-1)=="elave")
                <div class="row">
                   @include('dashboard.elave')
                </div>
        @endif
        @if(request()->segment(count(request()->segments()))=="hesabatlar")
                <div class="row">
                   @include('dashboard.hesabatlar')
                </div>
        @endif
        @if(request()->segment(count(request()->segments()))=="statistika")
            <div class="row">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content ">
                            <span class="card-title center">Hazırlanacaq Cədvəlin Növünü seçin</span>
                            <div class="collection">
                                <a href="/dashboard/statistika/ayliq" class="collection-item">2 saylı XTQ - da servis xidmətləri
                                    barədə arayış</a>
                                <a href="/dashboard/statistika/xidmetevler" class="collection-item ">Xidmətlər evlər üzrə</a>
                                <a href="#!" class="collection-item disabledLink">ADSL</a>
                                <a href="#!" class="collection-item disabledLink">Əlavə Xidmətlər</a>
                                <a href="#!" class="collection-item disabledLink">Provayderlər</a>
                                <a href="#!" class="collection-item disabledLink">AIQ(OPTIK)</a>
                                <a href="#!" class="collection-item disabledLink">GPON ateistləri üzrə</a>
                                <a href="#!" class="collection-item disabledLink">LTE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(request()->segment(count(request()->segments()))=="xidmetevler")
            @include('dashboard.gpon')
        @endif
        @if(request()->segment(count(request()->segments()))=="ayliq")
            <div class="row">
                <div class="col s9">
                    {{--<input type="text" placeholder="Xidmetin Adi" id="xdmAd">--}}

                    <select id="xdmAd">
                        <option value="-22" disabled selected>Xidməti Seçin</option>
                        @foreach($xidmetler as $row)
                            <option value="{{$row->kodtarifler}}">{{$row->ad}}</option>
                        @endforeach
                    </select>
                    <label>Xidməti Seçin</label>

                </div>
                <div class="col s3">
                    <button id="xdmET" class="btn" onclick="elET();">Xidmet Elave Et</button>
                </div>
            </div>
            <div class="row">
                <form action="/dashboard/statistika/ayliq" id="xdmtForm" method="POST">
                    {{ csrf_field() }}
                    <div class="input-field col s12 m6">
                    <select name="evvel" required>
                    <option value="" disabled selected>Intervalın Əvvalin seçin</option>
                        @foreach($dataTable as $row)
                            <option value="{{$row}}">{{substr($row,0,2)}}-20{{substr($row,2,4)}}</option>
                        @endforeach
                    </select>
                    <label>Ay Seçin</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select name="son" required>
                            <option value="-99" disabled selected>Intervalın Axırını seçin</option>
                            @foreach($dataTable as $row)
                                <option value="{{$row}}">{{substr($row,0,2)}}-20{{substr($row,2,4)}}</option>
                            @endforeach
                        </select>
                        <label>Ay Seçin</label>
                    </div>
                    {{--<div class="input-field col s12 m6">--}}
                        {{--<input type="text" class="datepicker" placeholder="Intervalın Əvvəli" name="evvel">--}}
                    {{--</div>--}}
                    {{--<div class="input-field col s12 m6">--}}
                        {{--<input type="text" class="datepicker" placeholder="Intervalın Sonu" name="son">--}}
                    {{--</div>--}}
                </form>
            </div>
            <div id="printable">
                <div class="row">
                    {{--@if(session()->has('data'))--}}
                    {{--                    {{dd(session()->get('data'))}}--}}
                    @if(!$data->isEmpty())
                        <table id="printableTable">
                            <thead>
                            <tr>
                                <th>Xidmət</th>
                                <th>{{substr($interval['evvel'],0,2)}}-20{{substr($interval['evvel'],2,4)}}</th>
                                <th>Interval Erzinde</th>
                                <th>{{substr($interval['son'],0,2)}}-20{{substr($interval['son'],2,4)}}</th>
                                <th>Hesablanib</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $row)
                                <tr>
                                    <td>{{$row["xtq"]}}</td>
                                    <td>{{$row["ay_ev"]}}</td>
                                    <td>@if($row["ay_ferq"]>0)
                                            <span class="green-text font-weight-bold">{{$row["ay_ferq"]}} <i class="tiny material-icons">keyboard_arrow_up</i></span>
                                        @elseif($row["ay_ferq"]==0)
                                            <span class="grey-text font-weight-bold">{{$row["ay_ferq"]}} <i class="tiny material-icons">remove</i></span>
                                        @else
                                            <span class="red-text font-weight-bold">{{$row["ay_ferq"]}} <i class="tiny material-icons">keyboard_arrow_down</i></span></span>
                                        @endif
                                    </td>
                                    <td>{{$row["ay_ax"]}}</td>
                                    <td>{{$row["sum"]}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
                <div class="row">
                    {!! $chart->container() !!}
                </div>

                @endif
                @if(!$data->isEmpty())
                    @isset($chart)
                        {!! $chart->script() !!}
                    @endisset
                @endif
                @endif
            </div>
        @isset($data)
            @if(!$data->isEmpty())
                <div class="row">
                    <div class="col s12 m2">
                        <button class="btn-flat waves-ripple" onclick="PrintElem('printable')">Print <i
                                    class="material-icons tiny">print</i></button>
                    </div>
                    <div class="col s12 m2">
                        <a class="btn-flat waves-ripple" onclick="exportToExcel('printableTable')">Excell <i
                                    class="material-icons tiny">insert_drive_file</i></a>
                    </div>
                    <div class="col s12 m8">
                        <form action="/api/hesabat" method="post" >
                            {{ csrf_field() }}
                            <input type="hidden" name="html" id="htmlm">
                            <div class="row">
                                <div class="input-field col s6">
                                    <input placeholder="Hesabatın adı" id="hesab_ad" type="text" class="validate" name="hesab_ad"
                                    onfocus="$('input[name='+'html'+']').val($('#printable').html())"
                                     required>
                                    <label for="hesab_ad">Hesabatın adı</label>
                                </div>
                                <div class="input-field col s6">
                                   <button class="btn waves-ripple" type="submit" name="submit" id="hsbAdd"
                                   >Hesabatı Yadda Saxla</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            @endisset

    </div>
@endsection
<script>
    function elET() {
        elm = $('#xdmAd');
        el = elm.val();
        if(el!=='-22'){
        gonder = $('#gonder');
        gonder.remove();
        gonderhtml = ' <div class="row" id="gonder">\n' +
            '                        <div class="col s12">\n' +
            '                            <input  name="submit" type="submit" value="Gönder" class="btn" style="width: 100%"/>\n' +
            '                        </div>\n' +
            '                    </div>';

        elmad = $("#xdmAd option:selected").text();
        elm.prop('selectedIndex', 0);
        elm.formSelect();
        form = $('#xdmtForm');
        input = ' <div class="row" id="' + el.replace(/,/g, '') + '">\n' +
            '          <div class="input-field col s10">\n' +
            '         <input type="text" id="' + el + '" class="validate"' +
            ' name="' + el + '" value="' + elmad + '">\n' +
            '         </div>\n' +
            '              <div class="col s2"> <button class="btn-danger btn red" onclick="$(\'#' + el.replace(/,/g, '') +'\').remove();">Sil</button></div>' +
            '</div>';

            // alert(el);
            form.append(input);
            form.append(gonderhtml);
        }
    }

    function PrintElem(elem) {
        // $('#' + elem).print();
        var mywindow = window.open('', 'PRINT','height=600, width=800');

        mywindow.document.write('<html><head><title>' + document.title + '</title>');
        mywindow.document.write('    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" media="print" type="text/css">\n' +
            '    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" media="print" rel="stylesheet">\n' +
            '    <link href="{{ asset("css/style2.css") }}" type="text/css" rel="stylesheet" media="print" media="screen,projection"/>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById(elem).innerHTML);
        mywindow.document.write('<script src="{{ asset("js/materialize.min.js") }}" media="print" defer><\/script>\n');
        mywindow.document.write('<script src="{{ asset("js/jquery.min.js") }}" media="print" defer><\/script>\n');
        mywindow.document.write('<script src="{{ asset("js/Chart.min.js") }}" media="print" defer><\/script>\n');
        mywindow.document.write('<script src="{{ asset("js/chartjs-plugin-datalabes.min.js") }}" media="print" defer><\/script>\n');
        mywindow.document.write('<script src="{{ asset("js/mBody.js") }}" media="print" defer><\/script>\n');
        {{--mywindow.document.write({!! $chart->script() !!};--}}
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        // mywindow.print();
        // mywindow.close();

        return true;
    }


    function exportToExcel(id){
        var uri = 'data:application/vnd.ms-excel;base64,';
        var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
        var base64 = function(s) {
            return window.btoa(unescape(encodeURIComponent(s)))
        };

        var format = function(s, c) {
            return s.replace(/{(\w+)}/g, function(m, p) {
                return c[p];
            })
        };
        $("#"+id+" .material-icons").remove();
        htmls = $("#"+id).prop('innerHTML');

        var ctx = {
            worksheet : 'Worksheet',
            table : htmls
        };
        window.title="das";
        window.location.href = uri + base64(format(template, ctx))

    }



</script>
