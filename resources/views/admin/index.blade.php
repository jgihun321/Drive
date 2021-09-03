@extends('layout.mainlayout')

@section('title',"은지네 드라이브")

@section('body')

    <! 추가 스크립트 로드>
    <script src="{{ asset('/js/circle-progress.js') }}"></script>
    <script src="{{ asset('/js/admin.js') }}"></script>
    <! 추가 스크립트 로드>


    <style type="text/css" media="all">
        .middle {
            /* 이하 필수 설정 */
            position: absolute; left: 50%; top: 50%;
            transform: translate(-50%, -50%); text-align: center;
        }
    </style>


    <div class="container">



        <ul class="nav nav-tabs mt-5">
            <li class="nav-item">
                @if (Session::get('active') == "system" || !Session::has('active'))
                <a class="nav-link active" data-toggle="tab" href="#system">시스템 상태</a>
                @else
                <a class="nav-link" data-toggle="tab" href="#system">시스템 상태</a>
                @endif
            </li>
            <li class="nav-item">
                @if (Session::get('active') == "drive")
                    <a class="nav-link active" data-toggle="tab" href="#drive">드라이브 관리</a>
                @else
                    <a class="nav-link" data-toggle="tab" href="#drive">드라이브 관리</a>
                @endif
            </li>
            <li class="nav-item">
                @if (Session::get('active') == "securitydir")
                <a class="nav-link active" data-toggle="tab" href="#securitydir">보안 폴더 관리</a>
                @else
                <a class="nav-link" data-toggle="tab" href="#securitydir">보안 폴더 관리</a>
                @endif
            </li>
        </ul>

        <div class="tab-content">

            @if (Session::get('active') == "drive")
            <div class="tab-pane fade show active" id="drive">
            @else
                <div class="tab-pane fade" id="drive">
            @endif
                <div class="container mt-5">
                    <table class="table">
                        <tr>
                            <th>현재 로드된 드라이브</th>
                            <th>서버에 존재하는 드라이브</th>
                        </tr>
                        <tr>
                            <td>
                                @for($i=0;$i<count($DriveList);$i++)
                                    <form class="form" action="/admin/drive" method="post">
                                        <input type="hidden" id="drive" name="drive" value="{{$DriveList[$i]["Name"]}}">
                                        <input type="hidden" id="type" name="type" value="2">
                                        @csrf
                                    {{$DriveList[$i]["Name"]}}<span class="float-right"><button class="btn btn-primary">삭제</button></span>
                                    </form>
                                    <br>
                                @endfor
                            </td>
                            <td>
                                @foreach($ServerDriveList as $list)
                                    <form class="form" action="/admin/drive" method="post">
                                        <input type="hidden" id="drive" name="drive" value="{{$list}}">
                                        <input type="hidden" id="type" name="type" value="1">
                                        @csrf
                                    {{$list}} <span class="float-right"><button class="btn btn-primary">추가</button></span>
                                    </form>
                                    <br>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            @if (Session::get('active') == "securitydir")
            <div class="tab-pane fade show active" id="securitydir">
            @else
            <div class="tab-pane fade" id="securitydir">
            @endif

                <div class="container mt-5">
                    <table class="table">
                        <tr>
                            <th>보안 폴더 목록</th>
                            <th>디렉토리 리스트</th>
                        </tr>
                        <tr>
                            <td width="50%">
                                @foreach($SecurityDirList as $list)
                                    <form class="form" action="/admin/security" method="post">
                                        <input type="hidden" id="path" name="path" value="{{$list}}">
                                        <input type="hidden" id="type" name="type" value="2">
                                    {{$list}}
                                    @csrf
                                    <span class="float-right"><button class="btn btn-primary">삭제</button></span>
                                    </form>
                                    <br>
                                @endforeach
                            </td>
                            <td width="50%">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" id="security-frame" name="security-frame" src="/admin/drive/jgihun321" scrolling="yes"></iframe>
                                </div>
                                <span class="float-right"><button class="btn btn-primary" onclick="addSecurity();">추가</button></span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>


            @if (Session::get('active') == "system" || !Session::has('active'))
                <div class="tab-pane fade active show" id="system" name="system">
            @else
                <div class="tab-pane fade" id="system">
            @endif

                <div class="container mt-5">

                    <div name="json_data" id="json_data">
                    <h2>가동시간 : </h2>
                    </div>
                    <br>
                        <div class="row">
                            <div class = "col-sm-6 col-md-4">
                                <h2>CPU 사용률</h2>
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div id="cpu_circle" class="cpu_circle">
                                            <div class="middle">
                                                <h2><strong></strong></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-sm-6 col-md-4">

                                <h2>메모리 사용률</h2>
                                <div class="card">
                                    <div class="card-body">
                                        <div id="mem_circle" class="mem_circle embed-responsive-item">
                                            <div class="middle">
                                                <h2><strong></strong></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <br><br>
                        <button class="btn btn-primary" onclick="RebootServer()">재부팅</button>
                </div>

            </div>

        </div>


    </div>


@endsection


<script>
@section('script')

    let timer = 0;

@if (Session::get('active') == "system" || !Session::has('active'))
    getInfo();
@endif


$( window ).resize( function() {
    $('.cpu_circle').circleProgress({
        size : $(".card-body").width()
    });
    $('.mem_circle').circleProgress({
        size : $(".card-body").width()
    });
} );


$('.nav-tabs a[href="#system"]').on('shown.bs.tab',function(e){

    $('.cpu_circle').circleProgress({
        size : $(".card-body").width()
    });

    $('.mem_circle').circleProgress({
        size : $(".card-body").width()
    });

    getInfo();
});

$('.nav-tabs a[href="#drive"]').on('shown.bs.tab',function(e){
    stopInfo();
});

$('.nav-tabs a[href="#securitydir"]').on('shown.bs.tab',function(e){
    stopInfo();
});

@endsection
</script>
