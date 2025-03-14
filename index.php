<!DOCTYPE html>
<html lang="en">
<head>
	<title>Daftar Online RSU Natalia Boyolali</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
	<link rel="stylesheet" href="node_modules/mdbootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="node_modules/mdbootstrap/css/mdb.min.css">
	<link rel="stylesheet" href="node_modules/mdbootstrap/css/style.css">
	<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
	<!--===============================================================================================-->
</head>

<body>
	<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-9 mx-auto">
					<div class="">
						<?php echo "<BR>"; ?>
						</div>
						<div class="">
							<?php echo "<BR>"; ?>
							</div>
							<div class="">
								<?php echo "<BR>"; ?>
								</div>
								<div class="">
									<?php echo "<BR>"; ?>
									</div>
									<div class="">
										<?php echo "<BR>"; ?>
										</div>
										<div class="">
											<?php echo "<BR>"; ?>
											</div>
											<div class="">
												<?php echo "<BR>"; ?>
												</div>


            <div class="jumbotron" align="center" style="width: 100%">
							<h1><b>
								ANTRIAN RSU NATALIA BOYOLALI
							</b>
							</h1>
							<div class="">
									<?php echo "<BR>"; ?>
								</div>
								<a href="norm.php?kunjungan=1" class="btn btn-primary btn-rounded">DATANG LANGSUNG / RUJUKAN PERTAMA</a>
								<a href="norm.php?kunjungan=2" class="btn btn-secondary btn-rounded">DAFTAR ONLINE</a>
								<a href="norm.php?kunjungan=3" class="btn btn-secondary btn-rounded">KONTROL BPJS</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-md vertical-align-center">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
									<button type="button" class="btn btn-secondary btn-rounded">ONLINE</button>
									<button type="button" class="btn btn-success btn-rounded">BPJS</button>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                </div>
              </div>
            </div>
        </div>




  <script>
import { mdbBtn } from 'mdbvue';
export default {
    name: 'ButtonPage',
    components: {
        mdbBtn
    }
}

</script>
  		<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  		<script type="text/javascript">
  		function isi_otomatis(){
  			var norm = $("#norm").val();
  			$.get("ajax-pasien.php?norm="+$("#norm").val(),function(data){
  				var json = data,
  				obj = JSON.parse(json);
  				$('#nama').val(obj.nama);
  			});
  		};

  		</script>


  		<!--===============================================================================================-->
			<script type="text/javascript" src="node_modules/mdbootstrap/js/jquery.min.js"></script>
			<script type="text/javascript" src="node_modules/mdbootstrap/js/popper.min.js"></script>
			<script type="text/javascript" src="node_modules/mdbootstrap/js/bootstrap.min.js"></script>
			<script type="text/javascript" src="node_modules/mdbootstrap/js/mdb.min.js"></script>


  	</body>
  	</html>
