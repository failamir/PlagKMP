@extends('home.base')
@section('content')
	<div class="container" style="padding-top: 20px">
	    <div class="row">    
	        <div class="col-lg-12">
	            <div class="form-horizontal">
	            	<div class="form-group">
                        <label class="col-md-4 control-label" style="color:black" for="Nom22">Chọn chủ đề</label>
                        <div class="col-md-4">
                            <input id='txtCategory' class="form-control" list="categorys" name="browser" placeholder="Kiểm tra với chủ đề">
                            <datalist id="categorys">
                                <option value="Công Nghệ Thông Tin">
                                <option value="Chính Trị">
                                <option value="Du Lịch">
                                <option value="Hoá Học">
                                <option value="Hình Học">
                                <option value="Kinh Tế">
                                <option value="Khoa Học">
                                <option value="Lịch Sử">
                                <option value="Tin Học">
                                <option value="Toán Tin">
                                <option value="Vật Lý">
                                <option value="Văn Học">
                                <option value="Thế Giới">
                                <option value="Tiểu Thuyết">
                                <option value="Xã Hội">
                            </datalist>
                        </div>
                    </div>
	            	<div class="form-group">
	            		<label class="col-md-4 control-label" style="color:black" for="Nom22">Chọn File</label>
	            		<div class="col-md-4">
		            		<div class="input-group">
							    <span class="input-group-btn">
									<button id="fake-file-button-browse" type="button" class="btn btn-default">
										<span class="glyphicon glyphicon-file"></span>
									</button>
								</span>
								<input type="file" id="files-input-upload" style="display:none">
								<input type="text" id="fake-file-input-name" disabled="disabled" placeholder="File not selected" class="form-control">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default" disabled="disabled" id="fake-file-button-upload">
										<span class="glyphicon glyphicon-upload"></span>
									</button>
								</span>
							</div>
						</div>
	            	</div>
	            	
	            	<div class="form-group">
                        <label class="col-md-4 control-label" for="send"></label>
                        <div class="col-md-4">
                            <button id="uploadFile" class="btn btn-default">Check</button>
                        </div>
                    </div>
                    <div class="result">
                        <!-- <label class="col-md-4 control-label" for="send"></label>
                        <div class="col-md-4">
                            <img id="loading" src="images/loading.gif" height="15" width="128" alt="kiểm tra bài luận của bạn ..." >
                        </div> -->
                    </div>
                    <div class="resultText">
                        
                    </div>
	            </div>
	            
	        </div>
	    </div>
	</div>
@endsection

@section('javascript')
	<script src="js/ajax.js"></script>
	<script>
		var filename = '';
        
		$('#uploadFile').click(function () {
		    upload();
		});
		function upload() {
		    var file_data = $('#files-input-upload').prop('files')[0];
		    var txtCate = $('#txtCategory').val();
		    var form_data = new FormData();
		    form_data.append('file', file_data);
		    form_data.append('txtCategory', txtCate);
		    $.ajaxSetup({
		        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
		    });
		    $('.result').addClass('form-group');
		    $('.result').html('<label class="col-md-4 control-label" for="send"></label><div class="col-md-4"><img id="loading" src="images/loading.gif" height="15" width="128">  Uploading ...</div>');
		    $.ajax({
		        url: "{{url('ajax/upload/plagiarism')}}", // point to server-side PHP script
		        data: form_data,
		        type: 'POST',
		        contentType: false,       // The content type used when sending data to the server.
		        cache: false,             // To unable request pages to be cached
		        processData: false,
		        success: function (data) {
		            if (data.fail) {
		                /*$('#result').html('<img src="plagiarism/images/error.gif"/>');*/
		                $('.result').html(data.errors['file']);
		                /*alert(data.errors['file']);*/
		            }
		            else {
		                var xml = $.parseXML(data),
					  	$xml = $( xml ),
					  	$result = $xml.find('messages');
					  	
					  	if($result.text() == 1) {
					  		$('.result').html("<span class='col-md-4 col-md-offset-4' style='color:red'>Bạn chưa chọn chủ đề</span>");
					  	}else if($result.text() == 2) {
					  		$('.result').html("<span class='col-md-4 col-md-offset-4' style='color:red'>File phải có định dạng .docx</span>");
					  	}else if($result.text() == 3) {
					  		$('.result').html("<span class='col-md-4 col-md-offset-4' style='color:red'>Chưa chọn file upload</span>");
					  	}else {
					  		
					  		$('.resultText').html("<span class='col-md-4 col-md-offset-4'>" + "<h3>Thông tin file: </h3>Tên file: " + $xml.find('fileName').text() + "<br />Kích cỡ: " + $xml.find('fileSize').text() + "<br />Định dạng: " + $xml.find('fileType').text() + "</span>");

					  		$('.result').html('<label class="col-md-4 control-label" for="send"></label><div class="col-md-4"><img id="loading" src="images/loading.gif" height="15" width="128">  Reading ...</div>');
					  		var data = new FormData();
						    data.append('fileName', $xml.find('success').text());
						    $.ajaxSetup({
						        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
						    });
					  		$.ajax({
						        url: "{{url('ajax/read/plagiarism')}}", 
						        data: data,
						        type: 'POST',
						        contentType: false,       
						        cache: false,            
						        processData: false,
						        success: function (data) {
						            if (data.fail) {
						                $('.result').html(data.errors['file']);
						            }
						            else {
						                $('.result').html(data);
						            }
						        },
						        error: function (xhr, status, error) {
						           
						        }
						    });
						    // end ajax 2
					  	}
		            }
		        },
		        error: function (xhr, status, error) {
		           /* alert(xhr.responseText);*/
		            //$('.result').html(xhr.responseText);
		        }
		    });
		    // end ajax 1
		}
	</script>
@endsection