  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid pt-2">
        <div class="alert alert-info" role="alert">
          Berikut rekap data ungkap kasus yang anda isi, mohon untuk memeriksa kembali informasi yang anda laporkan!
        </div>
        <h4>Informasi Umum Kasus</h4>
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="no_laporanpolisi">Nomor Laporan Polisi :</label>
                    <input type="text" class="form-control" id="no_laporanpolisi" value="<?= $dataKasus['no_laporanpolisi'] ?>" readonly>
                    
                    <label for="tkp">Tempat Kejadian Perkara :</label>
                    <input type="text" class="form-control" id="tkp" value="<?= $dataKasus['tkp'] ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="pasal">Deskripsi Pasal yang Ditangguhkan :</label>
                    <textarea class="form-control" id="pasal" rows="3" readonly><?= $dataKasus['pasal'] ?></textarea>
                    
                    <label for="deskripsi_waktudantkp">Deskripsi Waktu dan TKP :</label>
                    <textarea class="form-control" id="deskripsi_waktudantkp" rows="3" readonly><?= $dataKasus['deskripsi_waktudantkp'] ?></textarea>
                </div>
            </div>
        <hr>
        <h4>Data Tersangka</h4>
            <table id="table-full-fitur" class="table datatable table-bordered table-striped " style="width:100%">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>NIK</th>
                    <th>Agama</th>
                    <th>Status Tersangka</th>
                    <th>Kewarganegaraan</th>
                    <th>Jenis Kelamin</th>
                    <th>Usia</th>
                    <th>Pendidikan</th>
                    <th>Pekerjaan</th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($dataTersangka)){ ?>
                <?php foreach ($dataTersangka as $row) { ?>
                <tr>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['alamat'] ?></td>
                    <td><?= $row['nik'] ?></td>
                    <td><?= $row['agama'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= $row['status_kewarganegaraan'] ?></td>
                    <td><?= $row['jenis_kelamin'] ?></td>
                    <td><?= $row['usia'] ?></td>
                    <td><?= $row['pendidikan'] ?></td>
                    <td><?= $row['pekerjaan'] ?></td>
                </tr>
                <?php } ?>
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
            <hr>
            <h4>Data Barang Bukti</h4>
            <table id="table-full-fitur" class="table datatable table-bordered table-striped " style="width:100%">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($dataBarangBukti)){ ?>
                    <?php foreach ($dataBarangBukti as $row) { ?>
                    <tr>
                        <td><?= $row['nama_barangbukti'] ?>&nbsp;<?= ($row['kategori'] == 'Lain-lain') ? " dengan keterangan : ( {$row['keterangan']} )" : '' ?>&nbsp;<?= ($row['berat']) ? "& berat {$row['berat']} gram" : '' ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td><?= $row['satuan'] ?></td>
                    </tr>
                    <?php } ?>
                <?php }else{?>
                        <tr>
                            <td colspan="3" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Barang Bukti Belum Tersedia</p></td>
                            <td style="display: none"></td>
                            <td style="display: none"></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
        <hr>
        <div class="py-4 row">
            <div class="col-md-8">
                <a href="<?= base_url("kasus-pelimpahan/{$dataKasus['id_kasus']}") ?>" class="btn btn-secondary">Kembali ke Data LP Pelimpahan</a>
            </div>
            <div class="col-md-4 text-right">
                <a href="<?= base_url("kasus-pelimpahan") ?>" class="btn btn-primary">Lihat Master Pelimpahan</a>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  