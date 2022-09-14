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
        <h2>Data Selesai Perkara</h2>
        <p>Periode : <?= $dateNow ?></p>
        <div class="alert alert-warning" role="alert">
          Perhatian! Hanya LP yang <strong>terkunci ke database</strong> ter-rekap dalam <strong>data selesai perkara</strong>.
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
                <a class="btn btn-success btn-sm mt-1" href="<?= base_url('export-opsi/selra') ?>"><span><i class="fas fa-print"></i> </span>Export</a>
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
                        <form action="<?= base_url() ?>data/viewSelraByDate" method="post">
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
                        <th style="width:40%;">Kategori</th>
                        <th>CT</th>
                        <th>CC</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($dataKasus)){ ?>
                        <tr>
                            <td class="text-center"><strong>Kasus</strong></td>
                            <td class="text-center"><?= $dataKasus['CT']['Kasus'] ?></td>
                            <td class="text-center"><?= $dataKasus['CC']['Kasus'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><strong>Tersangka</strong></td>
                            <td class="text-center"><?= $dataKasus['CT']['Tersangka'] ?></td>
                            <td class="text-center"><?= $dataKasus['CC']['Tersangka'] ?></td>
                        </tr>
                    <?php }else{?>
                            <tr>
                                <td colspan="3" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Selra Belum Tersedia</p></td>
                            </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <hr>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                        <th style="width:40%;">Kesatuan</th>
                        <th>SP3</th>
                        <th>RJ</th>
                        <th>TAHAP II</th>
                        <th>Belum Diketahui</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($dataKasus)){ 
                        foreach ($matrikSelra as $keyKesatuan => $item) {
                        ?>
                        <tr class="text-center">
                            <td><?php 
                            $kesatuan = $CI->Modelkesatuan->getKesatuanByKode($keyKesatuan);
                            echo $kesatuan[0]['nama'];?>
                            </td>
                            <td><?= $item['SP3'] ?></td>
                            <td><?= $item['RJ'] ?></td>
                            <td><?= $item['TAHAPII'] ?></td>
                            <td><?= $item['BELUMDIKETAHUI'] ?></td>
                        </tr>
                    <?php } 
                        if(!isset($orderDate)):
                        ?> 
                        <tr class="text-center">
                            <td><strong>TOTAL</strong></td>
                            <td><?= $totalMatrikSelra['SP3'] ?></td>
                            <td><?= $totalMatrikSelra['RJ'] ?></td>
                            <td><?= $totalMatrikSelra['TAHAPII'] ?></td>
                            <td><?= $totalMatrikSelra['BELUMDIKETAHUI'] ?></td>
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
                    <button class="nav-link active" id="belumdiketahui-tab" data-toggle="tab" data-target="#belumdiketahui" type="button" role="tab" aria-controls="belumdiketahui" aria-selected="false">Status SELRA Belum Diketahui - <strong>CT</strong></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="selesai-tab" data-toggle="tab" data-target="#selesai" type="button" role="tab" aria-controls="selesai" aria-selected="true">Status SELRA Selesai (SP3/RJ/Tahap II) - <strong>CC</strong></button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- Kasus Belum Diketahui -->
                <div class="tab-pane fade show active py-3" id="belumdiketahui" role="tabpanel" aria-labelledby="belumdiketahui-tab">
                    <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr class="text-center">
                            <th>No</th>
                            <th>Kesatuan</th>
                            <th>No Laporan Polisi</th>
                            <th>Tanggal Input LP</th>
                            <th>Durasi Perkara Hingga Hari Ini</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($dataCT)){ ?>
                            <?php 
                            $no = 1;
                            foreach ($dataCT as $rowCT) { 
                            ?>
                            <tr>
                                <td class="text-center"><?= $no ?></td>
                                <td><?= $rowCT["kode_kesatuan"]; ?></td>
                                <td><?= $rowCT["no_laporanpolisi"]; ?></td>
                                <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowCT["created_at"]))) ?></td>
                                <td class="text-center">
                                    <?php 
                                        $diff = date_diff(date_create($rowCT["created_at"]), date_create(date("Y-m-d")));
                                        echo $diff->format("%a")." Hari";
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php if(empty($rowCT["status_kasus"])){ ?>
                                        <button class="btn btn-warning btn-sm"><strong>Belum Diketahui</strong></button>
                                    <?php }else if ($rowCT["status_kasus"] == 'TAHAP II'){ ?>
                                        <button class="btn btn-success btn-sm"><strong>Tahap II</strong></button>
                                    <?php }else if($rowCT["status_kasus"] == 'SP3'){ ?>
                                        <button class="btn btn-success btn-sm"><strong>SP3</strong></button>
                                    <?php }else{?>
                                        <button class="btn btn-success btn-sm"><strong>RJ</strong></button>
                                    <?php } ?>
                                </td>
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
                <!-- Kasus Selesai -->
                <div class="tab-pane fade py-3" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                    <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr class="text-center">
                            <th>No</th>
                            <th>Kesatuan</th>
                            <th>No Laporan Polisi</th>
                            <th>Tanggal Input LP</th>
                            <th>Tanggal SELRA</th>
                            <th>Durasi Perkara</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($dataCC)){ ?>
                            <?php 
                            $no = 1;
                            foreach ($dataCC as $rowCC) { 
                            ?>
                            <tr>
                                <td class="text-center"><?= $no ?></td>
                                <td><?php
                                $result = $CI->Modelkesatuan->getKesatuanByKode($rowCC["kode_kesatuan"]);
                                echo $result[0]['nama']; ?></td>
                                <td><?= $rowCC["no_laporanpolisi"]; ?></td>
                                <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowCC["created_at"]))) ?></td>
                                <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowCC["date_statusKasus"]))) ?></td>
                                <td class="text-center">
                                    <?php 
                                        $diff = date_diff(date_create($rowCC["created_at"]), date_create($rowCC["date_statusKasus"]));
                                        echo $diff->format("%a")." Hari";
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php if(empty($rowCC["status_kasus"])){ ?>
                                        <button class="btn btn-warning btn-sm"><strong>Belum Diketahui</strong></button>
                                    <?php }else if ($rowCC["status_kasus"] == 'TAHAP II'){ ?>
                                        <button class="btn btn-success btn-sm"><strong>Tahap II</strong></button>
                                    <?php }else if($rowCC["status_kasus"] == 'SP3'){ ?>
                                        <button class="btn btn-success btn-sm"><strong>SP3</strong></button>
                                    <?php }else{?>
                                        <button class="btn btn-success btn-sm"><strong>RJ</strong></button>
                                    <?php } ?>
                                </td>
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
                    <th style="width:40%;">Kategori</th>
                    <th>CT</th>
                    <th>CC</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($dataKasus)){ ?>
                    <tr>
                        <td class="text-center"><strong>Kasus</strong></td>
                        <td class="text-center"><?= $dataKasus['CT']['Kasus'] ?></td>
                        <td class="text-center"><?= $dataKasus['CC']['Kasus'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-center"><strong>Tersangka</strong></td>
                        <td class="text-center"><?= $dataKasus['CT']['Tersangka'] ?></td>
                        <td class="text-center"><?= $dataKasus['CC']['Tersangka'] ?></td>
                    </tr>
                <?php }else{?>
                        <tr>
                            <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Selra Belum Tersedia</p></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
            
            <table class="table table-bordered table-striped mt-2">
                <thead>
                    <tr class="text-center">
                        <th>Status SELRA</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($matrikSelra)){ ?>
                    <tr class="text-center">
                        <td><strong>SP3</strong></td>
                        <td><?= $matrikSelra['SP3'] ?></td>
                    </tr>
                    <tr class="text-center">
                        <td><strong>RJ</strong></td>
                        <td><?= $matrikSelra['RJ'] ?></td>
                    </tr>
                    <tr class="text-center">
                        <td><strong>Tahap II</strong></td>
                        <td><?= $matrikSelra['TAHAPII'] ?></td>
                    </tr>
                    <tr class="text-center">
                        <td><strong>Belum Diketahui</strong></td>
                        <td><?= $matrikSelra['BELUMDIKETAHUI'] ?></td>
                    </tr>
                <?php }else{?>
                        <tr>
                            <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Selra Belum Tersedia</p></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
            <hr>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="belumdiketahui-tab" data-toggle="tab" data-target="#belumdiketahui" type="button" role="tab" aria-controls="belumdiketahui" aria-selected="false">Status SELRA Belum Diketahui - <strong>CT</strong></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="selesai-tab" data-toggle="tab" data-target="#selesai" type="button" role="tab" aria-controls="selesai" aria-selected="true">Status SELRA Selesai (SP3/RJ/Tahap II) - <strong>CC</strong></button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- Kasus Belum Diketahui -->
                <div class="tab-pane fade show active py-3" id="belumdiketahui" role="tabpanel" aria-labelledby="belumdiketahui-tab">
                    <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr class="text-center">
                            <th>No</th>
                            <th>Action</th>
                            <th>No Laporan Polisi</th>
                            <th>Tanggal Input LP</th>
                            <th>Durasi Perkara Hingga Hari Ini</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($dataCT)){ ?>
                            <?php 
                            $no = 1;
                            foreach ($dataCT as $rowCT) { 
                            ?>
                            <tr>
                                <td class="text-center"><?= $no ?></td>
                                <td class="text-center">
                                    <div data-toggle="tooltip" data-placement="top" title="Pilih Status SELRA">
                                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#statusModal<?= $rowCT['id_kasus']; ?>"><i class="fas fa-check-square"></i></a>
                                    </div>
                                </td>
                                <td><?= $rowCT["no_laporanpolisi"]; ?></td>
                                <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowCT["created_at"]))) ?></td>
                                <td class="text-center">
                                    <?php 
                                        $diff = date_diff(date_create($rowCT["created_at"]), date_create(date("Y-m-d")));
                                        echo $diff->format("%a")." Hari";
                                    ?>
                                </td>
                                <td  class="text-center">
                                    <?php if(empty($rowCT["status_kasus"])){ ?>
                                        <button class="btn btn-warning btn-sm"><strong>Belum Diketahui</strong></button>
                                    <?php }else if ($rowCT["status_kasus"] == 'TAHAP II'){ ?>
                                        <button class="btn btn-success btn-sm"><strong>Tahap II</strong></button>
                                    <?php }else if($rowCT["status_kasus"] == 'SP3'){ ?>
                                        <button class="btn btn-success btn-sm"><strong>SP3</strong></button>
                                    <?php }else{?>
                                        <button class="btn btn-success btn-sm"><strong>RJ</strong></button>
                                    <?php } ?>
                                </td>
                            </tr>
                            <!-- Modal Status Kasus -->
                            <div class="modal fade" id="statusModal<?= $rowCT['id_kasus']; ?>" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="statusModalLabel">Pilih Status SELRA</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="<?= base_url("data/updateStatusKasus/{$rowCT['id_kasus']}/") ?>" method="post">
                                                <div class="form-group">
                                                    <label for="status_kasus">Status SELRA:</label>
                                                    <select name="status_kasus" id="status_kasus" class="form-control" required>
                                                        <option selected disabled>Pilih SELRA</option>
                                                        <option value="SP3">SP3</option>
                                                        <option value="RJ">RJ</option>
                                                        <option value="TAHAP II">TAHAP II</option>
                                                        <option value="">Belum Diketahui</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Keterangan SELRA <small style="color:red;">*opsional</small></label>
                                                    <textarea class="form-control" name="ket_statusKasus" rows="5" placeholder="Tulis Keterangan SELRA disini. Untuk SELRA Tahap II, mohon sertakan keterangan lokasi pelimpahan."></textarea>
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
                            <?php $no++; } ?>
                        <?php }else{?>
                                <tr>
                                    <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Selra Belum Tersedia</p></td>
                                </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- Kasus Selesai -->
                <div class="tab-pane fade py-3" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                    <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr class="text-center">
                            <th>No</th>
                            <th>Action</th>
                            <th>No Laporan Polisi</th>
                            <th>Tanggal Input LP</th>
                            <th>Tanggal SELRA</th>
                            <th>Durasi Perkara</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($dataCC)){ ?>
                            <?php 
                            $no = 1;
                            foreach ($dataCC as $rowCC) { 
                            ?>
                            <tr>
                                <td class="text-center"><?= $no ?></td>
                                <td class="text-center">
                                    <div data-toggle="tooltip" data-placement="top" title="Ubah Status SELRA">
                                        <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $rowCC['id_kasus']; ?>"><i class="fas fa-pen-square"></i></a>
                                    </div>
                                </td>
                                <td><?= $rowCC["no_laporanpolisi"]; ?></td>
                                <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowCC["created_at"]))) ?></td>
                                <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowCC["date_statusKasus"]))) ?></td>
                                <td class="text-center">
                                    <?php 
                                        $diff = date_diff(date_create($rowCC["created_at"]), date_create($rowCC["date_statusKasus"]));
                                        echo $diff->format("%a")." Hari";
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php if(empty($rowCC["status_kasus"])){ ?>
                                        <button class="btn btn-warning btn-sm">
                                            <strong>Belum Diketahui</strong>
                                        </button>
                                    <?php }else if ($rowCC["status_kasus"] == 'TAHAP II'){ ?>
                                        <button class="btn btn-success btn-sm">
                                            <strong>Tahap II</strong>
                                            <?php if(!empty($rowCC["ket_statusKasus"])): ?>
                                                <p><strong>Keterangan :</strong>&nbsp;<?= $rowCC["ket_statusKasus"] ?></p>
                                            <?php endif; ?>
                                        </button>
                                    <?php }else if($rowCC["status_kasus"] == 'SP3'){ ?>
                                        <button class="btn btn-success btn-sm">
                                            <strong>SP3</strong>
                                            <?php if(!empty($rowCC["ket_statusKasus"])): ?>
                                                <p><strong>Keterangan :</strong>&nbsp;<?= $rowCC["ket_statusKasus"] ?></p>
                                            <?php endif; ?>
                                        </button>
                                    <?php }else{?>
                                        <button class="btn btn-success btn-sm">
                                            <strong>RJ</strong>
                                            <?php if(!empty($rowCC["ket_statusKasus"])): ?>
                                                <p><strong>Keterangan :</strong>&nbsp;<?= $rowCC["ket_statusKasus"] ?></p>
                                            <?php endif; ?>
                                        </button>
                                    <?php } ?>
                                </td>
                            </tr>
                            <!-- Modal Status Kasus -->
                            <div class="modal fade" id="editModal<?= $rowCC['id_kasus']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Ubah Status SELRA</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="<?= base_url("data/updateStatusKasus/{$rowCC['id_kasus']}/") ?>" method="post">
                                                <div class="form-group">
                                                    <label for="status_kasus">Status SELRA:</label>
                                                    <select name="status_kasus" id="status_kasus" class="form-control" required>
                                                        <option selected value="<?= $rowCC['status_kasus'] ?>"><?= $rowCC['status_kasus'] ?></option>
                                                        <option value="SP3">SP3</option>
                                                        <option value="RJ">RJ</option>
                                                        <option value="TAHAP II">TAHAP II</option>
                                                        <option value="">Belum Diketahui</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Keterangan SELRA <small style="color:red;">*opsional</small></label>
                                                    <textarea class="form-control" name="ket_statusKasus" rows="5" placeholder="Tulis Keterangan SELRA disini. Untuk SELRA Tahap II, mohon sertakan keterangan lokasi pelimpahan."><?= $rowCC['ket_statusKasus'] ?></textarea>
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
        <?php } ?>
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
  