    <! 에러 출력 화면>
    <div class="modal fade" id="Warning_Modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">경고</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    {!! $errors->first() !!}
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
                </div>

            </div>
        </div>
    </div>



    @if ($errors->any())
        <script>$("#Warning_Modal").modal();</script>
    @endif
    <! 에러 출력 화면>

    <! 업로드 모달>
    <div class="modal fade" id="Upload_Modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">업로드</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <progress id="progressBar" value="0" max="100" style="width:100%"></progress>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button> -->
                </div>

            </div>
        </div>
    </div>

    <! 업로드 모달>


    <! 로그인 모달>
    <div class="modal fade" id="Login_Modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="/login">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">관리자 인증</h4>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">

                        @csrf
                        <input type='password' class='form-control' placeholder='관리자 인증 번호' id='password' name = 'password'><br>
                        <label class="form-check-label ml-4">
                            <input class="form-check-input" type="checkbox" id="autologin" name="autologin"> 자동 로그인
                        </label>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">전송</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <! 로그인 모달>


    <! 새폴더 모달>
    <div class="modal fade" id="NewDir_Modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="/newdir" id="newdir" name="newdir">
                @csrf

                <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">새 폴더</h4>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type='text' class='form-control' placeholder='이름' id='name' name = 'name'>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button> -->
                        <button type="submit" class="btn btn-primary">생성</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <! 새폴더 모달>

    <! 삭제 모달>
    <div class="modal fade" id="Delete_Modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">경고</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    정말 삭제 하시겠습니까?
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button> -->
                    <button type="button" class="btn btn-danger" id="deleteBtn" name="deleteBtn">삭제</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">취소</button>
                </div>
            </div>
        </div>
    </div>

    <! 삭제 모달>


    <! 폴더 삭제 모달>
    <div class="modal fade" id="DeleteDir_Modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">경고</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    정말 삭제 하시겠습니까?
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button> -->
                    <button type="button" class="btn btn-danger" onclick='location.href="{{str_replace("drive","delete",$_SERVER['REQUEST_URI'])}}"'>삭제</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">취소</button>
                </div>
            </div>
        </div>
    </div>

    <! 폴더 삭제 모달>


