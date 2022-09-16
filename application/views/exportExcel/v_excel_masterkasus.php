<?php 
    $namaKesatuan = $this->session->userdata('login_data_admin')['nama'];
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Master Kasus ({$namaKesatuan}) - Periode {$dateNow}.xls");
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
    $CI->load->model('Modeladmin');
?>

<div class="container">
    <div class="title-doc text-center">
        <h2 class="mb-0">REKAPITULASI TERSANGKA T.P. NARKOTIKA & PSIKOTROPIKA ( DIREKTORAT RESERSE NARKOBA POLDA JATIM )</h2>
        <h3 class="mb-0">Periode: <?= $dateNow ?></h3>
    </div>
    <table class="table table-bordered table-striped ">
            <thead>
                <tr class="text-center">
                  <th>No</th>
                  <?php if($allSearch): ?>
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
                  <th>Status(Selra)</th>
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
                    <?php if($allSearch): ?>
                    <td class="textcenter">
                      <?php $dataKesatuan =  $CI->Modelkesatuan->getKesatuanByKode($row_kasus['kode_kesatuan']);?>
                      <?= ($display) ? $dataKesatuan[0]["nama"]  :  "" ?>
                    </td>
                    <?php endif; ?>
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
                    <td>
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
                        <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Master Kasus Belum Tersedia</p></td>
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