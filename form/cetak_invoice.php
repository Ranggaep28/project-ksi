<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../lib/metro/css/metro-bootstrap.css">
    <script src="../lib/metro/js/jquery/jquery.min.js"></script>
    <script src="../lib/metro/js/jquery/jquery.widget.min.js"></script>
    <script src="../lib/metro/min/metro.min.js"></script>
    <script src="../js/main.js"></script>
</head>
<style>
body {padding:0px}
.print-area {border:0px solid blue;padding:0;margin:0}
.test{background-color:#8ED6FA; height:110px;}
</style>
<body class="metro">
  <?php
	date_default_timezone_set('Asia/Jakarta');
    include '../system/config_service.php'; 
    $no_inv = "";
    if (isset($_GET['no_inv'])) {
      $no_inv = $_GET['no_inv'];
    }
    
    //$strQuery = "select * from invoice_detail id inner join tanda_terima tt on id.tanda_terima_sid = tt.sid where id.no_inv= '$no_inv'";
	$strQuery = "select tt.*,		
		ih.no_inv as no_inv,
		ih.tanggal as tgl_inv,
		ih.total as total_inv,
		ih.cicilan as cicilan_inv,
		ih.sisa as sisa_inv,
		ih.jatuh_tempo as jatuh_tempo_inv,
		ih.keterangan as keterangan,
		id.no_inv as no_inv_detail,
		id.tarif as tarif_inv,
		SUM(tt.packing_kayu) as packing_kayu,
		SUM(tt.asuransi) as asuransi,
		SUM(tt.biaya) as biaya,
		tt.service_agent as agent_pengirim,
		(SELECT MAX(tanggal) FROM  invoice_pembayaran where no_inv = ih.no_inv) as tgl_pembayaran		
		
		from invoice_header ih 
		inner join invoice_detail id on ih.no_inv = id.no_inv
		inner join tanda_terima tt on id.tanda_terima_sid = tt.sid 
		where id.no_inv= '$no_inv'";
    $result = mysql_query($strQuery) or die(mysql_error());
    $arrResult = mysql_fetch_array($result);
  ?>
  <table width="100%" cellspacing="30" cellpadding="30">
    <tr>
      <td>
		<div id="print-area-1" class="print-area" style="width: 75%; padding: 0px;" align="center">
        <!--<fieldset style="width: 85%; padding: 10px;">-->
        <!-- <legend>Cetak SJ</legend> -->
        <table width="100%" border="0" cellpadding="5" cellspacing="5" style="border:solid 0px #000000; padding:10px;">
          <tr>
            <!--td align="left"><img src="../images/ksi.png" width="100" height="100" /></td>
			<td>&nbsp;</td-->
            <td align="left">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                <tr>
                  <td align="left" style="font-size:15px;"><strong><font style="color:red">CV. KIKI</font> <font style="color:blue">SOLUSI INTERNUSA</font></strong></td>
                  <td align="center" valign="top">&nbsp;</td>
                </tr>
			</table>	
			<table width="100%" border="0" cellpadding="1" cellspacing="0" >
                <tr>
                  <!--td align="left"><img src="../images/ksi.png" width="100" height="100" /></td>
			<td>&nbsp;</td-->
                  <td width="68%" align="left" valign="top"><p>Jl. Tanjung Keliling No. 21, Rt. 11 / Rw. 11<br />
                    Cipinang, Jakarta Timur<br />
                    Telp. 021-47883998, 68660967, 081310756621<br />
                    Email: ksi_jkt@yahoo.com<br />
                    </p> 
					</td>
                  <td width="32%" align="center" valign="top"><div><strong><font size="+2">INVOICE</font></strong><br/>
                      <font>No : <?php echo $arrResult['no_inv']; ?></font></div>
					  </td>
                </tr>
                            </table>              
							</td>						
          </tr>
          <tr>
            <td colspan="3">
			<table width="100%" border="0" cellpadding="2" cellspacing="0" style="border:1px solid black;">
              <tr>
                <td width="64%">Kepada</td>
                <td width="2%">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="18%">Tanggal Invoice</td>
                <td width="2%">:</td>
                <td width="12%"><?php echo $arrResult['tgl_inv']; ?></td>
              </tr>
              <tr>
                <td><?php echo $arrResult['pengirim']; ?></td>
                <td></td>
                <td></td>
                <td>Cara Pembayaran </td>
                <td>:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><?php echo $arrResult['alamat_pengirim']; ?></td>
                <td></td>
                <td></td>
                <td>Tanggal Jatuh Tempo</td>
                <td>:</td>
                <td><?php echo $arrResult['jatuh_tempo_inv']; ?></td>
              </tr>
              <tr>
                <td><?php echo $arrResult['telpon_pengirim']; ?></td>
                <td></td>
                <td></td>
                <td>Pengirim</td>
                <td>:</td>
                <td><?php echo $arrResult['agent_pengirim']; ?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td>Telepon</td>
                <td>:</td>
                <td><?php echo $arrResult['service_telp_agent']; ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="3"><table width="100%" border="1" cellpadding="3" cellspacing="3">
              <tr align="center">
                <td align="center">No</td>
                <td align="center">Tanggal</td>
                <td align="center">Tujuan</td>
                <td align="center">Service</td>
                <td align="center">CN</td>
                <td align="center">Coll</td>
                <td align="center" colspan"2">Kg</td>
				<td align="center">Tarif</td>
                <td align="center">Total</td>
              </tr>
				<?php										
                    $count = 0;
					$subtotal = 0;
					$totalKG = 0;
					$tarif = 0;
                    $strQuery = "select tt.*, 
								tt.tarif as tariff
								from tanda_terima tt 
								inner join invoice_detail id on tt.sid = id.tanda_terima_sid 
								where id.no_inv= '$no_inv'";
					$result = mysql_query($strQuery) or die(mysql_error());					
                    while($arrDetail = mysql_fetch_array($result)) {
                    			$count++;
								if($arrDetail['total_vol']>$arrDetail['total_berat']){
									$totalKG = $arrDetail['total_vol'];
									$tarif = $arrDetail['grand_total'] / $arrDetail['total_vol'];
								}else{
									$totalKG = $arrDetail['total_berat'];
									$tarif = $arrDetail['grand_total'] / $arrDetail['total_berat'];
								}															
								$subtotal = $subtotal + $arrDetail['subtotal'];
				?>
              <tr>
                <td align="center"><?php echo $count; ?></td>
                <td align="center"><?php echo $arrDetail['tanggal']; ?></td>
                <td align="center"><?php echo $arrDetail['tujuan']; ?></td>
				<td align="center"><?php echo "$arrDetail[service_udl]/$arrDetail[service_dtddtp]/$arrDetail[service_agent]"; ?></td>
				<td align="center"><?php echo $arrDetail['no_cn']; ?></td>
				<td align="right"><?php echo number_format($arrDetail['total_coll']); ?></td>
				<td align="right" colspan"2"><?php echo number_format($arrDetail['total_berat']); ?></td>
				<td align="right"><?php echo number_format($arrDetail['tariff']); ?></td>
				<td align="right"><?php echo number_format($arrDetail['subtotal']); ?></td>               
              </tr>
              <?php } ?>
              <tr>
                <td colspan="7" rowspan="5" align="left" valign="top"><b>Pembayaran dapat ditransfer ke Rekening :</b><br>
                  <b>Bank Danamon, No. 003571498470 a/n CV.KiKi Solusi Internusa </b><br>
                  <b>Bank Central Asia, No,Rek. 3422661422 a/n HARYAKA </b><br>
                  <b>Bank Mandiri, No, Rek. 117-00-0587544-8 a/n HARYAKA </b>				
				  </td>								
                <td align="right">Sub Total</td>
                <td align="right"><?php echo number_format($subtotal);?></td>
              </tr>
              <tr>
                <td align="right">Asuransi</td>
                <td align="right"><?php echo number_format($arrResult['asuransi']); ?></td>
              </tr>
			  <tr>
                <td align="right">Packing</td>
                <td align="right"><?php echo number_format($arrResult['packing_kayu']); ?></td>
              </tr>
			  <tr>
                <td align="right">Biaya Lain</td>
                <td align="right"><?php echo number_format($arrResult['biaya']); ?></td>
              </tr>
              <tr>
                <td align="right">Total</td>
                <td align="right"><?php echo number_format($subtotal+$arrResult['packing_kayu']+$arrResult['asuransi']+$arrResult['biaya']);?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="3">
				<!--b>Pembayaran dapat ditransfer ke Rekening :</b><br>
                <b>Bank Danamon, No. 003571498470 a/n CV.KiKi Solusi Internusa </b><br>
                <b>Bank Central Asia, No,Rek. 3422661422 a/n HARYAKA </b><br>
                <b>Bank Mandiri, No, Rek. 117-00-0587544-8 a/n HARYAKA </b-->			</td>
          </tr>
          <tr>
            <td colspan="3" align="center"><table width="100%" border="0" cellpadding="5" cellspacing="5">
              <tr align="center">
                <td></td>
                <td>Hormat Kami,</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr align="center">
                <td style="color:white">(.........................................)(.........................................)</td>
                <td>(.........................................)</td>
              </tr>
            </table></td>
          </tr>		
        </table>		
		<!-- </fieldset> -->		
		</div>		
		<table width="75%" border="0" cellpadding="0" cellspacing="0">
		<tr align="center">
			<td align="center">
				<a type="button" class="button" href="javascript:printDiv('print-area-1');" >Cetak</a>
			</td>
		</tr>
		</table>
      </td>		
    </tr>
  </table>
<textarea id="printing-css" style="display:none;">html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:70%;font:inherit;vertical-align:center}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:'';content:none}table{border-collapse:collapse;border-spacing:0}body{font:normal normal .8125em/1.4 Arial,Sans-Serif;background-color:white;color:#333}strong,b{font-weight:bold}cite,em,i{font-style:italic}a{text-decoration:none}a:hover{text-decoration:underline}a img{border:none}abbr,acronym{border-bottom:1px solid;cursor:help}sup,sub{vertical-align:baseline;position:relative;top:-.4em;font-size:86%}sub{top:.4em}small{font-size:86%}kbd{font-size:80%;border:1px solid #999;padding:2px 5px;border-bottom-width:2px;border-radius:3px}mark{background-color:#ffce00;color:black}p,blockquote,pre,table,figure,hr,form,ol,ul,dl{margin:0.5em 0}hr{height:1px;outline-style:double;background-color:#666}h1,h2,h3,h4,h5,h6{font-weight:bold;line-height:normal;margin:0.5em 0 0}h1{font-size:200%}h2{font-size:180%}h3{font-size:160%}h4{font-size:140%}h5{font-size:120%}h6{font-size:70%}ol,ul,dl{margin-left:3em}ol{list-style:decimal outside}ul{list-style:disc outside}li{margin:.5em 0}dt{font-weight:bold}dd{margin:0 0 .5em 2em}input,button,select,textarea{font:inherit;font-size:70%;line-height:normal;vertical-align:baseline}textarea{display:block;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}pre,code{font-family:"Courier New",Courier,Monospace;color:inherit}pre{white-space:pre;word-wrap:normal;overflow:auto}blockquote{margin-left:2em;margin-right:2em;border-left:4px solid #ccc;padding-left:1em;font-style:italic}table[border="1"] th,table[border="1"] td,table[border="1"] caption{border:1px solid;padding:.5em 1em}th{font-weight:bold}table[border="1"] caption{border:none;font-style:italic}.no-print{display:none}.test{background:#8ED6FA; height:110px;}</textarea>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>

</body>
<script>
function printDiv(elementId) {
    var a = document.getElementById('printing-css').value;
    var b = document.getElementById(elementId).innerHTML;
    window.frames["print_frame"].document.title = document.title;
    window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
    window.frames["print_frame"].window.focus();
    window.frames["print_frame"].window.print();
}
</script>
</html>