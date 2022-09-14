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
    $CI->load->model('Modelkesatuan');
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
            <a class="btn btn-primary btn-sm mt-1 mx-1" data-toggle="modal" data-target="#sortModal"><span><i class="fas fa-filter"></i> </span>Sort by Date</a>
          </div>
          <div class="col-md-2 text-right">
            <a class="btn btn-success btn-sm mt-1" href="<?= base_url('export-opsi/pelimpahanMaster') ?>"><span><i class="fas fa-print"></i> </span>Export</a>
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
                        <form action="<?= base_url() ?>pelimpahan/viewKasusPelimpahanByDate" method="post">
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

        <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>

          <table id="table-master-kasus" class="table table-responsive datatable table-bordered table-striped" style="width:100%">
              <thead>
                  <tr class="text-center">
                    <th>No</th>
                    <th>No Laporan Polisi</th>
                    <th>Tanggal Pelimpahan</th>
                    <th>Dari Kesatuan</th>
                    <th>Untuk Kesatuan</th> 
                  </tr>
              </thead>
              <tbody>
                <?php if(isset($dataKasus)){ ?>
                    <?php 
                    $no = 1;
                    foreach ($dataKasus as $row_kasus) { 
                      ?>
                    <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td><?= $row_kasus['no_laporanpolisi']  ?></td>
                        <td><?=  dateIndonesia(date('N j/n/Y', strtotime($row_kasus["created_at"]))) ?></td>
                        <td><?php 
                          $dataKesatuanUntuk =  $CI->Modelkesatuan->getKesatuanByKode($row_kasus['kodekesatuan_pelimpahanDari']);
                          echo $dataKesatuanUntuk[0]['nama'];
                        ?></td>
                        <td>
                          <?php $dataKesatuanDari =  $CI->Modelkesatuan->getKesatuanByKode($row_kasus['kode_kesatuan']); ?>
                          <?= ($row_kasus['nama_polsek']) ? $dataKesatuanDari[0]['nama'] . ' || '.$row_kasus['nama_polsek'] : $dataKesatuanDari[0]['nama']  ?>
                        </td>
                    </tr>
                    <?php $no++; } ?>
                <?php }else{?>
                        <tr>
                            <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Pelimpahan Belum Tersedia</p></td>
                        </tr>
                <?php } ?>
              </tbody>
          </table>


        <?php }else{ ?>

          <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="diterima-tab" data-toggle="tab" data-target="#diterima" type="button" role="tab" aria-controls="diterima" aria-selected="true">Data LP yang <strong>Diterima</strong></button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link" id="dilimpahkan-tab" data-toggle="tab" data-target="#dilimpahkan" type="button" role="tab" aria-controls="dilimpahkan" aria-selected="false">Data LP yang <strong>Dilimpahkan</strong></button>
              </li>
          </ul>
          
        <div class="tab-content py-4" id="myTabContent">
          <div class="tab-pane fade show active py-3" id="diterima" role="tabpanel" aria-labelledby="diterima-tab">
            <table class="table table-pelimpahan table-responsive datatable table-bordered table-striped" style="width:100%">
                <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Action</th>   
                      <th>No Laporan Polisi</th>
                      <th>Tanggal Input LP</th>
                      <th>Durasi Perkara</th>
                      <th>Deskripsi Waktu & TKP</th>
                      <th>Identitas Tersangka</th> 
                      <th>Umur</th> 
                      <th>Pendidikan</th> 
                      <th>Pekerjaan</th> 
                      <th>Barang Bukti</th> 
                      <th>Modus Operandi</th> 
                      <th>Administrator</th> 
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
                          $resKasusFrom = $CI->Modelpelimpahan->getKasusById($row_kasus['idkasus_pelimpahanDari']);
                        ?>
                      <tr>
                          <td class="text-center"><?= ($display) ? $no : "" ?></td>
                          <td class="text-center" style="font-size:24px;">
                            <?php if($display): ?>
                              <div data-toggle="tooltip" data-placement="top" title="Pilih Status SELRA">
                                <a style="cursor:pointer;" data-toggle="modal" data-target="#statusModal<?= $row_kasus['id_kasus']; ?>"><i class="fas fa-check-square" style="color:darkblue;"></i></a>
                              </div>
                              <div data-toggle="tooltip" data-placement="top" title="<?= ($row_kasus['isKasusMenonjol']) ? 'Batalkan Kasus Menonjol' : 'Ubah ke Kasus Menonjol' ?>">
                                <a class="<?= ($row_kasus['isKasusMenonjol']) ? 'tombol-batal-menonjol' : 'tombol-kasus-menonjol' ?>" style="cursor:pointer;" href="<?= ($row_kasus['isKasusMenonjol']) ? base_url("pelimpahan/batalKasusPelimpahanMenonjol/{$row_kasus['id_kasus']}/{$row_kasus['idkasus_pelimpahanDari']}") : base_url("pelimpahan/updateKasusPelimpahanMenonjol/{$row_kasus['id_kasus']}/{$row_kasus['idkasus_pelimpahanDari']}") ?>"><i class="fas fa-file-archive" style="color:grey;"></i></a>
                              </div>
                            <?php endif; ?>
                          </td>
                          <td><?= $display ? $row_kasus["no_laporanpolisi"] : ""; ?></td>
                          <td><?= $display ? dateIndonesia(date('N j/n/Y', strtotime($row_kasus["created_at"]))) : ""; ?></td>
                          <td>
                          <?php if($display): 
                            if(!empty($resKasusFrom[0]["date_statusKasus"])):
                              $diffSelra = date_diff(date_create($resKasusFrom[0]["created_at"]), date_create($resKasusFrom[0]["date_statusKasus"]));
                              echo $diffSelra->format("%a")." Hari (SELRA)";
                            else:
                              $diff = date_diff(date_create($resKasusFrom[0]["created_at"]), date_create(date("Y-m-d")));
                              echo $diff->format("%a")." Hari - Hingga Hari Ini";
                            endif; 
                          endif; ?>
                          </td>
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
                              <?php if(empty($row_kasus["status_kasus"])){ ?>
                                <button class="btn btn-warning btn-sm">
                                  <strong>Belum Diketahui</strong>
                                </button>
                              <?php }else if ($row_kasus["status_kasus"] == 'SP3'){ ?>
                                <button class="btn btn-success btn-sm">
                                  <strong>SP3</strong>
                                  <?php if(!empty($resKasusFrom[0]["ket_statusKasus"])): ?>
                                      <p><strong>Keterangan :</strong>&nbsp;<?= $resKasusFrom[0]["ket_statusKasus"] ?></p>
                                  <?php endif; ?>
                                </button>
                              <?php }else if($row_kasus["status_kasus"] == 'Tahap II'){ ?>
                                <button class="btn btn-success btn-sm">
                                  <strong>Tahap II</strong>
                                  <?php if(!empty($resKasusFrom[0]["ket_statusKasus"])): ?>
                                      <p><strong>Keterangan :</strong>&nbsp;<?= $resKasusFrom[0]["ket_statusKasus"] ?></p>
                                  <?php endif; ?>
                                </button>
                              <?php }else{?>
                                <button class="btn btn-success btn-sm">
                                  <strong>RJ</strong>
                                  <?php if(!empty($resKasusFrom[0]["ket_statusKasus"])): ?>
                                      <p><strong>Keterangan :</strong>&nbsp;<?= $resKasusFrom[0]["ket_statusKasus"] ?></p>
                                  <?php endif; ?>
                                </button>
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
                    <!-- Modal Status Kasus -->
                    <div class="modal fade" id="statusModal<?= $row_kasus['id_kasus']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Ubah Status SELRA</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= base_url("pelimpahan/updateStatusKasus/{$row_kasus['id_kasus']}/{$row_kasus['idkasus_pelimpahanDari']}") ?>" method="post">
                                        <div class="form-group">
                                            <label for="status_kasus">Status SELRA:</label>
                                            <select name="status_kasus" id="status_kasus" class="form-control" required>
                                                <option selected value="<?= $resKasusFrom[0]['status_kasus'] ?>"><?= $resKasusFrom[0]['status_kasus'] ?></option>
                                                <option value="SP3">SP3</option>
                                                <option value="RJ">RJ</option>
                                                <option value="TAHAP II">TAHAP II</option>
                                                <option value="">Belum Diketahui</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Keterangan SELRA <small style="color:red;">*opsional</small></label>
                                            <textarea class="form-control" name="ket_statusKasus" rows="5" placeholder="Tulis Keterangan SELRA disini. Untuk SELRA Tahap II, mohon sertakan keterangan lokasi pelimpahan."><?= $resKasusFrom[0]['ket_statusKasus'] ?></textarea>
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
                      <?php ($display) ? $no++ : $no; } ?>
                  <?php }else{?>
                          <tr>
                              <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Barang Bukti Belum Tersedia</p></td>
                          </tr>
                  <?php } ?>
                </tbody>
            </table>
          </div>
          <div class="tab-pane fade py-3" id="dilimpahkan" role="tabpanel" aria-labelledby="dilimpahkan-tab">
            <table class="table table-pelimpahan table-responsive datatable table-bordered table-striped" style="width:100%">
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
                      <th>Administrator Pelimpahan</th> 
                      <th>Status</th>
                      <th>LP Menonjol</th>
                    </tr>
                </thead>
                <tbody>
                  <?php if(isset($dataKasusPelimpahan)){ ?>
                      <?php 
                      $no = 1;
                      $account_numbers_pelimpahan = array();
                      foreach ($dataKasusPelimpahan as $row_kasusPelimpahan) { 
                          $displayPelimpahan = FALSE;
                          if(!in_array($row_kasusPelimpahan["no_laporanpolisi"], $account_numbers_pelimpahan)) {
                              array_push($account_numbers_pelimpahan, $row_kasusPelimpahan["no_laporanpolisi"]);
                              $displayPelimpahan = TRUE;
                          } 
                          $resKasusFrom = $CI->Modelpelimpahan->getKasusById($row_kasusPelimpahan['idkasus_pelimpahanDari']);
                        ?>
                      <tr>
                          <td class="text-center"><?= ($displayPelimpahan) ? $no : "" ?></td>
                          <td class="text-center">
                            <?php if($displayPelimpahan): ?>
                              <div data-toggle="tooltip" data-placement="top" title="Batal & Hapus Pelimpahan">
                                <a class="tombol-hapus-pelimpahan" href="<?= base_url() ?>pelimpahan/batalPelimpahan/<?= $row_kasusPelimpahan['id_kasus'] ?>/<?= $row_kasusPelimpahan['idkasus_pelimpahanDari'] ?>" ><i class="fas fa-trash" style="color:red;"></i></a>
                              </div>
                            <?php endif; ?>
                          </td>
                          <td><?= $displayPelimpahan ? $row_kasusPelimpahan["no_laporanpolisi"] : ""; ?></td>
                          <td><?= $displayPelimpahan ? dateIndonesia(date('N j/n/Y', strtotime($row_kasusPelimpahan["created_at"]))) : ""; ?></td>
                          <td>
                            <?= ($displayPelimpahan) ? $row_kasusPelimpahan["deskripsi_waktudantkp"]  :  "" ?>
                          </td>
                          <td>
                            <ul>
                              <li><strong>NAMA</strong> : <?= $row_kasusPelimpahan["nama"] ?></li>
                              <li><strong>ALAMAT</strong> : <?= $row_kasusPelimpahan["alamat"] ?></li>
                              <li><strong>NIK</strong> : <?= $row_kasusPelimpahan["nik"] ?></li>
                              <li><strong>AGAMA</strong> : <?= $row_kasusPelimpahan["agama"] ?></li>
                              <li><strong>JENIS KELAMIN</strong> : <?= $row_kasusPelimpahan["jenis_kelamin"] ?></li>
                              <li><strong>KEWARGANAGARAAN</strong> : <?= $row_kasusPelimpahan["status_kewarganegaraan"] ?></li>
                              <li><strong>STATUS</strong> : <?= $row_kasusPelimpahan["status"] ?></li>
                            </ul>
                          </td>
                          <td><?= $row_kasusPelimpahan["usia"] ?></td>
                          <td><?= $row_kasusPelimpahan["pendidikan"] ?></td>
                          <td><?= $row_kasusPelimpahan["pekerjaan"] ?></td>
                          <td>
                            <ol>
                            <?php 
                              $resultPelimpahan = $CI->Modelpelimpahan->getBarangBuktiByIdTersangka($row_kasusPelimpahan['id_kasus'], $row_kasusPelimpahan['id_tersangka'])->result_array();
                              if(!empty($resultPelimpahan)){ 
                                foreach ($resultPelimpahan as $rowBBPelimpahan) { 
                                  if($rowBBPelimpahan['isDuplicate']){
                                    $duplicateTSK = $CI->Modelpelimpahan->getTersangkaByIdTersangka($row_kasusPelimpahan['id_kasus'], $rowBBPelimpahan['id_duplicateTSK'])->result_array();
                                    $duplicateBB = $CI->Modelpelimpahan->getBarangBuktiByIdTersangka($row_kasusPelimpahan['id_kasus'], $rowBBPelimpahan['id_duplicateTSK'])->result_array();
                                    ?>
                                  <button class="btn-info btn btn-sm">
                                    Barang bukti sama dengan tersangka a.n <?= $duplicateTSK[0]['nama'] ?> (<strong><?= $duplicateBB[0]['kategori'] ?></strong>)
                                  </button>
                                  <?php }else{ ?>
                                    <li>
                                      <strong><?= $rowBBPelimpahan['nama_barangbukti'] ?></strong>
                                      <?php if($rowBBPelimpahan['keterangan']) { ?>
                                        yakni&nbsp;<?= $rowBBPelimpahan['keterangan'] ?>&nbsp;sejumlah&nbsp;<?= $rowBBPelimpahan['jumlah'] ?>&nbsp;<?= $rowBBPelimpahan['satuan'] ?>&nbsp;dengan berat&nbsp;<?= $rowBBPelimpahan['berat'] ?>&nbsp;gram.
                                      <?php }else{ ?>
                                        dengan berat&nbsp;<?= $rowBBPelimpahan['jumlah'] ?>&nbsp;<?= $rowBBPelimpahan['satuan'] ?>
                                      <?php } ?>
                                    </li>
                                <?php } } ?> 
                              <?php } else { ?>
                                <button class="btn btn-warning btn-sm"><strong>Belum Diketahui</strong></button>
                              <?php } ?>
                              </ol>
                          </td>
                          <td><?= $displayPelimpahan ? $row_kasusPelimpahan["pasal"] : '' ?></td>
                          <td>
                            <?php 
                              if ($displayPelimpahan) {
                                if (!empty($row_kasusPelimpahan["nrp_admin"])) {
                                  $dataAdminPelimpahan = $CI->Modeladmin->getAdminByNRP($row_kasusPelimpahan['nrp_admin']);
                                  echo $dataAdminPelimpahan[0]['nama_admin'].' - NRP. '.$dataAdminPelimpahan[0]['nrp'];
                                } else { ?>
                                  <button class="btn btn-sm btn-warning w-100"><strong>Admin Belum Dipilih</strong></buttin>
                                <?php }
                              } else {
                                echo '';
                              }
                              
                            ?>
                          </td>
                          <td>
                            <?php if($displayPelimpahan): ?>
                              <?php if(empty($row_kasusPelimpahan["status_kasus"])){ ?>
                                <button class="btn btn-warning btn-sm"><strong>Belum Diketahui</strong></button>
                              <?php }else if ($row_kasusPelimpahan["status_kasus"] == 'SP3'){ ?>
                                <button class="btn btn-success btn-sm">
                                  <strong>SP3</strong>
                                <?php if(!empty($resKasusFrom[0]["ket_statusKasus"])): ?>
                                    <p><strong>Keterangan :</strong>&nbsp;<?= $resKasusFrom[0]["ket_statusKasus"] ?></p>
                                <?php endif; ?>
                                </button>
                              <?php }else if($row_kasusPelimpahan["status_kasus"] == 'Tahap II'){ ?>
                                <button class="btn btn-success btn-sm">
                                  <strong>Tahap II</strong>
                                  <?php if(!empty($resKasusFrom[0]["ket_statusKasus"])): ?>
                                      <p><strong>Keterangan :</strong>&nbsp;<?= $resKasusFrom[0]["ket_statusKasus"] ?></p>
                                  <?php endif; ?>
                                </button>
                              <?php }else{?>
                                <button class="btn btn-success btn-sm">
                                  <strong>RJ</strong>
                                  <?php if(!empty($resKasusFrom[0]["ket_statusKasus"])): ?>
                                      <p><strong>Keterangan :</strong>&nbsp;<?= $resKasusFrom[0]["ket_statusKasus"] ?></p>
                                  <?php endif; ?>
                                </button>
                              <?php } ?>
                            <?php endif; ?>
                          </td>
                          <td>
                            <?php if($displayPelimpahan): ?>
                              <?php if($row_kasusPelimpahan["isKasusMenonjol"]){ ?>
                                <button class="btn btn-success btn-sm"><strong>Kasus Menonjol</strong></button>
                              <?php }else{?>
                                <button class="btn btn-warning btn-sm"><strong>Bukan Kasus Menonjol</strong></button>
                              <?php }?>
                            <?php endif; ?>
                          </td>
                      </tr>
                      <?php ($displayPelimpahan) ? $no++ : $no; } ?>
                  <?php }else{?>
                          <tr>
                              <td colspan="14" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Barang Bukti Belum Tersedia</p></td>
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
    
    $(".tombol-hapus-pelimpahan").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Batal & Hapus Pelimpahan?",
        text: "Membatalkan pelimpahan juga akan menghapus data kasus pada jajaran yang dilimpahkan dan bersifat permanen pada database, mohon berhati-hati.",
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
      
      $(".tombol-batal-menonjol").on("click", function (e) {
        e.preventDefault();
        const href = $(this).attr("href");
  
        Swal.fire({
          title: "Batalkan Kasus Menonjol?",
          text: "Membatalkan status kasus menonjol bersifat permanen pada database, mohon berhati-hati.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Batalkan Menonjol!",
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