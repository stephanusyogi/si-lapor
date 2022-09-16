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
        <h2>Data Kasus Menonjol</h2>
        <p>Periode : <?= $dateNow ?></p>
        <div class="alert alert-warning" role="alert">
          Perhatian! Hanya LP yang <strong>terkunci ke database</strong> ter-rekap dalam <strong>data kasus menonjol</strong>.
          Silahkan melengkapi instrumen yang kosong dengan pilihan yang disiapkan!
        </div>
        <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'):
        if (!empty($kesatuanChoosen)) { 
        $choosenKesatuan = $CI->Modelkesatuan->getKesatuanByKode($kesatuanChoosen); ?>
        <p>Kesatuan :&nbsp;<?= $choosenKesatuan[0]['nama'] ?></p>
        <?php } endif; ?>
        <hr>
        <div class="row">
            <div class="col-md-10">
                <a class="btn btn-primary btn-sm mt-1 mx-1" data-toggle="modal" data-target="#sortModal"><span><i class="fas fa-filter"></i> </span>Sort by Date</a>
            </div>
            <div class="col-md-2 text-right">
                <a class="btn btn-success btn-sm mt-1" href="<?= base_url('export-opsi/kasusmenonjol') ?>"><span><i class="fas fa-print"></i> </span>Export</a>
            </div>
        </div>
        <!-- Modal Sort Date -->
        <div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="sortModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sortModalLabel">Sort by Date</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url() ?>data/viewKasusMenonjolByDate" method="post">
                            <div class="section-date row">
                            <div class="col-md-12">
                                <div id="formDateSettings">
                                <div class="formDate row">
                                    <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'): ?>  
                                    <div class="form-group col-md-4">
                                            <?php $kesatuan = $CI->Modeldata->getKesatuan($this->session->userdata('login_data_admin')['kodekesatuan']); ?>
                                            <label for="kode_kesatuan">Pilih kesatuan / jajaran :</label>
                                            <select name="kode_kesatuan" class="form-control" data-live-search="true" required>
                                                <option value="all">All</option>
                                                <?php foreach ($kesatuan as $keyKesatuan) { ?>
                                                <option value="<?= $keyKesatuan['kode_kesatuan'] ?>"><?= $keyKesatuan['nama'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group col-md-4">
                                        <label>Pilih Tanggal Awal</label>
                                        <div class="input-group date" id="tanggalAwalHarian" data-target-input="nearest">
                                        <input type="text" name="tanggalAwal" class="form-control datetimepicker-input" data-target="#tanggalAwalHarian" placeholder="Pilih Tanggal Awal" required autocomplete="off"/>
                                        <div class="input-group-append" data-target="#tanggalAwalHarian" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Pilih Tanggal Akhir</label>
                                        <div class="input-group date" id="tanggalAkhirHarian" data-target-input="nearest">
                                        <input type="text" name="tanggalAkhir" class="form-control datetimepicker-input" data-target="#tanggalAkhirHarian" placeholder="Pilih Tanggal Akhir" autocomplete="off"/>
                                        <div class="input-group-append" data-target="#tanggalAkhirHarian" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="modal-footer" style="height:10rem;align-items:end;">
                                <button type="submit" id="submitDate" class="btn btn-success">Terapkan</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>
            <div style="height:20rem;overflow-y:scroll;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                        <th>Laporan Kasus Menonjol</th>
                        <th>Laporan Kasus Bukan Menonjol</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($dataKasus)){ ?>
                        <tr>
                            <td class="text-center"><?= $dataKasus['Menonjol'] ?></td>
                            <td class="text-center"><?= $dataKasus['BukanMenonjol'] ?></td>
                        </tr>
                    <?php }else{?>
                            <tr>
                                <td colspan="2" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Kasus Menonjol Belum Tersedia</p></td>
                            </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <hr>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th style="width:40%;">Kesatuan</th>
                            <th>Menonjol</th>
                            <th>Bukan Menonjol</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($dataKasus)){ 
                        foreach ($matrikMenonjol as $keyKesatuan => $item) {
                        ?>
                        <tr class="text-center">
                            <td><?php 
                            $kesatuan = $CI->Modelkesatuan->getKesatuanByKode($keyKesatuan);
                            echo $kesatuan[0]['nama'];?>
                            </td>
                            <td><?= $item['Menonjol'] ?></td>
                            <td><?= $item['BukanMenonjol'] ?></td>
                        </tr>
                    <?php } 
                        if(!isset($orderDate)):
                        ?> 
                        <tr class="text-center">
                            <td><strong>TOTAL</strong></td>
                            <td><?= $totalMatrikMenonjol['Menonjol'] ?></td>
                            <td><?= $totalMatrikMenonjol['BukanMenonjol'] ?></td>
                        </tr>
                    <?php endif; }else{?>
                            <tr>
                                <td colspan="3" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Selra Belum Tersedia</p></td>
                            </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="menonjol-tab" data-toggle="tab" data-target="#menonjol" type="button" role="tab" aria-controls="menonjol" aria-selected="false">Laporan Kasus Menonjol</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bukanmenonjol-tab" data-toggle="tab" data-target="#bukanmenonjol" type="button" role="tab" aria-controls="bukanmenonjol" aria-selected="true">Laporan Kasus Bukan Menonjol</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- Kasus Menonjol -->
                <div class="tab-pane fade show active py-3" id="menonjol" role="tabpanel" aria-labelledby="menonjol-tab">
                    <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr class="text-center">
                              <th>No</th>
                              <th>Kesatuan</th>
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
                                <td><?= $rowMenonjol["kode_kesatuan"]; ?></td>
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
                </div>
                <!-- Kasus Bukan Menonjol -->
                <div class="tab-pane fade py-3" id="bukanmenonjol" role="tabpanel" aria-labelledby="bukanmenonjol-tab">
                    <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr class="text-center">
                              <th>No</th>
                              <th>Kesatuan</th>
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
                                <td><?php
                                $result = $CI->Modelkesatuan->getKesatuanByKode($rowBukanMenonjol["kode_kesatuan"]);
                                echo $result[0]['nama']; ?></td>
                                <td><?= $rowBukanMenonjol["no_laporanpolisi"]; ?></td>
                                <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowBukanMenonjol["created_at"]))) ?></td>
                            </tr>
                            <?php $no++; } ?>
                        <?php }else{?>
                                <tr>
                                    <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Selra Belum Tersedia</p></td>
                                </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php }else{ ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                      <th>Laporan Kasus Menonjol</th>
                      <th>Laporan Kasus Bukan Menonjol</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($dataKasus)){ ?>
                    <tr>
                        <td class="text-center"><?= $dataKasus['Menonjol'] ?></td>
                        <td class="text-center"><?= $dataKasus['BukanMenonjol'] ?></td>
                    </tr>
                <?php }else{?>
                        <tr>
                            <td colspan="2" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Kasus Menonjol Belum Tersedia</p></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
            <hr>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="menonjol-tab" data-toggle="tab" data-target="#menonjol" type="button" role="tab" aria-controls="menonjol" aria-selected="false">Laporan Kasus Menonjol</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bukanmenonjol-tab" data-toggle="tab" data-target="#bukanmenonjol" type="button" role="tab" aria-controls="bukanmenonjol" aria-selected="true">Laporan Kasus Bukan Menonjol</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- Kasus Menonjol -->
                <div class="tab-pane fade show active py-3" id="menonjol" role="tabpanel" aria-labelledby="menonjol-tab">
                    <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Action</th>
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
                                <td class="text-center">
                                  <div data-toggle="tooltip" data-placement="top" title="Batalkan Kasus Menonjol">
                                    <a class="tombol-batal-menonjol btn btn-primary btn-sm" href="<?= base_url("data/batalKasusMenonjol/{$rowMenonjol["id_kasus"]}") ?>"><i class="fas fa-file-archive"></i></a>
                                  </div>
                                </td>
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
                </div>
                <!-- Kasus Bukan Menonjol -->
                <div class="tab-pane fade py-3" id="bukanmenonjol" role="tabpanel" aria-labelledby="bukanmenonjol-tab">
                    <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr class="text-center">
                            <th>No</th>
                            <th>Action</th>
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
                                <td class="text-center">
                                  <div data-toggle="tooltip" data-placement="top" title="Ubah ke Kasus Menonjol">
                                    <a class="tombol-kasus-menonjol btn btn-primary btn-sm" href="<?= base_url("data/updateKasusMenonjol/{$rowBukanMenonjol["id_kasus"]}") ?>"><i class="fas fa-file-archive"></i></a>
                                  </div>
                                </td>
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
                </div>
            </div>
        <?php } ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
  $(document).ready(function() {
    
    $(".tombol-kasus-menonjol").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Ubah ke Kasus Menonjol?",
        text: "Mengubah data bersifat permanen pada database, mohon berhati-hati.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Update!",
      }).then((result) => {
        if (result.isConfirmed) {
          document.location.href = href;
        }
      });
    });
    
    $(".tombol-batal-menonjol").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Batalkan Kasus Menonjol?",
        text: "Membatalkan bersifat permanen pada database, mohon berhati-hati.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Update!",
      }).then((result) => {
        if (result.isConfirmed) {
          document.location.href = href;
        }
      });
    });

    $('#tanggalAwalHarian').datetimepicker({
        format: 'YYYY-MM-DD'
    });
        
    $('#tanggalAkhirHarian').datetimepicker({
        format: 'YYYY-MM-DD'
    });
  });
  </script>
  
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
  