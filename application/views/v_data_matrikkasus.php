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
    $CI->load->model('Modelkesatuan');
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4 py-4">
        <div class="alert alert-warning" role="alert">
          Perhatian! Hanya LP yang <strong>terkunci ke matrik</strong> ter-rekap dalam modul <strong>matrik barang bukti</strong>.
          Silahkan melengkapi instrumen yang kosong dengan pilihan yang disiapkan!
        </div>
        <h2>Matrik Kasus <strong><?= $this->session->userdata('login_data_admin')['nama'] ?></strong></h2>
        <p>Periode : <?= $dateNow ?></p>
        <hr>
        <div class="row">
          <div class="col-md-10">
            <a class="btn btn-primary btn-sm mt-1 mx-1" data-toggle="modal" data-target="#sortModal"><span><i class="fas fa-filter"></i> </span>Sort by Date</a>
          </div>
          <div class="col-md-2 text-right">
              <a class="btn btn-success btn-sm mt-1" href="<?= base_url('export-opsi/matrikKasus') ?>"><span><i class="fas fa-print"></i> </span>Export</a>
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
                        <form action="<?= base_url() ?>data/viewMatrikKasusByDate" method="post">
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
        <table id="table-matrik-kasus" class="table table-responsive table-bordered table-striped text-center" style="width:100%">
            <thead class="text-center">
                <tr>
                  <th rowspan="3">NO</th>
                  <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'): ?>
                  <th rowspan="3">KESATUAN</th>
                  <?php endif; ?>
                  <th rowspan="3">KSS</th>
                  <th rowspan="3">TSK</th>
                  <td colspan="5">STATUS TSK</td>
                  <td colspan="4">KEWARGANEGARAAN</td>
                  <td colspan="5">USIA</td>
                  <td colspan="6">PENDIDIKAN</td>
                  <td colspan="17">PEKERJAAN</td>
                  <td colspan="7">TEMPAT KEJADIAN PERKARA</td>
                  <td colspan="13">BARANG BUKTI</td>
                </tr>
                <tr>
                    <!-- Status TSK -->
                    <th rowspan="2">Penanam</th>
                    <th rowspan="2">Produksi</th>
                    <th rowspan="2">Bandar</th>
                    <th rowspan="2">Pengedar</th>
                    <th rowspan="2">Pengguna</th>
                    <!-- Kewarganegaraan -->
                    <td colspan="2">WNI</td>
                    <td colspan="2">WNA</td>
                    <!-- Status TSK -->
                    <th rowspan="2">< 14</th>
                    <th rowspan="2">15 - 18</th>
                    <th rowspan="2">19 - 24</th>
                    <th rowspan="2">25 - 64</th>
                    <th rowspan="2">> 65</th>
                    <!-- Pendidikan -->
                    <th rowspan="2">Tidak Sekolah</th>
                    <th rowspan="2">SD</th>
                    <th rowspan="2">SMP</th>
                    <th rowspan="2">SMA</th>
                    <th rowspan="2">PT</th>
                    <th rowspan="2">Belum Diketahui</th>
                    <!-- Pekerjaan -->
                    <th rowspan="2">Pelajar</th>
                    <th rowspan="2">Mahasiswa</th>
                    <th rowspan="2">Swasta</th>
                    <th rowspan="2">Buruh/Karyawan</th>
                    <th rowspan="2">Petani/Nelayan</th>
                    <th rowspan="2">Pedagang</th>
                    <th rowspan="2">Wiraswasta/Pengusaha</th>
                    <th rowspan="2">Sopir/Tukang Ojek</th>
                    <th rowspan="2">Ikut Orang Tua</th>
                    <th rowspan="2">Ibu Rumah Tangga</th>
                    <th rowspan="2">Tidak Kerja</th>
                    <th rowspan="2">Notaris</th>
                    <th rowspan="2">TNI</th>
                    <th rowspan="2">POLRI</th>
                    <th rowspan="2">PNS</th>
                    <th rowspan="2">Pembantu</th>
                    <th rowspan="2">NAPI</th>
                    <!-- Tempat Kejadian Perkara -->
                    <th rowspan="2">Hotel/Villa/Kos</th>
                    <th rowspan="2">Ruko/Gedung/Mall/Pabrik</th>
                    <th rowspan="2">Tempat Umum</th>
                    <th rowspan="2">Pemukiman/Pondok</th>
                    <th rowspan="2">Diskotik/Tempat Karaoke</th>
                    <th rowspan="2">Terminal/Bandara/Pelabuhan</th>
                    <th rowspan="2">Rumah Tahanan</th>
                    <!-- Barang Bukti -->
                    <td colspan="10">Narkotika & Psikotropika</td>
                    <td colspan="3">Okerbaya</td>
                </tr>
                <tr>
                    <!-- Kewarganegaraan & Jenis Kelamin -->
                    <th>LK</th>
                    <th>PR</th>
                    <th>LK</th>
                    <th>PR</th>
                    <!-- Barang Bukti -->
                    <th>Ganja</th>
                    <th>Tembakau Gorilla</th>
                    <th>Hashish</th>
                    <th>Opium</th>
                    <th>Morphin</th>
                    <th>Heroin/Putaw</th>
                    <th>Kokain</th>
                    <th>Exstacy/Carnophen</th>
                    <th>Sabu</th>
                    <th>GOL IV</th>
                    <th>Daftar G</th>
                    <th>Kosmetik</th>
                    <th>Jamu</th>
                </tr>
            </thead>
            <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>

              <tbody>
                <?php 
                $no = 1;
                  foreach ($dataMatrik as $keyKesatuan => $item) {
                ?>
                <tr>
                    <!-- No -->
                    <td class="text-center"><?= $no ?>.</td>
                    <!-- KESATUAN -->
                    <td><?php 
                      $kesatuan = $CI->Modelkesatuan->getKesatuanByKode($keyKesatuan);
                      echo $kesatuan[0]['nama'];?>
                    </td>
                    <!-- Kasus -->
                    <td><?= $item['KSS'] ?></td>
                    <!-- Tersangka -->
                    <td><?= $item['TSK'] ?></td>
                    <!-- Status Tersangka -->
                    <td><?= $item['StatusTSK']['Penanam'] ?></td>
                    <td><?= $item['StatusTSK']['Produksi'] ?></td>
                    <td><?= $item['StatusTSK']['Bandar'] ?></td>
                    <td><?= $item['StatusTSK']['Pengedar'] ?></td>
                    <td><?= $item['StatusTSK']['Pengguna'] ?></td>
                    <!-- Kewarganegaraan & Jenis Kelamin -->
                    <td><?= $item['KEWARGANEGARAAN']['WNI']['LK'] ?></td>
                    <td><?= $item['KEWARGANEGARAAN']['WNI']['PR'] ?></td>
                    <td><?= $item['KEWARGANEGARAAN']['WNA']['LK'] ?></td>
                    <td><?= $item['KEWARGANEGARAAN']['WNA']['PR'] ?></td>
                    <!-- Usia -->
                    <td><?= $item['USIA']['<14'] ?></td>
                    <td><?= $item['USIA']['15-18'] ?></td>
                    <td><?= $item['USIA']['19-24'] ?></td>
                    <td><?= $item['USIA']['25-64'] ?></td>
                    <td><?= $item['USIA']['<65'] ?></td>
                    <!-- Pendidikan -->
                    <td><?= $item['PENDIDIKAN']['Tidak Sekolah'] ?></td>
                    <td><?= $item['PENDIDIKAN']['SD'] ?></td>
                    <td><?= $item['PENDIDIKAN']['SMP'] ?></td>
                    <td><?= $item['PENDIDIKAN']['SMA'] ?></td>
                    <td><?= $item['PENDIDIKAN']['PT'] ?></td>
                    <td><?= $item['PENDIDIKAN']['Belum Diketahui'] ?></td>
                    <!-- Pekerjaan -->
                    <td><?= $item['PEKERJAAAN']['Pelajar'] ?></td>
                    <td><?= $item['PEKERJAAAN']['Mahasiswa'] ?></td>
                    <td><?= $item['PEKERJAAAN']['Swasta'] ?></td>
                    <td><?= $item['PEKERJAAAN']['Buruh/Karyawan'] ?></td>
                    <td><?= $item['PEKERJAAAN']['Petani/Nelayan'] ?></td>
                    <td><?= $item['PEKERJAAAN']['Pedagang'] ?></td>
                    <td><?= $item['PEKERJAAAN']['Wiraswasta/Pengusaha'] ?></td>
                    <td><?= $item['PEKERJAAAN']['Sopir/TukangOjek'] ?></td>
                    <td><?= $item['PEKERJAAAN']['Ikut Orang Tua'] ?></td>
                    <td><?= $item['PEKERJAAAN']['Ibu Rumah Tangga'] ?></td>
                    <td><?= $item['PEKERJAAAN']['Tidak Kerja'] ?></td>
                    <td><?= $item['PEKERJAAAN']['Notaris'] ?></td>
                    <td><?= $item['PEKERJAAAN']['TNI'] ?></td>
                    <td><?= $item['PEKERJAAAN']['POLRI'] ?></td>
                    <td><?= $item['PEKERJAAAN']['PNS'] ?></td>
                    <td><?= $item['PEKERJAAAN']['PEMBANTU'] ?></td>
                    <td><?= $item['PEKERJAAAN']['NAPI'] ?></td>
                    <!-- TKP -->
                    <td><?= $item['TKP']['Hotel/Villa/Kos'] ?></td>
                    <td><?= $item['TKP']['Ruko/Gedung/Mall/Pabrik'] ?></td>
                    <td><?= $item['TKP']['Tempat Umum'] ?></td>
                    <td><?= $item['TKP']['Pemukiman/Pondok'] ?></td>
                    <td><?= $item['TKP']['Diskotik/Tempat Karaoke'] ?></td>
                    <td><?= $item['TKP']['Terminal/Bandara/Pelabuhan'] ?></td>
                    <td><?= $item['TKP']['Rumah Tahanan'] ?></td>
                    <!-- Barang Bukti -->
                    <td><?= $item['BARANGBUKTI']['Ganja'] ?></td>
                    <td><?= $item['BARANGBUKTI']['Tembakau Gorilla'] ?></td>
                    <td><?= $item['BARANGBUKTI']['Hashish'] ?></td>
                    <td><?= $item['BARANGBUKTI']['Opium'] ?></td>
                    <td><?= $item['BARANGBUKTI']['Morphin'] ?></td>
                    <td><?= $item['BARANGBUKTI']['Heroin/Putaw'] ?></td>
                    <td><?= $item['BARANGBUKTI']['Kokain'] ?></td>
                    <td><?= $item['BARANGBUKTI']['Exstacy/Carnophen'] ?></td>
                    <td><?= $item['BARANGBUKTI']['Sabu'] ?></td>
                    <td><?= $item['BARANGBUKTI']['GOL IV'] ?></td>
                    <td><?= $item['BARANGBUKTI']['Daftar G'] ?></td>
                    <td><?= $item['BARANGBUKTI']['Kosmetik'] ?></td>
                    <td><?= $item['BARANGBUKTI']['Jamu'] ?></td>
                </tr>
                <?php $no++; } ?>
              </tbody>

            <?php }else{ ?>

              <tbody>
                  <tr>
                      <!-- No -->
                      <td class="text-center">1.</td>
                      <!-- Kasus -->
                      <td><?= $dataMatrik['KSS'] ?></td>
                      <!-- Tersangka -->
                      <td><?= $dataMatrik['TSK'] ?></td>
                      <!-- Status Tersangka -->
                      <td><?= $dataMatrik['StatusTSK']['Penanam'] ?></td>
                      <td><?= $dataMatrik['StatusTSK']['Produksi'] ?></td>
                      <td><?= $dataMatrik['StatusTSK']['Bandar'] ?></td>
                      <td><?= $dataMatrik['StatusTSK']['Pengedar'] ?></td>
                      <td><?= $dataMatrik['StatusTSK']['Pengguna'] ?></td>
                      <!-- Kewarganegaraan & Jenis Kelamin -->
                      <td><?= $dataMatrik['KEWARGANEGARAAN']['WNI']['LK'] ?></td>
                      <td><?= $dataMatrik['KEWARGANEGARAAN']['WNI']['PR'] ?></td>
                      <td><?= $dataMatrik['KEWARGANEGARAAN']['WNA']['LK'] ?></td>
                      <td><?= $dataMatrik['KEWARGANEGARAAN']['WNA']['PR'] ?></td>
                      <!-- Usia -->
                      <td><?= $dataMatrik['USIA']['<14'] ?></td>
                      <td><?= $dataMatrik['USIA']['15-18'] ?></td>
                      <td><?= $dataMatrik['USIA']['19-24'] ?></td>
                      <td><?= $dataMatrik['USIA']['25-64'] ?></td>
                      <td><?= $dataMatrik['USIA']['<65'] ?></td>
                      <!-- Pendidikan -->
                      <td><?= $dataMatrik['PENDIDIKAN']['Tidak Sekolah'] ?></td>
                      <td><?= $dataMatrik['PENDIDIKAN']['SD'] ?></td>
                      <td><?= $dataMatrik['PENDIDIKAN']['SMP'] ?></td>
                      <td><?= $dataMatrik['PENDIDIKAN']['SMA'] ?></td>
                      <td><?= $dataMatrik['PENDIDIKAN']['PT'] ?></td>
                      <td><?= $dataMatrik['PENDIDIKAN']['Belum Diketahui'] ?></td>
                      <!-- Pekerjaan -->
                      <td><?= $dataMatrik['PEKERJAAAN']['Pelajar'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['Mahasiswa'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['Swasta'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['Buruh/Karyawan'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['Petani/Nelayan'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['Pedagang'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['Wiraswasta/Pengusaha'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['Sopir/TukangOjek'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['Ikut Orang Tua'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['Ibu Rumah Tangga'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['Tidak Kerja'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['Notaris'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['TNI'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['POLRI'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['PNS'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['PEMBANTU'] ?></td>
                      <td><?= $dataMatrik['PEKERJAAAN']['NAPI'] ?></td>
                      <!-- TKP -->
                      <td><?= $dataMatrik['TKP']['Hotel/Villa/Kos'] ?></td>
                      <td><?= $dataMatrik['TKP']['Ruko/Gedung/Mall/Pabrik'] ?></td>
                      <td><?= $dataMatrik['TKP']['Tempat Umum'] ?></td>
                      <td><?= $dataMatrik['TKP']['Pemukiman/Pondok'] ?></td>
                      <td><?= $dataMatrik['TKP']['Diskotik/Tempat Karaoke'] ?></td>
                      <td><?= $dataMatrik['TKP']['Terminal/Bandara/Pelabuhan'] ?></td>
                      <td><?= $dataMatrik['TKP']['Rumah Tahanan'] ?></td>
                      <!-- Barang Bukti -->
                      <td><?= $dataMatrik['BARANGBUKTI']['Ganja'] ?></td>
                      <td><?= $dataMatrik['BARANGBUKTI']['Tembakau Gorilla'] ?></td>
                      <td><?= $dataMatrik['BARANGBUKTI']['Hashish'] ?></td>
                      <td><?= $dataMatrik['BARANGBUKTI']['Opium'] ?></td>
                      <td><?= $dataMatrik['BARANGBUKTI']['Morphin'] ?></td>
                      <td><?= $dataMatrik['BARANGBUKTI']['Heroin/Putaw'] ?></td>
                      <td><?= $dataMatrik['BARANGBUKTI']['Kokain'] ?></td>
                      <td><?= $dataMatrik['BARANGBUKTI']['Exstacy/Carnophen'] ?></td>
                      <td><?= $dataMatrik['BARANGBUKTI']['Sabu'] ?></td>
                      <td><?= $dataMatrik['BARANGBUKTI']['GOL IV'] ?></td>
                      <td><?= $dataMatrik['BARANGBUKTI']['Daftar G'] ?></td>
                      <td><?= $dataMatrik['BARANGBUKTI']['Kosmetik'] ?></td>
                      <td><?= $dataMatrik['BARANGBUKTI']['Jamu'] ?></td>
                  </tr>
              </tbody>

            <?php } ?>
        </table>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <script>
  $(document).ready(function() {
    $('#tanggalAwalHarian').datetimepicker({
        format: 'YYYY-MM-DD'
    });
        
    $('#tanggalAkhirHarian').datetimepicker({
        format: 'YYYY-MM-DD'
    });
  });
  </script>