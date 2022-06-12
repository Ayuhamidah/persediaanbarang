<script type="text/javascript">
$(document).ready(function() {
	$("#tambah").click(function(){
		$(".input").val('');
		$("#txt_kode").focus();
	});
	$("#txt_kode").keyup(function() {
		var kode 	= $("#txt_kode").val()
		//var akses	= 1; //1 cari, 2 edit, 3 baru
		$.ajax({
			type	: "POST",
			url		: "modul/hutang/cari.php",
			data	: "kode="+kode,
			dataType	: "json",
			success	: function(data){
				$("#txt_tgl_hutang").val(data.tgl_hutang);
				$("#txt_kode_supplier").val(data.supplier);
				$("#txt_nominal").val(data.nominal);
				$("#txt_sisa_hutang").val(data.sisa_hutang);
				//$("#data").load('modul/hutang/tampil_data.php');
			}
		});
	});
	
	$("#simpan").click(function(){
	var akses = $("#akses").val();								
	if (akses==1){
		var pilih = confirm("Data sudah ada, apakah Akan mengubahnya ?");
		if (pilih==true) {
			simpan_data();
			return false;
		}else{
			$("#info").html("Anda membatalkan proses simpan");
			return false;
		}
	}else{
		simpan_data();
		return false;
	}
	});

	function simpan_data(){
		var	kode	    = $("#txt_kode").val();
		var	tgl_hutang  = $("#txt_nama").val();
		var	kode_supplier = $("#txt_nama").val();
		var	sisa_hutang = $("#txt_alamat").val();
		
		var error = false;

		if(kode.length == 0){
           var error = true;
           alert("Maaf, Kode Hutang tidak boleh kosong");
		   $("#txt_kode").focus();
		   return (false);
         }
		if(nama.length == 0){
           var error = true;
           alert("Maaf, tgl_hutang tidak boleh kosong");
		   $("#txt_nama").focus();
		   return (false);
         }	 
		if(error == false){
		$.ajax({
			type	: "POST",
			url		: "modul/hutang/simpan.php",
			data	: "kode="+kode+
					"&nama="+nama+
					"&alamat="+alamat,
			timeout	: 3000,
			beforeSend	: function(){		
				$("#info").html("<img src='loading.gif' />");			
			},				  
			success	: function(data){
				$("#info").html(data);
				$("#tampil_data").load('modul/hutang/tampil_data.php');
				$("#akses").val(1);
			}
		});
		}
		return false; 		
	}
});
</script>
<?php
echo "<input type='hidden' id='akses'>";
echo "<table width='100%'>
	<tr>
		<td>Kode Supplier</td>
		<td>:</td>
		<td><input type='text' name='txt_kode' id='txt_kode'  size='10' lenght='10' class='input'></td>
	</tr>
	<tr>
		<td>Nama Supplier</td>
		<td>:</td>
		<td><input type='text' name='txt_nama' id='txt_nama'  size='50' lenght='50' class='input'></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>:</td>
		<td><input type='text' name='txt_alamat' id='txt_alamat'  size='50' lenght='50' class='input'></td>
	</tr>
	<tr>
		<td colspan='3' align='center'>
		<button name='tambah' id='tambah'>Tambah</button>
		<button name='keluar' id='simpan'>Simpan</button>
		</td>
	</tr>
	</table>";
?>