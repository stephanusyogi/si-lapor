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
    .foto-tsk {
      width: 200px; /* You can set the dimensions to whatever you want */
      height: 200px;
      object-fit: cover;
      border-radius:15px;
    }

  </style>
  <!-- DATA -->
  <?php 
    $CI =& get_instance();
    $CI->load->model('Modelbarangbukti');
    $CI->load->model('Modeltersangka');
    $CI->load->model('Modeladmin');
    $CI->load->model('Modelkesatuan');
    $CI->load->model('Modelpermohonan');
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4 py-4">
        <h2>Hasil Pencarian Data</h2>
        <div class="alert alert-info" role="alert">
          Berikut hasil pencarian <strong>"<?= $searchValue ?>"</strong>. Tidak menemukan data yang anda cari? Coba ulangi kembali sesuai dengan petunjuk yang diberikan.
        </div>
        <hr>
        <table id="table-master-kasus" class="table table-responsive datatable table-hover table-bordered table-striped " style="width:100%">
            <thead>
                <tr class="text-center">
                  <th>No</th>
                  <?php if($kategoriPencarian == 'nolp'): ?>
                    <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'): ?>
                    <th>Kesatuan</th>
                    <?php endif; ?>   
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
                    <th>Keterangan Pelimpahan</th> 
                    <th>Status SELRA</th>
                    <th>LP Menonjol</th>
                  <?php else: ?>
                    <th>Identitas Tersangka</th> 
                    <th>Umur</th> 
                    <th>Pendidikan</th> 
                    <th>Pekerjaan</th> 
                    <th>Barang Bukti</th> 
                    <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'): ?>
                    <th>Kesatuan</th>
                    <?php endif; ?>   
                    <th>No Laporan Polisi</th>
                    <th>Tanggal Input LP</th>
                    <th>Durasi Perkara</th>
                    <th>Deskripsi Waktu & TKP</th>
                    <th>Modus Operandi</th> 
                    <th>Administrator</th>
                    <th>Keterangan Pelimpahan</th> 
                    <th>Status SELRA</th>
                    <th>LP Menonjol</th>
                  <?php endif; ?>
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
                    <?php if($kategoriPencarian == 'nolp'): ?>
                      <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>
                      <td class="textcenter">
                        <?php $dataKesatuan =  $CI->Modelkesatuan->getKesatuanByKode($row_kasus['kode_kesatuan']);?>
                        <?= ($display) ? $dataKesatuan[0]["nama"]  :  "" ?>
                      </td>
                      <?php } ?>
                      <td><?= $display ? $row_kasus["no_laporanpolisi"] : ""; ?></td>
                      <td><?= $display ? dateIndonesia(date('N j/n/Y', strtotime($row_kasus["created_at"]))) : ""; ?></td>
                      <td>
                        <?php if($display): 
                          if(!empty($row_kasus["date_statusKasus"])):
                            $diffSelra = date_diff(date_create($row_kasus["created_at"]), date_create($row_kasus["date_statusKasus"]));
                            echo $diffSelra->format("%a")." Hari (SELRA)";
                          else:
                            $diff = date_diff(date_create($row_kasus["created_at"]), date_create(date("Y-m-d")));
                            echo $diff->format("%a")." Hari - Hingga Hari Ini";
                          endif; 
                        endif; ?>
                      </td>
                      <td><?= ($display) ? $row_kasus["deskripsi_waktudantkp"]  :  "" ?></td>
                      <td>
                        <div class="text-center">
                        <?php if(!empty($row_kasus["file_foto"])): ?>
                          <a class="test-popup-link" href="<?= base_url() ?>uploads/fotoTersangka/<?= $row_kasus["file_foto"] ?>"><img src="<?= base_url() ?>uploads/fotoTersangka/<?= $row_kasus["file_foto"] ?>" alt="Rounded image" class="foto-tsk"></a>
                        <?php else: ?>
                          <small>Belum Ada Foto</small>
                        <?php endif; ?>
                        </div>
                        <hr>
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
                          if($display){
                            if (!empty($row_kasus["nrp_admin"])) {
                              echo $dataAdmin[0]['nama_admin'].' - NRP. '.$dataAdmin[0]['nrp']; 
                            }else{ ?>
                              <a class="btn btn-sm btn-info w-100" data-toggle="modal" data-target="#adminModal<?= $row_kasus['id_kasus']; ?>">Pilih Admin</a>
                            <?php }
                          }else{ 
                            echo '';
                          };
                        ?>
                      </td>
                      <td class="text-center">
                        <?php if($display): ?>
                          <?php if($row_kasus["ket_pelimpahan"] == 'dilimpahkan'){ ?>
                            <button class="btn btn-success btn-sm"><strong>Dilimpahkan</strong></button>
                          <?php }else{?>
                            <button class="btn btn-warning btn-sm"><strong>Bukan Pelimpahan</strong></button>
                          <?php } ?>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                        <?php if($display): ?>
                          <?php if(empty($row_kasus["status_kasus"])){ ?>
                            <button class="btn btn-warning btn-sm"><strong>Belum Diketahui</strong></button>
                          <?php }else if ($row_kasus["status_kasus"] == 'TAHAP II'){ ?>
                            <button class="btn btn-success btn-sm">
                              <strong>Tahap II</strong>
                              <?php if(!empty($row_kasus["ket_statusKasus"])): ?>
                                  <p><strong>Keterangan :</strong>&nbsp;<?= $row_kasus["ket_statusKasus"] ?></p>
                              <?php endif; ?>
                            </button>
                          <?php }else if($row_kasus["status_kasus"] == 'SP3'){ ?>
                            <button class="btn btn-success btn-sm">
                              <strong>SP3</strong>
                              <?php if(!empty($row_kasus["ket_statusKasus"])): ?>
                                  <p><strong>Keterangan :</strong>&nbsp;<?= $row_kasus["ket_statusKasus"] ?></p>
                              <?php endif; ?>
                            </button>
                          <?php }else{?>
                            <button class="btn btn-success btn-sm">
                              <strong>RJ</strong>
                              <?php if(!empty($row_kasus["ket_statusKasus"])): ?>
                                  <p><strong>Keterangan :</strong>&nbsp;<?= $row_kasus["ket_statusKasus"] ?></p>
                              <?php endif; ?>
                            </button>
                          <?php }?>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                        <?php if($display): ?>
                          <?php if($row_kasus["isKasusMenonjol"]){ ?>
                            <button class="btn btn-success btn-sm"><strong>Kasus Menonjol</strong></button>
                          <?php }else{?>
                            <button class="btn btn-warning btn-sm"><strong>Bukan Kasus Menonjol</strong></button>
                          <?php }?>
                        <?php endif; ?>
                      </td>
                    <?php else: ?>
                      <td>
                        <div class="text-center">
                        <?php if(!empty($row_kasus["file_foto"])): ?>
                          <a class="test-popup-link" href="<?= base_url() ?>uploads/fotoTersangka/<?= $row_kasus["file_foto"] ?>"><img src="<?= base_url() ?>uploads/fotoTersangka/<?= $row_kasus["file_foto"] ?>" alt="Rounded image" class="foto-tsk"></a>
                        <?php else: ?>
                          <small>Belum Ada Foto</small>
                        <?php endif; ?>
                        </div>
                        <hr>
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
                      <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>
                      <td class="textcenter">
                        <?php $dataKesatuan =  $CI->Modelkesatuan->getKesatuanByKode($row_kasus['kode_kesatuan']);?>
                        <?= ($display) ? $dataKesatuan[0]["nama"]  :  "" ?>
                      </td>
                      <?php } ?>
                      <td><?= $display ? $row_kasus["no_laporanpolisi"] : ""; ?></td>
                      <td><?= $display ? dateIndonesia(date('N j/n/Y', strtotime($row_kasus["created_at"]))) : ""; ?></td>
                      <td>
                        <?php if($display): 
                          if(!empty($row_kasus["date_statusKasus"])):
                            $diffSelra = date_diff(date_create($row_kasus["created_at"]), date_create($row_kasus["date_statusKasus"]));
                            echo $diffSelra->format("%a")." Hari (SELRA)";
                          else:
                            $diff = date_diff(date_create($row_kasus["created_at"]), date_create(date("Y-m-d")));
                            echo $diff->format("%a")." Hari - Hingga Hari Ini";
                          endif; 
                        endif; ?>
                      </td>
                      <td><?= ($display) ? $row_kasus["deskripsi_waktudantkp"]  :  "" ?></td>
                      <td><?= $display ? $row_kasus["pasal"] : '' ?></td>
                      <td>
                        <?php
                          $dataAdmin = $CI->Modeladmin->getAdminByNRP($row_kasus['nrp_admin']);
                          if($display){
                            if (!empty($row_kasus["nrp_admin"])) {
                              echo $dataAdmin[0]['nama_admin'].' - NRP. '.$dataAdmin[0]['nrp']; 
                            }else{
                              if($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER'){?>
                              <a class="btn btn-sm btn-info w-100" data-toggle="modal" data-target="#adminModal<?= $row_kasus['id_kasus']; ?>">Pilih Admin</a>
                              <?php }else{ ?>
                                <p>Admin Belum Dipilih</p>
                              <?php } 
                            }
                          }else{ 
                            echo '';
                          };
                        ?>
                      </td>
                      <td class="text-center">
                        <?php if($display): ?>
                          <?php if($row_kasus["ket_pelimpahan"] == 'dilimpahkan'){ ?>
                            <button class="btn btn-success btn-sm"><strong>Dilimpahkan</strong></button>
                          <?php }else{?>
                            <button class="btn btn-warning btn-sm"><strong>Bukan Pelimpahan</strong></button>
                          <?php } ?>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                        <?php if($display): ?>
                          <?php if(empty($row_kasus["status_kasus"])){ ?>
                            <button class="btn btn-warning btn-sm"><strong>Belum Diketahui</strong></button>
                          <?php }else if ($row_kasus["status_kasus"] == 'TAHAP II'){ ?>
                            <button class="btn btn-success btn-sm">
                              <strong>Tahap II</strong>
                              <?php if(!empty($row_kasus["ket_statusKasus"])): ?>
                                  <p><strong>Keterangan :</strong>&nbsp;<?= $row_kasus["ket_statusKasus"] ?></p>
                              <?php endif; ?>
                            </button>
                          <?php }else if($row_kasus["status_kasus"] == 'SP3'){ ?>
                            <button class="btn btn-success btn-sm">
                              <strong>SP3</strong>
                              <?php if(!empty($row_kasus["ket_statusKasus"])): ?>
                                  <p><strong>Keterangan :</strong>&nbsp;<?= $row_kasus["ket_statusKasus"] ?></p>
                              <?php endif; ?>
                            </button>
                          <?php }else{?>
                            <button class="btn btn-success btn-sm">
                              <strong>RJ</strong>
                              <?php if(!empty($row_kasus["ket_statusKasus"])): ?>
                                  <p><strong>Keterangan :</strong>&nbsp;<?= $row_kasus["ket_statusKasus"] ?></p>
                              <?php endif; ?>
                            </button>
                          <?php }?>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                        <?php if($display): ?>
                          <?php if($row_kasus["isKasusMenonjol"]){ ?>
                            <button class="btn btn-success btn-sm"><strong>Kasus Menonjol</strong></button>
                          <?php }else{?>
                            <button class="btn btn-warning btn-sm"><strong>Bukan Kasus Menonjol</strong></button>
                          <?php }?>
                        <?php endif; ?>
                      </td>
                    <?php endif; ?>
                </tr>
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
                            <form action="<?= base_url("data/updateAdmin/{$row_kasus['id_kasus']}") ?>" method="post">
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
              <!-- Modal Permohonan -->
              <div class="modal fade" id="permohonanModal<?= $row_kasus['id_kasus']; ?>" tabindex="-1" role="dialog" aria-labelledby="adminModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="adminModalLabel">Permohonan Edit LP</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                            <form action="<?= base_url("data/addPermohonan/{$row_kasus['id_kasus']}") ?>" method="post">
                                <input type="hidden" nama="kode_kesatuan" value="<?= $this->session->userdata('login_data_admin')['kodekesatuan'] ?>">
                                <div class="form-group">
                                  <label for="">Alasan Pengajuan Perubahan LP :</label>
                                  <textarea class="form-control" name="alasan_permohonan" rows="5" placeholder="contoh: Barang bukti pada LP belum terisi, Perubahan data instrumen pada LP"></textarea>
                                </div>
                                <div class="modal-footer" style="align-items:end;">
                                    <button type="submit" class="btn btn-success">Add</button>
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
                        <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Master Belum Tersedia</p></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <script src="<?= base_url() ?>assets/js/magnific-popup/jquery.magnific-popup.js"></script>
  <script>    
  $(document).ready(function() {
    $('.test-popup-link').magnificPopup({
      type:'image',
      mainClass: 'mfp-with-zoom', // this class is for CSS animation below

      zoom: {
        enabled: true, // By default it's false, so don't forget to enable it

        duration: 300, // duration of the effect, in milliseconds
        easing: 'ease-in-out', // CSS transition easing function

        // The "opener" function should return the element from which popup will be zoomed in
        // and to which popup will be scaled down
        // By defailt it looks for an image tag:
        opener: function(openerElement) {
          // openerElement is the element on which popup was initialized, in this case its <a> tag
          // you don't need to add "opener" option if this code matches your needs, it's defailt one.
          return openerElement.is('img') ? openerElement : openerElement.find('img');
        }
      }
    });
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

    
    $(".tombol-kunci-matrik").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Kunci Ke Database?",
        text: "Kunci LP ke database dengan data informasi kasus, tersangka, dan barang bukti yang valid!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Kunci!",
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