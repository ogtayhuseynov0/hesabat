
    <div class="row">
        <nav>
            <div class="nav-wrapper">
                <form action="/dashboard/hesabatlar" method="GET">
                    {{--@csrf--}}
                    <div class="input-field">
                        <input id="search" type="search" name="query" required placeholder="Hesabatın adını daxil edin"
                               onfocus="$('.xclose').toggleClass('white-text')"
                               onblur="$('.xclose').toggleClass('white-text')">
                        <label class="label-icon" for="query"><i
                                    class="material-icons white-text xclose">search</i></label>
                        <i class="material-icons white-text xclose"
                           onclick="window.location.href = '/dashboard/hesabatlar';">close</i>
                    </div>
                </form>
            </div>
        </nav>
    </div>
    @if($hesabatlar[0]==null)
        <div class="row center">
            <h3 class="red-text">Hesabat yoxdur!</h3>
        </div>
        @else
            <div class="row center">
                <h5 class="green-text">Hesabat sayı: {{$hesabatlar[0]->count()}}</h5>
            </div>
    @endif
<div class="row" >
    @foreach($hesabatlar as $hesabat)
        <div class="row">
            <div class="col s12">
                <div class="card ">
                    <div class="card-content" id="{{$hesabat->id}}">
                        <center><span class="card-title center " style="text-align: center"><b><h4>{{$hesabat->hesab_ad}}</h4></b></span></center>
                       {!! $hesabat->html !!}
                    </div>
                    <div class="row" style="padding-bottom: 15px;padding-left: 20px;">
                        <div class="col s12 m6">
                            <button class="btn-flat waves-ripple" onclick="PrintElem('{{$hesabat->id}}')">Print <i
                                        class="material-icons tiny">print</i></button>
                            <a class="btn-flat waves-ripple waves-red red-text" href="/dashboard/hesabatlar/sil/{{$hesabat->id}}" >
                                <span class="red-text">Sil</span> <i class="material-icons tiny red-text">delete</i></a>
                            <a class="btn-flat waves-ripple" onclick="$('table').attr('id','printableTable');exportToExcel('printableTable')">Excell <i
                                        class="material-icons tiny">insert_drive_file</i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="row center">
    {{$hesabatlar->links()}}
</div>