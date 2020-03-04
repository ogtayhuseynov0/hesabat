<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Baktelecom') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/style2.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>

    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">--}}


    <style>
        .activem{
            background-color: #F2F2F2;
        }
        .mbody{
            padding-left: 120px;
        }
        @media only screen and (max-width : 992px) {
            .mbody{
                padding-left: 0;
            }
        }
        .coloredClass{
            background: #31A4F3; /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #4CAF50, #31A4F3,#F44336); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #4CAF50, #31A4F3,#F44336); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .disabledLink {
            color: currentColor;
            cursor: not-allowed;
            opacity: 0.5;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="navbar-fixed" style="z-index: 9999">
    <nav class="white">
        <div class="container">
            <div class="nav-wrapper">
                <a class="btn-floating btn-small waves-effect waves-light  dropdown-trigger hide-on-large-only"
                   href='#' data-target='dropdown1'><i class="material-icons">arrow_drop_down_circle</i></a>
                <!-- Dropdown Structure -->
                <ul id='dropdown1' class='dropdown-content'>
                    <li class=""><a href="/">Ana Sehife</a></li>
                    <li class=""><a href="/">Dashboard</a></li>
                </ul>

                <a id="logo-container" href="#" class="brand-logo black-text">
                    <b class="">Hesabat</b>
                </a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li class="{{request()->segment(count(request()->segments()))=="" ? "activem": ""}}"><a href="/">Ana Sehife</a></li>
                    <li class="{{request()->segment(count(request()->segments()))=="dashboard" ? "activem": ""}}"><a href="/dashboard">Dashboard</a></li>
                </ul>

            </div>

        </div>
    </nav>
</div>
<div class="container">
    @yield('content')
</div>
<script src="{{ asset('js/materialize.min.js') }}" defer></script>
<script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/Chart.min.js')}}" charset="utf-8"></script>
<script src="{{asset('js/chartjs-plugin-datalabes.min.js') }}" type="text/javascript"></script>
{{--<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>--}}

<script>
    Chart.defaults.global.defaultFontColor = 'Black';
    // M.AutoInit();
    // document.addEventListener('DOMContentLoaded', function() {
    //     var elems = document.querySelectorAll('.modal');
    //     var instances = M.Modal.init(elems, options);
    // });
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.datepicker');
        var instances = M.Datepicker.init(elems, {
            container: 'body',
            format: 'yy-mm-dd',
            maxDate: new Date(),
            minDate: new Date("2019-01-01"),
            i18n : {
                cancel: 'Bağla',
                clear: 	'Təmizlə',
                done:	'Hazır',
                months: [
                        'Yanvar',
                        'Fevral',
                        'Mart',
                        'Aprel',
                        'May',
                        'İyun',
                        'İyul',
                        'Avgust',
                        'Sentyabr',
                        'Oktyabr',
                        'Noyabr',
                        'Dekabr'
                    ],
                monthsShort: [
                        'Yan',
                        'Fev',
                        'Mar',
                        'Apr',
                        'May',
                        'İyn',
                        'İyl',
                        'Avg',
                        'Sen',
                        'Okt',
                        'Noy',
                        'Dek'
                    ],
                weekdays: [
                        'Bazar',
                        'Bazar Ertəsi',
                        'Çərşənbə axşamı',
                        'Çərşənbə',
                        'Cümə axşamı',
                        'Cümə',
                        'Şənbə'
                    ],
                weekdaysShort: [
                        'Baz',
                        'BazE',
                        'ÇərAx',
                        'Çər',
                        'CümAx',
                        'Cüm',
                        'Şən'
                    ],
                weekdaysAbbrev: 	['B','BE','ÇA','Ç','CA','C','Ş']
            }
        });
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems, options);
    });
    $(document).ready(function(){
        $('select').formSelect();
        $('.dropdown-trigger').dropdown();
        $('.sidenav').sidenav();
        $('.modal').modal();
        // $('table').DataTable({
        //     paging: false,
        //     select: true,
        //     "orderMulti": true
        // });
    });
</script>
</body>
</html>
