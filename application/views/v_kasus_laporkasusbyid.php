  
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
      <div class="container-fluid pt-2">
        <div class="alert alert-warning" role="alert">
          Silahkan mengisi formulir dibawah ini. Harap mengisi data dengan benar dan akurat !
        </div>
        <div class="alert alert-info" role="alert">
          Setelah mengisi deskripsi LP, harap segera dilanjutkan dengan mengisi identitas tersangka dan barangbukti!
        </div>
        <!-- Form Informasi Umum Kasus -->
        <form action="<?= base_url() ?>kasus/updateKasus/<?= $dataKasus['id_kasus'] ?>" method="post">
          <h4>Kesatuan :</h4>
          <select id="kesatuan" name="kesatuan" class="form-control" style="width:20%;">
            <option value="polres" <?= strpos($dataKasus['no_laporanpolisi'], 'POLSEK') ? '' : 'selected'?>>Polres</option>
            <option value="polsek" <?= strpos($dataKasus['no_laporanpolisi'], 'POLSEK') ? 'selected' : ''?>>Polsek</option>
          </select>
          <hr>
          <div class="form-group">
              <label for="nolp">Nomor Laporan Polisi</label>
              <div id="formatLP"></div>
                <?php if(strpos($dataKasus['no_laporanpolisi'], 'POLSEK')){ ?>
                    <div class="d-flex align-items-center formatPolsek">
                        <p class="mb-0">LP/A/</p>
                        <input type="number" class="form-control" name="nosurat" id="nosurat" autocomplete="off" placeholder="" required style="width:10%;" value="<?= explode('/',$dataKasus['no_laporanpolisi'])[2] ?>">
                        <p class="mb-0">/</p>
                        <select name="bulansurat" id="bulansurat" class="form-control" style="width:10%;"><option value="<?= explode('/',$dataKasus['no_laporanpolisi'])[2] ?>" selected><?= explode('/',$dataKasus['no_laporanpolisi'])[3] ?></option><option value="I">I</option><option value="II">II</option><option value="III">III</option><option value="IV">IV</option><option value="V">V</option><option value="VI">VI</option><option value="VII">VII</option><option value="VIII">VIII</option><option value="IX">IX</option><option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option></select>
                        <p class="mb-0">/</p>
                        <div class="input-group date" id="tahunsuratpolsek" data-target-input="nearest" style="width:10%;"><input type="text" class="form-control" name="tahunsurat" datetimepicker-input" data-target="#tahunsuratpolsek" value="<?= explode('/',$dataKasus['no_laporanpolisi'])[4] ?>"/><div class="input-group-append" data-target="#tahunsuratpolsek" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div>
                        <p class="mb-0">/SPKT/</p>
                        <input type="text" name="namapolsek" class="form-control" id="namapolsek" autocomplete="off" placeholder="Nama Polsek" required style="width:20%;text-transform:uppercase;" value="<?= explode('/',$dataKasus['no_laporanpolisi'])[6] ?>">
                        <p class="mb-0">/</p>
                        <p class="mb-0"><?= $this->session->userdata('login_data_admin')['nama'] ?></p>
                        <p class="mb-0">/POLDA JAWA TIMUR</p>
                    </div>
                <?php }else{ ?>
                    <div class="d-flex align-items-center formatPolres">
                        <p class="mb-0">LP/A/</p>
                        <input type="number" class="form-control" name="nosurat" id="nosurat" autocomplete="off" placeholder="" required style="width:10%;" value="<?= explode('/',$dataKasus['no_laporanpolisi'])[2] ?>">
                        <p class="mb-0">/</p>
                        <select id="bulansurat" name="bulansurat" class="form-control" style="width:10%;"><option value="<?= explode('/',$dataKasus['no_laporanpolisi'])[4] ?>" selected><?= explode('/',$dataKasus['no_laporanpolisi'])[3] ?></option><option value="I">I</option><option value="II">II</option><option value="III">III</option><option value="IV">IV</option><option value="V">V</option><option value="VI">VI</option><option value="VII">VII</option><option value="VIII">VIII</option><option value="IX">IX</option><option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option></select>
                        <p class="mb-0">/</p>
                        <div class="input-group date" id="tahunsurat" data-target-input="nearest" style="width:10%;">
                        <input type="text" name="tahunsurat" class="form-control datetimepicker-input" data-target="#tahunsurat" value="<?= explode('/',$dataKasus['no_laporanpolisi'])[4] ?>" /><div class="input-group-append" data-target="#tahunsurat" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div>
                        <p class="mb-0">/SPKT.</p><p class="mb-0"><?= $this->session->userdata('login_data_admin')['kode_lp'] ?></p><p class="mb-0">/POLDA JAWA TIMUR</p>
                    </div>
                <?php } ?>
          </div>
          <div class="form-group">
            <label for="tkp">Tempat Kejadian Perkara</label>
            <select name="tkp" id="tkp" class="form-control w-50" required>
                <option value="<?= $dataKasus['tkp'] ?>" selected><?= $dataKasus['tkp'] ?></option>
              <option disabled>Pilih TKP</option>
              <option value="Hotel/Villa/Kos">Hotel / Villa / Kos</option>
              <option value="Ruko/Gedung/Mall/Pabrik">Ruko / Gedung / Mall / Pabrik</option>
              <option value="Tempat Umum">Tempat Umum</option>
              <option value="Pemukiman/Pondok">Pemukiman / Pondok</option>
              <option value="Diskotik/Tempat Karaoke">Diskotik / Tempat Karaoke</option>
              <option value="Terminal/Bandara/Pelabuhan">Terminal / Bandara / Pelabuhan</option>
              <option value="Rumah Tahanan">Rumah Tahanan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="deskripsi_waktudantkp">Keterangan Deskripsi Waktu & Tempat Kejadian</label>
            <textarea class="form-control" name="deskripsi_waktudantkp" id="deskripsi_waktudantkp" rows="5" required placeholder="Tulis keterangan perkara disini"><?= $dataKasus['deskripsi_waktudantkp'] ?></textarea>
          </div>
          <div class="form-group">
            <label for="pasal">Pasal</label>
            <textarea class="form-control" name="pasal" id="pasal" rows="5" required placeholder="Tulis keterangan pasal yang ditangguhkan disini"><?= $dataKasus['pasal'] ?></textarea>
          </div>  
          <div class="text-right mb-2" id="scrollToContent">
            <button type="submit" class="btn btn-secondary">Edit Informasi Umum Kasus</button>
          </div>
        </form>
        <hr>
        <!-- Form Tersangka -->
        <h3>Data Tersangka</h3>
        <h5>Kasus No. Laporan Polisi : <strong><?= $dataKasus['no_laporanpolisi'] ?></strong></h5>
        <hr>
          <form action="<?= base_url("kasus/addTersangka/{$dataKasus['id_kasus']}") ?>" method="POST">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" id="nama" class="form-control" name="nama" placeholder="Masukkan Nama Tersangka" autocomplete="off" required>

                  <label for="ttl">Tempat & Tanggal Lahir</label>
                  <div class="row">
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="tempatTTL" placeholder="Masukkan Tempat Lahir" autocomplete="off" required>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group date" id="tahunTTL" data-target-input="nearest">
                        <input type="text" class="form-control" name="tahunTTL" datetimepicker-input" data-target="#tahunTTL" />
                        <div class="input-group-append" data-target="#tahunTTL" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <label for="nik">NIK</label>
                  <input type="text" id="nik" class="form-control" name="nik" placeholder="Masukkan NIK Tersangka" autocomplete="off" required>

                  <label for="alamat">Alamat</label>
                  <textarea class="form-control" name="alamat" id="alamat" rows="3" required placeholder="Tulis Alamat Tersangka Disini"></textarea>

                  <label for="agama">Agama</label>
                  <select name="agama" id="agama" class="form-control" required>
                    <option selected disabled>Pilih Agama</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Konghucu">Konghucu</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <label for="kategori_usia">Kategori Usia</label>
                <select name="kategori_usia" id="kategori_usia" class="form-control" required>
                  <option selected disabled>Pilih Rentang Usia</option>
                  <option value="<14"><14</option>
                  <option value="15-18">15-18</option>
                  <option value="19-24">19-24</option>
                  <option value="25-64">25-64</option>
                  <option value=">65">>65</option>
                </select>

                <label for="usia">Usia</label>
                <input type="number" name="usia" id="usia" class="form-control" min="" max="" placeholder="Masukkan Usia" required>

                <label for="pendidikan">Pendidikan</label>
                <select name="pendidikan" id="pendidikan" class="form-control" required>
                  <option selected disabled>Pilih Jenjang Pendidikan</option>
                  <option value="Tidak Sekolah">Tidak Sekolah</option>
                  <option value="SD">SD</option>
                  <option value="SMP">SMP</option>
                  <option value="SMA">SMA</option>
                  <option value="PT">PT</option>
                  <option value="Belum Diketahui">Belum Diketahui</option>
                </select>

                <label for="pekerjaan">Pekerjaan</label>
                <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                  <option selected disabled>Pilih Pekerjaan</option>
                  <option value="Pelajar">Pelajar</option>
                  <option value="Mahasiswa">Mahasiswa</option>
                  <option value="Swasta">Swasta</option>
                  <option value="Buruh/Karyawan">Buruh/Karyawan</option>
                  <option value="Petani/Nelayan">Petani/Nelayan</option>
                  <option value="Pedagang">Pedagang</option>
                  <option value="Wiraswasta/Pengusaha">Wiraswasta/Pengusaha</option>
                  <option value="Sopir/TukangOjek">Sopir/TukangOjek</option>
                  <option value="Ikut Orang Tua">Ikut Orang Tua</option>
                  <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                  <option value="Tidak Kerja">Tidak Kerja</option>
                  <option value="Notaris">Notaris</option>
                  <option value="TNI">TNI</option>
                  <option value="POLRI">POLRI</option>
                  <option value="PNS">PNS</option>
                  <option value="PEMBANTU">PEMBANTU</option>
                  <option value="NAPI">NAPI</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                  <option selected disabled>Pilih Status Tersangka</option>
                  <option value="Penanam">Penanam</option>
                  <option value="Produksi">Produksi</option>
                  <option value="Bandar">Bandar</option>
                  <option value="Pengedar">Pengedar</option>
                  <option value="Pengguna">Pengguna</option>
                </select>

                <label for="status_kewarganegaraan">Kewarganegaraan</label>
                <select name="status_kewarganegaraan" id="status_kewarganegaraan" class="form-control" required>
                  <option selected disabled>Pilih Kewarganegaraan</option>
                  <option value="WNI">WNI</option>
                  <option value="WNA">WNA</option>
                </select>

                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                  <option selected disabled>Pilih Jenis Kelamin</option>
                  <option value="LK">Laki - Laki</option>
                  <option value="PR">Perempuan</option>
                </select>
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button class="btn btn-info" type="submit"><i class="fas fa-plus-circle"></i> Tambah Data Tersangka</button>
            </div>
          </form>
        <hr>
        <table id="table-full-fitur" class="table datatable table-bordered table-striped " style="width:100%">
          <thead>
              <tr>
                  <th>No</th>
                  <th>Action</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>NIK</th>
                  <th>Usia</th>
                  <th>Daftar BB</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
          <?php if(isset($dataTersangka)){ ?>
            <?php $no=1; foreach ($dataTersangka as $row) { ?>
              <tr>
                <td class="text-center"><?= $no ?>.</td>
                <td class="text-center" style="font-size:18px;">
                  <div data-toggle="tooltip" data-placement="top" title="Edit Identitas Tersangka">
                    <a class="mx-1" style="cursor:pointer;" data-toggle="modal" data-target="#editModal<?= $row['id_tersangka']; ?>"><i class="fas fa-pen-square" style="color:green;"></i></a>
                  </div>
                  <div data-toggle="tooltip" data-placement="top" title="Detail Identitas Tersangka">
                    <a class="mx-1" style="cursor:pointer;" data-toggle="modal" data-target="#detailModal<?= $row['id_tersangka']; ?>"><i class="fas fa-eye" style="color:blue;"></i></a>
                  </div>
                  <div data-toggle="tooltip" data-placement="top" title="Hapus Tersangka">
                    <a class="tombol-hapus mx-1" href="<?= base_url("kasus/delTersangka/{$row['id_tersangka']}/{$dataKasus['id_kasus']}") ?>" ><i class="fas fa-trash" style="color:red;"></i></a>
                  </div>
                </td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td><?= $row['nik'] ?></td>
                <td><?= $row['usia'] ?></td>
                <td>
                      <?php 
                        $checkBB = $CI->Modelbarangbukti->getBarangBuktiByIdKasus($dataKasus['id_kasus'])->result_array(); 
                        $result = $CI->Modelbarangbukti->getBarangBuktiByIdTersangka($dataKasus['id_kasus'],$row['id_tersangka'])->result_array();
                        if(!empty($checkBB) && !empty($result)){ 
                          // Tampilkan Barang Bukti
                          ?>
                          <ol>
                            <?php foreach ($result as $rowBB) { 
                              if (!$rowBB['isDuplicate']) { ?>
                                <li>
                                  <strong><?= $rowBB['nama_barangbukti'] ?></strong>
                                  <?php if($rowBB['kategori'] == 'Lain-lain') { ?>
                                    <?php if($rowBB['nama_barangbukti'] == 'Exstacy/Carnophen') { ?>
                                      yakni&nbsp;<?= $rowBB['keterangan'] ?>&nbsp;sejumlah&nbsp;<?= $rowBB['jumlah'] ?>&nbsp;<?= $rowBB['satuan'] ?>.
                                    <?php }else{ ?>
                                      yakni&nbsp;<?= $rowBB['keterangan'] ?>&nbsp;sejumlah&nbsp;<?= $rowBB['jumlah'] ?>&nbsp;<?= $rowBB['satuan'] ?>&nbsp;dengan berat&nbsp;<?= $rowBB['berat'] ?>&nbsp;gram.
                                    <?php } ?>
                                  <?php }else{ ?>
                                      sejumlah&nbsp;<?= $rowBB['jumlah'] ?>&nbsp;<?= $rowBB['satuan'] ?>
                                  <?php } ?>
                                </li>
                              <?php }else{ 
                                $duplicateTSK = $CI->Modeltersangka->getTersangkaByIdTersangka($dataKasus['id_kasus'], $rowBB['id_duplicateTSK'])->result_array();
                                $duplicateBB = $CI->Modelbarangbukti->getBarangBuktiByIdTersangka($dataKasus['id_kasus'], $rowBB['id_duplicateTSK'])->result_array();
                                ?>
                                <li>Barang bukti sama dengan tersangka a.n <?= $duplicateTSK[0]['nama'] ?> (<strong><?= $duplicateBB[0]['kategori'] ?></strong>) <span><a href="<?= base_url() ?>kasus/delBBDuplicate/<?= $rowBB['id_barangbukti'] ?>/<?= $dataKasus['id_kasus'] ?>" class="btn btn-danger btn-sm batalBB"  data-toggle="tooltip" data-placement="top" title="Batal Samakan Barang Bukti?"><i class="fas fa-trash"></i></a></span></li>
                              <?php } ?>
                            <?php } ?> 
                          </ol>
                        <?php }else if(empty($checkBB) && empty($result)){ ?> 
                          <button class="btn btn-warning btn-sm">Belum Diketahui</button>
                        <?php }else{ ?>
                          <!-- Tampilkan Modal -->
                          <button class="btn btn-warning btn-sm mb-1">Belum Diketahui</button>
                          <br>
                          <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#duplicateModal<?= $row['id_tersangka']; ?>">Samakan Barang Bukti</button>
                          <!-- Modal Duplicate -->
                          <div class="modal fade" id="duplicateModal<?= $row['id_tersangka']; ?>" tabindex="-1" aria-labelledby="duplicateModalLabel<?= $row['id_tersangka']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="duplicateModalLabel<?= $row['id_tersangka']; ?>">Samakan Barang Bukti</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="<?= base_url("kasus/addBBDuplicate/{$dataKasus['id_kasus']}/{$row['id_tersangka']}") ?>" method="post">
                                    <div class="form-group">
                                      <label for="">Pilih Nama Tersangka</label>
                                      <?php $chooseTSK = $CI->Modeltersangka->getTersangkaExceptIdTersangka($this->session->userdata('login_data_admin')['kodekesatuan'] ,$row['id_kasus'])->result_array(); ?>
                                      <select name="id_tersangka" class="chooseTSK<?= $row['id_tersangka'] ?> form-control">
                                        <option selected disabled>Pilih Tersangka</option>
                                        <?php foreach ($chooseTSK as $key) { ?>
                                          <option value="<?= $key['id_tersangka'] ?>"><?= $key['nama'] ?></option>
                                        <?php } ?>
                                      </select>
                                      <label>Pilih Barang Bukti</label>
                                      <div class="showKategori<?= $row['id_tersangka'] ?>"></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                                  </form>
                              </div>
                            </div>
                          </div>
                          <script>
                            var idKasus = <?= $dataKasus['id_kasus'] ?>;
                            $('.chooseTSK<?= $row['id_tersangka'] ?>').on('change', function() {
                              $(`.formKategori`).remove();
                              let xhr = new XMLHttpRequest();
                              xhr.open("POST", "<?= base_url() ?>kasus/getBBDuplicate", true);
                              xhr.onload = () => {
                                  if (xhr.readyState === XMLHttpRequest.DONE) {
                                      if (xhr.status === 200) {
                                          var data = xhr.response;
                                          $('.showKategori<?= $row['id_tersangka'] ?>').append(data);
                                      }
                                  }
                              }
                              xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                              xhr.send("id_tersangka=" + this.value + "&id_kasus=" + idKasus);
                            });
                          </script>
                        <?php } ?>
                </td>
                <td><a href="<?= base_url("barang-bukti/{$dataKasus['id_kasus']}/{$row['id_tersangka']}") ?>" class="btn btn-secondary btn-sm">Tambah / Ubah Barang Bukti</a></td>
              </tr>
              <!-- Modal Edit Tersangka -->
              <div class="modal fade" id="editModal<?= $row['id_tersangka']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="editModalLabel">Update Data Tersangka</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <form action="<?= base_url('kasus/updateTersangka'); ?>/<?= $row['id_tersangka']; ?>/<?= $dataKasus['id_kasus'] ?>" method="POST"  enctype="multipart/form-data">
                                  <div class="row">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" id="nama" class="form-control" name="nama" placeholder="Masukkan Nama Tersangka" autocomplete="off" required value="<?= $row['nama'] ?>">

                                        <label for="ttl">Tempat & Tanggal Lahir</label>
                                        <div class="row">
                                          <div class="col-md-6">
                                            <input type="text" class="form-control" name="tempatTTL" placeholder="Masukkan Tempat Lahir" autocomplete="off" required value="<?= strtok($row['ttl'],',') ?>">
                                          </div>
                                          <div class="col-md-6">
                                            <div class="input-group date" id="tahunTTL<?= $row['id_tersangka'] ?>" data-target-input="nearest">
                                              <input type="text" class="form-control" name="tahunTTL" datetimepicker-input" data-target="#tahunTTL<?= $row['id_tersangka'] ?>"value="<?= substr($row['ttl'], strpos($row['ttl'], ",") + 1)  ?>"/>
                                              <div class="input-group-append" data-target="#tahunTTL<?= $row['id_tersangka'] ?>" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <script>
                                          $(function () {
                                            $('#tahunTTL<?= $row['id_tersangka'] ?>').datetimepicker({
                                              format: 'YYYY-MM-DD'
                                            });
                                          });
                                        </script>

                                        <label for="nik">NIK</label>
                                        <input type="text" id="nik" class="form-control" name="nik" placeholder="Masukkan NIK Tersangka" autocomplete="off" required value="<?= $row['nik'] ?>">

                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" name="alamat" id="alamat" rows="3" required placeholder="Tulis Alamat Tersangka Disini"><?= $row['alamat'] ?></textarea>

                                        <label for="agama">Agama</label>
                                        <select name="agama" id="agama" class="form-control" required>
                                          <option value="<?= $row['agama'] ?>" selected><?= $row['agama'] ?></option>
                                          <option value="Islam">Islam</option>
                                          <option value="Kristen">Kristen</option>
                                          <option value="Katolik">Katolik</option>
                                          <option value="Hindu">Hindu</option>
                                          <option value="Buddha">Buddha</option>
                                          <option value="Konghucu">Konghucu</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <label for="status">Status</label>
                                      <select name="status" id="status" class="form-control" required>
                                        <option value="<?= $row['status'] ?>" selected><?= $row['status'] ?></option>
                                        <option value="Penanam">Penanam</option>
                                        <option value="Produksi">Produksi</option>
                                        <option value="Bandar">Bandar</option>
                                        <option value="Pengedar">Pengedar</option>
                                        <option value="Pengguna">Pengguna</option>
                                      </select>

                                      <label for="status_kewarganegaraan">Kewarganegaraan</label>
                                      <select name="status_kewarganegaraan" id="status_kewarganegaraan" class="form-control" required>
                                        <option value="<?= $row['status_kewarganegaraan'] ?>" selected><?= $row['status_kewarganegaraan'] ?></option>
                                        <option value="WNI">WNI</option>
                                        <option value="WNA">WNA</option>
                                      </select>

                                      <label for="jenis_kelamin">Jenis Kelamin</label>
                                      <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                        <option value="<?= $row['jenis_kelamin'] ?>" selected><?= $row['jenis_kelamin'] ?></option>
                                        <option value="LK">Laki - Laki</option>
                                        <option value="PR">Perempuan</option>
                                      </select>
                                    </div>
                                    
                                    <div class="col-md-4">
                                      <label for="">Usia</label>
                                      <select name="kategori_usia" id="kategori_usia<?= $row['id_tersangka'] ?>" class="form-control" required>
                                        <option value="<?= $row['kategori_usia'] ?>" selected><?= $row['kategori_usia'] ?></option>
                                        <option value="<14"><14</option>
                                        <option value="15-18">15-18</option>
                                        <option value="19-24">19-24</option>
                                        <option value="25-64">25-64</option>
                                        <option value=">65">>65</option>
                                      </select>

                                      <label for="usia">Usia</label>
                                      <input type="number" name="usia" id="usia<?= $row['id_tersangka'] ?>" class="form-control" min="" max="" placeholder="Masukkan Usia" value="<?= $row['usia'] ?>" required>

                                      <script>
                                        $('#kategori_usia<?= $row['id_tersangka'] ?>').on('change', function() {
                                          switch (this.value) {
                                            case "<14":
                                              $("#usia<?= $row['id_tersangka'] ?>").attr({
                                                "max" : 14,
                                                "min" : 1
                                              });
                                              break;
                                            case "15-18":
                                              $("#usia<?= $row['id_tersangka'] ?>").attr({
                                                "max" : 18,
                                                "min" : 15
                                              });
                                              break;
                                            case "19-24":
                                              $("#usia<?= $row['id_tersangka'] ?>").attr({
                                                "max" : 24,
                                                "min" : 19
                                              });
                                              break;
                                            case "25-64":
                                              $("#usia<?= $row['id_tersangka'] ?>").attr({
                                                "max" : 64,
                                                "min" : 25
                                              });
                                              break;
                                            default:
                                              $("#usia<?= $row['id_tersangka'] ?>").attr({
                                                "max" : 150,
                                                "min" : 65
                                              });
                                              break;
                                          }
                                        });

                                        switch (document.getElementById("kategori_usia<?= $row['id_tersangka'] ?>").value) {
                                          case "<14":
                                            $("#usia<?= $row['id_tersangka'] ?>").attr({
                                              "max" : 14,
                                              "min" : 1
                                            });
                                            break;
                                          case "15-18":
                                            $("#usia<?= $row['id_tersangka'] ?>").attr({
                                              "max" : 18,
                                              "min" : 15
                                            });
                                            break;
                                          case "19-24":
                                            $("#usia<?= $row['id_tersangka'] ?>").attr({
                                              "max" : 24,
                                              "min" : 19
                                            });
                                            break;
                                          case "25-64":
                                            $("#usia<?= $row['id_tersangka'] ?>").attr({
                                              "max" : 64,
                                              "min" : 25
                                            });
                                            break;
                                          default:
                                            $("#usia<?= $row['id_tersangka'] ?>").attr({
                                              "max" : 150,
                                              "min" : 65
                                            });
                                            break;
                                        }
                                      </script>

                                      <label for="pendidikan">Pendidikan</label>
                                      <select name="pendidikan" id="pendidikan" class="form-control" required>
                                        <option value="<?= $row['pendidikan'] ?>" selected><?= $row['pendidikan'] ?></option>
                                        <option value="Tidak Sekolah">Tidak Sekolah</option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                        <option value="PT">PT</option>
                                        <option value="Belum Diketahui">Belum Diketahui</option>
                                      </select>

                                      <label for="pekerjaan">Pekerjaan</label>
                                      <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                        <option value="<?= $row['pekerjaan'] ?>" selected><?= $row['pekerjaan'] ?></option>
                                        <option value="Pelajar">Pelajar</option>
                                        <option value="Mahasiswa">Mahasiswa</option>
                                        <option value="Swasta">Swasta</option>
                                        <option value="Buruh/Karyawan">Buruh/Karyawan</option>
                                        <option value="Petani/Nelayan">Petani/Nelayan</option>
                                        <option value="Pedagang">Pedagang</option>
                                        <option value="Wiraswasta/Pengusaha">Wiraswasta/Pengusaha</option>
                                        <option value="Sopir/TukangOjek">Sopir/TukangOjek</option>
                                        <option value="Ikut Orang Tua">Ikut Orang Tua</option>
                                        <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                        <option value="Tidak Kerja">Tidak Kerja</option>
                                        <option value="Notaris">Notaris</option>
                                        <option value="TNI">TNI</option>
                                        <option value="POLRI">POLRI</option>
                                        <option value="PNS">PNS</option>
                                        <option value="PEMBANTU">PEMBANTU</option>
                                        <option value="NAPI">NAPI</option>
                                      </select>
                                    </div>
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
              <!-- Modal Detail Tersangka -->
              <div class="modal fade" id="detailModal<?= $row['id_tersangka']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="detailModalLabel">Detail Identitas Tersangka</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <div class="row">
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" id="nama" class="form-control" name="nama" placeholder="Masukkan Nama Tersangka" autocomplete="off" required value="<?= $row['nama'] ?>" disabled>
                                    
                                    <label for="ttl">TTL</label>
                                    <input type="text" id="ttl" class="form-control" name="ttl" placeholder="Masukkan TTL Tersangka" autocomplete="off" required value="<?= $row['ttl'] ?>" disabled>
                                    
                                    <label for="nik">NIK</label>
                                    <input type="text" id="nik" class="form-control" name="nik" placeholder="Masukkan NIK Tersangka" autocomplete="off" required value="<?= $row['nik'] ?>" disabled>

                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" name="alamat" id="alamat" rows="3" required placeholder="Tulis Alamat Tersangka Disini" disabled><?= $row['alamat'] ?></textarea>

                                    <label for="agama">Agama</label>
                                    <select name="agama" id="agama" class="form-control" required disabled>
                                      <option value="<?= $row['agama'] ?>" selected><?= $row['agama'] ?></option>
                                      <option value="Islam">Islam</option>
                                      <option value="Kristen">Kristen</option>
                                      <option value="Katolik">Katolik</option>
                                      <option value="Hindu">Hindu</option>
                                      <option value="Buddha">Buddha</option>
                                      <option value="Konghucu">Konghucu</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <label for="status">Status</label>
                                  <select name="status" id="status" class="form-control" required disabled>
                                    <option value="<?= $row['status'] ?>" selected><?= $row['status'] ?></option>
                                    <option value="Penanam">Penanam</option>
                                    <option value="Produksi">Produksi</option>
                                    <option value="Bandar">Bandar</option>
                                    <option value="Pengedar">Pengedar</option>
                                    <option value="Pengguna">Pengguna</option>
                                  </select>

                                  <label for="status_kewarganegaraan">Kewarganegaraan</label>
                                  <select name="status_kewarganegaraan" id="status_kewarganegaraan" class="form-control" required disabled>
                                    <option value="<?= $row['status_kewarganegaraan'] ?>" selected><?= $row['status_kewarganegaraan'] ?></option>
                                    <option value="WNI">WNI</option>
                                    <option value="WNA">WNA</option>
                                  </select>

                                  <label for="jenis_kelamin">Jenis Kelamin</label>
                                  <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required disabled>
                                    <option value="<?= $row['jenis_kelamin'] ?>" selected><?= $row['jenis_kelamin'] ?></option>
                                    <option value="LK">Laki - Laki</option>
                                    <option value="PR">Perempuan</option>
                                  </select>
                                </div>
                                
                                <div class="col-md-4">
                                  <label for="kategori_usia">Usia</label>
                                  <select name="kategori_usia" id="kategori_usia" class="form-control" required disabled>
                                    <option value="<?= $row['kategori_usia'] ?>" selected><?= $row['kategori_usia'] ?></option>
                                    <option value="<14"><14</option>
                                    <option value="15-18">15-18</option>
                                    <option value="19-24">19-24</option>
                                    <option value="25-64">25-64</option>
                                    <option value=">65">>65</option>
                                  </select>

                                  <label for="usia">Usia</label>
                                  <input type="number" name="usia" id="usia" class="form-control" placeholder="Masukkan Usia" value="<?= $row['usia'] ?>" required disabled>

                                  <label for="pendidikan">Pendidikan</label>
                                  <select name="pendidikan" id="pendidikan" class="form-control" required disabled>
                                    <option value="<?= $row['pendidikan'] ?>" selected><?= $row['pendidikan'] ?></option>
                                    <option value="Tidak Sekolah">Tidak Sekolah</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="PT">PT</option>
                                    <option value="Belum Diketahui">Belum Diketahui</option>
                                  </select>

                                  <label for="pekerjaan">Pekerjaan</label>
                                  <select name="pekerjaan" id="pekerjaan" class="form-control" required disabled>
                                    <option value="<?= $row['pekerjaan'] ?>" selected><?= $row['pekerjaan'] ?></option>
                                    <option value="Pelajar">Pelajar</option>
                                    <option value="Mahasiswa">Mahasiswa</option>
                                    <option value="Swasta">Swasta</option>
                                    <option value="Buruh/Karyawan">Buruh/Karyawan</option>
                                    <option value="Petani/Nelayan">Petani/Nelayan</option>
                                    <option value="Pedagang">Pedagang</option>
                                    <option value="Wiraswasta/Pengusaha">Wiraswasta/Pengusaha</option>
                                    <option value="Sopir/TukangOjek">Sopir/TukangOjek</option>
                                    <option value="Ikut Orang Tua">Ikut Orang Tua</option>
                                    <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                    <option value="Tidak Kerja">Tidak Kerja</option>
                                    <option value="Notaris">Notaris</option>
                                    <option value="TNI">TNI</option>
                                    <option value="POLRI">POLRI</option>
                                    <option value="PNS">PNS</option>
                                    <option value="PEMBANTU">PEMBANTU</option>
                                    <option value="NAPI">NAPI</option>
                                  </select>
                                </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            <?php $no++; } ?>
          <?php }else{?>
                <tr>
                    <td colspan="10" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Tersangka Belum Tersedia</p></td>
                    <td style="display: none"></td>
                    <td style="display: none"></td>
                    <td style="display: none"></td>
                    <td style="display: none"></td>
                    <td style="display: none"></td>
                    <td style="display: none"></td>
                    <td style="display: none"></td>
                    <td style="display: none"></td>
                    <td style="display: none"></td>
                </tr>
          <?php } ?>
          </tbody>
        </table>
        <div class="py-4 d-flex justify-content-end">
            <a href="<?= base_url("finalisasi-data/{$dataKasus['id_kasus']}") ?>" class="btn btn-success">Finalisasi Data</a>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script>
  $('html, body').animate({
      scrollTop: $("#scrollToContent").offset().top
  }, 2000);

  $(document).ready(function() {

    $('#kesatuan').on('change', function() {
      
      // alert( this.value );
      if (this.value == 'polsek') {
        $(`.formatPolres`).remove();
        // Append Element Format LP Polsek
        const formatLP = $(`<div class="d-flex align-items-center formatPolsek"><p class="mb-0">LP/A/</p><input type="number" class="form-control" name="nosurat" id="nosurat" autocomplete="off" placeholder="" required style="width:10%;"><p class="mb-0">/</p><select name="bulansurat" id="bulansurat" class="form-control" style="width:10%;"><option selected disabled></option><option value="I">I</option><option value="II">II</option><option value="III">III</option><option value="IV">IV</option><option value="V">V</option><option value="VI">VI</option><option value="VII">VII</option><option value="VIII">VIII</option><option value="IX">IX</option><option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option></select><p class="mb-0">/</p><div class="input-group date" id="tahunsuratpolsek" data-target-input="nearest" style="width:10%;"><input type="text" class="form-control" name="tahunsurat" datetimepicker-input" data-target="#tahunsuratpolsek" /><div class="input-group-append" data-target="#tahunsuratpolsek" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div><p class="mb-0">/SPKT/</p><input type="text" name="namapolsek" class="form-control" id="namapolsek" autocomplete="off" placeholder="Nama Polsek" required style="width:20%;text-transform:uppercase;"><p class="mb-0">/</p><p class="mb-0" id="namaKesatuanPolsek"></p><p class="mb-0">/POLDA JAWA TIMUR</p></div>`);

        $('#formatLP').append(formatLP);
        document.getElementById('namaKesatuanPolsek').innerHTML = "<?= $this->session->userdata('login_data_admin')['nama'] ?>"

        $('#tahunsuratpolsek').datetimepicker({
          viewMode: 'years',
          format: 'YYYY'
        });
      }else{
        $(`.formatPolsek`).remove();
        // Append Element Format LP Polres
        const formatLP = $(`<div class="d-flex align-items-center formatPolres"><p class="mb-0">LP/A/</p><input type="number" class="form-control" name="nosurat" id="nosurat" autocomplete="off" placeholder="" required style="width:10%;"><p class="mb-0">/</p><select name="bulansurat" id="bulansurat" class="form-control" style="width:10%;"><option selected disabled></option><option value="I">I</option><option value="II">II</option><option value="III">III</option><option value="IV">IV</option><option value="V">V</option><option value="VI">VI</option><option value="VII">VII</option><option value="VIII">VIII</option><option value="IX">IX</option><option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option></select><p class="mb-0">/</p><div class="input-group date" id="tahunsuratpolres" data-target-input="nearest" style="width:10%;"><input type="text" class="form-control datetimepicker-input" name="tahunsurat" data-target="#tahunsuratpolres" /><div class="input-group-append" data-target="#tahunsuratpolres" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div><p class="mb-0">/SPKT.</p><p class="mb-0" id="namaKesatuanPolres"></p><p class="mb-0">/POLDA JAWA TIMUR</p></div>`);

        $('#formatLP').append(formatLP);
        document.getElementById('namaKesatuanPolres').innerHTML = "<?= $this->session->userdata('login_data_admin')['kode_lp'] ?>"
        
        $('#tahunsuratpolres').datetimepicker({
          viewMode: 'years',
          format: 'YYYY'
        });
      }
    });
    
    $(function () {
      $('#tahunsurat').datetimepicker({
          viewMode: 'years',
          format: 'YYYY'
        });
    });
    
    $(function () {
      $('#tahunTTL').datetimepicker({
        format: 'YYYY-MM-DD'
      });
    });
    
    $(".tombol-hapus").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Hapus Informasi Data Tersangka?",
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
    
    $(".batalBB").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Batal Samakan Barang Bukti?",
        text: "Membatalkan bersifat permanen pada database, mohon berhati-hati.",
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

    $('#kategori_usia').on('change', function() {
      switch (this.value) {
        case "<14":
          $("#usia").attr({
            "max" : 14,
            "min" : 1
          });
          break;
        case "15-18":
          $("#usia").attr({
            "max" : 18,
            "min" : 15
          });
          break;
        case "19-24":
          $("#usia").attr({
            "max" : 24,
            "min" : 19
          });
          break;
        case "25-64":
          $("#usia").attr({
            "max" : 64,
            "min" : 25
          });
          break;
        default:
          $("#usia").attr({
            "max" : 150,
            "min" : 65
          });
          break;
      }
    });
  });
</script>