<?php 
    $namaKesatuan = $this->session->userdata('login_data_admin')['nama'];
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Kasus Menonjol ({$namaKesatuan}) - Periode {$dateNow}.xls");
?>

<style>
    ul{
      padding-left:0;
    }
    ol{
      padding-left:10px;
    }
    ul> li{
      list-style-type: none;
    }
  </style>
  <!-- DATA -->
  <?php 
    $CI =& get_instance();
    $CI->load->model('Modelbarangbukti');
    $CI->load->model('Modeltersangka');
    $CI->load->model('Modelkesatuan');
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4 py-4">
        <p>Periode : <?= $dateNow ?></p>
        <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'):
        if (!empty($kesatuanChoosen)) { 
        $choosenKesatuan = $CI->Modelkesatuan->getKesatuanByKode($kesatuanChoosen); ?>
        <p>Kesatuan :&nbsp;<?= $choosenKesatuan[0]['nama'] ?></p>
        <?php } endif; ?>
        <hr>
        <h3>Data Kasus Menonjol</h3>
        <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <?php if($allSearch): ?>
                    <th>Kesatuan</th>
                    <?php endif; ?>
                    <th>No Laporan Polisi</th>
                    <th>Tanggal Input LP</th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($dataMenonjol)){ ?>
                <?php 
                $no = 1;
                foreach ($dataMenonjol as $rowMenonjol) { 
                ?>
                <tr>
                    <td class="text-center"><?= $no ?></td>
                    <?php if($allSearch): ?>
                      <td>
                        <?php
                          $result = $CI->Modelkesatuan->getKesatuanByKode($rowMenonjol["kode_kesatuan"]);
                          echo $result[0]['nama']; 
                        ?>
                      </td>
                    <?php endif; ?>
                    <td><?= $rowMenonjol["no_laporanpolisi"]; ?></td>
                    <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowMenonjol["created_at"]))) ?></td>
                </tr>
                <?php $no++; } ?>
            <?php }else{?>
                    <tr>
                        <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Kasus Menonjol Belum Tersedia</p></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
        <hr>
        <h3>Data Kasus Bukan Menonjol</h3>
        <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <?php if($allSearch): ?>
                    <th>Kesatuan</th>
                    <?php endif; ?>
                    <th>No Laporan Polisi</th>
                    <th>Tanggal Input LP</th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($dataBukanMenonjol)){ ?>
                <?php 
                $no = 1;
                foreach ($dataBukanMenonjol as $rowBukanMenonjol) { 
                ?>
                <tr>
                    <td class="text-center"><?= $no ?></td>
                    <?php if($allSearch): ?>
                      <td>
                        <?php
                          $result = $CI->Modelkesatuan->getKesatuanByKode($rowBukanMenonjol["kode_kesatuan"]);
                          echo $result[0]['nama']; 
                        ?>
                      </td>
                    <?php endif; ?>
                    <td><?= $rowBukanMenonjol["no_laporanpolisi"]; ?></td>
                    <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowBukanMenonjol["created_at"]))) ?></td>
                </tr>
                <?php $no++; } ?>
            <?php }else{?>
                    <tr>
                        <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Kasus Menonjol Belum Tersedia</p></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <?php 
	function dateIndonesia($waktu_lengkap){
		$nama_hari = array(
			1 => 'Senin',
			2 => 'Selasa',
			3 => 'Rabu',
			4 => 'Kamis',
			5 => 'Jumat',
			6 => 'Sabtu',
			7 => 'Minggu',
		);
		$nama_bulan = array(
			1 =>  'Januari',
			2 =>  'Februari',
			3 =>  'Maret',
			4 =>  'April',
			5 =>  'Mei',
			6 =>  'Juni',
			7 =>  'Juli',
			8 =>  'Agustus',
			9 =>  'September',
			10 =>  'Oktober',
			11 =>  'November',
			12 =>  'Desember',
		);

		$pisah_waktu = explode(" ",$waktu_lengkap);
		$hari = $pisah_waktu[0];
		$tanggal = $pisah_waktu[1];

		$hari_baru = $nama_hari[$hari];

		$pisah_tanggal = explode("/",$tanggal);
		$tanggal_baru = $pisah_tanggal[0]." ".$nama_bulan[$pisah_tanggal[1]]." ".$pisah_tanggal[2];

		return $hari_baru.", ".$tanggal_baru;
	}
  ?>
  