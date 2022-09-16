<?php 
    $namaKesatuan = $this->session->userdata('login_data_admin')['nama'];
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Selesai Perkara ({$namaKesatuan}) - Periode {$dateNow}.xls");
?>

<style>
    .title-doc{
        padding-top:10rem;
    }
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

<div class="container">
    <h5>Status SELRA (SP3 / RJ / Tahap II)</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <?php if($allSearch){ ?>
                    <th>Kesatuan</th>
                <?php } ?>
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
                <?php if($allSearch){ ?>
                    <td><?php
                        $result = $CI->Modelkesatuan->getKesatuanByKode($rowCC["kode_kesatuan"]);
                        echo $result[0]['nama']; ?>
                    </td>
                <?php } ?>
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
            <?php $no++; } ?>
        <?php }else{?>
                <tr>
                    <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Selra Belum Tersedia</p></td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
    <br>
    <br>
    <h5>Status SELRA Belum Diketahui</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>
                    <th>Kesatuan</th>
                <?php } ?>
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
                <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>
                    <td><?php
                        $result = $CI->Modelkesatuan->getKesatuanByKode($rowCT["kode_kesatuan"]);
                        echo $result[0]['nama']; ?>
                    </td>
                <?php } ?>
                <td><?= $rowCT["no_laporanpolisi"]; ?></td>
                <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowCT["created_at"]))) ?></td>
                <td class="text-center">
                    <?php 
                        $diff = date_diff(date_create($rowCT["created_at"]), date_create(date("Y-m-d")));
                        echo $diff->format("%a")." Hari";
                    ?>
                </td>
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