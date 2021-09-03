@extends('layout.mainlayout')

@section('title',"은지네 드라이브")

@section('body')



<div class = "container mt-5">

    <table class="table table-hover">
        @foreach($DriveList as $List)
            <tr class='clickable-row' data-href="/drive/{{$List["Name"]}}">
                <td width = "5%">
                    <img src="https://image.flaticon.com/icons/png/512/3076/3076612.png" width="100" height="100">
                </td>
                <td width = "95%">
                    <h3>{{$List["Name"]}}</h3>
                    <br>
                    <div class="progress">
                        <div class="progress-bar" style="width:{{100-(number_format($List["FreeSpace"]/$List["TotalSpace"]*100))}}%"></div> &nbsp;&nbsp;{{100-(number_format($List["FreeSpace"]/$List["TotalSpace"]*100))}}%
                    </div><br>
                    {{ number_format($List["TotalSpace"],2)}}GB 중에 {{number_format(($List["FreeSpace"]),2)}}GB 남음
                </td>
            </tr>
        @endforeach
    </table>

</div>
@endsection


<script>



</script>
