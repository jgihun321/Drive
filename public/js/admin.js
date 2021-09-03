function RebootServer() {

    $.ajax({
        url:'/reboot',
        type: 'get',
        success : function(data){
            alert("재부팅 신호를 전송하였습니다.");
        }
    });

}


function addSecurity(){


    //let url = $('#security-frame').attr('src');
    let url = document.getElementById("security-frame").contentWindow.document.location.href

    url = url.substring(url.indexOf("/")+1,url.length);
    url = url.substring(url.indexOf("/")+1,url.length);
    url = url.substring(url.indexOf("/")+1,url.length);

    let newForm = $('<form></form>'); //set attribute (form)
    newForm.attr("name","newForm");
    newForm.attr("method","post");
    newForm.attr("action","/admin/security");
    newForm.append($('<input/>', {type: 'hidden', name: 'path', value: url }));
    newForm.append($('<input/>', {type: 'hidden', name: 'type', value: "1" }));
    newForm.appendTo('body');
    newForm.submit();


}




function getInfo(){
    timer = setInterval( function () {

        $.ajax ({

            "url" : "/api/admin/systeminfo",
            "dataType": "json",
            cache : false,
            success: function (data) {

                console.log(data);

                let json = JSON.parse(data);

                //let time = data.name;

                let cpu = json.usage_percent_cpu;
                let total_memory = (json.total_mem/1024/1024).toFixed(2);
                let used_memory = (json.used_mem/1024/1024).toFixed(2);
                let usage_percent_mem = json.usage_percent_mem;
                let uptime = json.uptime;


                $('.cpu_circle').circleProgress({
                    startAngle: -Math.PI/2 ,
                    value: cpu/100,
                    size : $(".card-body").width(),
                    animation: false,
                    fill: {
                        gradient: ["red", "orange"]
                    }
                }).ready(function(event, progress) {
                    $('.cpu_circle').find('strong').html(cpu.toFixed(2) + '<i>%</i>');
                });

                $('.mem_circle').circleProgress({
                    startAngle: -Math.PI/2 ,
                    value: usage_percent_mem/100,
                    size : $(".card-body").width(),
                    animation: false,
                    fill: {
                        gradient: ["red", "orange"]
                    }
                }).ready(function(event, progress) {
                    $('.mem_circle').find('strong').html(used_memory + 'GB <br>' + total_memory + 'GB');
                });


                //alert(cpu);
                let html = "";
                html += "가동시간 : " + uptime;
                $("#json_data").find('h2').html(html);
            }

        });

    }, 1000);

}

function stopInfo(){
 clearInterval(timer);
}


