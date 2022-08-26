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
    .bootstrap-select button{
        background: white!important;
        text-transform: inherit!important;
        font-weight: normal!important;
    }
  </style>
  <!-- DATA -->
  <?php 
    $CI =& get_instance();
    $CI->load->model('Modelbarangbukti');
    $CI->load->model('Modeltersangka');
    $CI->load->model('Modeladmin');
    $CI->load->model('Modelkesatuan');
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="mb-2 text-center">
            <h1 class="m-0">REKAPITULASI TERSANGKA T.P. NARKOTIKA & PSIKOTROPIKA</h1>
            <h2 class="m-0">(<?= $this->session->userdata('login_data_admin')['nama'] ?>)</h2>
            <p>Periode : <?= $dateNow ?></p>
          </div>
        </div><!-- /.container-fluid -->
      </div>
      <hr class="my-2">
      <div class="row">
        <div class="col-md-10 d-flex">
          <a class="btn btn-primary btn-sm mt-1 mx-1" data-toggle="modal" data-target="#searchModal"><span><i class="fas fa-search"></i> </span>Search by Kesatuan</a>
          <a class="btn btn-primary btn-sm mt-1 mx-1" data-toggle="modal" data-target="#sortModal"><span><i class="fas fa-filter"></i> </span>Sort by Date</a>
        </div>
        <div class="col-md-2 text-right">
          <a class="btn btn-success btn-sm mt-1" href="<?= base_url('export-opsi/kasusMaster') ?>"><span><i class="fas fa-print"></i> </span>Export</a>
        </div>
      </div>
      <!-- Modal Search Kesatuan -->
      <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="searchModalLabel">Search by Kesatuan</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <form action="#" method="post">
                        <div class="modal-footer" style="height:10rem;align-items:end;">
                            <button type="submit" class="btn btn-success">Terapkan</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                  </div>
              </div>
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
                    <form action="<?= base_url() ?>data/viewMasterKasusByDate" method="post">
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
      <hr class="my-2">
        <table id="table-master-kasus" class="table table-responsive datatable table-bordered table-striped " style="width:100%">
            <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>Kesatuan</th>
                  <th>No Laporan Polisi</th>
                  <th>Created Date</th>
                  <th>Deskripsi Waktu & TKP</th>
                  <th>Identitas Tersangka</th> 
                  <th>Umur</th> 
                  <th>Pendidikan</th> 
                  <th>Pekerjaan</th> 
                  <th>Barang Bukti</th> 
                  <th>Modus Operandi</th> 
                  <th>Administrator</th>
                  <th>Keterangan Pelimpahan</th> 
                  <th>Status</th>
                  <th>LP Menonjol</th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($dataKasus)){ ?>
                <?php 
                $no = 1;
                $account_numbers = array();
                foreach ($dataKasus as $row_kasus) { 
                    $display = FALSE;
                    if(!in_array($row_kasus["no_laporanpolisi"], $account_numbers)) {
                        array_push($account_numbers, $row_kasus["no_laporanpolisi"]);
                        $display = TRUE;
                    }
                  ?>
                <tr>
                    <td class="text-center"><?= ($display) ? $no : "" ?></td>
                    <td class="textcenter">
                      <?php $dataKesatuan =  $CI->Modelkesatuan->getKesatuanByKode($row_kasus['kode_kesatuan']);?>
                      <?= ($display) ? $dataKesatuan[0]["nama"]  :  "" ?>
                    </td>
                    <td><?= $display ? $row_kasus["no_laporanpolisi"] : ""; ?></td>
                    <td><?= $display ? date('l jS \of F Y', strtotime($row_kasus["created_at"])) : ""; ?></td>
                    <td>
                      <?= $row_kasus["deskripsi_waktudantkp"] ?>
                    </td>
                    <td>
                      <ul>
                        <li><strong>NAMA</strong> : <?= $row_kasus["nama"] ?></li>
                        <li><strong>ALAMAT</strong> : <?= $row_kasus["alamat"] ?></li>
                        <li><strong>NIK</strong> : <?= $row_kasus["nik"] ?></li>
                        <li><strong>AGAMA</strong> : <?= $row_kasus["agama"] ?></li>
                        <li><strong>JENIS KELAMIN</strong> : <?= $row_kasus["jenis_kelamin"] ?></li>
                        <li><strong>KEWARGANAGARAAN</strong> : <?= $row_kasus["status_kewarganegaraan"] ?></li>
                        <li><strong>STATUS</strong> : <?= $row_kasus["status"] ?></li>
                      </ul>
                    </td>
                    <td><?= $row_kasus["usia"] ?></td>
                    <td><?= $row_kasus["pendidikan"] ?></td>
                    <td><?= $row_kasus["pekerjaan"] ?></td>
                    <td>
                      <ol>
                      <?php 
                        $result = $CI->Modelbarangbukti->getBarangBuktiByIdTersangka($row_kasus['id_kasus'], $row_kasus['id_tersangka'])->result_array();
                        if(!empty($result)){ 
                          foreach ($result as $rowBB) { 
                            if($rowBB['isDuplicate']){
                              $duplicateTSK = $CI->Modeltersangka->getTersangkaByIdTersangka($row_kasus['id_kasus'], $rowBB['id_duplicateTSK'])->result_array();
                              $duplicateBB = $CI->Modelbarangbukti->getBarangBuktiByIdTersangka($row_kasus['id_kasus'], $rowBB['id_duplicateTSK'])->result_array();
                              ?>
                            <button class="btn-info btn btn-sm">
                              Barang bukti sama dengan tersangka a.n <?= $duplicateTSK[0]['nama'] ?> (<strong><?= $duplicateBB[0]['kategori'] ?></strong>)
                            </button>
                            <?php }else{ ?>
                              <li>
                                <strong><?= $rowBB['nama_barangbukti'] ?></strong>
                                <?php if($rowBB['keterangan']) { ?>
                                  yakni&nbsp;<?= $rowBB['keterangan'] ?>&nbsp;sejumlah&nbsp;<?= $rowBB['jumlah'] ?>&nbsp;<?= $rowBB['satuan'] ?>&nbsp;dengan berat&nbsp;<?= $rowBB['berat'] ?>&nbsp;gram.
                                <?php }else{ ?>
                                  dengan berat&nbsp;<?= $rowBB['jumlah'] ?>&nbsp;<?= $rowBB['satuan'] ?>
                                <?php } ?>
                              </li>
                          <?php } } ?> 
                        <?php } else { ?>
                          <button class="btn btn-warning btn-sm"><strong>Belum Diketahui</strong></button>
                        <?php } ?>
                        </ol>
                    </td>
                    <td><?= $display ? $row_kasus["pasal"] : '' ?></td>
                    <td>
                      <?php
                        $dataAdmin = $CI->Modeladmin->getAdminByNRP($row_kasus['nrp_admin']);
                        if($display){ echo $dataAdmin[0]['nama_admin'].' - NRP. '.$dataAdmin[0]['nrp']; }else{ echo '';};
                      ?>
                    </td>
                    <td>
                      <?php if($display): ?>
                        <?php if($row_kasus["ket_pelimpahan"] == 'dilimpahkan'){ ?>
                          <button class="btn btn-success btn-sm"><strong>Dilimpahkan</strong></button>
                        <?php }else{?>
                          <button class="btn btn-warning btn-sm"><strong>Bukan Pelimpahan</strong></button>
                        <?php } ?>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($display): ?>
                        <?php if(empty($row_kasus["status_kasus"])){ ?>
                          <button class="btn btn-warning btn-sm"><strong>Belum Diketahui</strong></button>
                        <?php }else if ($row_kasus["status_kasus"] == 'TAHAP II'){ ?>
                          <button class="btn btn-success btn-sm"><strong>Tahap II</strong></button>
                        <?php }else if($row_kasus["status_kasus"] == 'SP3'){ ?>
                          <button class="btn btn-success btn-sm"><strong>SP3</strong></button>
                        <?php }else{?>
                          <button class="btn btn-success btn-sm"><strong>RJ</strong></button>
                        <?php }?>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($display): ?>
                        <?php if($row_kasus["isKasusMenonjol"]){ ?>
                          <button class="btn btn-success btn-sm"><strong>Kasus Menonjol</strong></button>
                        <?php }else{?>
                          <button class="btn btn-warning btn-sm"><strong>Bukan Kasus Menonjol</strong></button>
                        <?php }?>
                      <?php endif; ?>
                    </td>
                </tr>
              <!-- Modal Status Kasus -->
              <div class="modal fade" id="statusModal<?= $row_kasus['id_kasus']; ?>" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="statusModalLabel">Update Status Kasus</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                            <form action="<?= base_url("data/updateStatusKasus/{$row_kasus['id_kasus']}/") ?>" method="post">
                                <div class="form-group">
                                  <label for="status_kasus">Status :</label>
                                  <select name="status_kasus" id="status_kasus" class="form-control" required>
                                    <option value="<?= $row_kasus['status_kasus'] ?>" selected><?= $row_kasus['status_kasus'] ?></option>
                                    <option value="SP3">SP3</option>
                                    <option value="RJ">RJ</option>
                                    <option value="TAHAP II">TAHAP II</option>
                                    <option value="">Belum Diketahui</option>
                                  </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                </div>
                            </form>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- Modal Limpahkan Kasus -->
              <div class="modal fade" id="pelimpahanModal<?= $row_kasus['id_kasus']; ?>" tabindex="-1" role="dialog" aria-labelledby="pelimpahanModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="pelimpahanModalLabel">Pelimpahan Kasus</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                            <form action="<?= base_url("pelimpahan/addKasusPelimpahan/{$row_kasus['id_kasus']}") ?>" method="post">
                                <div class="form-group">
                                  <label for="kode_kesatuan">Pilih kesatuan / jajaran yang akan dilimpahkan :</label>
                                  <select name="kode_kesatuan" class="form-control" data-live-search="true" required>
                                    <?php foreach ($kesatuan as $keyKesatuan) { ?>
                                      <option value="<?= $keyKesatuan['kode_kesatuan'] ?>"><?= $keyKesatuan['nama'] ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="nama_polsek">Isi bagian berikut apabila pelimpahan kepada <strong>polsek</strong>.</label>
                                  <input type="text" class="form-control" name="nama_polsek" style="text-transform:uppercase;" placeholder="Tulis Nama Polsek" autocomplete="off">
                                </div>
                                <div class="modal-footer" style="height:10rem;align-items:end;">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                </div>
                            </form>
                          </div>
                      </div>
                  </div>
              </div>
                <?php ($display) ? $no++ : $no; } ?>
            <?php }else{?>
                    <tr>
                        <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Barang Bukti Belum Tersedia</p></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>    
  $(document).ready(function() {
    $(".tombol-hapus-masterkasus").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Hapus Ungkap Kasus?",
        text: "Menghapus data bersifat permanen pada database, mohon berhati-hati.",
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
    
    $('#tanggalAwalHarian').datetimepicker({
        format: 'YYYY-MM-DD'
    });
      
    $('#tanggalAkhirHarian').datetimepicker({
        format: 'YYYY-MM-DD'
    });
  });
  </script>
  