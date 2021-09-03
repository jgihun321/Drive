<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Ajax File Upload Example - Tutsmake.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
        .container{
            padding: 0.5%;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
    <a class="navbar-brand" href="{{ url('/') }}">Tutsmake</a>
</nav>
<div class="container mt-4">
    <div class="row">
        <div class="col-sm-12">
            <h4>File Upload using Ajax in Laravel</h4>
        </div>
    </div>
    <hr />
    <form method="POST" enctype="multipart/form-data" id="laravel-ajax-file-upload" action="javascript:void(0)" >
                <div class="form-group">
                    <input type="file" name="file" placeholder="Choose File" id="file">
                    <span class="text-danger">{{ $errors->first('file') }}</span>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>

        <progress id="progressBar" value="0" max="100" style="width:100%"></progress>

    </form>

    <form method="POST" enctype="multipart/form-data" action="/upload" >
        @csrf
        <div class="form-group">
            <input type="hidden" id="path" name="path" value="JGH'SHDD/미디어/">
            <input type="file" name="file" placeholder="Choose File" id="file">
            <span class="text-danger">{{ $errors->first('file') }}</span>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>


    </form>

</div>
</body>
<script type="text/javascript">
    $(document).ready(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#laravel-ajax-file-upload').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: "/upload",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                xhr: function() { //XMLHttpRequest 재정의 가능
                    let xhr = $.ajaxSettings.xhr();
                    xhr.upload.onprogress = function(e) { //progress 이벤트 리스너 추가
                        let percent = e.loaded * 100 / e.total;
                        setProgress(percent);
                    };
                    return xhr;
                },
                success: (data) => {
                    this.reset();
                    alert('File has been uploaded successfully');
                    console.log(data);
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
    });
    let $progressBar = $("#progressBar");
    function setProgress(per) {
        $progressBar.val(per);
    }

</script>
</html>
