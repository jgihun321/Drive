

function GoBack(){
    let url = window.location.href;
    url = url.substring(0,url.lastIndexOf("/"));


    //alert(url);

    if(url.substring(url.lastIndexOf("/"),url.length) == "/drive"){
        location.href = "/";
    }else{
        location.href = url;
    }
}

function DeletePopup(name,mode){

    let url = window.location.href

    url = url.substring(url.indexOf("/")+1,url.length);
    url = url.substring(url.indexOf("/")+1,url.length);
    url = url.substring(url.indexOf("/")+1,url.length);

    url =url.replace("drive","delete");

    //alert(mode);

    if(mode == "1"){
        url = encodeURI(url);
        url = "/" + url + "/" + name;

        //alert(url);
        //alert(name);

    }else if(mode == "2"){


        //url = url.substring(0,url.lastIndexOf("/"));
        url = encodeURI(url);
        url = "/" + url;

        //alert(url);
        //alert(name);

    }

    $('#deleteBtn').attr("onclick",'location.href="' + url + '";');
    $('#Delete_Modal').modal();
}


$(document).ready(function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#laravel-ajax-file-upload').submit(function(e) {
        if(!document.getElementById('file').value){
            alert("파일이 선택 되지 않았습니다.");
            return false;
        }
        $("#Upload_Modal").modal();
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
                alert('파일 업로드가 완료되었습니다.');
                console.log(data);
                location.reload();
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});

function setProgress(per) {
    $progressBar.val(per);
}
