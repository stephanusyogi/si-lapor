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

<div class="container">
    
<table class="table table-bordered table-striped ">
    <thead class="text-center">
        <tr>
            <th rowspan="3">NO</th>
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
</table>
</div>