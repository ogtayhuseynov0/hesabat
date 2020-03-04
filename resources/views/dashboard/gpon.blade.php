<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title center">Xidmətlər mənzillər üzrə</span>
                <div class="row">
                   <form method="post" action="/dashboard/statistika/xidmetevler">
                       {!! csrf_field() !!}
                    <div class="col s9">
                        <select id="xdmAd" name="xidmet" >
                            <option value="-22" disabled selected>Xidməti Seçin</option>
                            @foreach($xidmetler as $row)
                                <option value="{{$row->kodtarifler}}">{{$row->ad}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col s3">
                        <button id="xdmET" type="submit" class="btn">Göndər</button>
                        @isset($res)
                            <a class="btn-flat waves-ripple" onclick="exportToExcel('xidmetAll')">Excell <i
                                        class="material-icons tiny">insert_drive_file</i></a>
                        @endisset
                    </div>
                   </form>
                </div>
                @isset($res)
                <div class="row">

                    <table id="xidmetAll">
                        <thead>
                        <tr>
                            <th>NOTEL</th>
                            <th>Ad Abune</th>
                            <th>Küçə Kodu</th>
                            <th>Ev</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach($res as $row)
                                <tr>
                                    <td>{{$row->notel}}</td>
                                    <td>{{$row->adabune}}</td>
                                    <td>{{$row->kodkuce}}</td>
                                    <td>{{$row->ev}}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                @endisset

            </div>
        </div>
    </div>
</div>