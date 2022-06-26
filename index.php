<?php
	include "config.php";
?>
<html>
	<head>
		<title>CRUD SUARAT KELUAR JQueri AJAX</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		
		<!-- JUDUL APLIKASI -->
	<div class="container">
		<h3 class='text-center'>CRUD SURAT KELUAR JQueri AJAX</h3><hr>

		<!-- MEMBUAT FORM TABEL INPUT DATA -->
		<div class='row'>
			<div class="col-md-5">
				<form id='frm'>
				  <div class="form-group">
					<label>Nomor</label>
					<input type="nomor" class="form-control" name="nomor" id='nomor' required placeholder="Masukkan nomor">
				  </div>
				  <div class="form-group">
					<label>tanggal</label>
					<input type="date" class="form-control" name="tanggal" id='tanggal' required placeholder="Masukkan tanggal">
				  </div>
				  <div class="form-group">
					<label>Penerima</label>
					<input type="penerima" class="form-control"  name="penerima" id='penerima' required placeholder="Masukkan penerima">
				  </div>
				  
				  <input type="hidden" class="form-control" name="uid" id='uid' required value='0' placeholder="">
				  
				  <button type="submit" name="submit" id="but" class="btn btn-success">Tambah Surat</button>
				  <button type="button" id="clear" class="btn btn-warning">Reset</button>
				</form> 
			</div>

			<!-- MEMBUAT TABEL DATA -->
			<div class="col-md-7">
				<table class="table table-bordered" id='table'>
					<thead>
						<tr>
							<th>Nomor</th>
							<th>Tanggal</th>
							<th>Penerima</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>

					<!-- VALIDASI DATA TABEL DENGAN TABEL DI DB  -->
					<tbody>
						<?php
							$sql="select * from user";
							$res=$con->query($sql);
							if($res->num_rows>0)
							{
								while($row=$res->fetch_assoc())
								{	
									echo"<tr class='{$row["UID"]}'>
										<td>{$row["NOMOR"]}</td>
										<td>{$row["TANGGAL"]}</td>
										<td>{$row["PENERIMA"]}</td>
										<td><a href='#' class='btn btn-primary edit' uid='{$row["UID"]}'>Edit</a></td>
										<td><a href='#' class='btn btn-danger del' uid='{$row["UID"]}'>Delete</a></td>					
									</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>	
	<script>
		$(document).ready(function(){
			
			//RESET INPUTAN DATA PADA MENU EDIT
			$("#clear").click(function(){
				$("#nomor").val("");
				$("#tanggal").val("");
				$("#penerima").val("");
				$("#uid").val("0");
				$("#but").text("Add User");
			});
			
			//MENGUPDATE DATA 
			$("#but").click(function(e){
				e.preventDefault();
				var btn=$(this);
				var uid=$("#uid").val();
				
				
				var required=true;
				$("#frm").find("[required]").each(function(){
					if($(this).val()==""){
						alert($(this).attr("placeholder"));
						$(this).focus();
						required=false;
						return false;
					}
				});
				if(required){
					$.ajax({
						type:'POST',
						url:'ajax_action.php',
						data:$("#frm").serialize(),
						beforeSend:function(){
							$(btn).text("Wait...");
						},
						success:function(res){
							
							var uid=$("#uid").val();
							if(uid=="0"){
								$("#table").find("tbody").append(res);
							}else{
								$("#table").find("."+uid).html(res);
							}
							
							$("#clear").click();
							$("#but").text("Tambah Surat");
						}
					});
				}
			});
			
			//MENGHAPUS DATA
			$("body").on("click",".del",function(e){
				e.preventDefault();
				var uid=$(this).attr("uid");
				var btn=$(this);
				if(confirm("Apakah anda ingin menghapus? ")){
					$.ajax({
						type:'POST',
						url:'ajax_delete.php',
						data:{id:uid},
						beforeSend:function(){
							$(btn).text("Deleting...");
						},
						success:function(res){
							if(res){
								btn.closest("tr").remove();
							}
						}
					});
				}
			});
			
			//mengisi form input data ssesuai tabel db
			$("body").on("click",".edit",function(e){
				e.preventDefault();
				var uid=$(this).attr("uid");
				$("#uid").val(uid);
				var row=$(this);
				var nomor=row.closest("tr").find("td:eq(0)").text();
				$("#nomor").val(nomor);
				var tanggal=row.closest("tr").find("td:eq(1)").text();
				$("#tanggal").val(tanggal);
				var penerima=row.closest("tr").find("td:eq(2)").text();
				$("#penerima").val(penerima);
				$("#but").text("Update Surat");
			});
		});
	</script>
	</body>
</html>