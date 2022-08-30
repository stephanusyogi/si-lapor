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
        <h2>Matrik CC CT</h2>
        <p>Periode : <?= $dateNow ?></p>
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
            <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
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
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                    <th style="width:40%;">Kategori</th>
                    <th>CC</th>
                    <th>CT</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($dataKasus)){ ?>
                    <tr>
                        <td class="text-center"><strong>Kasus</strong></td>
                        <td class="text-center"><?= $dataKasus['CC']['Kasus'] ?></td>
                        <td class="text-center"><?= $dataKasus['CT']['Kasus'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-center"><strong>Tersangka</strong></td>
                        <td class="text-center"><?= $dataKasus['CC']['Tersangka'] ?></td>
                        <td class="text-center"><?= $dataKasus['CT']['Tersangka'] ?></td>
                    </tr>
                <?php }else{?>
                        <tr>
                            <td colspan="3" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Selra Belum Tersedia</p></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
            <hr>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="selesai-tab" data-toggle="tab" data-target="#selesai" type="button" role="tab" aria-controls="selesai" aria-selected="true">Status Kasus/Perkara Selesai - <strong>CC</strong></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="belumdiketahui-tab" data-toggle="tab" data-target="#belumdiketahui" type="button" role="tab" aria-controls="belumdiketahui" aria-selected="false">Status Kasus/Perkara Belum Diketahui - <strong>CT</strong></button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- Kasus Selesai -->
                <div class="tab-pane fade show active py-3" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                    <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr class="text-center">
                            <th>No</th>
                            <th>Kesatuan</th>
                            <th>No Laporan Polisi</th>
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
                                <td>
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
                <!-- Kasus Belum Diketahui -->
                <div class="tab-pane fade py-3" id="belumdiketahui" role="tabpanel" aria-labelledby="belumdiketahui-tab">
                    <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr class="text-center">
                            <th>No</th>
                            <th>Kesatuan</th>
                            <th>No Laporan Polisi</th>
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
                                <td>
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
            </div>
        <?php }else{ ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                    <th style="width:40%;">Kategori</th>
                    <th>CC</th>
                    <th>CT</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($dataKasus)){ ?>
                    <tr>
                        <td class="text-center"><strong>Kasus</strong></td>
                        <td class="text-center"><?= $dataKasus['CC']['Kasus'] ?></td>
                        <td class="text-center"><?= $dataKasus['CT']['Kasus'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-center"><strong>Tersangka</strong></td>
                        <td class="text-center"><?= $dataKasus['CC']['Tersangka'] ?></td>
                        <td class="text-center"><?= $dataKasus['CT']['Tersangka'] ?></td>
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
                    <button class="nav-link active" id="selesai-tab" data-toggle="tab" data-target="#selesai" type="button" role="tab" aria-controls="selesai" aria-selected="true">Status Kasus/Perkara Selesai - <strong>CC</strong></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="belumdiketahui-tab" data-toggle="tab" data-target="#belumdiketahui" type="button" role="tab" aria-controls="belumdiketahui" aria-selected="false">Status Kasus/Perkara Belum Diketahui - <strong>CT</strong></button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- Kasus Selesai -->
                <div class="tab-pane fade show active py-3" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                    <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr class="text-center">
                            <th>No</th>
                            <th>No Laporan Polisi</th>
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
                                <td><?= $rowCC["no_laporanpolisi"]; ?></td>
                                <td>
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
                <!-- Kasus Belum Diketahui -->
                <div class="tab-pane fade py-3" id="belumdiketahui" role="tabpanel" aria-labelledby="belumdiketahui-tab">
                    <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr class="text-center">
                            <th>No</th>
                            <th>No Laporan Polisi</th>
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
                                <td><?= $rowCT["no_laporanpolisi"]; ?></td>
                                <td>
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