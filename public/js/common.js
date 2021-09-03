function BootingComputer() {

    $.ajax({
        url:'/boot',
        type: 'get',
        success : function(data){
            alert("부팅 신호를 전송하였습니다.");
        }
    });

}
