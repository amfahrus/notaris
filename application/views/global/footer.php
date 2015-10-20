	<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.table.addrow.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/highcharts.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pageMe.js"></script>
    <script type="text/javascript">
	    jQuery(document).ready(function($) {
			var link_base = "<?php echo base_url();?>";

	    	$('.menu').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget);
				var id = button.data('id');

				var nama_pekerjaan = button.data('nama');
				var jenis = button.data('jenis');
				var akta = button.data('akta');
				var langkah_pekerjaan = button.data('langkah');
				var biaya_kerja = button.data('biaya');
				var titip = button.data('titip');
				var klien = button.data('klien');
				var syarat = button.data('syarat');
				var aktor = button.data('aktor');
				var tipe = button.data('tipe');
				var berkas = button.data('berkas');
				var nominal = button.data('nominal');
				var ket = button.data('ket');
				var user = button.data('user');
				var email = button.data('email');
				var akses = button.data('akses');
				var detail = button.data('detail');
				var jmldetail = button.data('jmldetail');
				var jmlsyarat = button.data('jmlsyarat');
				var biaya_bayar = button.data('biaya_bayar');


				$("#delete").attr("data-id",id);
				$("#delete").attr("data-jenis",jenis);
				$("#reset").attr("data-id",id);

				if (jenis == "user") {
					$("#edit").attr("data-id",id);
					$("#edit").attr("data-user",user);
					$("#edit").attr("data-email",email);
					$("#edit").attr("data-akses",akses);
				}
				if(jenis == "pkj"){
					var detail = link_base+"Home/detail_pekerjaan/"+aktor+"/"+nama_pekerjaan+"/"+id;
					$("#detail_pekerjaan").attr("href",detail);
					$("#edit").attr("data-id",id);
					$("#edit").attr("data-nama",nama_pekerjaan);
					$("#edit").attr("data-akta",akta);
				}
				else if(jenis == "detail"){
					$("#edit").attr("data-target",".edit-detail");
					$("#edit").attr("data-id",id);
					$("#edit").attr("data-langkah",langkah_pekerjaan);
					$("#edit").attr("data-biaya",biaya_kerja);
				}
				else if(jenis == 'syarat'){
					$("#edit").attr("data-target",".edit-syarat");
					$("#edit").attr("data-id",id);
					$("#edit").attr("data-syarat",syarat);
				}
				else if(jenis == 'tambahan'){
					$("#edit").attr("data-target",".edit-tambahan");
					$("#edit").attr("data-id",id);
					$("#edit").attr("data-nominal",nominal);
					$("#edit").attr("data-ket",ket);
				}
				else if(jenis == 'klien'){
					var edit_klien = link_base+"Home/edit_klien/"+id;

					$("#edit_klien").attr("href",edit_klien);
				}
				else if(jenis == 'tanah'){
					var edit_tanah = link_base+"Home/edit_tanah/"+id;

					$("#edit_tanah").attr("href",edit_tanah);
				}
				else if(jenis == 'pending'){
					var edit_berkas = link_base+"Home/edit_berkas_pending/"+id;
					var sess = <?php echo $this->session->userdata('SESS_HAK_AKSES'); ?>;
					if (sess == 0 ) {
						if (biaya_kerja) {
							var approve = "<a id=\"approve\" href=\""+ link_base +"Home/pkj_approve/"+id+"\" class=\"list-group-item\"><span class=\"glyphicon glyphicon-check\"></span> Terima Pekerjaan</a>";
						}else{
							var approve = "<a id=\"approve\" class=\"list-group-item disabled\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Pastikan Biaya Klien Telah di Set\"><span class=\"glyphicon glyphicon-check\"></span> Terima Pekerjaan</a>";
						}
						$("#bks").append(approve);
					}

					$("#edit_berkas").attr("href",edit_berkas);
				}
				else if(jenis == 'berkas'){
					var edit_berkas = link_base+"Home/edit_berkas/"+id;
					

					$("#edit_berkas").attr("href",edit_berkas);
				}
				else if(jenis == 'selesai'){
					var sess = <?php echo $this->session->userdata('SESS_HAK_AKSES'); ?>;

					var sms = "<a id=\"sms\" href=\""+ link_base +"Sms/kirim_sms/"+id+"\" class=\"list-group-item\"><span class=\"glyphicon glyphicon-envelope\"></span> Kirim Pemberitahuan SMS</a>";
					var mail = "<a id=\"email\" href=\""+ link_base +"Home/email/"+id+"\" class=\"list-group-item\"><span class=\"glyphicon glyphicon-envelope\"></span> Kirim Pemberitahuan Email</a>";
					$("#bks").append(sms);
					$("#bks").append(mail);
					if (sess == 0 ) {
						if (titip == klien) {
							var approve = "<a id=\"approve\" href=\""+ link_base +"Home/set_selesai/"+id+"\" class=\"list-group-item\"><span class=\"glyphicon glyphicon-check\"></span> Tandai Sebagai Selesai</a>";
						}else{
							var approve = "<a id=\"approve\" class=\"list-group-item disabled\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Pastikan Pekerjaan Telah Lunas\"><span class=\"glyphicon glyphicon-check\"></span> Tandai Sebagai Selesai</a>";
						}
						$("#bks").append(approve);
					}

				}
				else if(jenis == 'ambil'){
					if (tipe != '4') {
						var ambil_klien = link_base+"Home/take_klien_pkj/"+aktor+"/"+nama_pekerjaan+"/"+tipe+"/"+id;

						$("#ambil_klien").attr("href",ambil_klien);
					}else{
						var ambil_tanah = link_base+"Home/take_tanah_pkj/"+aktor+"/"+nama_pekerjaan+"/"+tipe+"/"+id;

						$("#ambil_tanah").attr("href",ambil_tanah);
					}
				}
				else if(jenis == 'ambil_berkas'){
					if (tipe != '4') {
						var ambil_klien_berkas = link_base+"Home/take_klien_berkas/"+berkas+"/"+id+"/"+tipe;

						$("#ambil_klien_berkas").attr("href",ambil_klien_berkas);
					}else{
						var ambil_tanah_berkas = link_base+"Home/take_tanah_berkas/"+berkas+"/"+id+"/"+tipe;

						$("#ambil_tanah_berkas").attr("href",ambil_tanah_berkas);
					}
				}
				else if(jenis == 'ambil_berkas_pending'){
					if (tipe != '4') {
						var ambil_klien_berkas_pending = link_base+"Home/take_klien_berkas/"+berkas+"/"+id+"/"+tipe+"/pending";

						$("#ambil_klien_berkas_pending").attr("href",ambil_klien_berkas_pending);
					}else{
						var ambil_tanah_berkas_pending = link_base+"Home/take_tanah_berkas/"+berkas+"/"+id+"/"+tipe+"/pending";

						$("#ambil_tanah_berkas_pending").attr("href",ambil_tanah_berkas_pending);
					}
				}
				else if(jenis == 'pengeluaran'){
					if (ket == 'belum') {
						var bayar_pengeluaran = link_base+"Home/update_stat_biaya/belum/"+berkas+"/"+id+"/"+biaya_bayar;

					}else{
						var bayar_pengeluaran = link_base+"Home/update_stat_biaya/all/"+berkas+"/"+id+"/"+biaya_bayar;
					}

					$("#bayar_pengeluaran").attr("href",bayar_pengeluaran);
				}
			});

			$(".menu").on('hidden.bs.modal', function (event) {
				$("#sms").remove();
				$("#email").remove();
				$("#approve").remove();

			});

			$(".pelunasan").on('hidden.bs.modal', function (event){
				$(".pelunasan").removeData('bs.modal')
			});

			$(".table-hover").find('tr[data-target]').on('click', function(){
		         $('.menu').data('id',$(this).data('id'));
		    });

		    $(".list-group").find('.list-group-item[data-target]').on('click', function(){
		         $('.menu').data('id',$(this).data('id'));
		    });

		    $('.harga').on('show.bs.modal', function (event) {
		    	var button = $(event.relatedTarget);
		    	var id = button.data('id');
		    	var harga = button.data('harga');

		    	var modal = $(this);
		    	modal.find('.modal-body input#inputId').val(id);
		    	modal.find('.modal-body input#inputHarga').val(harga);
		    });


			$('.delete').on('show.bs.modal', function (event) {
				$('.menu').modal('hide');
				var button = $(event.relatedTarget);
				var id = button.data('id');
				var jenis = button.data('jenis');

				var link_base = "<?php echo base_url();?>";
				var aktor = button.data('aktor');
				var nama = button.data('nama');
				var pkj = button.data('pkj');

				if(jenis == "detail"){
					$("#verDelete").attr("action",link_base+"Home/delete_detail_pekerjaan/"+aktor+"/"+nama+"/"+pkj);
				}
				else if(jenis == "syarat"){
					$("#verDelete").attr("action",link_base+"Home/delete_syarat_pekerjaan/"+aktor+"/"+nama+"/"+pkj);
				}

				var modal = $(this);
				modal.find('.modal-body input#inputId').val(id);
			});

			$('.reset-pwd').on('show.bs.modal', function (event) {
				$('.menu').modal('hide');
				var button = $(event.relatedTarget);
				var id = button.data('id');
				var modal = $(this);
				modal.find('.modal-body input#inputId').val(id);
			});

			$('.edit-user').on('show.bs.modal', function (event) {
				$('.menu').modal('hide');
				var button = $(event.relatedTarget);
				var id = button.data('id');
				var user = button.data('user');
				var email = button.data('email');
				var akses = button.data('akses');
				var akses1 = "";
				var akses2 = "";
				var nama_akses = "";
				var nama_akses1 = "";
				var nama_akses2 = "";

				switch(akses){
					case 0:
					nama_akses = "Notaris";
					akses1 = "1";
					akses2 = "2";
					akses3 = "3";
					nama_akses1 = "Admin";
					nama_akses2 = "Staff";
					nama_akses3 = "Staff Khusus";
					break;
					case 1:
					nama_akses = "Admin";
					akses1 = "0";
					akses2 = "2";
					akses3 = "3";
					nama_akses1 = "Notaris";
					nama_akses2 = "Staff";
					nama_akses3 = "Staff Khusus";
					break;
					case 2:
					nama_akses = "Staff";
					akses1 = "0";
					akses2 = "1";
					akses3 = "3";
					nama_akses1 = "Notaris";
					nama_akses2 = "Admin";
					nama_akses3 = "Staff Khusus";
					break; 
					case 3:
					nama_akses = "Staff Khusus";
					akses1 = "0";
					akses2 = "1";
					akses3 = "2";
					nama_akses1 = "Notaris";
					nama_akses2 = "Admin";
					nama_akses3 = "Staff";
				}

				var modal = $(this);
				modal.find('.modal-body input#inputId').val(id);
				modal.find('.modal-body input#inputUser').val(user);
				modal.find('.modal-body input#inputEmail').val(email);
				modal.find('.modal-body option#optionAkses').text(nama_akses);
				modal.find('.modal-body option#optionAkses').val(akses);
				modal.find('.modal-body option#optionAkses1').text(nama_akses1);
				modal.find('.modal-body option#optionAkses1').val(akses1);
				modal.find('.modal-body option#optionAkses2').text(nama_akses2);
				modal.find('.modal-body option#optionAkses2').val(akses2);
				modal.find('.modal-body option#optionAkses3').text(nama_akses3);
				modal.find('.modal-body option#optionAkses3').val(akses3);
			});
			$('.edit-user').on('hidden.bs.modal', function (event) {
				location.reload();
			});
			$('.edit-pekerjaan').on('show.bs.modal', function (event) {
				$('.menu').modal('hide');
				var button = $(event.relatedTarget);
				var id = button.data('id');
				var nama = button.data('nama');
				if (button.data('akta') == "-") {
					var akta = "";
				}else{
					var akta = button.data('akta');
				}

				var modal = $(this);
				modal.find('.modal-body input#inputId').val(id);
				modal.find('.modal-body input#inputPekerjaan').val(nama);
				modal.find('.modal-body input#inputAkta').val(akta);
			});
			$('.edit-detail').on('show.bs.modal', function (event) {
				$('.menu').modal('hide');
				var button = $(event.relatedTarget);
				var id = button.data('id');
				var langkah = button.data('langkah');
				var biaya = button.data('biaya');

				var modal = $(this);
				modal.find('.modal-body input#inputId').val(id);
				modal.find('.modal-body input#inputDetail').val(langkah);
				modal.find('.modal-body input#inputBiaya').val(biaya);

			});
			$('.edit-syarat').on('show.bs.modal', function (event) {
				$('.menu').modal('hide');
				var button = $(event.relatedTarget);
				var id = button.data('id');
				var syarat = button.data('syarat');

				var modal = $(this);
				modal.find('.modal-body input#inputId').val(id);
				modal.find('.modal-body input#inputSyarat').val(syarat);
			});
			$('.edit-tambahan').on('show.bs.modal', function (event) {
				$('.menu').modal('hide');
				var button = $(event.relatedTarget);
				var id = button.data('id');
				var nominal = button.data('nominal');
				var ket = button.data('ket');

				var modal = $(this);
				modal.find('.modal-body input#inputId').val(id);
				modal.find('.modal-body input#inputNominal').val(nominal);
				modal.find('.modal-body input#inputKet').val(ket);
			});
			
			$("#tambahSyarat").click(function(){
			    var thisTableId = $(this).parents("table").attr("id");

		        var lastRow = $('#'+thisTableId + " tr#baris:last");
		        var newRow = lastRow.clone(true);

		        // tambah baris 
		        $('#'+thisTableId + " tr#baris:last").after(newRow);

		        // clear input baris (Optional)
                $('#'+thisTableId + " tr#baris:last td :input").val('');

                $('#'+thisTableId + " tr#baris:last td.delete .del").css("visibility", "hidden");

		        // aksi untuk hapus
		        $('#'+thisTableId + " tr#baris td:last .delRow").css("visibility", "visible");


		        return false;

			});

			$(".delRow").on('click', function(){
                $(this).parents("tr").remove();
                return false;
            });

			$("#tmbSrt").click(function(){
				var table = $(this).parents("table").attr("id");

		    	var row = "<tr id=\"baris\"><td><select name=\"tmb_syarat[]\" class=\"form-control\">";
		    	<?php if (!empty($syarat)): ?>
			    	<?php foreach ($syarat as $srt): ?>
						row += "<option value=\"<?php echo $srt->id_syarat;?>\"><?php echo $srt->syarat;?></option>";
					<?php endforeach ?>
				<?php endif ?>
				row += "</select></td><td><input type=\"text\" class=\"form-control\" name=\"tmb_ket_syarat[]\" placeholder=\"Keterangan Syarat\"></td><td><a href=\"#\" class=\"btn btn-danger pull-left delRow\"  onClick=\"javascript:deleted(this);return false;\"><span class=\"glyphicon glyphicon-remove\"></span></a></td></tr>";

		    	$('#'+table + " tr#baris:last").after(row);

				return false;
			});

            $(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			});

			$('.extra').on('hidden.bs.modal', function(){
				$('.extra').removeData('bs.modal');
			});

			$('.alert-dismisable').hide().fadeIn(500);
		      setTimeout(function(){
			  	jQuery(".alert-dismisable").fadeOut();
			  },10000);

		    $('.datepick').each(function(){
				$(this).datepicker({
				    format: "yyyy-mm-dd",
				    autoclose: true,
				    todayHighlight: true,
				});
		    });

		    var jumlah_dihapus = 0;
		    $(".del").click(function(){

		    	var id_berkas = $(this).data('id-berkas');
		    	var id_ket = $(this).data('id-ket');

		    	var append_berkas = "<input type=\"text\" name=\"list_berkas_dihapus["+jumlah_dihapus+"]\" value=\"" + id_berkas + "\">";
		    	var append_ket = "<input type=\"text\" name=\"list_ket_dihapus["+jumlah_dihapus+"]\" value=\"" + id_ket + "\">";

		    	$("#daftar_berkas_dihapus").append(append_berkas);
		    	$("#daftar_ket_dihapus").append(append_ket);

		    	// attribute.remove();
		    	$(this).parents("tr").remove();
		    	jumlah_dihapus++;

		    	return false;
		    });

		    $("#inputEmail").keyup(function(){
		    	if($("#inputEmail").val().length >= 4){
		    		$.ajax({
		    			type: "POST",
		    			url: "<?php echo base_url();?>Home/cek_email",
		    			data: "email="+$("#inputEmail").val(),
		    			success: function(msg){
		    				if ($.trim(msg)=="true") {
			    				$("#email_check").text("Email Benar");
			    				$("#email_check").attr("class", "notif-success");
								$("#logo_check").attr("class","glyphicon glyphicon-ok");
		    				}else{
		    					$("#email_check").text("Email Salah");
			    				$("#email_check").attr("class", "notif-error");
								$("#logo_check").attr("class","glyphicon glyphicon-remove");	
		    				}
		    			}
		    		})
		    	}else{
		    		$("#email_check").text("");
					$("#logo_check").attr("class","");
		    	}
		    });

		    $("#inputPass").keyup(function(){
		    	if($("#inputPass").val().length >= 4)
		    	{
		    		var un = {'name' : $("#inputUser").val(),
		    					'pass' : $("#inputPass").val()
		    				};
		    		$.ajax({
		    			type: "POST",
		    			url: "<?php echo base_url();?>Home/konfirm_pass",
		    			data: un,
		    			success:function(msg){
		    				if($.trim(msg) == "true"){
		    					$("#pass_check").text("Password cocok");
		    				}else{
		    					$("#pass_check").text("Password Tidak Cocok");
		    				}
		    			}
		    		});
		    	}else{
		    		$("#pass_check").text("");
		    	}
		    });

		    $("#inputUser").keyup(function(){
				if($("#inputUser").val().length >= 4)
				{
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>Home/cek_username",
						data: "name="+$("#inputUser").val(),
						success: function(msg){
						if($.trim(msg)=="true")
						{
							$("#username_check").text("Username Dapat Digunakan");
							$("#username_check").attr("class", "notif-success");
							$("#logo_check2").attr("class","glyphicon glyphicon-ok");
						}
						else
						{
							$("#username_check").text("Username Telah Terdaftar");
							$("#username_check").attr("class", "notif-error");
							$("#logo_check2").attr("class","glyphicon glyphicon-remove");
						}
						}
					});
				}
				else if($("#inputUser").val().length == 0){
					$("#username_check").text("");
					$("#logo_check2").attr("class","");
				}
				else 
				{
					$("#username_check").text("Username minimal 4 huruf");
					$("#username_check").attr("class", "notif-error");
					$("#logo_check2").attr("class","glyphicon glyphicon-remove");
				}
			});

		    <?php if (!empty($chart)): ?>
			var chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chart',
					type: 'column',
				},
				title: {
					text: '',
					x: -20
				},
				xAxis:{
					title: {
						text: 'Bulan'
					},
					categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
				},
				yAxis:{
					title: {
						text: 'Pendapatan (Rp)'
					}
				},
				series: [{
					name: 'Pendapatan (Rp)',
					data: <?php echo json_encode(($chart));?>,
				}]
			});
		    <?php endif ?>

		});

		$('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:5});

		function deleted (elem) {
			 $(elem).parents("tr").remove();
            return false;
		}
    </script>
  </body>
</html>