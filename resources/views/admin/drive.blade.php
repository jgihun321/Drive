<!DOCTYPE html>
<html lang="ko">
<head>
    <! 부트스트랩 로드>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <! 부트스트랩 로드>

    <! 추가 스크립트 로드>
    <script src="{{ asset('/js/common.js') }}"></script>
    <! 추가 스크립트 로드>




</head>

<div class = "container">
    <table class="table table-hover">
        @if($_SERVER['REQUEST_URI'] != "/admin/drive/jgihun321")
        <tr onclick="GoBack();">
            <td width = "5%">
                <img src="https://image.flaticon.com/icons/png/512/21/21201.png" width="20" height="20">
            </td>
            <td width = "95%">
                ..
                <br>
            </td>
            <td width = "5%"></td>
        </tr>
        @endif
        @foreach($DirList as $list)
            <tr class="clickable-row" data-href="{{$_SERVER['REQUEST_URI']}}/{{$list}}">
                <td width = "5%">
                    <img src="https://image.flaticon.com/icons/png/512/1383/1383970.png" width="20" height="20">
                </td>
                <td width = "95%">
                    {{$list}}
                    <br>
                </td>

                <td width = "5%"></td>



            </tr>
    @endforeach
    </table>
</div>

<script>
    //cursor:pointer
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });

</script>

<! 추가 스크립트 로드>
<script src="{{ asset('/js/drive.js') }}"></script>
<! 추가 스크립트 로드>
