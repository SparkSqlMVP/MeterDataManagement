@extends('layouts.master')
@section('title','Meter Data')

@section('body')
<div class="table-responsive text-center">
			{{ csrf_field() }}
			<table  id="table" class="display" style="width:100%">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">mfrs.</th>
						<th class="text-center">Image</th>
						<th class="text-center">OCR</th>
						<th class="text-center">Meter</th>
						<th class="text-center">Location</th>
						<th class="text-center">UploadTime</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				@foreach($data as $item)
				<tr class="item{{$item->id}}">
					<td>{{$item->id}}</td>
					<td>{{$item->DeviceSN}}</td>
					<td>
                    <img id="i" src="<?php echo(asset("/Images/".substr($item->ImagePath,0,strrpos($item->ImagePath,"_"))."/".
            substr($item->ImagePath, strrpos($item->ImagePath,"_")+1))) ?>"
             width="60" height="40" style="cursor: pointer;" border="1" onclick="PopImage('{{$item->ImagePath}}')" alt="隐藏"/>
                    </td>
					<td><?php echo(substr($item->OCRText,0,20)).'...' ?></td>
					<td>{{$item->MeterValue}}</td>
					<td>
						<?php echo(substr($item->geography,0,30)).'...' ?>
					</td>
					<td>{{$item->ctime}}</td>
					<td><button class="edit-modal btn btn-info"
							data-info="{{$item->id}};{{$item->DeviceSN}};{{$item->ImagePath}};{{$item->OCRText}};{{$item->MeterValue}};{{$item->geography}};{{$item->ctime}}">
							<span class="glyphicon glyphicon-edit"></span> Edit
						</button>
						<button class="delete-modal btn btn-danger"
							data-info="{{$item->id}};{{$item->DeviceSN}};{{$item->ImagePath}};{{$item->OCRText}};{{$item->MeterValue}};{{$item->geography}}">
							<span class="glyphicon glyphicon-trash"></span> Delete
						</button></td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title pull-left"></h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label class="control-label col-sm-2" for="id">Id</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="fid" disabled>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-2" for="mfrs">mfrs.</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="mfrs" disabled>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-2" for="Image">Image</label>
							<div class="col-sm-10">
								<img src="" alt="" class="img-thumbnail" id="Image" disabled>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-2" for="OCR">OCR</label>
							<div class="col-sm-10">
								<textarea class="form-control" aria-label="With textarea" id="OCR" disabled></textarea>
							</div>
						</div>
						<!--
						<p class="email_error error text-center alert alert-danger hidden"></p>
						<div class="form-group">
							<label class="control-label col-sm-2" for="gender">Gender</label>
							<div class="col-sm-10">
								<select class="form-control" id="gender" name="gender">
									<option value="" disabled selected>Choose your option</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
						</div>
						-->
						<div class="form-group">
							<label class="control-label col-sm-2" for="Meter">Meter</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="Meter">
							</div>
						</div>
						<p class="Meter_error error text-center alert alert-danger hidden"></p>

						<div class="form-group">
							<label class="control-label col-sm-2" for="Location">Location</label>
							<div class="col-sm-10">
								<!--<input type="text" class="form-control" id="Location">-->
								<textarea class="form-control" aria-label="With textarea" id="Location" disabled></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-2" for="UploadTime">UploadTime</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="UploadTime" disabled>
							</div>
						</div>

					</form>

					<div class="deleteContent">
						Are you Sure you want to delete <span class="dname"></span> ? <span
							class="hidden did"></span>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn actionBtn" data-dismiss="modal">
							<span id="footer_action_button" class='glyphicon'> </span>
						</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">
							<span class='glyphicon glyphicon-remove'></span> Close
						</button>
					</div>
				</div>
			</div>
	</div>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
                    "order": [[0, "desc"]]
                });
    } );
  </script>

	<script>
        $(document).on('click', '.edit-modal', function() {
            $('#footer_action_button').text("Update");
            $('#footer_action_button').addClass('glyphicon-check');
            $('#footer_action_button').removeClass('glyphicon-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').removeClass('delete');
            $('.actionBtn').addClass('edit');
            $('.modal-title').text('Edit');
            $('.deleteContent').hide();
            $('.form-horizontal').show();
            var stuff = $(this).data('info').split(';');
            fillmodalData(stuff)
            $('#myModal').modal('show');
        });
        $(document).on('click', '.delete-modal', function() {
            $('#footer_action_button').text("Delete");
            $('#footer_action_button').removeClass('glyphicon-check');
            $('#footer_action_button').addClass('glyphicon-trash');
            $('.actionBtn').removeClass('btn-success');
            $('.actionBtn').addClass('btn-danger');
            $('.actionBtn').removeClass('edit');
            $('.actionBtn').addClass('delete');
            $('.modal-title').text('Delete');
            $('.deleteContent').show();
            $('.form-horizontal').hide();
            var stuff = $(this).data('info').split(';');
            $('.did').text(stuff[0]); // condition
            $('.dname').html(stuff[1] +" "+stuff[2]); 
            $('#myModal').modal('show');
        });
    function fillmodalData(details){
        $('#fid').val(details[0]);
        $('#mfrs').val(details[1]);

		$('#Image').attr('src',"/images/"+details[2].substring(0,details[2].indexOf("_"))+"/"+
					details[2].substring(details[2].indexOf("_")+1)
		);
        $('#OCR').val(details[3]);
        $('#Meter').val(details[4]);
        $('#Location').val(details[5]);
        $('#UploadTime').val(details[6]);
    }
        $('.modal-footer').on('click', '.edit', function() {
            $.ajax({
                type: 'post',
                url: '/editItem',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $("#fid").val(),
                    'Meter': $('#Meter').val()
                },
                success: function(data) {
					console.log(data);
                    if (data.errors){
                        $('#myModal').modal('show');
                        if(data.errors.Meter) {
                            $('.Meter_error').removeClass('hidden');
                            $('.Meter_error').text("Meter must be a valid value !");
                        }
                    }
                    else {
                        $('.error').addClass('hidden');
						$('.item' + data[0].id).replaceWith("<tr class='item" + data[0].id + "'><td>" +
								data[0].id + "</td><td>" + data[0].DeviceSN +
								"</td><td><img src=\"/images/"+data[0].ImagePath.substring(0,data[0].ImagePath.indexOf("_"))+"/"+
								data[0].ImagePath.substring(data[0].ImagePath.indexOf('_')+1)+ "\" width=\"60\" height=\"40\" style=\"cursor: pointer;\" border=\"1\" onclick=\"PopImage('{{$item->ImagePath}}')\" alt=\"隐藏\"/> </td><td>" + data[0].OCRText.substring(0,20) + "...</td><td>" +
								data[0].MeterValue + "</td><td>" + data[0].geography.substring(0,30) + "...</td><td>" + data[0].ctime +
								"</td><td><button class='edit-modal btn btn-info' data-info='" + data[0].id+";"+data[0].DeviceSN+";"+data[0].ImagePath+";"+data[0].OCRText+";"+data[0].MeterValue+";"+data[0].geography+";"+data[0].ctime+"'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-info='" + data[0].id+";"+data[0].DeviceSN+";"+data[0].ImagePath+";"+data[0].OCRText+";"+data[0].MeterValue+";"+data[0].geography+";"+data[0].ctime+"' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
						}
					}
            });
        });
        $('.modal-footer').on('click', '.delete', function() {
            $.ajax({
                type: 'post',
                url: '/deleteItem',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $('.did').text()
                },
                success: function(data) {
                    $('.item' + $('.did').text()).remove();
                }
            });
        });
    </script>


@endsection