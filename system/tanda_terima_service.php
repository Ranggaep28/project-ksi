<?php
	include 'config_service.php';
	include 'gen_uuid_service.php';
	session_start();
	if ($_POST['data'] != null) {				
		
		$test = json_encode($_POST['data']);
		$jsondata = json_decode($test);
		$id = gen_uuid();
		$cn = strtoupper($jsondata[0]->cn);
		
		$tanggal = $jsondata[0]->tanggal;
		$tgl=substr($tanggal,0,2);
		$bln=substr($tanggal,3,2);
		$thn=substr($tanggal,6,4);
		$hasil="$thn-$bln-$tgl";
		
		$pengirim = $jsondata[0]->pengirim;
		$alamat_pengirim = $jsondata[0]->alamat_pengirim;
		$telpon_pengirim = $jsondata[0]->telpon_pengirim;
		$tujuan = $jsondata[0]->tujuan;
		$penerima = $jsondata[0]->penerima;
		$alamat_penerima = $jsondata[0]->alamat_penerima;
		$telpon_penerima = $jsondata[0]->telpon_penerima;
		$udl = $jsondata[0]->udl;
		$dtddtp = $jsondata[0]->dtddtp;
		$agent = $jsondata[0]->agent;
		$telp_agent = $jsondata[0]->telp_agent;
		$alamat_agent = $jsondata[0]->alamat_agent;
		$coll = $jsondata[0]->coll;
		$kg = $jsondata[0]->kg;
		$vol = $jsondata[0]->vol;
		$tarif = $jsondata[0]->tarif;
		$subtotal = $jsondata[0]->subtotal;
		$packing_kayu = $jsondata[0]->packing_kayu;
		$asuransi = $jsondata[0]->asuransi;
		$biaya = $jsondata[0]->biaya;
		$grandtotal = $jsondata[0]->grand_total;
		$deskripsi = $jsondata[0]->deskripsi;
		$user_id = $_SESSION['user_sid'];
		$user_name = $_SESSION['username'];				
		
		$countQry = mysql_query("select * from tanda_terima order by no desc") or die(mysql_error());
		$arrCountQry = mysql_fetch_array($countQry);
		$cnt = 1;
		if ($arrCountQry['no'] == "") {
			$cnt = 1;
		} else {
			$cnt = $arrCountQry['no'] + 1;
		}
		//$nomor = "P".str_pad($cnt,5,"0",STR_PAD_LEFT);		
		$cekCN	= mysql_num_rows(mysql_query("SELECT * FROM tanda_terima WHERE no_cn='$cn'"));
		$cekCustomer = mysql_num_rows(mysql_query("SELECT * FROM customer WHERE nama like '%$pengirim%'"));
		$cekAgent = mysql_num_rows(mysql_query("SELECT * FROM agent WHERE agent like '%$agent%'"));
		
		if(($cekCustomer)<1){
			$newCust = mysql_query("insert into customer values ('".$id."','".$pengirim."','".$alamat_pengirim."','".$telpon_pengirim."') ");
		}
		
		if(($cekAgent)<1){
			$newAgent = mysql_query("insert into agent values ('".$id."','".$agent."','".$telp_agent."','".$alamat_agent."') ");
		}
		
		if(($cekCN)>=1){
			echo "Nomor CN $cn sudah ada di database, silahkan ganti dengan yang lain !";
		}else{		
			$strQry = "INSERT INTO tanda_terima VALUES ('$id','$cnt','$cn','$tanggal','$pengirim', '$alamat_pengirim', $telpon_pengirim,'$tujuan', '$penerima', '$alamat_penerima', $telpon_penerima, '$udl', '$dtddtp', '$agent', '$telp_agent', '$alamat_agent', '$coll', '$kg', '$vol', '$tarif', '$subtotal', '$packing_kayu', '$asuransi', '$biaya', '$grandtotal', '$deskripsi', '$user_id', '$user_name', 0)";
			// echo ">>>".$strQry;
			mysql_query($strQry) or die(mysql_error());
			
		}
		
	} else if ($_GET['sch_cn'] != null) {
		$sch = mysql_query("select * from tanda_terima where no_cn = '".$_GET['sch_cn']."' ");
		$count = mysql_num_rows($sch);
		
		if (($count) >= 1) {
			$result = array();
			while($row = mysql_fetch_object($sch)){
				array_push($result, $row);
			}
			//$row = mysql_fetch_array($sch);
			echo json_encode($result);
		} else {
			echo "";
		}
	}
?>
