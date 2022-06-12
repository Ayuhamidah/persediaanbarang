<script type="text/javascript">
$(document).ready(function() {
    $(function() {
        $("#theList tr:even").addClass("stripe1");
        $("#theList tr:odd").addClass("stripe2");

        $("#theList tr").hover(
            function() {
                $(this).toggleClass("highlight");
            },
            function() {
                $(this).toggleClass("highlight");
            }
        );
    });	
});
	function edit_data(ID){
		//location.window();
		//window.location.href='media.php?module=pembeli';
		var kode = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/pembeli/cari.php",
			data	: "kode="+kode,
			dataType	: "json",
			success	: function(data){
				$("#txt_kode").val(kode);
				$("#txt_nama").val(data.nama);
				$("#txt_alamat").val(data.alamat);
				$("#txt_telepon").val(data.telepon);
				$("#akses").val(data.akses);
				$("#info").html("Data sudah di tampung pada tab inputan, silahkan klik");
			}
		});
	}
	function hapus_data(ID){
		//location.window();
		//window.location.href='media.php?module=pembeli';
		var pilih = confirm('Data yang akan dihapus kode = '+ID+ '?');
		if (pilih==true) {
		var kode = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/pembeli/hapus.php",
			data	: "kode="+kode,
			success	: function(data){
				$("#info").html(data);
				$("#tampil_data").load('modul/pembeli/tampil_data.php');
				$("#akses").val('');
			}
		});
		}
	}

</script>
<?php
include '../../inc/inc.koneksi.php';
$cari	= $_GET['cari'];
$hal	= $_GET['hal'] ? $_GET['hal'] : 0;
$lim	= 5;

	$query2	= "SELECT * FROM pembeli 
			WHERE (kode_pembeli LIKE '%$cari%' OR nama_pembeli LIKE '%$cari%')  ";
	$data2	= mysql_query($query2);
	$jml	= mysql_num_rows($data2);
	
	$max	= ceil($jml/$lim);

echo "<table id='theList' width='100%'>
		<tr>
			<th>No.</th>
			<th>Kode Pembeli</th>
			<th>Nama Pembeli</th>
			<th>Alamat</th>
			<th>Telepon</th>
			<th>Aksi</th>
		</tr>";
		$sql = "SELECT * FROM pembeli
				WHERE (kode_pembeli LIKE '%$cari%' OR nama_pembeli LIKE '%$cari%')
				ORDER BY kode_pembeli
				LIMIT $hal,$lim";
				
		//echo $sql;
		$query = mysql_query($sql);
		
		$no=1+$hal;
		while($r_data=mysql_fetch_array($query)){
			$kode_pembeli = $r_data['kode_pembeli'];
			echo "<tr>
					<td align='center'>$no</td>
					<td>".$r_data['kode_pembeli']."</td>
					<td>".$r_data['nama_pembeli']."</td>
					<td>".$r_data['alamat']."</td>
					<td>".$r_data['telepon']."</td>
					<td align='center'>
					<a href='javascript:void(0)' onClick=\"edit_data('".$r_data['kode_pembeli']."')\">
					<img src='icon/thumb_up.png' border='0' id='edit' title='Edit' width='12' height='12' >
					</a>
					<a href='javascript:void(0)' onClick=\"hapus_data('".$r_data['kode_pembeli']."')\">
					<img src='icon/thumb_down.png' border='0' id='hapus' title='Hapus' width='12' height='12' >
					</a>					
					</td>
					</tr>";
			$no++;
		}
		
	echo "</table>";
	echo "<table width='100%'>
		<tr>
			<td>Jumlah Data : $jml</td>
			<td align='right'>Halaman :";
			for ($h = 1; $h <= $max; $h++) {
					$list[$h] = $lim * $h - $lim;
					echo " <a href='javascript:void(0)' ";?> 
                    onClick="$.get('modul/pembeli/tampil_data.php?cari=<?php echo $_GET['cari'];?>&hal=<?php echo $list[$h]; ?>', 
                    null, function(data) {$('#tampil_data').html(data);})" <?php echo">".$h."</a> ";
				}
	echo "</td>
		</tr>
		</table>";
?>