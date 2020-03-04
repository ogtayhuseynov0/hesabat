@if(request()->segment(count(request()->segments()))=="elave")
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content ">
                    <span class="card-title center">Əlavə ediləcək məlumatı seçin</span>
                    <div class="collection">
                        <a href="/dashboard/elave/xidmet" class="collection-item">Xidmətlərin əlavəsi</a>
                        <a href="/dashboard/elave/xidmetdeyish" class="collection-item">Xidmətlərin dəyişməsi</a>
                        <a href="/dashboard/elave/flkart" class="collection-item">FLKart və FLKartX əlavə et.</a>
                        <a href="/dashboard/elave/flkartsil" class="collection-item">FLKart və FLKartX ayları sil.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if(request()->segment(count(request()->segments()))=="xidmetdeyish")
    @php
        $xidmetler = \App\Xidmet::all()
    @endphp
    <div class="row">
        <div class="col s12">
            <div class="card">
                @if (\Session::has('success'))
                    <div class="row">
                        {{--{!! \Session::get('success') !!}--}}
                        <div class="card-panel green lighten-2">{!! \Session::get('success') !!}</div>
                    </div>
                @endif
                <div class="card-content ">
                    <span class="card-title center">Xidmətləri Dəyiş</span>
                    <table>
                        <thead>
                        <tr>
                            <th>AD</th>
                            <th>Kodtariflər</th>
                            <th>FlkartX</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($xidmetler as $xidmet)
                        <tr>
                            <form method="post" action="/dashboard/elave/xidmetdeyish">
                                {!! csrf_field() !!}
                                <input type="hidden" name="id" value="{{$xidmet->id}}"/>
                            <td> <input placeholder="Xidmətin Adı" id="ad" type="text" name="ad" required value="{{$xidmet->ad}}"></td>
                            <td>
                                <textarea id="kodtarifler" class="materialize-textarea" required name="kodtarifler" >{{$xidmet->kodtarifler}}</textarea>
                            </td>
                            <td>
                                <p>
                                    <label>
                                        <input type="checkbox" name="isX" @if($xidmet->isX) ? checked : @endif />
                                        <span>FlkartX</span>
                                    </label>
                                </p>
                            </td>
                            <td>
                                {{--href="/dashboard/elave/xidmet/{{$xidmet->id}}--}}
                                <a href="#modal1" class="red-text  modal-trigger" onclick="xdmAD('{{$xidmet->ad}}','/dashboard/elave/xidmet/{{$xidmet->id}}')">Sil</a>
                                <button class="btn-flat green-text" type="submit">&nbsp;&nbsp; Deyish</button>
                            </td>
                            </form>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4 id="modalAd">Modal Header</h4>
                <p >Silməyə razısız?</p>
            </div>
            <div class="modal-footer">
                <a href="#!" id="test2" class="modal-close waves-effect waves-red btn red">Bəli</a>
                <a href="#!" class="modal-close waves-effect waves-green  green btn">Xeyr</a>
            </div>
        </div>
    </div>
@endif
@if(request()->segment(count(request()->segments()))=="xidmet")
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title center">Xidmət Əlavəsi</span>
                    @if (\Session::has('success'))
                        <div class="row">
                            {{--{!! \Session::get('success') !!}--}}
                            <div class="card-panel green lighten-2">{!! \Session::get('success') !!}</div>
                        </div>
                    @endif
                    <form method="post" action="/dashboard/elave/xidmet">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="input-field col s12">
                                <input placeholder="Xidmətin Adı" id="ad" type="text" class="validate" name="ad" required>
                                <label for="ad">Xidmətin Adı</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <textarea id="kodtarifler" class="materialize-textarea" required name="kodtarifler"></textarea>
                                <label for="kodtarifler">Xidmətin kodları. Vergüllə ayrılmış. 555,112,365,136</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <p>
                                    <label>
                                        <input type="checkbox" name="isX"/>
                                        <span>FlkartX</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <button class="btn" type="submit" style="width: 100%;" name="submit">Göndər</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
@if(request()->segment(count(request()->segments()))=="flkart")
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content ">
                    @if (\Session::has('success'))
                        <div class="row" id="sucMsg">
                            {{--{!! \Session::get('success') !!}--}}
                            <div class="card-panel green lighten-2">{!! \Session::get('success') !!}</div>
                        </div>
                    @endif
                    <span class="card-title center">FLKart və FLKartX əlavə et.</span>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <select>
                                <option value="" disabled selected>Mövcud olan aylar:</option>
                                @foreach($dataTable as $data)
                                    <option value="1" DISABLED>{{substr($data,0,2)}}-20{{substr($data,2,4)}}</option>
                                @endforeach
                            </select>
                            <label>Mövcud olan aylar:</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <select disabled>
                                <option value="1" DISABLED selected>0{{substr($dataTable[sizeof($dataTable)-1],0,2)+1}}-20{{substr($data,2,4)}}</option>
                            </select>
                            <label>Əlavə olunmalı ay:</label>
                        </div>
                    </div>
                    <div class="row">
                        <form action="{{route('flkartpost')}}" method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" name="to" value="0{{substr($dataTable[sizeof($dataTable)-1],0,2)+1}}{{substr($data,2,4)}}">

                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>FLKart</span>
                                    <input type="file" name="flkart">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" name="flkart">
                                </div>
                            </div>
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>FLKartX</span>
                                    <input type="file" name="flkartx">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" name="flkartx">
                                </div>
                            </div>
                            <div class="row center">
                                <div class="input-field col s12">
                                    <p>
                                        <label>
                                            <input type="checkbox" name="arxiv"/>
                                            <span>Aylıq Arxiv</span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                            <button type="submit" class="btn" id="gndr"
                                    style="width: 100%" onclick="$('#sucMsg').addClass('hide');$('#progress').toggleClass('hide'); $('#gndr').addClass('hide')">Göndər</button>

                            <div class="progress hide" id="progress" style="height: 15px">
                                <div class="indeterminate" ></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if(request()->segment(count(request()->segments()))=="flkartsil")
    <div class="row">
        <div class="col s12">
            <div class="card">
                @if (\Session::has('success'))
                    <div class="row" id="sucMsg">
                        {{--{!! \Session::get('success') !!}--}}
                        <div class="card-panel green lighten-2">{!! \Session::get('success') !!}</div>
                    </div>
                @endif
                <div class="card-content ">
                    <span class="card-title center">FLKart və FLKartX Sil</span>
                    <table>
                        <thead>
                        <tr>
                            <th>Aylar</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($dataTable as $table)
                            <tr>
                                <td>{{substr($table,0,2)}}-20{{substr($table,2,4)}}</td>
                                <td>
                                    <a href="#modal1" class="red-text  modal-trigger"
                                       onclick="xdmAy('{{substr($table,0,2)}}-20{{substr($table,2,4)}}','/dashboard/elave/flkartsil/{{$table}}')"
                                    >Sil</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div id="modal1" class="modal">
                            <div class="modal-content">
                                <h4 id="modalAy">Modal Header</h4>
                                <p >Flkart Və FlkartX Silməyə razısız?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" id="test3" class="modal-close waves-effect waves-red btn red">Bəli</a>
                                <a href="#!" class="modal-close waves-effect waves-green  green btn">Xeyr</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<script>
    function xdmAD(ads,bsd) {
        $('#modalAd').html(ads);
        $('#test2').attr("href", bsd);
    }
    function xdmAy(ads,bsd) {
        $('#modalAy').html(ads);
        $('#test3').attr("href", bsd);
    }
</script>