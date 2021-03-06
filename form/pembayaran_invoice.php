<td width="156">&nbsp;</td>
<td>
    <br>
    <table width="80%" border="1" align="left" cellpadding="4" cellspacing="2" style="border: solid 1px #efefef;">
        <tr>
            <td>
                    <!--form action="../system/pembayaran_invoice_service.php" method="post" enctype="multipart/form-data"-->
                        <table width="100%" border="0" cellspacing="0" cellpadding="3">
                            <tr>
                                <td width="150px"><label>No. Invoice <font color='red'>*</font></label></td>
                                <td width="1px">:</td>
                                <td width="190px">
                                    <input class="easyui-textbox" style="width:150px;height:25px;padding:8px" data-options="prompt:'No Invoice',iconWidth:38" id="no_inv" name="no_inv" disabled>
                                    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#lookupinvoice').window('open')"><img src="../images/famfam/application_xp.png" /></a>
                                    <div id="lookupinvoice" class="easyui-window" title="Lookup Invoice" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:70%;height:320px;padding:10px; text-align:left;">
                                        Pencarian : <input class="easyui-searchbox" data-options="prompt:'.......',menu:'#mm',searcher:searchLookupInvoice" style="width:480px;height:25px;padding:10px;"></input>
                                        <br/>
                                        <br/>
                                        <div id="mm">
                                            <div data-options="name:'semua'">Semua</div>
                                            <div data-options="name:'no_inv'">No Inv</div>
                                            <div data-options="name:'tanggal'">Tanggal</div>
                                        </div>
                                        <table id="tblLookupInvoice" class="easyui-datagrid" title="" style="width:98%;height:180px"
											data-options="rownumbers:true,
											singleSelect:true,
											collapsible:true,
											url:'../json/get_invoice.php',
											method:'get',
											onDblClickRow:function(){
												selectInvoice()
											}">
											<thead>
											<tr>												
												<th width="20%" data-options="field:'no_inv'">No. Invoice</th>												
												<th width="12%" data-options="field:'tanggal'">Tanggal</th>
												<th width="25%" data-options="field:'customer_nama'">Customer</th>
												<th width="14%" data-options="field:'total'" formatter="formatPrice" align="right">Total</th>
												<th width="13%" data-options="field:'cicilan'" formatter="formatPrice" align="right">Cicilan</th>
												<th width="13%" data-options="field:'sisa'" formatter="formatPrice" align="right">Sisa</th>
											</tr>
											</thead>
										</table>
                                        <br/>
                                        <div style="float:right;">
											<button type="submit" onclick="selectInvoice()">Pilih</button>
										</div>
                                    </div>
                                </td>
                                <td rowspan="8" valign="top">
                                <table id="gridDetailInvoice" class="easyui-datagrid" style="width:100%;height:250px" title="Invoice Detail"
									data-options="rownumbers:true,singleSelect:true,collapsible:true,url:'../json/get_invoice_detail.php',method:'get'">
									<thead>
									<tr>										
										<th width="10%" data-options="field:'no_cn'">CN</th>
										<th width="14%" data-options="field:'tanggal'">Tanggal</th>
										<th width="20%" data-options="field:'pengirim'">Pengirim</th>
										<th width="35%" data-options="field:'tujuan'">Tujuan</th>
										<th width="16%" data-options="field:'grand_total'" align="right" formatter="formatPrice">Total</th>
									</tr>
									</thead>
								</table>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Tanggal</label></td>
                                <td>:</td>
                                <td>
									<input class="easyui-textbox" style="width:150px;height:25px;padding:8px" data-options="prompt:'Tanggal Invoice'" id="tanggal" name="tanggal" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Customer</label></td>
                                <td>:</td>
                                <td>
									<input class="easyui-textbox" style="width:150px;height:25px;padding:8px" data-options="prompt:'Nama Customer'" id="customer" name="customer" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Total</label></td>
                                <td>:</td>
                                <td>
									<input type="text" class="easyui-numberbox" min="0" precision="0" style="width:150px;height:25px;padding:8px" data-options="prompt:'Total'" id="total" name="total" disabled>
                                </td>
                            </tr>
							<tr>
                                <td><label>Cicilan</label></td>
                                <td>:</td>
                                <td>
									<input type="text" class="easyui-numberbox" min="0" precision="0" style="width:150px;height:25px;padding:8px" data-options="prompt:'Cicilan'" id="cicilan" name="cicilan" disabled>
                                </td>
                            </tr>
							<tr>
                                <td><label>Sisa</label></td>
                                <td>:</td>
                                <td>
									<input type="text" class="easyui-numberbox" min="0" precision="0" style="width:150px;height:25px;padding:8px" data-options="prompt:'Sisa'" id="sisa" name="sisa" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Tanggal Pembayaran <font color='red'>*</font></label></td>
                                <td>:</td>
                                <td>
									<input type="text" id="tanggal_bayar" name="tanggal_bayar" class="easyui-datebox" style="width:150px;height:25px;padding:8px" placeholder="Tanggal Pembayaran" data-options="prompt:'Tanggal Pembayaran',formatter:myformatter,parser:myparser"></input>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Nilai Pembayaran <font color='red'>*</font></label></td>
                                <td>:</td>
                                <td>
									<input type="text" id="bayar" name="bayar" class="easyui-textbox" style="width:150px;height:25px;padding:8px" 
									data-options="prompt:'Nilai Pembayaran',onChange: function(value){
													var bayar = parseInt($('#bayar').textbox('getText').split(',').join(''))
													var sisa = parseInt($('#sisa').textbox('getText').split(',').join(''))													
														if(bayar > sisa){
															document.getElementById('labelAngka').innerHTML = ''
															$.messager.alert('Peringatan', 'Nilai Bayar tidak boleh lebih besar dari sisa', 'warning');
															$('#bayar').textbox('clear');
														}
														document.getElementById('labelAngka').innerHTML = formatTruncateNumber(bayar,true)
												}">
									<span id="labelAngka">&nbsp;</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <button type="submit" name="simpan_inv" onclick="savePembayaran()">Save</button>
                                    <button onclick="releaseLocking()">Batal</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <br/>
                    <table id="gridRekapPembayaranInvoice" style="width:101%;height:245px" title="Entri Invoice"
							data-options="singleSelect:true,
								collapsible:true,url:'../json/get_invoice.php',
								method:'get',
								rownumbers:true,
								pagination:true,
								pageSize:20,
								onSelect: function(){
									rowClickEntriPembayaranInvoice()
								}" class="easyui-datagrid">
					<thead>
						<tr>
							<th width="20%" data-options="field:'no_inv'">No. Invoice</th>												
							<th width="12%" data-options="field:'tanggal'">Tanggal</th>
							<th width="25%" data-options="field:'customer_nama'">Customer</th>
							<th width="14%" data-options="field:'total'" formatter="formatPrice" align="right">Total</th>
							<th width="13%" data-options="field:'cicilan'" formatter="formatPrice" align="right">Cicilan</th>
							<th width="13%" data-options="field:'sisa'" formatter="formatPrice" align="right">Sisa</th>
						</tr>
					</thead>
			</table>
				</td>
        </tr>
    </table>
