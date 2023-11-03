<?php 
extract($_POST);
?>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: block
	}
</style>
<div class="container-fluid">
	<div class="col-lg-12 ">
		<form id="manage_log">
			<input type="hidden" name="type" value="<?php echo $type ?>">
			<div class="alert alert-info"><i class="fa fa-info"></i> <large><b>This Log Form is for Visitors</b></large></div>
			<div id="msg"></div>
			<div class="h-40 w-100">
				<div class="form-group">
					<label for="">Name</label>
					<input type="text" class="form-control" name="name" id="name" autofocus>
				</div>
				<div class="form-group">
					<label for="">Contact</label>
					<input type="text" class="form-control" name="contact" id="contact">
				</div>
				<div class="form-group">
					<label for="">Address</label>
					<textarea name="address" id="address" cols="30" rows="4" class="form-control"><?php echo isset($address) ? $address :'' ?></textarea>
				</div>
				<div class="form-group">
					<label for="">Transaction</label>
					<textarea name="transaction" id="transaction" cols="30" rows="4" class="form-control"><?php echo isset($transaction) ? $transaction :'' ?></textarea>
				</div>
				<div class="form-group">
					<label for="">Type of ID Presented</label>
					<input type="text" class="form-control" name="id_presented" id="id_presented">
				</div>
				<div class="form-group">
					<label for="">ID Number</label>
					<input type="text" class="form-control" name="id_no" id="id_no">
				</div>
				<div class="form-group">
					<label for="">Pass Number</label>
					<input type="text" class="form-control" name="pass_no" id="pass_no">
					<small><i>Ask for the staff for your pass number.</i></small>
				</div>
			</div>
			<div class="col-md-12"><button class="btn btn-block btn-primary btn-sm">Save</button></div>
		</form>
	</div>
</div>
<script>
	$(document).ready(function(){
	$('button,input').blur()
	setTimeout(function(){
		$("[name='id_code']").get(0).focus()
	},300)
		// $("[name='id_code']").get(0).focus()
	})

	$('#manage_log').submit(function(e){
		e.preventDefault()
        start_load()
        $('#msg').html('')
		$.ajax({
            url:'admin/ajax.php?action=save_log_visitor',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
            	resp = JSON.parse(resp)
                if(resp.status ==1){
                    alert_toast("Data successfully saved.",'success')
						setTimeout(function(){
							location.reload()
						},1000)
                }else if(resp.status  == 2){
                $('#msg').html('<div class="alert alert-danger mx-2">The pass number entered is still in logged-in status in the system.</div>')
                end_load()
                }    
            }
        })
	})
</script>