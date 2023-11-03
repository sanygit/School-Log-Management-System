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
			<div class="alert alert-info"><i class="fa fa-info"></i> <large><b>This Log Form is for <?php echo ucwords($type) ?></b></large></div>
			<div id="msg"></div>
			<div class="h-40 w-100">
				<div class="form-group">
					<input type="text" class="form-control" name="id_code" id="id_code" autofocus>
				</div>
			</div>
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
            url:'admin/ajax.php?action=save_log',
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
                    if(resp.type == 1)
                	$('#msg').html('<div class="text-center mb-3"><h4><b>Welcome '+resp.name+'</b></h4></div>')
                	else
                	$('#msg').html('<div class="text-center mb-3"><h4><b>Thank you '+resp.name+'</b></h4></div>')

                        $("[name='id_code']").val('').focus()
                end_load()
                }else if(resp.status  == 2){
                $('#msg').html('<div class="alert alert-danger mx-2">Unkown ID Number.</div>')
                end_load()
                }    
            }
        })
	})
</script>