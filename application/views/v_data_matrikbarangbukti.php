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
    .hoverItem:hover{
      background-color:darkgrey!important;
      cursor:pointer;
    }
  </style>
  
  <!-- DATA -->
  <?php 
      $CI =& get_instance();
      $CI->load->model('Modeldata');
      $CI->load->model('Modelkesatuan');
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" onload="alertMatrik()">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4 py-4">
        <div class="alert alert-warning" role="alert">
          Perhatian! Hanya LP yang <strong>terkunci ke database</strong> ter-rekap dalam modul <strong>matrik barang bukti</strong>.
          Silahkan melengkapi instrumen yang kosong dengan pilihan yang disiapkan!
        </div>
        <h2>Matrik Ungkap Kasus <strong><?= $this->session->userdata('login_data_admin')['nama'] ?></strong></h2>
        <p>Periode : <?= $dateNow ?></p>
        <?php if (!empty($kesatuanChoosen)) { 
          $choosenKesatuan = $CI->Modelkesatuan->getKesatuanByKode($kesatuanChoosen);
          ?>
          <p>Kesatuan :&nbsp;<?= $choosenKesatuan[0]['nama'] ?></p>
        <?php } ?>
        <hr>
        <div class="row">
          <div class="col-md-10">
            <a class="btn btn-primary btn-sm mt-1 mx-1" data-toggle="modal" data-target="#sortModal"><span><i class="fas fa-filter"></i> </span>Sort</a>
            <?php if($btnExitSort): ?>
              <a class="btn btn-danger btn-sm mt-1 mx-1" href="<?= base_url('matrik-barang-bukti')?>">Exit From Sort View</a>
            <?php endif; ?>
          </div>
          <div class="col-md-2 text-right">
              <!-- <a class="btn btn-success btn-sm mt-1" href="<?= base_url('export-opsi/matrikBB') ?>"><span><i class="fas fa-print"></i> </span>Export</a> -->
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
                      <form action="<?= base_url() ?>data/viewMatrikBarangBuktiByDate" method="post">
                          <div class="section-date row">
                            <div class="col-md-12">
                              <div id="formDateSettings">
                                <div class="formDate row">
                                  <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>
                                    <?php $kesatuan = $CI->Modeldata->getKesatuan($this->session->userdata('login_data_admin')['kodekesatuan']); ?>
                                      <div class="form-group col-md-4">
                                        <label for="kode_kesatuan">Pilih kesatuan / jajaran :</label>
                                        <select name="kode_kesatuan" class="form-control" data-live-search="true" required>
                                          <option value="all">All</option>
                                          <?php foreach ($kesatuan as $keyKesatuan) { ?>
                                            <option value="<?= $keyKesatuan['kode_kesatuan'] ?>"><?= $keyKesatuan['nama'] ?></option>
                                          <?php } ?>
                                        </select>
                                      </div>
                                    <?php } ?>
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
        <table class="table table-responsive table-bordered table-striped mt-2" style="width:100%;font-size:0.8rem;">
            <thead class="text-center">
                <tr>
                  <th rowspan="3">NO</th>
                  <th rowspan="3">JENIS KASUS STATUS TSK</th>
                  <th rowspan="3">JML KSS</th>
                  <th rowspan="3">JML TSK</th>
                  <th rowspan="3">KSS YG SELESAI</th>
                  <td colspan="4">KEWARGANEGARAAN</td>
                  <td colspan="5">USIA</td>
                  <td colspan="6">PENDIDIKAN</td>
                  <td colspan="17">PEKERJAAN</td>
                  <th rowspan="3">JUMLAH BB SITAAN</th>
                </tr>
                <tr>
                    <td colspan="2">WNI</td>
                    <td colspan="2">WNA</td>
                    <!-- USIA -->
                    <th rowspan="2"><14</th>
                    <th rowspan="2">15-18</th>
                    <th rowspan="2">19-24</th>
                    <th rowspan="2">25-64</th>
                    <th rowspan="2">>65</th>
                    <!-- PENDIDIKAN -->
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
                </tr>
                <tr>
                    <th>LK</th>
                    <th>PR</th>
                    <th>LK</th>
                    <th>PR</th>
                </tr>
            </thead>
            <tbody>
              <!-- LOOPING DISPLAY ONLY FIRST TIME -->
                <?php 
                include('matrikCountingBB/arrayVariable.php');
                $CI =& get_instance();
                $CI->load->model('Modeldata');
                $kategoriBB = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","Daftar G","Kosmetik","Jamu");
                $kategoriBBGol = array("GOL III", "GOL IV");
                $instrumenStatusTSK = array("Penanam", "Produksi", "Bandar", "Pengedar", "Pengguna");
                $instrumenPekerjaan = array("Penanam", "Produksi", "Bandar", "Pengedar", "Pengguna");
                $no = 1;

                foreach($kategoriBB as $kategori) { ?>
                  <tr>
                      <!-- No -->
                      <td rowspan="6" class="text-center"><?= $no ?>.</td>
                      <td colspan="40"><strong><?= strtoupper($kategori) ?></strong></td>
                  </tr>
                  <?php foreach ($instrumenStatusTSK as $keyStatusTSK) { ?>
                    <tr class="text-center hoverItem">
                        <td><?= $keyStatusTSK ?></td>
                        <!-- KSS -->
                        <td class="<?= $keyStatusTSK ?>KSS<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php
                          $KSS = $dataMatrik[$kategori][$keyStatusTSK]['JML_KSS'];
                          if (!empty($KSS)) {
                            foreach ($KSS as $checkKSS) { 
                              $display = FALSE;
                              if(!in_array($checkKSS['no_laporanpolisi'], $arrayKSS)) {
                                  array_push($arrayKSS, $checkKSS['no_laporanpolisi']);
                                  $display = TRUE;
                              }
                            }
                            if ($display) {
                              echo count($KSS);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($KSS);;
                          }
                          ?>
                        </td>
                        <!-- JML TSK -->
                        <td class="<?= $keyStatusTSK ?>TSK<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php
                            $TSK = $dataMatrik[$kategori][$keyStatusTSK]['JML_TSK'];
                            if (!empty($TSK)) {
                              foreach ($TSK as $checkTSK) { 
                                $displayTSK = FALSE;
                                if(!in_array($checkTSK['nama'], $arrayTSK)) {
                                    array_push($arrayTSK, $checkTSK['nama']);
                                    $displayTSK = TRUE;
                                }
                              }
                              if ($displayTSK) {
                                echo count($TSK);
                              }else{
                                echo 0;
                              }
                            }else{
                              echo count($TSK);;
                            }
                          ?>
                        </td>
                        <!-- KSS SELESAI -->
                        <td class="<?= $keyStatusTSK ?>SelesaiKSS<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php
                          $SelesaiKSS = $dataMatrik[$kategori][$keyStatusTSK]['JML_SelesaiKSS'];
                          if (!empty($SelesaiKSS)) {
                            foreach ($SelesaiKSS as $checkSelesaiTSK) { 
                              $displaySelesaiKSS = FALSE;
                              if(!in_array($checkSelesaiTSK['no_laporanpolisi'], $arraySelesaiKSS)) {
                                  array_push($arraySelesaiKSS, $checkSelesaiTSK['no_laporanpolisi']);
                                  $displaySelesaiKSS = TRUE;
                              }
                            }
                            if ($displaySelesaiKSS) {
                              echo count($SelesaiKSS);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($SelesaiKSS);;
                          }
                          ?>
                        </td>
                        <!-- KEWARGANEGARAAN -->
                        <!-- WNI LK PR -->
                        <td class="<?= $keyStatusTSK ?>WNILK<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $WNILK = $dataMatrik[$kategori][$keyStatusTSK]['WNILK']; 
                          if (!empty($WNILK)) {
                            foreach ($WNILK as $checkWNILK) { 
                              $displayWNILK = FALSE;
                              if(!in_array($checkWNILK['id_tersangka'], $arrayWNILK)) {
                                  array_push($arrayWNILK, $checkWNILK['id_tersangka']);
                                  $displayWNILK = TRUE;
                              }
                            }
                            if ($displayWNILK) {
                              echo count($WNILK);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($WNILK);;
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>WNIPR<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $WNIPR = $dataMatrik[$kategori][$keyStatusTSK]['WNIPR']; 
                          if (!empty($WNIPR)) {
                            foreach ($WNIPR as $checkWNIPR) { 
                              $displayWNIPR = FALSE;
                              if(!in_array($checkWNIPR['id_tersangka'], $arrayWNIPR)) {
                                  array_push($arrayWNIPR, $checkWNIPR['id_tersangka']);
                                  $displayWNIPR = TRUE;
                              }
                            }
                            if ($displayWNIPR) {
                              echo count($WNIPR);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($WNIPR);;
                          }
                          ?>
                        </td>
                        <!-- WNA LK PR -->
                        <td class="<?= $keyStatusTSK ?>WNALK<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $WNALK = $dataMatrik[$kategori][$keyStatusTSK]['WNALK']; 
                          if (!empty($WNALK)) {
                            foreach ($WNALK as $checkWNALK) { 
                              $displayWNALK = FALSE;
                              if(!in_array($checkWNALK['id_tersangka'], $arrayWNALK)) {
                                  array_push($arrayWNALK, $checkWNALK['id_tersangka']);
                                  $displayWNALK = TRUE;
                              }
                            }
                            if ($displayWNALK) {
                              echo count($WNALK);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($WNALK);;
                          }?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>WNAPR<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $WNAPR = $dataMatrik[$kategori][$keyStatusTSK]['WNAPR']; 
                          if (!empty($WNAPR)) {
                            foreach ($WNAPR as $checkWNAPR) { 
                              $displayWNAPR = FALSE;
                              if(!in_array($checkWNAPR['id_tersangka'], $arrayWNAPR)) {
                                  array_push($arrayWNAPR, $checkWNAPR['id_tersangka']);
                                  $displayWNAPR = TRUE;
                              }
                            }
                            if ($displayWNAPR) {
                              echo count($WNAPR);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($WNAPR);;
                          }
                          ?>
                        </td>
                        <!-- USIA -->
                        <td class="<?= $keyStatusTSK ?>14<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $USIA14 = $dataMatrik[$kategori][$keyStatusTSK]['USIA14']; 
                          if (!empty($USIA14)) {
                            foreach ($USIA14 as $checkUSIA14) { 
                              $displayUSIA14 = FALSE;
                              if(!in_array($checkUSIA14['id_tersangka'], $arrayUSIA14)) {
                                  array_push($arrayUSIA14, $checkUSIA14['id_tersangka']);
                                  $displayUSIA14 = TRUE;
                              }
                            }
                            if ($displayUSIA14) {
                              echo count($USIA14);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($USIA14);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>1518<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $USIA1518 = $dataMatrik[$kategori][$keyStatusTSK]['USIA1518']; 
                          if (!empty($USIA1518)) {
                            foreach ($USIA1518 as $checkUSIA1518) { 
                              $displayUSIA1518 = FALSE;
                              if(!in_array($checkUSIA1518['id_tersangka'], $arrayUSIA1518)) {
                                  array_push($arrayUSIA1518, $checkUSIA1518['id_tersangka']);
                                  $displayUSIA1518 = TRUE;
                              }
                            }
                            if ($displayUSIA1518) {
                              echo count($USIA1518);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($USIA1518);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>1924<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $USIA1924 = $dataMatrik[$kategori][$keyStatusTSK]['USIA1924']; 
                          if (!empty($USIA1924)) {
                            foreach ($USIA1924 as $checkUSIA1924) { 
                              $displayUSIA1924 = FALSE;
                              if(!in_array($checkUSIA1924['id_tersangka'], $arrayUSIA1924)) {
                                  array_push($arrayUSIA1924, $checkUSIA1924['id_tersangka']);
                                  $displayUSIA1924 = TRUE;
                              }
                            }
                            if ($displayUSIA1924) {
                              echo count($USIA1924);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($USIA1924);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>2564<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $USIA2564 = $dataMatrik[$kategori][$keyStatusTSK]['USIA2564']; 
                          if (!empty($USIA2564)) {
                            foreach ($USIA2564 as $checkUSIA2564) { 
                              $displayUSIA2564 = FALSE;
                              if(!in_array($checkUSIA2564['id_tersangka'], $arrayUSIA2564)) {
                                  array_push($arrayUSIA2564, $checkUSIA2564['id_tersangka']);
                                  $displayUSIA2564 = TRUE;
                              }
                            }
                            if ($displayUSIA2564) {
                              echo count($USIA2564);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($USIA2564);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>65<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $USIA65 = $dataMatrik[$kategori][$keyStatusTSK]['USIA65']; 
                          if (!empty($USIA65)) {
                            foreach ($USIA65 as $checkUSIA65) { 
                              $displayUSIA65 = FALSE;
                              if(!in_array($checkUSIA65['id_tersangka'], $arrayUSIA65)) {
                                  array_push($arrayUSIA65, $checkUSIA65['id_tersangka']);
                                  $displayUSIA65 = TRUE;
                              }
                            }
                            if ($displayUSIA65) {
                              echo count($USIA65);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($USIA65);
                          }
                          ?>
                        </td>
                        <!-- PENDIDIKAN -->
                        <td class="<?= $keyStatusTSK ?>TidakSekolah<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PND_TIDAKSEKOLAH = $dataMatrik[$kategori][$keyStatusTSK]['PND_TIDAKSEKOLAH']; 
                          if (!empty($PND_TIDAKSEKOLAH)) {
                            foreach ($PND_TIDAKSEKOLAH as $checkPND_TIDAKSEKOLAH) { 
                              $displayPND_TIDAKSEKOLAH = FALSE;
                              if(!in_array($checkPND_TIDAKSEKOLAH['id_tersangka'], $arrayPND_TIDAKSEKOLAH)) {
                                  array_push($arrayPND_TIDAKSEKOLAH, $checkPND_TIDAKSEKOLAH['id_tersangka']);
                                  $displayPND_TIDAKSEKOLAH = TRUE;
                              }
                            }
                            if ($displayPND_TIDAKSEKOLAH) {
                              echo count($PND_TIDAKSEKOLAH);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PND_TIDAKSEKOLAH);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>SD<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PND_SD = $dataMatrik[$kategori][$keyStatusTSK]['PND_SD']; 
                          if (!empty($PND_SD)) {
                            foreach ($PND_SD as $checkPND_SD) { 
                              $displayPND_SD = FALSE;
                              if(!in_array($checkPND_SD['id_tersangka'], $arrayPND_SD)) {
                                  array_push($arrayPND_SD, $checkPND_SD['id_tersangka']);
                                  $displayPND_SD = TRUE;
                              }
                            }
                            if ($displayPND_SD) {
                              echo count($PND_SD);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PND_SD);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>SMP<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PND_SMP = $dataMatrik[$kategori][$keyStatusTSK]['PND_SMP']; 
                          if (!empty($PND_SMP)) {
                            foreach ($PND_SMP as $checkPND_SMP) { 
                              $displayPND_SMP = FALSE;
                              if(!in_array($checkPND_SMP['id_tersangka'], $arrayPND_SMP)) {
                                  array_push($arrayPND_SMP, $checkPND_SMP['id_tersangka']);
                                  $displayPND_SMP = TRUE;
                              }
                            }
                            if ($displayPND_SMP) {
                              echo count($PND_SMP);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PND_SMP);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>SMA<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PND_SMA = $dataMatrik[$kategori][$keyStatusTSK]['PND_SMA']; 
                          if (!empty($PND_SMA)) {
                            foreach ($PND_SMA as $checkPND_SMA) { 
                              $displayPND_SMA = FALSE;
                              if(!in_array($checkPND_SMA['id_tersangka'], $arrayPND_SMA)) {
                                  array_push($arrayPND_SMA, $checkPND_SMA['id_tersangka']);
                                  $displayPND_SMA = TRUE;
                              }
                            }
                            if ($displayPND_SMA) {
                              echo count($PND_SMA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PND_SMA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>PT<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PND_PT = $dataMatrik[$kategori][$keyStatusTSK]['PND_PT']; 
                          if (!empty($PND_PT)) {
                            foreach ($PND_PT as $checkPND_PT) { 
                              $displayPND_PT = FALSE;
                              if(!in_array($checkPND_PT['id_tersangka'], $arrayPND_PT)) {
                                  array_push($arrayPND_PT, $checkPND_PT['id_tersangka']);
                                  $displayPND_PT = TRUE;
                              }
                            }
                            if ($displayPND_PT) {
                              echo count($PND_PT);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PND_PT);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>BelumDiketahui<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PND_BELUMDIKETAHUI = $dataMatrik[$kategori][$keyStatusTSK]['PND_BELUMDIKETAHUI']; 
                          if (!empty($PND_BELUMDIKETAHUI)) {
                            foreach ($PND_BELUMDIKETAHUI as $checkPND_BELUMDIKETAHUI) { 
                              $displayPND_BELUMDIKETAHUI = FALSE;
                              if(!in_array($checkPND_BELUMDIKETAHUI['id_tersangka'], $arrayPND_BELUMDIKETAHUI)) {
                                  array_push($arrayPND_BELUMDIKETAHUI, $checkPND_BELUMDIKETAHUI['id_tersangka']);
                                  $displayPND_BELUMDIKETAHUI = TRUE;
                              }
                            }
                            if ($displayPND_BELUMDIKETAHUI) {
                              echo count($PND_BELUMDIKETAHUI);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PND_BELUMDIKETAHUI);
                          }
                          ?>
                        </td>
                        <!-- Pekerjaan -->
                        <td class="<?= $keyStatusTSK ?>Pelajar<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_PELAJAR = $dataMatrik[$kategori][$keyStatusTSK]['PKR_PELAJAR']; 
                          if (!empty($PKR_PELAJAR)) {
                            foreach ($PKR_PELAJAR as $checkPKR_PELAJAR) { 
                              $displayPKR_PELAJAR = FALSE;
                              if(!in_array($checkPKR_PELAJAR['id_tersangka'], $arrayPKR_PELAJAR)) {
                                  array_push($arrayPKR_PELAJAR, $checkPKR_PELAJAR['id_tersangka']);
                                  $displayPKR_PELAJAR = TRUE;
                              }
                            }
                            if ($displayPKR_PELAJAR) {
                              echo count($PKR_PELAJAR);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_PELAJAR);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>Mahasiswa<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_MAHASISWA = $dataMatrik[$kategori][$keyStatusTSK]['PKR_MAHASISWA']; 
                          if (!empty($PKR_MAHASISWA)) {
                            foreach ($PKR_MAHASISWA as $checkPKR_MAHASISWA) { 
                              $displayPKR_MAHASISWA = FALSE;
                              if(!in_array($checkPKR_MAHASISWA['id_tersangka'], $arrayPKR_MAHASISWA)) {
                                  array_push($arrayPKR_MAHASISWA, $checkPKR_MAHASISWA['id_tersangka']);
                                  $displayPKR_MAHASISWA = TRUE;
                              }
                            }
                            if ($displayPKR_MAHASISWA) {
                              echo count($PKR_MAHASISWA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_MAHASISWA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>Swasta<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_SWASTA = $dataMatrik[$kategori][$keyStatusTSK]['PKR_SWASTA']; 
                          if (!empty($PKR_SWASTA)) {
                            foreach ($PKR_SWASTA as $checkPKR_SWASTA) { 
                              $displayPKR_SWASTA = FALSE;
                              if(!in_array($checkPKR_SWASTA['id_tersangka'], $arrayPKR_SWASTA)) {
                                  array_push($arrayPKR_SWASTA, $checkPKR_SWASTA['id_tersangka']);
                                  $displayPKR_SWASTA = TRUE;
                              }
                            }
                            if ($displayPKR_SWASTA) {
                              echo count($PKR_SWASTA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_SWASTA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>BuruhKaryawan<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_BURUHKARYAWAN = $dataMatrik[$kategori][$keyStatusTSK]['PKR_BURUHKARYAWAN']; 
                          if (!empty($PKR_BURUHKARYAWAN)) {
                            foreach ($PKR_BURUHKARYAWAN as $checkPKR_BURUHKARYAWAN) { 
                              $displayPKR_BURUHKARYAWAN = FALSE;
                              if(!in_array($checkPKR_BURUHKARYAWAN['id_tersangka'], $arrayPKR_BURUHKARYAWAN)) {
                                  array_push($arrayPKR_BURUHKARYAWAN, $checkPKR_BURUHKARYAWAN['id_tersangka']);
                                  $displayPKR_BURUHKARYAWAN = TRUE;
                              }
                            }
                            if ($displayPKR_BURUHKARYAWAN) {
                              echo count($PKR_BURUHKARYAWAN);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_BURUHKARYAWAN);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>PetaniNelayan<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_PETANINELAYAN = $dataMatrik[$kategori][$keyStatusTSK]['PKR_PETANINELAYAN']; 
                          if (!empty($PKR_PETANINELAYAN)) {
                            foreach ($PKR_PETANINELAYAN as $checkPKR_PETANINELAYAN) { 
                              $displayPKR_PETANINELAYAN = FALSE;
                              if(!in_array($checkPKR_PETANINELAYAN['id_tersangka'], $arrayPKR_PETANINELAYAN)) {
                                  array_push($arrayPKR_PETANINELAYAN, $checkPKR_PETANINELAYAN['id_tersangka']);
                                  $displayPKR_PETANINELAYAN = TRUE;
                              }
                            }
                            if ($displayPKR_PETANINELAYAN) {
                              echo count($PKR_PETANINELAYAN);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_PETANINELAYAN);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>Pedagang<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_PEDAGANG = $dataMatrik[$kategori][$keyStatusTSK]['PKR_PEDAGANG']; 
                          if (!empty($PKR_PEDAGANG)) {
                            foreach ($PKR_PEDAGANG as $checkPKR_PEDAGANG) { 
                              $displayPKR_PEDAGANG = FALSE;
                              if(!in_array($checkPKR_PEDAGANG['id_tersangka'], $arrayPKR_PEDAGANG)) {
                                  array_push($arrayPKR_PEDAGANG, $checkPKR_PEDAGANG['id_tersangka']);
                                  $displayPKR_PEDAGANG = TRUE;
                              }
                            }
                            if ($displayPKR_PEDAGANG) {
                              echo count($PKR_PEDAGANG);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_PEDAGANG);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>WiraswastaPengusaha<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_WIRASWASTAPENGUSAHA = $dataMatrik[$kategori][$keyStatusTSK]['PKR_WIRASWASTAPENGUSAHA']; 
                          if (!empty($PKR_WIRASWASTAPENGUSAHA)) {
                            foreach ($PKR_WIRASWASTAPENGUSAHA as $checkPKR_WIRASWASTAPENGUSAHA) { 
                              $displayPKR_WIRASWASTAPENGUSAHA = FALSE;
                              if(!in_array($checkPKR_WIRASWASTAPENGUSAHA['id_tersangka'], $arrayPKR_WIRASWASTAPENGUSAHA)) {
                                  array_push($arrayPKR_WIRASWASTAPENGUSAHA, $checkPKR_WIRASWASTAPENGUSAHA['id_tersangka']);
                                  $displayPKR_WIRASWASTAPENGUSAHA = TRUE;
                              }
                            }
                            if ($displayPKR_WIRASWASTAPENGUSAHA) {
                              echo count($PKR_WIRASWASTAPENGUSAHA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_WIRASWASTAPENGUSAHA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>SopirTukangOjek<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_SOPIRTUKANGOJEK = $dataMatrik[$kategori][$keyStatusTSK]['PKR_SOPIRTUKANGOJEK']; 
                          if (!empty($PKR_SOPIRTUKANGOJEK)) {
                            foreach ($PKR_SOPIRTUKANGOJEK as $checkPKR_SOPIRTUKANGOJEK) { 
                              $displayPKR_SOPIRTUKANGOJEK = FALSE;
                              if(!in_array($checkPKR_SOPIRTUKANGOJEK['id_tersangka'], $arrayPKR_SOPIRTUKANGOJEK)) {
                                  array_push($arrayPKR_SOPIRTUKANGOJEK, $checkPKR_SOPIRTUKANGOJEK['id_tersangka']);
                                  $displayPKR_SOPIRTUKANGOJEK = TRUE;
                              }
                            }
                            if ($displayPKR_SOPIRTUKANGOJEK) {
                              echo count($PKR_SOPIRTUKANGOJEK);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_SOPIRTUKANGOJEK);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>IkutOrangTua<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_IKUTORANGTUA = $dataMatrik[$kategori][$keyStatusTSK]['PKR_IKUTORANGTUA']; 
                          if (!empty($PKR_IKUTORANGTUA)) {
                            foreach ($PKR_IKUTORANGTUA as $checkPKR_IKUTORANGTUA) { 
                              $displayPKR_IKUTORANGTUA = FALSE;
                              if(!in_array($checkPKR_IKUTORANGTUA['id_tersangka'], $arrayPKR_IKUTORANGTUA)) {
                                  array_push($arrayPKR_IKUTORANGTUA, $checkPKR_IKUTORANGTUA['id_tersangka']);
                                  $displayPKR_IKUTORANGTUA = TRUE;
                              }
                            }
                            if ($displayPKR_IKUTORANGTUA) {
                              echo count($PKR_IKUTORANGTUA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_IKUTORANGTUA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>IbuRumahTangga<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_IBURUMAHTANGGA = $dataMatrik[$kategori][$keyStatusTSK]['PKR_IBURUMAHTANGGA']; 
                          if (!empty($PKR_IBURUMAHTANGGA)) {
                            foreach ($PKR_IBURUMAHTANGGA as $checkPKR_IBURUMAHTANGGA) { 
                              $displayPKR_IBURUMAHTANGGA = FALSE;
                              if(!in_array($checkPKR_IBURUMAHTANGGA['id_tersangka'], $arrayPKR_IBURUMAHTANGGA)) {
                                  array_push($arrayPKR_IBURUMAHTANGGA, $checkPKR_IBURUMAHTANGGA['id_tersangka']);
                                  $displayPKR_IBURUMAHTANGGA = TRUE;
                              }
                            }
                            if ($displayPKR_IBURUMAHTANGGA) {
                              echo count($PKR_IBURUMAHTANGGA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_IBURUMAHTANGGA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>TidakKerja<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_TIDAKKERJA = $dataMatrik[$kategori][$keyStatusTSK]['PKR_TIDAKKERJA']; 
                          if (!empty($PKR_TIDAKKERJA)) {
                            foreach ($PKR_TIDAKKERJA as $checkPKR_TIDAKKERJA) { 
                              $displayPKR_TIDAKKERJA = FALSE;
                              if(!in_array($checkPKR_TIDAKKERJA['id_tersangka'], $arrayPKR_TIDAKKERJA)) {
                                  array_push($arrayPKR_TIDAKKERJA, $checkPKR_TIDAKKERJA['id_tersangka']);
                                  $displayPKR_TIDAKKERJA = TRUE;
                              }
                            }
                            if ($displayPKR_TIDAKKERJA) {
                              echo count($PKR_TIDAKKERJA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_TIDAKKERJA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>Notaris<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_NOTARIS = $dataMatrik[$kategori][$keyStatusTSK]['PKR_NOTARIS']; 
                          if (!empty($PKR_NOTARIS)) {
                            foreach ($PKR_NOTARIS as $checkPKR_NOTARIS) { 
                              $displayPKR_NOTARIS = FALSE;
                              if(!in_array($checkPKR_NOTARIS['id_tersangka'], $arrayPKR_NOTARIS)) {
                                  array_push($arrayPKR_NOTARIS, $checkPKR_NOTARIS['id_tersangka']);
                                  $displayPKR_NOTARIS = TRUE;
                              }
                            }
                            if ($displayPKR_NOTARIS) {
                              echo count($PKR_NOTARIS);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_NOTARIS);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>TNI<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_TNI = $dataMatrik[$kategori][$keyStatusTSK]['PKR_TNI']; 
                          if (!empty($PKR_TNI)) {
                            foreach ($PKR_TNI as $checkPKR_TNI) { 
                              $displayPKR_TNI = FALSE;
                              if(!in_array($checkPKR_TNI['id_tersangka'], $arrayPKR_TNI)) {
                                  array_push($arrayPKR_TNI, $checkPKR_TNI['id_tersangka']);
                                  $displayPKR_TNI = TRUE;
                              }
                            }
                            if ($displayPKR_TNI) {
                              echo count($PKR_TNI);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_TNI);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>POLRI<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_POLRI = $dataMatrik[$kategori][$keyStatusTSK]['PKR_POLRI']; 
                          if (!empty($PKR_POLRI)) {
                            foreach ($PKR_POLRI as $checkPKR_POLRI) { 
                              $displayPKR_POLRI = FALSE;
                              if(!in_array($checkPKR_POLRI['id_tersangka'], $arrayPKR_POLRI)) {
                                  array_push($arrayPKR_POLRI, $checkPKR_POLRI['id_tersangka']);
                                  $displayPKR_POLRI = TRUE;
                              }
                            }
                            if ($displayPKR_POLRI) {
                              echo count($PKR_POLRI);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_POLRI);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>PNS<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_PNS = $dataMatrik[$kategori][$keyStatusTSK]['PKR_PNS']; 
                          if (!empty($PKR_PNS)) {
                            foreach ($PKR_PNS as $checkPKR_PNS) { 
                              $displayPKR_PNS = FALSE;
                              if(!in_array($checkPKR_PNS['id_tersangka'], $arrayPKR_PNS)) {
                                  array_push($arrayPKR_PNS, $checkPKR_PNS['id_tersangka']);
                                  $displayPKR_PNS = TRUE;
                              }
                            }
                            if ($displayPKR_PNS) {
                              echo count($PKR_PNS);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_PNS);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>PEMBANTU<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_PEMBANTU = $dataMatrik[$kategori][$keyStatusTSK]['PKR_PEMBANTU']; 
                          if (!empty($PKR_PEMBANTU)) {
                            foreach ($PKR_PEMBANTU as $checkPKR_PEMBANTU) { 
                              $displayPKR_PEMBANTU = FALSE;
                              if(!in_array($checkPKR_PEMBANTU['id_tersangka'], $arrayPKR_PEMBANTU)) {
                                  array_push($arrayPKR_PEMBANTU, $checkPKR_PEMBANTU['id_tersangka']);
                                  $displayPKR_PEMBANTU = TRUE;
                              }
                            }
                            if ($displayPKR_PEMBANTU) {
                              echo count($PKR_PEMBANTU);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_PEMBANTU);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>NAPI<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $PKR_NAPI = $dataMatrik[$kategori][$keyStatusTSK]['PKR_NAPI']; 
                          if (!empty($PKR_NAPI)) {
                            foreach ($PKR_NAPI as $checkPKR_NAPI) { 
                              $displayPKR_NAPI = FALSE;
                              if(!in_array($checkPKR_NAPI['id_tersangka'], $arrayPKR_NAPI)) {
                                  array_push($arrayPKR_NAPI, $checkPKR_NAPI['id_tersangka']);
                                  $displayPKR_NAPI = TRUE;
                              }
                            }
                            if ($displayPKR_NAPI) {
                              echo count($PKR_NAPI);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_NAPI);
                          }
                          ?>
                        </td>
                        <!-- JUMLAH BB SITAAN -->
                        <td class="<?= $keyStatusTSK ?>BERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>">
                          <?php $JML_BERAT_BB = $dataMatrik[$kategori][$keyStatusTSK]['JML_BERAT_BB'] ;
                            $beratTotal = 0;
                            if (!empty($JML_BERAT_BB)) {
                              foreach ($JML_BERAT_BB as $keyBeratBB) {
                                $berat = (float)$keyBeratBB['jumlah'];
                                $beratTotal += $berat;
                              }
                              $countResult = "{$beratTotal} {$JML_BERAT_BB[0]['satuan']}";
                              echo $countResult;
                            }else{
                              echo $beratTotal;
                            }
                          ?>
                        </td>
                    </tr>
                  <?php } ?>
                  <!-- JUMLAH -->
                  <tr class="text-center" style="font-weight:700;">
                      <td colspan="2">JUMLAH</td>
                      <!-- KSS -->
                      <td class="JML_KSS<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <!-- JML TSK -->
                      <td class="JML_TSK<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <!-- KSS SELESAI -->
                      <td class="JML_SelesaiKSS<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <!-- KEWARGANEGARAAN -->
                      <!-- WNI LK PR -->
                      <td class="JML_WNILK<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_WNIPR<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <!-- WNA LK PR -->
                      <td class="JML_WNALK<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_WNAPR<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <!-- USIA -->
                      <td class="JML_14<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_1518<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_1924<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_2564<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_65<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <!-- PENDIDIKAN -->
                      <td class="JML_TidakSekolah<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_SD<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_SMP<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_SMA<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_PT<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_BelumDiketahui<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <!-- Pekerjaan -->
                      <td class="JML_Pelajar<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_Mahasiswa<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_Swasta<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_BuruhKaryawan<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_PetaniNelayan<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_Pedagang<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_WiraswastaPengusaha<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_SopirTukangOjek<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_IkutOrangTua<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_IbuRumahTangga<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_TidakKerja<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_Notaris<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_TNI<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_POLRI<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_PNS<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_PEMBANTU<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <td class="JML_NAPI<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                      <!-- JUMLAH BB SITAAN -->
                      <td class="JML_BERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>"></td>
                  </tr>
                  <?php include('matrikCountingBB/jumlahPerKategori.php') ?>
                <?php $no++; } ?>
                  
                <!-- Khusus GOL IV & GOL III -->
                <?php
                $noGol = 13;
                 foreach($kategoriBBGol as $kategoriGol) { ?>
                  <tr>
                      <!-- No -->
                      <td rowspan="6" class="text-center"><?= $noGol ?>.</td>
                      <td colspan="40"><strong><?= $kategoriGol ?></strong></td>
                  </tr>
                  <?php foreach ($instrumenStatusTSK as $keyStatusTSK) { ?>
                    <tr class="text-center hoverItem">
                        <td><?= $keyStatusTSK ?></td>
                        <!-- KSS -->
                        <td class="<?= $keyStatusTSK ?>KSS<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php
                          $KSS = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['JML_KSS'];
                          if (!empty($KSS)) {
                            foreach ($KSS as $checkKSS) { 
                              $display = FALSE;
                              if(!in_array($checkKSS['no_laporanpolisi'], $arrayKSS)) {
                                  array_push($arrayKSS, $checkKSS['no_laporanpolisi']);
                                  $display = TRUE;
                              }
                            }
                            if ($display) {
                              echo count($KSS);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($KSS);;
                          }
                          ?>
                        </td>
                        <!-- JML TSK -->
                        <td class="<?= $keyStatusTSK ?>TSK<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php
                            $TSK = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['JML_TSK'];
                            if (!empty($TSK)) {
                              foreach ($TSK as $checkTSK) { 
                                $displayTSK = FALSE;
                                if(!in_array($checkTSK['nama'], $arrayTSK)) {
                                    array_push($arrayTSK, $checkTSK['nama']);
                                    $displayTSK = TRUE;
                                }
                              }
                              if ($displayTSK) {
                                echo count($TSK);
                              }else{
                                echo 0;
                              }
                            }else{
                              echo count($TSK);;
                            }
                          ?>
                        </td>
                        <!-- KSS SELESAI -->
                        <td class="<?= $keyStatusTSK ?>SelesaiKSS<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php
                          $SelesaiKSS = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['JML_SelesaiKSS'];
                          if (!empty($SelesaiKSS)) {
                            foreach ($SelesaiKSS as $checkSelesaiTSK) { 
                              $displaySelesaiKSS = FALSE;
                              if(!in_array($checkSelesaiTSK['no_laporanpolisi'], $arraySelesaiKSS)) {
                                  array_push($arraySelesaiKSS, $checkSelesaiTSK['no_laporanpolisi']);
                                  $displaySelesaiKSS = TRUE;
                              }
                            }
                            if ($displaySelesaiKSS) {
                              echo count($SelesaiKSS);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($SelesaiKSS);;
                          }
                          ?>
                        </td>
                        <!-- KEWARGANEGARAAN -->
                        <!-- WNI LK PR -->
                        <td class="<?= $keyStatusTSK ?>WNILK<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $WNILK = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['WNILK']; 
                          if (!empty($WNILK)) {
                            foreach ($WNILK as $checkWNILK) { 
                              $displayWNILK = FALSE;
                              if(!in_array($checkWNILK['id_tersangka'], $arrayWNILK)) {
                                  array_push($arrayWNILK, $checkWNILK['id_tersangka']);
                                  $displayWNILK = TRUE;
                              }
                            }
                            if ($displayWNILK) {
                              echo count($WNILK);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($WNILK);;
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>WNIPR<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $WNIPR = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['WNIPR']; 
                          if (!empty($WNIPR)) {
                            foreach ($WNIPR as $checkWNIPR) { 
                              $displayWNIPR = FALSE;
                              if(!in_array($checkWNIPR['id_tersangka'], $arrayWNIPR)) {
                                  array_push($arrayWNIPR, $checkWNIPR['id_tersangka']);
                                  $displayWNIPR = TRUE;
                              }
                            }
                            if ($displayWNIPR) {
                              echo count($WNIPR);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($WNIPR);;
                          }
                          ?>
                        </td>
                        <!-- WNA LK PR -->
                        <td class="<?= $keyStatusTSK ?>WNALK<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $WNALK = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['WNALK']; 
                          if (!empty($WNALK)) {
                            foreach ($WNALK as $checkWNALK) { 
                              $displayWNALK = FALSE;
                              if(!in_array($checkWNALK['id_tersangka'], $arrayWNALK)) {
                                  array_push($arrayWNALK, $checkWNALK['id_tersangka']);
                                  $displayWNALK = TRUE;
                              }
                            }
                            if ($displayWNALK) {
                              echo count($WNALK);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($WNALK);;
                          }?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>WNAPR<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $WNAPR = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['WNAPR']; 
                          if (!empty($WNAPR)) {
                            foreach ($WNAPR as $checkWNAPR) { 
                              $displayWNAPR = FALSE;
                              if(!in_array($checkWNAPR['id_tersangka'], $arrayWNAPR)) {
                                  array_push($arrayWNAPR, $checkWNAPR['id_tersangka']);
                                  $displayWNAPR = TRUE;
                              }
                            }
                            if ($displayWNAPR) {
                              echo count($WNAPR);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($WNAPR);;
                          }
                          ?>
                        </td>
                        <!-- USIA -->
                        <td class="<?= $keyStatusTSK ?>14<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $USIA14 = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['USIA14']; 
                          if (!empty($USIA14)) {
                            foreach ($USIA14 as $checkUSIA14) { 
                              $displayUSIA14 = FALSE;
                              if(!in_array($checkUSIA14['id_tersangka'], $arrayUSIA14)) {
                                  array_push($arrayUSIA14, $checkUSIA14['id_tersangka']);
                                  $displayUSIA14 = TRUE;
                              }
                            }
                            if ($displayUSIA14) {
                              echo count($USIA14);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($USIA14);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>1518<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $USIA1518 = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['USIA1518']; 
                          if (!empty($USIA1518)) {
                            foreach ($USIA1518 as $checkUSIA1518) { 
                              $displayUSIA1518 = FALSE;
                              if(!in_array($checkUSIA1518['id_tersangka'], $arrayUSIA1518)) {
                                  array_push($arrayUSIA1518, $checkUSIA1518['id_tersangka']);
                                  $displayUSIA1518 = TRUE;
                              }
                            }
                            if ($displayUSIA1518) {
                              echo count($USIA1518);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($USIA1518);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>1924<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $USIA1924 = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['USIA1924']; 
                          if (!empty($USIA1924)) {
                            foreach ($USIA1924 as $checkUSIA1924) { 
                              $displayUSIA1924 = FALSE;
                              if(!in_array($checkUSIA1924['id_tersangka'], $arrayUSIA1924)) {
                                  array_push($arrayUSIA1924, $checkUSIA1924['id_tersangka']);
                                  $displayUSIA1924 = TRUE;
                              }
                            }
                            if ($displayUSIA1924) {
                              echo count($USIA1924);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($USIA1924);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>2564<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $USIA2564 = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['USIA2564']; 
                          if (!empty($USIA2564)) {
                            foreach ($USIA2564 as $checkUSIA2564) { 
                              $displayUSIA2564 = FALSE;
                              if(!in_array($checkUSIA2564['id_tersangka'], $arrayUSIA2564)) {
                                  array_push($arrayUSIA2564, $checkUSIA2564['id_tersangka']);
                                  $displayUSIA2564 = TRUE;
                              }
                            }
                            if ($displayUSIA2564) {
                              echo count($USIA2564);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($USIA2564);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>65<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $USIA65 = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['USIA65']; 
                          if (!empty($USIA65)) {
                            foreach ($USIA65 as $checkUSIA65) { 
                              $displayUSIA65 = FALSE;
                              if(!in_array($checkUSIA65['id_tersangka'], $arrayUSIA65)) {
                                  array_push($arrayUSIA65, $checkUSIA65['id_tersangka']);
                                  $displayUSIA65 = TRUE;
                              }
                            }
                            if ($displayUSIA65) {
                              echo count($USIA65);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($USIA65);
                          }
                          ?>
                        </td>
                        <!-- PENDIDIKAN -->
                        <td class="<?= $keyStatusTSK ?>TidakSekolah<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PND_TIDAKSEKOLAH = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PND_TIDAKSEKOLAH']; 
                          if (!empty($PND_TIDAKSEKOLAH)) {
                            foreach ($PND_TIDAKSEKOLAH as $checkPND_TIDAKSEKOLAH) { 
                              $displayPND_TIDAKSEKOLAH = FALSE;
                              if(!in_array($checkPND_TIDAKSEKOLAH['id_tersangka'], $arrayPND_TIDAKSEKOLAH)) {
                                  array_push($arrayPND_TIDAKSEKOLAH, $checkPND_TIDAKSEKOLAH['id_tersangka']);
                                  $displayPND_TIDAKSEKOLAH = TRUE;
                              }
                            }
                            if ($displayPND_TIDAKSEKOLAH) {
                              echo count($PND_TIDAKSEKOLAH);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PND_TIDAKSEKOLAH);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>SD<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PND_SD = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PND_SD']; 
                          if (!empty($PND_SD)) {
                            foreach ($PND_SD as $checkPND_SD) { 
                              $displayPND_SD = FALSE;
                              if(!in_array($checkPND_SD['id_tersangka'], $arrayPND_SD)) {
                                  array_push($arrayPND_SD, $checkPND_SD['id_tersangka']);
                                  $displayPND_SD = TRUE;
                              }
                            }
                            if ($displayPND_SD) {
                              echo count($PND_SD);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PND_SD);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>SMP<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PND_SMP = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PND_SMP']; 
                          if (!empty($PND_SMP)) {
                            foreach ($PND_SMP as $checkPND_SMP) { 
                              $displayPND_SMP = FALSE;
                              if(!in_array($checkPND_SMP['id_tersangka'], $arrayPND_SMP)) {
                                  array_push($arrayPND_SMP, $checkPND_SMP['id_tersangka']);
                                  $displayPND_SMP = TRUE;
                              }
                            }
                            if ($displayPND_SMP) {
                              echo count($PND_SMP);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PND_SMP);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>SMA<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PND_SMA = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PND_SMA']; 
                          if (!empty($PND_SMA)) {
                            foreach ($PND_SMA as $checkPND_SMA) { 
                              $displayPND_SMA = FALSE;
                              if(!in_array($checkPND_SMA['id_tersangka'], $arrayPND_SMA)) {
                                  array_push($arrayPND_SMA, $checkPND_SMA['id_tersangka']);
                                  $displayPND_SMA = TRUE;
                              }
                            }
                            if ($displayPND_SMA) {
                              echo count($PND_SMA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PND_SMA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>PT<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PND_PT = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PND_PT']; 
                          if (!empty($PND_PT)) {
                            foreach ($PND_PT as $checkPND_PT) { 
                              $displayPND_PT = FALSE;
                              if(!in_array($checkPND_PT['id_tersangka'], $arrayPND_PT)) {
                                  array_push($arrayPND_PT, $checkPND_PT['id_tersangka']);
                                  $displayPND_PT = TRUE;
                              }
                            }
                            if ($displayPND_PT) {
                              echo count($PND_PT);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PND_PT);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>BelumDiketahui<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PND_BELUMDIKETAHUI = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PND_BELUMDIKETAHUI']; 
                          if (!empty($PND_BELUMDIKETAHUI)) {
                            foreach ($PND_BELUMDIKETAHUI as $checkPND_BELUMDIKETAHUI) { 
                              $displayPND_BELUMDIKETAHUI = FALSE;
                              if(!in_array($checkPND_BELUMDIKETAHUI['id_tersangka'], $arrayPND_BELUMDIKETAHUI)) {
                                  array_push($arrayPND_BELUMDIKETAHUI, $checkPND_BELUMDIKETAHUI['id_tersangka']);
                                  $displayPND_BELUMDIKETAHUI = TRUE;
                              }
                            }
                            if ($displayPND_BELUMDIKETAHUI) {
                              echo count($PND_BELUMDIKETAHUI);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PND_BELUMDIKETAHUI);
                          }
                          ?>
                        </td>
                        <!-- Pekerjaan -->
                        <td class="<?= $keyStatusTSK ?>Pelajar<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_PELAJAR = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_PELAJAR']; 
                          if (!empty($PKR_PELAJAR)) {
                            foreach ($PKR_PELAJAR as $checkPKR_PELAJAR) { 
                              $displayPKR_PELAJAR = FALSE;
                              if(!in_array($checkPKR_PELAJAR['id_tersangka'], $arrayPKR_PELAJAR)) {
                                  array_push($arrayPKR_PELAJAR, $checkPKR_PELAJAR['id_tersangka']);
                                  $displayPKR_PELAJAR = TRUE;
                              }
                            }
                            if ($displayPKR_PELAJAR) {
                              echo count($PKR_PELAJAR);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_PELAJAR);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>Mahasiswa<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_MAHASISWA = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_MAHASISWA']; 
                          if (!empty($PKR_MAHASISWA)) {
                            foreach ($PKR_MAHASISWA as $checkPKR_MAHASISWA) { 
                              $displayPKR_MAHASISWA = FALSE;
                              if(!in_array($checkPKR_MAHASISWA['id_tersangka'], $arrayPKR_MAHASISWA)) {
                                  array_push($arrayPKR_MAHASISWA, $checkPKR_MAHASISWA['id_tersangka']);
                                  $displayPKR_MAHASISWA = TRUE;
                              }
                            }
                            if ($displayPKR_MAHASISWA) {
                              echo count($PKR_MAHASISWA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_MAHASISWA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>Swasta<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_SWASTA = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_SWASTA']; 
                          if (!empty($PKR_SWASTA)) {
                            foreach ($PKR_SWASTA as $checkPKR_SWASTA) { 
                              $displayPKR_SWASTA = FALSE;
                              if(!in_array($checkPKR_SWASTA['id_tersangka'], $arrayPKR_SWASTA)) {
                                  array_push($arrayPKR_SWASTA, $checkPKR_SWASTA['id_tersangka']);
                                  $displayPKR_SWASTA = TRUE;
                              }
                            }
                            if ($displayPKR_SWASTA) {
                              echo count($PKR_SWASTA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_SWASTA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>BuruhKaryawan<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_BURUHKARYAWAN = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_BURUHKARYAWAN']; 
                          if (!empty($PKR_BURUHKARYAWAN)) {
                            foreach ($PKR_BURUHKARYAWAN as $checkPKR_BURUHKARYAWAN) { 
                              $displayPKR_BURUHKARYAWAN = FALSE;
                              if(!in_array($checkPKR_BURUHKARYAWAN['id_tersangka'], $arrayPKR_BURUHKARYAWAN)) {
                                  array_push($arrayPKR_BURUHKARYAWAN, $checkPKR_BURUHKARYAWAN['id_tersangka']);
                                  $displayPKR_BURUHKARYAWAN = TRUE;
                              }
                            }
                            if ($displayPKR_BURUHKARYAWAN) {
                              echo count($PKR_BURUHKARYAWAN);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_BURUHKARYAWAN);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>PetaniNelayan<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_PETANINELAYAN = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_PETANINELAYAN']; 
                          if (!empty($PKR_PETANINELAYAN)) {
                            foreach ($PKR_PETANINELAYAN as $checkPKR_PETANINELAYAN) { 
                              $displayPKR_PETANINELAYAN = FALSE;
                              if(!in_array($checkPKR_PETANINELAYAN['id_tersangka'], $arrayPKR_PETANINELAYAN)) {
                                  array_push($arrayPKR_PETANINELAYAN, $checkPKR_PETANINELAYAN['id_tersangka']);
                                  $displayPKR_PETANINELAYAN = TRUE;
                              }
                            }
                            if ($displayPKR_PETANINELAYAN) {
                              echo count($PKR_PETANINELAYAN);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_PETANINELAYAN);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>Pedagang<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_PEDAGANG = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_PEDAGANG']; 
                          if (!empty($PKR_PEDAGANG)) {
                            foreach ($PKR_PEDAGANG as $checkPKR_PEDAGANG) { 
                              $displayPKR_PEDAGANG = FALSE;
                              if(!in_array($checkPKR_PEDAGANG['id_tersangka'], $arrayPKR_PEDAGANG)) {
                                  array_push($arrayPKR_PEDAGANG, $checkPKR_PEDAGANG['id_tersangka']);
                                  $displayPKR_PEDAGANG = TRUE;
                              }
                            }
                            if ($displayPKR_PEDAGANG) {
                              echo count($PKR_PEDAGANG);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_PEDAGANG);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>WiraswastaPengusaha<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_WIRASWASTAPENGUSAHA = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_WIRASWASTAPENGUSAHA']; 
                          if (!empty($PKR_WIRASWASTAPENGUSAHA)) {
                            foreach ($PKR_WIRASWASTAPENGUSAHA as $checkPKR_WIRASWASTAPENGUSAHA) { 
                              $displayPKR_WIRASWASTAPENGUSAHA = FALSE;
                              if(!in_array($checkPKR_WIRASWASTAPENGUSAHA['id_tersangka'], $arrayPKR_WIRASWASTAPENGUSAHA)) {
                                  array_push($arrayPKR_WIRASWASTAPENGUSAHA, $checkPKR_WIRASWASTAPENGUSAHA['id_tersangka']);
                                  $displayPKR_WIRASWASTAPENGUSAHA = TRUE;
                              }
                            }
                            if ($displayPKR_WIRASWASTAPENGUSAHA) {
                              echo count($PKR_WIRASWASTAPENGUSAHA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_WIRASWASTAPENGUSAHA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>SopirTukangOjek<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_SOPIRTUKANGOJEK = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_SOPIRTUKANGOJEK']; 
                          if (!empty($PKR_SOPIRTUKANGOJEK)) {
                            foreach ($PKR_SOPIRTUKANGOJEK as $checkPKR_SOPIRTUKANGOJEK) { 
                              $displayPKR_SOPIRTUKANGOJEK = FALSE;
                              if(!in_array($checkPKR_SOPIRTUKANGOJEK['id_tersangka'], $arrayPKR_SOPIRTUKANGOJEK)) {
                                  array_push($arrayPKR_SOPIRTUKANGOJEK, $checkPKR_SOPIRTUKANGOJEK['id_tersangka']);
                                  $displayPKR_SOPIRTUKANGOJEK = TRUE;
                              }
                            }
                            if ($displayPKR_SOPIRTUKANGOJEK) {
                              echo count($PKR_SOPIRTUKANGOJEK);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_SOPIRTUKANGOJEK);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>IkutOrangTua<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_IKUTORANGTUA = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_IKUTORANGTUA']; 
                          if (!empty($PKR_IKUTORANGTUA)) {
                            foreach ($PKR_IKUTORANGTUA as $checkPKR_IKUTORANGTUA) { 
                              $displayPKR_IKUTORANGTUA = FALSE;
                              if(!in_array($checkPKR_IKUTORANGTUA['id_tersangka'], $arrayPKR_IKUTORANGTUA)) {
                                  array_push($arrayPKR_IKUTORANGTUA, $checkPKR_IKUTORANGTUA['id_tersangka']);
                                  $displayPKR_IKUTORANGTUA = TRUE;
                              }
                            }
                            if ($displayPKR_IKUTORANGTUA) {
                              echo count($PKR_IKUTORANGTUA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_IKUTORANGTUA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>IbuRumahTangga<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_IBURUMAHTANGGA = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_IBURUMAHTANGGA']; 
                          if (!empty($PKR_IBURUMAHTANGGA)) {
                            foreach ($PKR_IBURUMAHTANGGA as $checkPKR_IBURUMAHTANGGA) { 
                              $displayPKR_IBURUMAHTANGGA = FALSE;
                              if(!in_array($checkPKR_IBURUMAHTANGGA['id_tersangka'], $arrayPKR_IBURUMAHTANGGA)) {
                                  array_push($arrayPKR_IBURUMAHTANGGA, $checkPKR_IBURUMAHTANGGA['id_tersangka']);
                                  $displayPKR_IBURUMAHTANGGA = TRUE;
                              }
                            }
                            if ($displayPKR_IBURUMAHTANGGA) {
                              echo count($PKR_IBURUMAHTANGGA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_IBURUMAHTANGGA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>TidakKerja<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_TIDAKKERJA = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_TIDAKKERJA']; 
                          if (!empty($PKR_TIDAKKERJA)) {
                            foreach ($PKR_TIDAKKERJA as $checkPKR_TIDAKKERJA) { 
                              $displayPKR_TIDAKKERJA = FALSE;
                              if(!in_array($checkPKR_TIDAKKERJA['id_tersangka'], $arrayPKR_TIDAKKERJA)) {
                                  array_push($arrayPKR_TIDAKKERJA, $checkPKR_TIDAKKERJA['id_tersangka']);
                                  $displayPKR_TIDAKKERJA = TRUE;
                              }
                            }
                            if ($displayPKR_TIDAKKERJA) {
                              echo count($PKR_TIDAKKERJA);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_TIDAKKERJA);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>Notaris<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_NOTARIS = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_NOTARIS']; 
                          if (!empty($PKR_NOTARIS)) {
                            foreach ($PKR_NOTARIS as $checkPKR_NOTARIS) { 
                              $displayPKR_NOTARIS = FALSE;
                              if(!in_array($checkPKR_NOTARIS['id_tersangka'], $arrayPKR_NOTARIS)) {
                                  array_push($arrayPKR_NOTARIS, $checkPKR_NOTARIS['id_tersangka']);
                                  $displayPKR_NOTARIS = TRUE;
                              }
                            }
                            if ($displayPKR_NOTARIS) {
                              echo count($PKR_NOTARIS);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_NOTARIS);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>TNI<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_TNI = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_TNI']; 
                          if (!empty($PKR_TNI)) {
                            foreach ($PKR_TNI as $checkPKR_TNI) { 
                              $displayPKR_TNI = FALSE;
                              if(!in_array($checkPKR_TNI['id_tersangka'], $arrayPKR_TNI)) {
                                  array_push($arrayPKR_TNI, $checkPKR_TNI['id_tersangka']);
                                  $displayPKR_TNI = TRUE;
                              }
                            }
                            if ($displayPKR_TNI) {
                              echo count($PKR_TNI);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_TNI);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>POLRI<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_POLRI = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_POLRI']; 
                          if (!empty($PKR_POLRI)) {
                            foreach ($PKR_POLRI as $checkPKR_POLRI) { 
                              $displayPKR_POLRI = FALSE;
                              if(!in_array($checkPKR_POLRI['id_tersangka'], $arrayPKR_POLRI)) {
                                  array_push($arrayPKR_POLRI, $checkPKR_POLRI['id_tersangka']);
                                  $displayPKR_POLRI = TRUE;
                              }
                            }
                            if ($displayPKR_POLRI) {
                              echo count($PKR_POLRI);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_POLRI);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>PNS<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_PNS = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_PNS']; 
                          if (!empty($PKR_PNS)) {
                            foreach ($PKR_PNS as $checkPKR_PNS) { 
                              $displayPKR_PNS = FALSE;
                              if(!in_array($checkPKR_PNS['id_tersangka'], $arrayPKR_PNS)) {
                                  array_push($arrayPKR_PNS, $checkPKR_PNS['id_tersangka']);
                                  $displayPKR_PNS = TRUE;
                              }
                            }
                            if ($displayPKR_PNS) {
                              echo count($PKR_PNS);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_PNS);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>PEMBANTU<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_PEMBANTU = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_PEMBANTU']; 
                          if (!empty($PKR_PEMBANTU)) {
                            foreach ($PKR_PEMBANTU as $checkPKR_PEMBANTU) { 
                              $displayPKR_PEMBANTU = FALSE;
                              if(!in_array($checkPKR_PEMBANTU['id_tersangka'], $arrayPKR_PEMBANTU)) {
                                  array_push($arrayPKR_PEMBANTU, $checkPKR_PEMBANTU['id_tersangka']);
                                  $displayPKR_PEMBANTU = TRUE;
                              }
                            }
                            if ($displayPKR_PEMBANTU) {
                              echo count($PKR_PEMBANTU);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_PEMBANTU);
                          }
                          ?>
                        </td>
                        <td class="<?= $keyStatusTSK ?>NAPI<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $PKR_NAPI = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['PKR_NAPI']; 
                          if (!empty($PKR_NAPI)) {
                            foreach ($PKR_NAPI as $checkPKR_NAPI) { 
                              $displayPKR_NAPI = FALSE;
                              if(!in_array($checkPKR_NAPI['id_tersangka'], $arrayPKR_NAPI)) {
                                  array_push($arrayPKR_NAPI, $checkPKR_NAPI['id_tersangka']);
                                  $displayPKR_NAPI = TRUE;
                              }
                            }
                            if ($displayPKR_NAPI) {
                              echo count($PKR_NAPI);
                            }else{
                              echo 0;
                            }
                          }else{
                            echo count($PKR_NAPI);
                          }
                          ?>
                        </td>
                        <!-- JUMLAH BB SITAAN -->
                        <td class="<?= $keyStatusTSK ?>BERAT_BB<?= str_replace(['/', ' '],'',$kategoriGol) ?>">
                          <?php $JML_BERAT_BB = $dataMatrikGol[$kategoriGol][$keyStatusTSK]['JML_BERAT_BB'] ;
                            $berat_gram = 0;
                            $berat_butir = 0;
                            $final_result_berat = "";
                            if (!empty($JML_BERAT_BB)) {
                              foreach ($JML_BERAT_BB as $keyBeratBB) {
                                if ($keyBeratBB['satuan'] == 'gram') {
                                  $berat_gram += (float)$keyBeratBB['jumlah'];
                                } else {
                                  $berat_butir += (float)$keyBeratBB['jumlah'];
                                }
                              }
                              if ($berat_gram != 0 && $berat_butir != 0) {
                                $final_result_berat = $berat_gram." gram & ".$berat_butir." butir";
                              }elseif ($berat_gram == 0) {
                                $final_result_berat = $berat_butir." butir";
                              }else{
                                $final_result_berat = $berat_gram." gram";
                              }
                              echo $final_result_berat;
                            }else{
                              echo 0;
                            }
                          ?>
                          <input type="hidden" class="<?= $keyStatusTSK ?>BERAT_BB<?= str_replace(['/', ' '],'',$kategoriGol) ?>GRAM" value="<?= $berat_gram ?>">
                          <input type="hidden" class="<?= $keyStatusTSK ?>BERAT_BB<?= str_replace(['/', ' '],'',$kategoriGol) ?>BUTIR" value="<?= $berat_butir ?>">
                        </td>
                    </tr>
                  <?php } ?>
                  <!-- JUMLAH -->
                  <tr class="text-center" style="font-weight:700;">
                      <td colspan="2">JUMLAH</td>
                      <!-- KSS -->
                      <td class="JML_KSS<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <!-- JML TSK -->
                      <td class="JML_TSK<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <!-- KSS SELESAI -->
                      <td class="JML_SelesaiKSS<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <!-- KEWARGANEGARAAN -->
                      <!-- WNI LK PR -->
                      <td class="JML_WNILK<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_WNIPR<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <!-- WNA LK PR -->
                      <td class="JML_WNALK<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_WNAPR<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <!-- USIA -->
                      <td class="JML_14<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_1518<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_1924<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_2564<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_65<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <!-- PENDIDIKAN -->
                      <td class="JML_TidakSekolah<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_SD<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_SMP<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_SMA<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_PT<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_BelumDiketahui<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <!-- Pekerjaan -->
                      <td class="JML_Pelajar<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_Mahasiswa<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_Swasta<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_BuruhKaryawan<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_PetaniNelayan<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_Pedagang<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_WiraswastaPengusaha<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_SopirTukangOjek<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_IkutOrangTua<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_IbuRumahTangga<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_TidakKerja<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_Notaris<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_TNI<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_POLRI<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_PNS<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_PEMBANTU<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <td class="JML_NAPI<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                      <!-- JUMLAH BB SITAAN -->
                      <td class="JML_BERAT_BB<?= str_replace(['/', ' '],'',$kategoriGol) ?>"></td>
                  </tr>
                  <?php 
                  include('matrikCountingBB/jumlahPerKategoriKhususGol.php');
                  $noGol++; } 
                  ?>
            </tbody>
            <tfoot class="text-center">
                <tr>
                  <th rowspan="3">NO</th>
                  <th rowspan="3">JENIS KASUS STATUS TSK</th>
                  <th rowspan="3">JML KSS</th>
                  <th rowspan="3">JML TSK</th>
                  <th rowspan="3">KSS YG SELESAI</th>
                  <td colspan="4">KEWARGANEGARAAN</td>
                  <td colspan="5">USIA</td>
                  <td colspan="6">PENDIDIKAN</td>
                  <td colspan="17">PEKERJAAN</td>
                  <th rowspan="3">JUMLAH BB SITAAN</th>
                </tr>
                <tr>
                    <td colspan="2">WNI</td>
                    <td colspan="2">WNA</td>
                    <!-- USIA -->
                    <th rowspan="2"><14</th>
                    <th rowspan="2">15-18</th>
                    <th rowspan="2">19-24</th>
                    <th rowspan="2">25-64</th>
                    <th rowspan="2">>65</th>
                    <!-- PENDIDIKAN -->
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
                </tr>
                <tr>
                    <th>LK</th>
                    <th>PR</th>
                    <th>LK</th>
                    <th>PR</th>
                </tr>
            </tfoot>
        </table>
        <hr>
        <h2>Matrik Berdasarkan Undang - Undang</h2>
        <!-- Tabel Berdasarkan Perundang-Undangan -->
        <table class="table table-responsive table-bordered table-striped mt-2" style="width:100%;font-size:0.8rem;">
          <thead class="text-center">
            <tr>
              <th rowspan="3">NO</th>
              <th rowspan="3">Undang - Undang</th>
              <th rowspan="3">JML KSS</th>
              <th rowspan="3">JML TSK</th>
              <th rowspan="3">KSS YG SELESAI</th>
              <td colspan="4">KEWARGANEGARAAN</td>
              <td colspan="5">USIA</td>
              <td colspan="6">PENDIDIKAN</td>
              <td colspan="17">PEKERJAAN</td>
              <th rowspan="3">JUMLAH BB SITAAN</th>
            </tr>
            <tr>
                <td colspan="2">WNI</td>
                <td colspan="2">WNA</td>
                <!-- USIA -->
                <th rowspan="2"><14</th>
                <th rowspan="2">15-18</th>
                <th rowspan="2">19-24</th>
                <th rowspan="2">25-64</th>
                <th rowspan="2">>65</th>
                <!-- PENDIDIKAN -->
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
            </tr>
            <tr>
                <th>LK</th>
                <th>PR</th>
                <th>LK</th>
                <th>PR</th>
            </tr>
          </thead>
          <tbody>
            <tr>
                <!-- No -->
                <td rowspan="2" class="text-center">1.</td>
                <td colspan="40"><strong>UNDANG-UNDANG RI NO.5 TH 1997 TTG PSIKOTROPIKA (Ganja, Tembakau Gorilla, Hashish, Opium, Morphin, Heroin/Putaw, Kokain, Exstacy/Carnophen, Sabu)</strong></td>
            </tr>
            <tr class="text-center" style="font-weight:700;">
                <td>TOTAL</td>
                <!-- KSS -->
                <td class="PSI_KSS"></td>
                <!-- JML TSK -->
                <td class="PSI_TSK"></td>
                <!-- KSS SELESAI -->
                <td class="PSI_SelesaiKSS"></td>
                <!-- KEWARGANEGARAAN -->
                <!-- WNI LK PR -->
                <td class="PSI_WNILK"></td>
                <td class="PSI_WNIPR"></td>
                <!-- WNA LK PR -->
                <td class="PSI_WNALK"></td>
                <td class="PSI_WNAPR"></td>
                <!-- USIA -->
                <td class="PSI_14"></td>
                <td class="PSI_1518"></td>
                <td class="PSI_1924"></td>
                <td class="PSI_2564"></td>
                <td class="PSI_65"></td>
                <!-- PENDIDIKAN -->
                <td class="PSI_TidakSekolah"></td>
                <td class="PSI_SD"></td>
                <td class="PSI_SMP"></td>
                <td class="PSI_SMA"></td>
                <td class="PSI_PT"></td>
                <td class="PSI_BelumDiketahui"></td>
                <!-- Pekerjaan -->
                <td class="PSI_Pelajar"></td>
                <td class="PSI_Mahasiswa"></td>
                <td class="PSI_Swasta"></td>
                <td class="PSI_BuruhKaryawan"></td>
                <td class="PSI_PetaniNelayan"></td>
                <td class="PSI_Pedagang"></td>
                <td class="PSI_WiraswastaPengusaha"></td>
                <td class="PSI_SopirTukangOjek"></td>
                <td class="PSI_IkutOrangTua"></td>
                <td class="PSI_IbuRumahTangga"></td>
                <td class="PSI_TidakKerja"></td>
                <td class="PSI_Notaris"></td>
                <td class="PSI_TNI"></td>
                <td class="PSI_POLRI"></td>
                <td class="PSI_PNS"></td>
                <td class="PSI_PEMBANTU"></td>
                <td class="PSI_NAPI"></td>
                <!-- JUMLAH BB SITAAN -->
                <td class="PSI_BERAT_BB">-</td>
            </tr>
            <tr>
                <!-- No -->
                <td rowspan="2" class="text-center">2.</td>
                <td colspan="40"><strong>UNDANG-UNDANG RI NO.35 TH 2009 TTG NARKOTIKA (GOL III & GOL IV)</strong></td>
            </tr>
            <tr class="text-center" style="font-weight:700;">
                <td>TOTAL</td>
                <!-- KSS -->
                <td class="NAR_KSS"></td>
                <!-- JML TSK -->
                <td class="NAR_TSK"></td>
                <!-- KSS SELESAI -->
                <td class="NAR_SelesaiKSS"></td>
                <!-- KEWARGANEGARAAN -->
                <!-- WNI LK PR -->
                <td class="NAR_WNILK"></td>
                <td class="NAR_WNIPR"></td>
                <!-- WNA LK PR -->
                <td class="NAR_WNALK"></td>
                <td class="NAR_WNAPR"></td>
                <!-- USIA -->
                <td class="NAR_14"></td>
                <td class="NAR_1518"></td>
                <td class="NAR_1924"></td>
                <td class="NAR_2564"></td>
                <td class="NAR_65"></td>
                <!-- PENDIDIKAN -->
                <td class="NAR_TidakSekolah"></td>
                <td class="NAR_SD"></td>
                <td class="NAR_SMP"></td>
                <td class="NAR_SMA"></td>
                <td class="NAR_PT"></td>
                <td class="NAR_BelumDiketahui"></td>
                <!-- Pekerjaan -->
                <td class="NAR_Pelajar"></td>
                <td class="NAR_Mahasiswa"></td>
                <td class="NAR_Swasta"></td>
                <td class="NAR_BuruhKaryawan"></td>
                <td class="NAR_PetaniNelayan"></td>
                <td class="NAR_Pedagang"></td>
                <td class="NAR_WiraswastaPengusaha"></td>
                <td class="NAR_SopirTukangOjek"></td>
                <td class="NAR_IkutOrangTua"></td>
                <td class="NAR_IbuRumahTangga"></td>
                <td class="NAR_TidakKerja"></td>
                <td class="NAR_Notaris"></td>
                <td class="NAR_TNI"></td>
                <td class="NAR_POLRI"></td>
                <td class="NAR_PNS"></td>
                <td class="NAR_PEMBANTU"></td>
                <td class="NAR_NAPI"></td>
                <!-- JUMLAH BB SITAAN -->
                <td class="NAR_BERAT_BB">-</td>
            </tr>
            <tr>
                <!-- No -->
                <td rowspan="2" class="text-center">3.</td>
                <td colspan="40"><strong>UNDANG-UNDANG RI NO.36 TH 2009 TTG KESEHATAN (Jamu, Kosmetik, Daftar G)</strong></td>
            </tr>
            <tr class="text-center" style="font-weight:700;">
                <td>TOTAL</td>
                <!-- KSS -->
                <td class="KES_KSS"></td>
                <!-- JML TSK -->
                <td class="KES_TSK"></td>
                <!-- KSS SELESAI -->
                <td class="KES_SelesaiKSS"></td>
                <!-- KEWARGANEGARAAN -->
                <!-- WNI LK PR -->
                <td class="KES_WNILK"></td>
                <td class="KES_WNIPR"></td>
                <!-- WNA LK PR -->
                <td class="KES_WNALK"></td>
                <td class="KES_WNAPR"></td>
                <!-- USIA -->
                <td class="KES_14"></td>
                <td class="KES_1518"></td>
                <td class="KES_1924"></td>
                <td class="KES_2564"></td>
                <td class="KES_65"></td>
                <!-- PENDIDIKAN -->
                <td class="KES_TidakSekolah"></td>
                <td class="KES_SD"></td>
                <td class="KES_SMP"></td>
                <td class="KES_SMA"></td>
                <td class="KES_PT"></td>
                <td class="KES_BelumDiketahui"></td>
                <!-- Pekerjaan -->
                <td class="KES_Pelajar"></td>
                <td class="KES_Mahasiswa"></td>
                <td class="KES_Swasta"></td>
                <td class="KES_BuruhKaryawan"></td>
                <td class="KES_PetaniNelayan"></td>
                <td class="KES_Pedagang"></td>
                <td class="KES_WiraswastaPengusaha"></td>
                <td class="KES_SopirTukangOjek"></td>
                <td class="KES_IkutOrangTua"></td>
                <td class="KES_IbuRumahTangga"></td>
                <td class="KES_TidakKerja"></td>
                <td class="KES_Notaris"></td>
                <td class="KES_TNI"></td>
                <td class="KES_POLRI"></td>
                <td class="KES_PNS"></td>
                <td class="KES_PEMBANTU"></td>
                <td class="KES_NAPI"></td>
                <!-- JUMLAH BB SITAAN -->
                <td class="KES_BERAT_BB">-</td>
            </tr>
          </tbody>
        </table>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php 
  include('matrikCountingBB/jumlahKasusNarkotika.php'); 
  ?>

  <script>
    $(document).ready(function(){
        function codeAddress() {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 15000
          });

          Toast.fire({
            icon: 'success',
            title: '&nbsp;Terimakasih telah menunggu, modul matrik membutuhkan waktu untuk memproses data.'
          })
        }
        window.onload = codeAddress;

        $('#tanggalAwalHarian').datetimepicker({
            format: 'YYYY-MM-DD'
        });
          
        $('#tanggalAkhirHarian').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
  </script>
