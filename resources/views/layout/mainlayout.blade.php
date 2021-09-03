<!DOCTYPE html>
<html lang="ko">
<head>
    <! 부트스트랩 로드>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <! 부트스트랩 로드>





    <title>@yield('title')</title>



</head>

<style>
    /* 가로 스크롤 안보이게 하기 ▼▼▼ */
    html {
        overflow-x: hidden;

    }

    /* 상단바랑 메인화면 안겹치게 및 가로스크롤 안보이게 하기 ▼▼▼ */
    body { padding-top: 70px; overflow-x:hidden}

    ::-webkit-scrollbar {display:none;}



    /* 모바일 PC 글씨 크기 조절 ▼▼▼ */
    @media only screen and (max-width: 1200px)
    {
        html  {
            font-size: 0.8rem; // you can also use px here...
        }


    }

    @media only screen and (min-width: 1200px) {
        html {
            font-size: 1rem; // you can also use px here...
        }
    }
    /* 모바일에서만 리스트 안보이게 하기 ▼▼▼ */





</style>



<body>

<! 팝업창>
@include("layout.popup")
<! 팝업창>

<! 본문>

<div class="container-fluid">

    @if(session()->get('admin') != "true")

    <div class ="fixed-top">
        <span class="float-right">
            <button class="btn" onclick="$('#Login_Modal').modal();">관리자 로그인</button>
        </span>
        <br>
    </div>

    @else
        <div class ="fixed-top">
            <span class="float-right">
                <button class="btn" onclick="location.href='/admin'">관리 메뉴</button>
                <button class="btn" onclick="BootingComputer()">데스크탑 부팅</button>
                <button class="btn" onclick="location.href='/logout'">관리자 로그아웃</button>
            </span>
            <br>
        </div>
    @endif


<h1 align="center">은지네 드라이브</h1>


<div class="container-fluid">
@yield('body')

</div>

</div>

<! 본문>


<script src="{{ asset('/js/drive.js') }}"></script>
<script src="{{ asset('/js/common.js') }}"></script>


</body>


<! 컨텐츠 선택시 링크로 이동>
<script>
    //cursor:pointer
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });

</script>
<! 컨텐츠 선택시 링크로 이동>



<! 전용 스크립트>
<script>
    @section('script')
    @show
</script>
<! 전용 스크립트>



