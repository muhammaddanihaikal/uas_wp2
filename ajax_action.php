<!-- Validasi data -->
<?php 
	include "config.php";
	$uid=$_POST["uid"];
	$nomor=mysqli_real_escape_string($con,$_POST["nomor"]);
	$tanggal=mysqli_real_escape_string($con,$_POST["tanggal"]);
	$penerima=mysqli_real_escape_string($con,$_POST["penerima"]);
	if($uid=="0"){

		//fungsi tambah data
		$sql="insert into user (NOMOR,TANGGAL,PENERIMA) values ('{$nomor}','{$tanggal}','{$penerima}')";
		if($con->query($sql)){
			$uid=$con->insert_id;
			echo"<tr class='{$uid}'>
				<td>{$nomor}</td>
				<td>{$tanggal}</td>
				<td>{$penerima}</td>
				<td><a href='#' class='btn btn-primary edit' uid='{$uid}'>Edit</a></td>
				<td><a href='#' class='btn btn-danger del' uid='{$uid}'>Delete</a></td>					
			</tr>";
			
		}
	}else{

		//fungsi update data
		$sql="update user set NOMOR='{$nomor}',TANGGAL='{$tanggal}',PENERIMA='{$penerima}' where UID='{$uid}'";
		if($con->query($sql)){
			echo"
				<td>{$nomor}</td>
				<td>{$tanggal}</td>
				<td>{$penerima}</td>
				<td><a href='#' class='btn btn-primary edit' uid='{$uid}'>Edit</a></td>
				<td><a href='#' class='btn btn-danger del' uid='{$uid}'>Delete</a></td>					
			";
		}
	}
?>