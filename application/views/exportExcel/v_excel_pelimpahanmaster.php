<?php 
    $namaKesatuan = $this->session->userdata('login_data_admin')['nama'];
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Master Kasus Pelimpahan ({$namaKesatuan}) - Periode {$dateNow}.xls");
?>

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
    $CI->load->model('Modelpelimpahan');
?>

<div class="container">
    <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>
        <table class="table table-bordered table-striped">
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
    <?php }else{?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>No Laporan Polisi</th>
                    <th>Deskripsi Waktu & TKP</th>
                    <th>Identitas Tersangka</th> 
                    <th>Umur</th> 
                    <th>Pendidikan</th> 
                    <th>Pekerjaan</th> 
                    <th>Barang Bukti</th> 
                    <th>Modus Operandi</th> 
                    <th>Keterangan</th>
                    <th>Status (Selra)</th>
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
                    <td><?= $display ? $row_kasus["no_laporanpolisi"] : ""; ?></td>
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
                <?php ($display) ? $no++ : $no; } ?>
            <?php }else{?>
                    <tr>
                        <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Master Belum Tersedia</p></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php }?>
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