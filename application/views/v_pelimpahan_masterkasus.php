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
    $CI->load->model('Modelpelimpahan');
    $CI->load->model('Modeladmin');
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4 py-4">
        <div class="content-header">
          <div class="container-fluid">
            <div class="mb-2 text-center">
              <h1 class="m-0">Data Kasus Pelimpahan</h1>
              <p>Periode : <?= $dateNow ?></p>
            </div>
          </div><!-- /.container-fluid -->
        </div>
        <div class="row">
          <div class="col-md-10">
            <!-- View by Date -->
            <form action="<?= base_url() ?>data/viewMatrikBarangBuktiByDate" method="post">
              <div class="section-date row">
                <div class="col-md-8">
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
                    <button type="submit" id="submitDate" class="btn btn-info btn-sm">Sort by Date</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-2 text-right">
              <a class="btn btn-success btn-sm mt-1" href="<?= base_url('export-opsi/pelimpahanMaster') ?>"><span><i class="fas fa-print"></i> </span>Export</a>
          </div>
        </div>
        <table id="table-master-kasus" class="table table-responsive datatable table-bordered table-striped" style="width:100%">
            <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>Action</th>   
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
                  <th>Keterangan</th>
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
                    <td class="text-center" style="font-size:24px;">
                      <?php if($display): ?>
                        <div data-toggle="tooltip" data-placement="top" title="Update Laporan Kasus">
                          <a href="<?= base_url("kasus-pelimpahan/{$row_kasus["id_kasus"]}") ?>" style="cursor:pointer;"><i class="fas fa-pen-square" style="color:green;"></i></a>
                        </div>
                        <div data-toggle="tooltip" data-placement="top" title="Update Status Laporan">
                          <a style="cursor:pointer;" data-toggle="modal" data-target="#statusModal<?= $row_kasus['id_kasus']; ?>"><i class="fas fa-check-square" style="color:darkblue;"></i></a>
                        </div>
                        <div data-toggle="tooltip" data-placement="top" title="Kasus Menonjol">
                          <a class="tombol-kasus-menonjol" style="cursor:pointer;" href="<?= base_url("pelimpahan/updateKasusPelimpahanMenonjol/{$row_kasus['id_kasus']}/{$row_kasus['idkasus_pelimpahanDari']}") ?>"><i class="fas fa-file-archive" style="color:grey;"></i></a>
                        </div>
                      <?php endif; ?>
                    </td>
                    <td><?= $display ? $row_kasus["no_laporanpolisi"] : ""; ?></td>
                    <td><?= $display ? date('l jS \of F Y', strtotime($row_kasus["created_at"])) : ""; ?></td>
                    <td>
                      <?= ($display) ? $row_kasus["deskripsi_waktudantkp"]  :  "" ?>
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
                        $result = $CI->Modelpelimpahan->getBarangBuktiByIdTersangka($row_kasus['id_kasus'], $row_kasus['id_tersangka'])->result_array();
                        if(!empty($result)){ 
                          foreach ($result as $rowBB) { 
                            if($rowBB['isDuplicate']){
                              $duplicateTSK = $CI->Modelpelimpahan->getTersangkaByIdTersangka($row_kasus['id_kasus'], $rowBB['id_duplicateTSK'])->result_array();
                              $duplicateBB = $CI->Modelpelimpahan->getBarangBuktiByIdTersangka($row_kasus['id_kasus'], $rowBB['id_duplicateTSK'])->result_array();
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
                        if ($display) {
                          if (!empty($row_kasus["nrp_admin"])) {
                            $dataAdmin = $CI->Modeladmin->getAdminByNRP($row_kasus['nrp_admin']);
                            echo $dataAdmin[0]['nama_admin'].' - NRP. '.$dataAdmin[0]['nrp'];
                          } else { ?>
                            <a class="btn btn-sm btn-info w-100" data-toggle="modal" data-target="#adminModal<?= $row_kasus['id_kasus']; ?>">Pilih Admin</a>
                          <?php }
                        } else {
                          echo '';
                        }
                        
                      ?>
                    </td>
                    <td>
                      <?php if($display): ?>
                        <?php if($row_kasus["ket_pelimpahan"] == 'diterima'){ ?>
                          <button class="btn btn-success btn-sm"><strong>pelimpahan diterima</strong></button>
                        <?php }else{?>
                          <button class="btn btn-warning btn-sm"><strong>Bukan Pelimpahan</strong></button>
                        <?php }?>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($display): ?>
                        <?php if(empty($row_kasus["status_kasus"])){ ?>
                          <button class="btn btn-warning btn-sm"><strong>Belum Diketahui</strong></button>
                        <?php }else if ($row_kasus["status_kasus"] == 'SP3'){ ?>
                          <button class="btn btn-success btn-sm"><strong>SP3</strong></button>
                        <?php }else if($row_kasus["status_kasus"] == 'Tahap II'){ ?>
                          <button class="btn btn-success btn-sm"><strong>Tahap II</strong></button>
                        <?php }else{?>
                          <button class="btn btn-success btn-sm"><strong>RJ</strong></button>
                        <?php } ?>
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
                            <form action="<?= base_url("pelimpahan/updateStatusKasus/{$row_kasus['id_kasus']}/{$row_kasus['idkasus_pelimpahanDari']}") ?>" method="post">
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
              <!-- Modal Pilih Admin -->
              <div class="modal fade" id="adminModal<?= $row_kasus['id_kasus']; ?>" tabindex="-1" role="dialog" aria-labelledby="adminModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="adminModalLabel">Pilih Administrator</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                            <form action="<?= base_url("pelimpahan/updateAdmin/{$row_kasus['id_kasus']}") ?>" method="post">
                                <div class="form-group">
                                  <label for="nrp">Pilih Admin :</label>
                                  <select name="nrp" class="form-control" required>
                                    <?php 
                                    $resAdmin = $CI->Modeladmin->getAdminByKesatuan($this->session->userdata('login_data_admin')['kodekesatuan']);
                                    foreach ($resAdmin as $keyAdmin) { ?>
                                      <option value="<?= $keyAdmin['nrp'] ?>"><?= $keyAdmin['nama_admin'].' - NRP. '.$keyAdmin['nrp'] ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                                <div class="modal-footer" style="height:10rem;align-items:end;">
                                    <button type="submit" class="btn btn-success">Update</button>
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
  