</td>
<script type="text/javascript">	
	setTimeout(function(){
		$('#gridDetailInvoice').datagrid({
			queryParams: {
				custNama: '',
				no_inv: '',
			}
		});
	},150)	
	
	function selectInvoice(){
		var row = $('#tblLookupInvoice').datagrid('getSelected');
		if (row){
			$('#no_inv').textbox('setValue', row.no_inv);
			$('#tanggal').textbox('setValue', row.tanggal);
			$('#customer').textbox('setValue', row.customer_nama);
			$('#total').textbox('setValue', formatTruncateNumber(row.total,true));
			$('#cicilan').textbox('setValue', formatTruncateNumber(row.cicilan,true));
			$('#sisa').textbox('setValue', formatTruncateNumber(row.sisa,true));
			$('#lookupinvoice').window('close');	
			onLockingData(row.no_inv,'PEMBAYARANINVOICE')
			setTimeout(function(){
				$('#gridDetailInvoice').datagrid({
					queryParams: {
						custNama: row.customer_nama,
						no_inv: row.no_inv,
					}
				});
			},150)		
		}else{
			$.messager.alert('Peringatan', 'Data belum di pilih !', 'warning');
		}
	}
	
	function savePembayaran() {
		if ($('#no_inv').textbox('getText') != "" && $('#tanggal_bayar').datebox('getValue') != "" 
			&& $('#bayar').textbox('getText') != "") {
		
			var objBayar = [{
					no_inv :  $('#no_inv').textbox('getText'),
					tanggal :  $('#tanggal_bayar').datebox('getValue'),
					nilai_bayar :  $('#bayar').textbox('getText')
				}];
			
			$.ajax({
				type	: "POST",
				url		: "../system/pembayaran_invoice_service.php",
				data	: {
					data : objBayar
				},
				success	: function(data){
					location.reload();			
				}
			});
			
		}else{
			$.messager.alert('Kesalahan', 'Field yang bertanda * harus di isi ! ', 'error');
		}
	}
	
	function refreshPembayaran() {
		$('#no_inv').textbox('setValue', '')
		$('#tanggal').textbox('setValue', '')
		$('#customer').textbox('setValue', '')
		$('#total').textbox('setValue', '')
		$('#cicilan').textbox('setValue', '')
		$('#sisa').textbox('setValue', '')
		$('#tanggal_bayar').textbox('setValue', '')
		$('#bayar').textbox('setValue', '')
		document.getElementById('simpan_inv').style.display = "inline-block"
		$('#gridDetailInvoice').datagrid('reload')
		$('#tblLookupInvoice').datagrid('reload')
	}

	function searchLookupInvoice(value,name) {
		if (value == "") {
			//alert('Data tidak ditemukan !')
			console.log("kosong");
		} else {
			if (name == "no_inv") {
				$('#tblLookupInvoice').datagrid({
					queryParams: {
						no_inv: value
					}
				});
				
			} else if (name == "no_inv") { 
				$('#tblLookupInvoice').datagrid({
					queryParams: {
						tanggal: value
					}
				});
			}
		}
	}
	
	function rowClickEntriPembayaranInvoice() {
		var row = $('#gridRekapPembayaranInvoice').datagrid('getSelected');
		$('#no_inv').textbox('setValue', row.no_inv);
		$('#tanggal').textbox('setValue', row.tanggal);
		$('#customer').textbox('setValue', row.customer_nama);
		$('#total').textbox('setValue', formatTruncateNumber(row.total,true));
		$('#cicilan').textbox('setValue', formatTruncateNumber(row.cicilan,true));
		$('#sisa').textbox('setValue', formatTruncateNumber(row.sisa,true));
		$('#lookupinvoice').window('close');	
		onLockingData(row.no_inv,'PEMBAYARANINVOICE')
		setTimeout(function(){
			$('#gridDetailInvoice').datagrid({
				queryParams: {
					custNama: row.customer_nama,
					no_inv: row.no_inv,
				}
			});
		},150)		
	}
</script>
