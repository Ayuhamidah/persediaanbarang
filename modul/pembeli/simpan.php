<?php
include "../../inc/inc.koneksi.php";

$table		="pembeli";

$kode		=$_POST['kode'];
$nama		=str_replace("'","\'",$_POST['nama']);
$alamat		=$_POST['alamat'];

$sql = mysql_query("SELECT kode_pembeli,nama_pembeli,alamat,telepon
				   FROM $table 
				   WHERE kode_pembeli= '$kode'");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table SET nama_pembeli	='$nama',
								alamat		='$alamat',
								telepon		='$telepon'
					WHERE kode_pembeli= '$kode'";
	mysql_query($input);								
	echo "Data Sukses diubah";
}else{
	$input = "INSERT INTO $table (kode_pembeli,nama_pembeli,alamat,telepon)
				VALUES('$kode','$nama','$alamat','$telepon')";
	mysql_query($input);
	echo "Data sukses disimpan";
}	
//echo "<br>".$input."<br/>";
?>
