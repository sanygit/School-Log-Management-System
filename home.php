<?php include 'admin/db_connect.php' ?>
<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    top: 0;
}
.imgs{
		margin: .5em;
		max-width: calc(100%);
		max-height: calc(100%);
	}
	.imgs img{
		max-width: calc(100%);
		max-height: calc(100%);
		cursor: pointer;
	}
	#imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
		height: 60vh !important;background: black;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
	}
	#imagesCarousel img{
		width: auto!important;
		height: auto!important;
		max-height: calc(100%)!important;
		max-width: calc(100%)!important;
	}
    .bg-gradient-primary{
        background: rgb(119,172,233);
        background: linear-gradient(149deg, rgba(119,172,233,1) 5%, rgba(83,163,255,1) 10%, rgba(46,51,227,1) 41%, rgba(40,51,218,1) 61%, rgba(75,158,255,1) 93%, rgba(124,172,227,1) 98%);
    }
    .btn-primary-gradient{
        background: linear-gradient(to right, #1e85ff 0%, #00a5fa 80%, #00e2fa 100%);
    }
    .btn-danger-gradient{
        background: linear-gradient(to right, #f25858 7%, #ff7840 50%, #ff5140 105%);
    }
</style>

<div class="containe-fluid">
	<div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card bg-gradient-primary text-white mx-2 mb-2">
                                    <div class="card-body text-center">
                                        <h4><b>Student</b></h4>
                                    </div>
                                    <div class="card-footer p-0 pt-1 border-top border-secondary">
                                        <div class="d-flex mx-o mt-0 mb-0">
                                        <button type="button" class="btn btn-block btn-primary-gradient text-white font-weight-bold mt-0 mx-0 btn-log" data-type='students' data-log="1">Log</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-gradient-primary text-white mx-2 mb-2">
                                    <div class="card-body text-center">
                                        <h4><b>Faculty</b></h4>
                                    </div>
                                    <div class="card-footer p-0 pt-1 border-top border-secondary">
                                        <div class="d-flex mx-o mt-0 mb-0">
                                        <button type="button" class="btn btn-block btn-primary-gradient text-white font-weight-bold mt-0 mx-0 btn-log" data-type='faculty' data-log="1">Log</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-gradient-primary text-white mx-2 mb-2">
                                    <div class="card-body text-center">
                                        <h4><b>Employee</b></h4>
                                    </div>
                                    <div class="card-footer p-0 pt-1 border-top border-secondary">
                                        <div class="d-flex mx-o mt-0 mb-0">
                                        <button type="button" class="btn btn-block btn-primary-gradient text-white font-weight-bold mt-0 mx-0 btn-log" data-type='employees' data-log="1">Log</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card bg-gradient-primary text-white mx-2 mb-2">
                                    <div class="card-body text-center">
                                        <h4><b>Visitor</b></h4>
                                    </div>
                                    <div class="card-footer p-0 pt-1 border-top border-secondary">
                                        <div class="d-flex mx-o mt-0 mb-0">
                                        <button type="button" class="btn btn-block btn-primary-gradient text-white font-weight-bold col-sm-6 mt-0 mx-0 visitor-in" data-type='visitor' data-log="1">In</button>
                                        <button type="button" class="btn btn-block btn-danger-gradient text-white font-weight-bold col-sm-6 mt-0 mx-0 btn-log-visitor" data-type='visitor' data-log="2">Out</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>      			
        </div>
    </div>
</div>
<script>

    $('.btn-log').click(function(){
        uni_modal("<large><b>Scan your Barcode or Enter your ID Code</b></large>",'manage_log.php','',{type:$(this).attr('data-type'),log:$(this).attr('data-log')})
    })
    $('.visitor-in').click(function(){
        uni_modal("Please fill the fields below.",'manage_log_visitor.php','',{type:$(this).attr('data-type'),log:$(this).attr('data-log')})
    })
    $('.btn-log-visitor').click(function(){
        uni_modal("<large><b>Please Enter your visitor's pass number.</b></large>",'manage_log_visitor_out.php','',{type:$(this).attr('data-type'),log:$(this).attr('data-log')})
    })
    
</script>