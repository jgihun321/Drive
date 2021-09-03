@extends('layout.mainlayout')

@section('title',"은지네 드라이브")

@section('body')




<div class = "container mt-5">
    <div class="form-inline float-right">
        <form class="form-inline float-right" method="POST" name="upload" enctype="multipart/form-data" id="laravel-ajax-file-upload" action="javascript:void(0)" >
            @csrf
            <div class="form-group">
                <input type="file" name="file" placeholder="Choose File" id="file">
                <span class="text-danger">{{ $errors->first('file') }}</span>
            </div>
            <button type="submit" class="btn btn-primary">업로드</button>

        </form>

        <button class="form-inline float-right btn btn-primary mb-3 ml-3" onclick="$('#NewDir_Modal').modal();">새폴더</button>

        @if(session()->get('admin') == "true")
        <button class="form-inline float-right btn btn-primary mb-3 ml-3" onclick="$('#DeleteDir_Modal').modal();">현재 폴더 삭제</button>
        @endif

    </div>




    <table class="table table-hover">
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



        @for($i = 0; $i < count($FileList) ; $i++)

            @php
                $ext = strtolower(substr($FileList[$i], strrpos($FileList[$i], '.') + 1));
            @endphp

            <tr>


                    @switch($ext)
                        @case("mp4")
                        @case("avi")
                        @case("wmv")
                        @case("mov")
                        @case("mkv")
                        <td width = "5%">
                            <img src="https://image.flaticon.com/icons/png/512/1179/1179120.png" width="20" height="20">
                        </td>
                        @break


                        @case("mp3")
                        @case("m4a")
                        @case("wav")
                        <td width = "5%">
                            <img src="https://image.flaticon.com/icons/png/512/1262/1262052.png" width="20" height="20">
                        </td>
                        @break

                        @case("jpeg")
                        @case("jpg")
                        @case("bmp")
                        @case("png")
                        @case("gif")
                        <td width = "5%">
                            <img src="https://image.flaticon.com/icons/png/512/3342/3342137.png" width="20" height="20">
                        </td>
                        @break

                        @case("zip")
                        @case("alz")
                        @case("7z")
                        @case("egg")
                        @case("iso")
                        @case("img")
                        @case("pkg")
                        <td width = "5%">
                            <img src="https://image.flaticon.com/icons/png/512/33/33284.png" width="20" height="20">
                        </td>
                        @break

                        @case("xls")
                        @case("xlsx")
                        <td width = "5%">
                            <img src="https://image.flaticon.com/icons/png/512/1/1396.png" width="20" height="20">
                        </td>
                        @break


                        @case("ppt")
                        @case("pptx")
                        <td width = "5%">
                            <img src="https://image.flaticon.com/icons/png/512/732/732074.png" width="20" height="20">
                        </td>
                        @break

                        @case("txt")
                        @case("hwp")
                        @case("doc")
                        @case("docx")
                        @case("ini")
                        @case("conf")
                        @case("smi")
                        <td width = "5%">
                            <img src="https://image.flaticon.com/icons/png/512/2911/2911213.png" width="20" height="20">
                        </td>
                        @break

                        @case("exe")
                        <td width = "5%">
                            <img src="https://image.flaticon.com/icons/png/512/29/29482.png" width="20" height="20">
                        </td>
                        @break


                        @default
                        <td width = "5%">
                            <img src="https://image.flaticon.com/icons/png/512/2521/2521768.png" width="20" height="20">
                        </td>
                        @break

                    @endswitch

                    <td width = "50%" style = "word-break:break-all">
                        {{$FileList[$i]}}
                        @if($FileSize[$i] >= 1024.00)
                            <span class="float-right">
                                {{number_format($FileSize[$i]/1024,2)}}GB
                            </span>
                        @else
                            <span class="float-right">
                                {{number_format($FileSize[$i],2)}}MB
                            </span>
                        @endif

                        <br>

                    </td>

                    <td width = "5%">
                        <div class="dropdown dropleft">
                            <img src="https://image.flaticon.com/icons/png/512/1828/1828859.png" class="dropdown-toggle "  id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" width="20" height="20">




                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @switch($ext)
                            @case("mp4")
                            @case("avi")
                            @case("wmv")
                            @case("mov")
                            @case("mkv")
                                    <a class="dropdown-item" href="{{str_replace("drive","play",$_SERVER['REQUEST_URI'])}}/{{$FileList[$i]}}">다운로드</a>
                            @break
                            @default
                                    <a class="dropdown-item" href="{{str_replace("drive","download",$_SERVER['REQUEST_URI'])}}/{{$FileList[$i]}}">다운로드</a>
                            @break
                                @endswitch

                                <a class="dropdown-item" onclick="DeletePopup('{{$FileList[$i]}}','1');">삭제</a>
                                <a class="dropdown-item" href="{{$_SERVER['REQUEST_URI']}}/{{$FileList[$i]}}">속성</a>
                            </div>
                        </div>
                    </td>

            </tr>


        @endfor
    </table>

</div>



@endsection


<script>

    @section("script")


    let uploadForm = document.forms["upload"];
    let newDirForm = document.forms["newdir"];
    let input   = document.createElement('input');
    let url = decodeURI(window.location.href) + "/";

    url = url.substring(url.lastIndexOf("/drive")+7,url.length);

    input.type   = 'hidden';
    input.name  = "path";
    input.id  = "path";
    input.value  = url;

    let input2   = document.createElement('input');

    input2.type   = 'hidden';
    input2.name  = "path";
    input2.id  = "path";
    input2.value  = url;

    uploadForm.appendChild(input);
    newDirForm.appendChild(input2);
    let $progressBar = $("#progressBar");

    @endsection

</script>


