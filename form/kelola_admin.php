<?php if ($_SESSION['jabatan'] == "ADMIN") { ?>
<td width="156">&nbsp;</td>
<td>
    <br>
    <table width="80%" border="1" align="left" cellpadding="10" cellspacing="3" style="border: solid 1px #efefef;">
        <tr>
            <td>
                    <!--form action="../system/kelola_admin_service.php" method="post" enctype="multipart/form-data"-->
                        <table width="80%" border="0" cellspacing="0" cellpadding="3">
                            <tr>
                                <td width="150px"><label>Username <font color='red'>*</font></label></td>
                                <td>:</td>
                                <td>									
                                    <input type="text" id="username" name="username" class="easyui-textbox" style="width:150px;height:25px;padding:8px" data-options="prompt:'Username',iconWidth:38">
									<input type="hidden" id="user_id" name="user_id" class="easyui-textbox" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Password <font color='red'>*</font></label></td>
                                <td>:</td>
                                <td>
									<input type="password" id="password" name="password" class="easyui-textbox" style="width:150px;height:25px;padding:8px" data-options="prompt:'Password',iconWidth:38">
                                </td>
                            </tr>
                            <tr>
                                <td><label>Nama <font color='red'>*</font></label></td>
                                <td>:</td>
                                <td>
									<input type="text" id="nama" name="nama" class="easyui-textbox" style="width:150px;height:25px;padding:8px" data-options="prompt:'Nama',iconWidth:38">
                                </td>
                            </tr>
                            <tr>
                                <td><label>Jabatan <font color='red'>*</font></label></td>
                                <td>:</td>
                                <td>
									<select class="easyui-combobox" name="jabatan" id="jabatan" style="width:110px;height:25px;padding:8px">
										<option value="ADMIN">ADMIN</option>
										<option value="USER">USER</option>
									</select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <button id="btnSaveUser" onclick="saveUser()">Save</button>
									<button id="btnDeleteUser" onclick="hapusUser()">Hapus</button>
                                    <button onclick="location.reload()">Batal</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <table id="gridUser" class="easyui-datagrid" title="" style="width:98%;height:240px"
						data-options="rownumbers:true,singleSelect:true,collapsible:true,url:'../json/get_users.php',method:'get',
						onSelect: function(){
							editUser()
						}
					">
						<thead>
							<tr>																
								<th width="20%" data-options="field:'nama'">Nama</th>
								<th width="20%" data-options="field:'username'">Username</th>
								<th width="20%" data-options="field:'password'">Password</th>
								<th width="20%" data-options="field:'jabatan'">Jabatan</th>								
							</tr>
						</thead>
					</table>
			</td>
        </tr>
    </table>
</td>
<script type="text/javascript">	
	function editUser(){
		var row = $('#gridUser').datagrid('getSelected');
		if (row){
			$('#user_id').textbox('setValue', row.id);
			$('#username').textbox('setValue', row.username);
			$('#password').textbox('setValue', row.password);
			$('#nama').textbox('setValue', row.nama);
			$('#jabatan').combobox('setValue', row.jabatan);			
		}else{
			$.messager.alert('Peringatan', 'Data belum di pilih !', 'warning');
		}
	}
	
	function saveUser() {
		var obj = [{
				user_id : $('#user_id').textbox('getValue'),
				username :  $('#username').textbox('getValue'),
				password :  $('#password').textbox('getValue'),
				nama :  $('#nama').textbox('getValue'),
				jabatan :  $('#jabatan').combobox("getValue")
			}];
			
		if ($('#username').textbox('getValue') != "" && $('#password').textbox('getValue') != ""
			&& $('#nama').textbox('getValue') != ""  &&  $('#jabatan').combobox('getValue') != "") {
		
			$.ajax({
				type	: "POST",
				url		: "../system/kelola_admin_service.php",
				data	: {
					data : obj
				},
				success	: function(data){
					location.reload();
					//$.messager.alert('Info', 'Data berhasil disimpan ', 'info');
					//refreshUser();
				}
			});
		} else {
			$.messager.alert('Kesalahan', 'Field yang bertanda * harus di isi ! ', 'error');
		}
	}
	
	function refreshUser() {
		$('#user_id').textbox('setValue','')
		$('#username').textbox('setValue','')
		$('#password').textbox('setValue','')
		$('#nama').textbox('setValue','')
		$('#jenis_kelamin').combobox('setValue','L')
		$('#tempat_lahir').textbox('setValue','')
		$('#tanggal_lahir').textbox('setValue','')
		$('#alamat').textbox('setValue','')
		$('#jabatan').combobox('setValue','ADMIN')
		$('#gridUser').datagrid('reload')
	}
	
	function hapusUser(){
		var row = $('#gridUser').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi','Apakah anda yakin ingin menghapus user ini?',function(r){
				if (r){
					$.post('../system/hapus_user.php',{id:row.id},function(result){
						if (result.success){
							refreshUser();
							//$('#gridUser').datagrid('reload');	
						} else {
							$.messager.show({	
								title: 'Error',
								msg: result.errorMsg
							});
						}
					},'json');
				}
			});
		} else {
			$.messager.alert('Peringatan', 'Data belum di pilih !', 'warning');
		}
	}
</script>
<?php }else{ echo "<script>window.location.href='../form/halaman_utama.php?page=home'</script>"; }?>
