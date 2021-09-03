@extends('layout.mainlayout')

@section('title',"은지네 드라이브")

@section('body')

    <style>
        .table-borderless td,
        .table-borderless th {
            border: 0;
        }

    </style>

<div class="container">


    <table class="table mt-5 table-hover table-borderless">
        <tr onclick="GoBack();">
            <td colspan="2"><center>
                <img src="https://image.flaticon.com/icons/png/512/21/21201.png" width="20" height="20"></center>
            </td>
        </tr>

        <tr>
            <td width="50%">

@switch(strtolower($File[0]['extension']))
    @case("mp4")
    @case("avi")
    @case("wmv")
    @case("mov")
    @case("mkv")
        <img src="https://image.flaticon.com/icons/png/512/1179/1179120.png" width="300" height="300">
    @break


    @case("mp3")
    @case("m4a")
    @case("wav")
        <img src="https://image.flaticon.com/icons/png/512/1262/1262052.png" width="300" height="300">
    @break

    @case("jpeg")
    @case("jpg")
    @case("bmp")
    @case("png")
    @case("gif")
        <img src="https://image.flaticon.com/icons/png/512/3342/3342137.png" width="300" height="300">
    @break

    @case("zip")
    @case("alz")
    @case("7z")
    @case("egg")
    @case("iso")
    @case("img")
    @case("pkg")
        <img src="https://image.flaticon.com/icons/png/512/33/33284.png" width="300" height="300">
    @break

    @case("xls")
    @case("xlsx")
        <img src="https://image.flaticon.com/icons/png/512/1/1396.png" width="300" height="300">
    @break


    @case("ppt")
    @case("pptx")
        <img src="https://image.flaticon.com/icons/png/512/732/732074.png" width="300" height="300">
    @break

    @case("txt")
    @case("hwp")
    @case("doc")
    @case("docx")
    @case("ini")
    @case("conf")
    @case("smi")
        <img src="https://image.flaticon.com/icons/png/512/2911/2911213.png" width="300" height="300">
    @break

    @case("exe")
        <img src="https://image.flaticon.com/icons/png/512/29/29482.png" width="300" height="300">
    @break


    @default
        <img src="https://image.flaticon.com/icons/png/512/2521/2521768.png" width="300" height="300">
    @break

@endswitch
            </td>

            <td width="50%">
                <form class="form-inline" method="POST" action="/rename">@csrf
                이름 : <input class="form-control form-inline w-50 ml-1" id="name" name="name" type="text" value="{{$File[0]['name']}}"> <button type="summit" class="form-control btn btn-primary ml-1">변경</button>
                <input type="hidden" id="path" name="path" value="{{$File[0]['dir']}}">
                <input type="hidden" id="oriName" name="oriName" value="{{$File[0]['name']}}">
                </form>
                <br>
                경로 : {{$File[0]['dir']}}
                <br><br>
                생성 시간 : {{$File[0]['mtime']}}
                <br><br>
                수정 시간 : {{$File[0]['ctime']}}
                <br><br>
                용량 : {{number_format($File[0]['size']/1024/1024,2)}}MB

                <br>

            </td>
        </tr>
    </table>


    <center>
        <div class="mt-5">
            <button class="btn btn-primary" onclick='location.href="{{str_replace("drive","download",$_SERVER['REQUEST_URI'])}}"'>다운로드</button>
            <button class="btn btn-danger" onclick='DeletePopup("{{$File[0]['name']}}",2);'>삭제</button>
        </div>
    </center>

</div>


@endsection
