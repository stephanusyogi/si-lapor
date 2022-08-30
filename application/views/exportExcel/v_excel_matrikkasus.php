<?php 
    $namaKesatuan = $this->session->userdata('login_data_admin')['nama'];
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Matrik Kasus ({$namaKesatuan}) - Periode {$dateNow}.xls");
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
    $CI->load->model('Modelkesatuan');
?>
<div class="container">
    
<table class="table table-bordered table-striped ">
    <thead class="text-center">
        <tr>
            <th rowspan="3">NO</th>
            <th rowspan="3">KESATUAN</th>
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
</table>
</div>