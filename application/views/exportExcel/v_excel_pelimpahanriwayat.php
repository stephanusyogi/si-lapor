<?php 
    $namaKesatuan = $this->session->userdata('login_data_admin')['nama'];
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Riwayat Pelimpahan ({$namaKesatuan}) - Periode {$dateNow}.xls");
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
    $CI->load->model('Modelbarangbukti');
    $CI->load->model('Modeltersangka');
?>

<div class="container">
    <h4>LP Diterima</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>No Laporan Polisi</th>
                <th>Diterima Dari</th>
                <th>Kepada Polsek</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($LPditerima)){ ?>
                <?php 
                $no = 1;
                foreach ($LPditerima as $rowLPditerima) { 
                ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $rowLPditerima['no_laporanpolisi'] ?></td>
                    <td><?= $rowLPditerima['kodekesatuan_pelimpahanDari']?></td>
                    <td><?= $rowLPditerima['nama_polsek']?></td>
                    <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowLPditerima["created_at"]))) ?></td>
                </tr>
                <?php $no++; } ?>
            <?php }else{?>
                    <tr>
                        <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Riwayat Belum Tersedia</p></td>
                    </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <br>
    <h4>LP Dilimpahkan</h4>
    <table class="table datatable table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Batalkan Pelimpahan</th>
                <th>No Laporan Polisi</th>
                <th>Dilimpahkan Ke</th>
                <th>Kepada Polsek</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($LPdilimpahkan)){ ?>
                <?php 
                $no = 1;
                foreach ($LPdilimpahkan as $rowLPdilimpahkan) { 
                ?>
                <tr>
                    <td><?= $no ?></td>
                    <td class="text-center">
                        <div data-toggle="tooltip" data-placement="top" title="Batalkan Pelimpahan">
                        <a class="tombol-batal-pelimpahan" href="<?= base_url() ?>pelimpahan/batalPelimpahan/<?= $rowLPdilimpahkan['idKasusPelimpahan'] ?>/<?= $rowLPdilimpahkan['id_kasus'] ?>" ><i class="fas fa-trash" style="color:red;"></i></a>
                        </div>
                    </td>
                    <td><?= $rowLPdilimpahkan['no_laporanpolisi'] ?></td>
                    <td><?= $rowLPdilimpahkan['kodekesatuan_pelimpahanKe']?></td>
                    <td><?= $rowLPdilimpahkan['namaPolsekPelimpahan']?></td>
                    <td><?= dateIndonesia(date('N j/n/Y', strtotime($rowLPdilimpahkan["created_at"])))?></td>
                </tr>
                <?php $no++; } ?>
            <?php }else{?>
                    <tr>
                        <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Riwayat Belum Tersedia</p></td>
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
