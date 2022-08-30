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
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4 py-2">
        <div class="content-header">
          <div class="container-fluid">
            <div class="mb-2 text-center">
              <h1 class="m-0">Riwayat Kasus Pelimpahan</h1>
              <p>Periode : <?= $dateNow ?></p>
            </div>
            <div class="row">
              <div class="col-md-10">
                <a class="btn btn-primary btn-sm mt-1 mx-1" data-toggle="modal" data-target="#sortModal"><span><i class="fas fa-filter"></i> </span>Sort by Date</a>
              </div>
              <div class="col-md-2 text-right">
                  <a class="btn btn-success btn-sm mt-1" href="<?= base_url('export-opsi/pelimpahanRiwayat') ?>"><span><i class="fas fa-print"></i> </span>Export</a>
              </div>
            </div>
            <!-- Modal Sort Date -->
            <div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="sortModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="sortModalLabel">Sort by Date</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url() ?>pelimpahan/viewRiwayatPelimpahanByDate" method="post">
                                <div class="section-date row">
                                <div class="col-md-12">
                                    <div id="formDateSettings">
                                    <div class="formDate d-flex">
                                        <div class="form-group">
                                            <label>Pilih Tanggal Awal</label>
                                            <div class="input-group date" id="tanggalAwalHarian" data-target-input="nearest">
                                            <input type="text" name="tanggalAwal" class="form-control datetimepicker-input" data-target="#tanggalAwalHarian" placeholder="Pilih Tanggal Awal" required autocomplete="off"/>
                                            <div class="input-group-append" data-target="#tanggalAwalHarian" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group mx-2">
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
        </div><!-- /.container-fluid -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="diterima-tab" data-toggle="tab" data-target="#diterima" type="button" role="tab" aria-controls="diterima" aria-selected="true"><strong>LP Diterima</strong></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dilimpahkan-tab" data-toggle="tab" data-target="#dilimpahkan" type="button" role="tab" aria-controls="dilimpahkan" aria-selected="false"><strong>LP Dilimpahkan</strong></button>
            </li>
        </ul>
        <div class="tab-content py-4" id="myTabContent">
          <div class="tab-pane fade py-3" id="diterima" role="tabpanel" aria-labelledby="diterima-tab">
                <table class="table table-pelimpahan datatable table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>No Laporan Polisi</th>
                            <th>Diterima Dari</th>
                            <th>Kepada Polsek</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($LPditerima)){ ?>
                            <?php 
                            $no = 1;
                            foreach ($LPditerima as $rowLPditerima) { 
                            ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $rowLPditerima['no_laporanpolisi'] ?></td>
                                <td><?= $rowLPditerima['kodekesatuan_pelimpahanDari']?></td>
                                <td><?= $rowLPditerima['nama_polsek']?></td>
                                <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowLPditerima["created_at"]))) ?></td>
                            </tr>
                            <?php $no++; } ?>
                        <?php }else{?>
                                <tr>
                                    <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Selra Belum Tersedia</p></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <hr>
          </div>
          <div class="tab-pane fade show active py-3" id="dilimpahkan" role="tabpanel" aria-labelledby="dilimpahkan-tab">
                <table class="table table-pelimpahan datatable table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Batalkan Pelimpahan</th>
                            <th>No Laporan Polisi</th>
                            <th>Dilimpahkan Ke</th>
                            <th>Kepada Polsek</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($LPdilimpahkan)){ ?>
                            <?php 
                            $no = 1;
                            foreach ($LPdilimpahkan as $rowLPdilimpahkan) { 
                            ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td class="text-center">
                                    <div data-toggle="tooltip" data-placement="top" title="Batalkan Pelimpahan">
                                    <a class="tombol-batal-pelimpahan" href="<?= base_url() ?>pelimpahan/batalPelimpahan/<?= $rowLPdilimpahkan['idKasusPelimpahan'] ?>/<?= $rowLPdilimpahkan['id_kasus'] ?>" ><i class="fas fa-trash" style="color:red;"></i></a>
                                    </div>
                                </td>
                                <td><?= $rowLPdilimpahkan['no_laporanpolisi'] ?></td>
                                <td><?= $rowLPdilimpahkan['kodekesatuan_pelimpahanKe']?></td>
                                <td><?= $rowLPdilimpahkan['namaPolsekPelimpahan']?></td>
                                <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowLPdilimpahkan["created_at"]))) ?></td>
                            </tr>
                            <?php $no++; } ?>
                        <?php }else{?>
                                <tr>
                                    <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Selra Belum Tersedia</p></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <hr>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <script>    
  $(document).ready(function() {
    $(".tombol-batal-pelimpahan").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Batalkan Pelimpahan?",
        text: "Membatalkan pelimpahan data bersifat permanen pada database, mohon berhati-hati.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Delete!",
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