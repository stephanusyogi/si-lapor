
<script>
$(document).ready(function(){
    // KSS
    var arrayJumlahKSS = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamKSS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiKSS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarKSS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarKSS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaKSS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_KSS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahKSS["Penanam"] +  arrayJumlahKSS["Produksi"] +  arrayJumlahKSS["Bandar"] +  arrayJumlahKSS["Pengedar"] +  arrayJumlahKSS["Pengguna"];

    // TSK
    var arrayJumlahTSK = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamTSK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiTSK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarTSK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarTSK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaTSK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_TSK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahTSK["Penanam"] +  arrayJumlahTSK["Produksi"] +  arrayJumlahTSK["Bandar"] +  arrayJumlahTSK["Pengedar"] +  arrayJumlahTSK["Pengguna"];

    // Selesai KSS
    var arrayJumlahSelesaiKSS = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamSelesaiKSS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiSelesaiKSS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarSelesaiKSS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarSelesaiKSS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaSelesaiKSS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_SelesaiKSS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahSelesaiKSS["Penanam"] +  arrayJumlahSelesaiKSS["Produksi"] +  arrayJumlahSelesaiKSS["Bandar"] +  arrayJumlahSelesaiKSS["Pengedar"] +  arrayJumlahSelesaiKSS["Pengguna"];
    
    // WNI LK
    var arrayJumlahWNILK = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamWNILK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiWNILK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarWNILK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarWNILK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaWNILK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_WNILK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahWNILK["Penanam"] +  arrayJumlahWNILK["Produksi"] +  arrayJumlahWNILK["Bandar"] +  arrayJumlahWNILK["Pengedar"] +  arrayJumlahWNILK["Pengguna"];
    
    // WNI PR
    var arrayJumlahWNIPR = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamWNIPR<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiWNIPR<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarWNIPR<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarWNIPR<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaWNIPR<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_WNIPR<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahWNIPR["Penanam"] +  arrayJumlahWNIPR["Produksi"] +  arrayJumlahWNIPR["Bandar"] +  arrayJumlahWNIPR["Pengedar"] +  arrayJumlahWNIPR["Pengguna"];
    
    // WNA LK
    var arrayJumlahWNALK = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamWNALK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiWNALK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarWNALK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarWNALK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaWNALK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_WNALK<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahWNALK["Penanam"] +  arrayJumlahWNALK["Produksi"] +  arrayJumlahWNALK["Bandar"] +  arrayJumlahWNALK["Pengedar"] +  arrayJumlahWNALK["Pengguna"];
    
    // WNA PR
    var arrayJumlahWNAPR = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamWNAPR<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiWNAPR<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarWNAPR<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarWNAPR<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaWNAPR<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_WNAPR<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahWNAPR["Penanam"] +  arrayJumlahWNAPR["Produksi"] +  arrayJumlahWNAPR["Bandar"] +  arrayJumlahWNAPR["Pengedar"] +  arrayJumlahWNAPR["Pengguna"];
    
    // USIA 14
    var arrayJumlahUsia14 = {
        "Penanam" : parseInt(document.getElementsByClassName('Penanam14<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('Produksi14<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('Bandar14<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('Pengedar14<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('Pengguna14<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_14<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahUsia14["Penanam"] +  arrayJumlahUsia14["Produksi"] +  arrayJumlahUsia14["Bandar"] +  arrayJumlahUsia14["Pengedar"] +  arrayJumlahUsia14["Pengguna"];
    
    // USIA 15-18
    var arrayJumlahUsia1518 = {
        "Penanam" : parseInt(document.getElementsByClassName('Penanam1518<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('Produksi1518<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('Bandar1518<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('Pengedar1518<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('Pengguna1518<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_1518<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahUsia1518["Penanam"] +  arrayJumlahUsia1518["Produksi"] +  arrayJumlahUsia1518["Bandar"] +  arrayJumlahUsia1518["Pengedar"] +  arrayJumlahUsia1518["Pengguna"];
    
    // USIA 19-24
    var arrayJumlahUsia1924 = {
        "Penanam" : parseInt(document.getElementsByClassName('Penanam1924<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('Produksi1924<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('Bandar1924<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('Pengedar1924<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('Pengguna1924<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_1924<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahUsia1924["Penanam"] +  arrayJumlahUsia1924["Produksi"] +  arrayJumlahUsia1924["Bandar"] +  arrayJumlahUsia1924["Pengedar"] +  arrayJumlahUsia1924["Pengguna"];
    
    // USIA 25-64
    var arrayJumlahUsia2564 = {
        "Penanam" : parseInt(document.getElementsByClassName('Penanam2564<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('Produksi2564<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('Bandar2564<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('Pengedar2564<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('Pengguna2564<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_2564<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahUsia2564["Penanam"] +  arrayJumlahUsia2564["Produksi"] +  arrayJumlahUsia2564["Bandar"] +  arrayJumlahUsia2564["Pengedar"] +  arrayJumlahUsia2564["Pengguna"];
    
    // USIA 65
    var arrayJumlahUsia65 = {
        "Penanam" : parseInt(document.getElementsByClassName('Penanam65<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('Produksi65<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('Bandar65<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('Pengedar65<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('Pengguna65<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_65<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahUsia65["Penanam"] +  arrayJumlahUsia65["Produksi"] +  arrayJumlahUsia65["Bandar"] +  arrayJumlahUsia65["Pengedar"] +  arrayJumlahUsia65["Pengguna"];
    
    // PENDIDIKAN Tidak Sekolah
    var arrayJumlahTidakSekolah = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamTidakSekolah<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiTidakSekolah<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarTidakSekolah<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarTidakSekolah<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaTidakSekolah<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_TidakSekolah<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahTidakSekolah["Penanam"] +  arrayJumlahTidakSekolah["Produksi"] +  arrayJumlahTidakSekolah["Bandar"] +  arrayJumlahTidakSekolah["Pengedar"] +  arrayJumlahTidakSekolah["Pengguna"];
    
    // PENDIDIKAN SD
    var arrayJumlahSD = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamSD<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiSD<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarSD<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarSD<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaSD<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_SD<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahSD["Penanam"] +  arrayJumlahSD["Produksi"] +  arrayJumlahSD["Bandar"] +  arrayJumlahSD["Pengedar"] +  arrayJumlahSD["Pengguna"];
    
    // PENDIDIKAN SMP
    var arrayJumlahSMP = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamSMP<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiSMP<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarSMP<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarSMP<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaSMP<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_SMP<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahSMP["Penanam"] +  arrayJumlahSMP["Produksi"] +  arrayJumlahSMP["Bandar"] +  arrayJumlahSMP["Pengedar"] +  arrayJumlahSMP["Pengguna"];
    
    // PENDIDIKAN SMA
    var arrayJumlahSMA = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamSMA<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiSMA<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarSMA<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarSMA<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaSMA<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_SMA<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahSMA["Penanam"] +  arrayJumlahSMA["Produksi"] +  arrayJumlahSMA["Bandar"] +  arrayJumlahSMA["Pengedar"] +  arrayJumlahSMA["Pengguna"];
    
    // PENDIDIKAN PT
    var arrayJumlahPT = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamPT<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiPT<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarPT<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarPT<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaPT<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_PT<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahPT["Penanam"] +  arrayJumlahPT["Produksi"] +  arrayJumlahPT["Bandar"] +  arrayJumlahPT["Pengedar"] +  arrayJumlahPT["Pengguna"];
    
    // PENDIDIKAN Belum Diketahui
    var arrayJumlahBelumDiketahui = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamBelumDiketahui<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiBelumDiketahui<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarBelumDiketahui<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarBelumDiketahui<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaBelumDiketahui<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_BelumDiketahui<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahBelumDiketahui["Penanam"] +  arrayJumlahBelumDiketahui["Produksi"] +  arrayJumlahBelumDiketahui["Bandar"] +  arrayJumlahBelumDiketahui["Pengedar"] +  arrayJumlahBelumDiketahui["Pengguna"];

    // PEKERJAAN Pelajar
    var arrayJumlahPelajar = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamPelajar<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiPelajar<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarPelajar<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarPelajar<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaPelajar<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_Pelajar<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahPelajar["Penanam"] +  arrayJumlahPelajar["Produksi"] +  arrayJumlahPelajar["Bandar"] +  arrayJumlahPelajar["Pengedar"] +  arrayJumlahPelajar["Pengguna"];

    // PEKERJAAN Mahasiswa
    var arrayJumlahMahasiswa = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamMahasiswa<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiMahasiswa<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarMahasiswa<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarMahasiswa<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaMahasiswa<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_Mahasiswa<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahMahasiswa["Penanam"] +  arrayJumlahMahasiswa["Produksi"] +  arrayJumlahMahasiswa["Bandar"] +  arrayJumlahMahasiswa["Pengedar"] +  arrayJumlahMahasiswa["Pengguna"];

    // PEKERJAAN Swasta
    var arrayJumlahSwasta = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamSwasta<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiSwasta<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarSwasta<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarSwasta<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaSwasta<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_Swasta<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahSwasta["Penanam"] +  arrayJumlahSwasta["Produksi"] +  arrayJumlahSwasta["Bandar"] +  arrayJumlahSwasta["Pengedar"] +  arrayJumlahSwasta["Pengguna"];

    // PEKERJAAN Buruh / Karyawan
    var arrayJumlahBuruhKaryawan = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamBuruhKaryawan<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiBuruhKaryawan<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarBuruhKaryawan<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarBuruhKaryawan<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaBuruhKaryawan<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_BuruhKaryawan<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahBuruhKaryawan["Penanam"] +  arrayJumlahBuruhKaryawan["Produksi"] +  arrayJumlahBuruhKaryawan["Bandar"] +  arrayJumlahBuruhKaryawan["Pengedar"] +  arrayJumlahBuruhKaryawan["Pengguna"];

    // PEKERJAAN Petani / Nelayan
    var arrayJumlahPetaniNelayan = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamPetaniNelayan<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiPetaniNelayan<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarPetaniNelayan<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarPetaniNelayan<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaPetaniNelayan<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_PetaniNelayan<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahPetaniNelayan["Penanam"] +  arrayJumlahPetaniNelayan["Produksi"] +  arrayJumlahPetaniNelayan["Bandar"] +  arrayJumlahPetaniNelayan["Pengedar"] +  arrayJumlahPetaniNelayan["Pengguna"];

    // PEKERJAAN Pedagang
    var arrayJumlahPedagang = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamPedagang<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiPedagang<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarPedagang<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarPedagang<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaPedagang<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_Pedagang<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahPedagang["Penanam"] +  arrayJumlahPedagang["Produksi"] +  arrayJumlahPedagang["Bandar"] +  arrayJumlahPedagang["Pengedar"] +  arrayJumlahPedagang["Pengguna"];

    // PEKERJAAN Wiraswasta / Pengusaha
    var arrayJumlahWiraswastaPengusaha = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamWiraswastaPengusaha<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiWiraswastaPengusaha<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarWiraswastaPengusaha<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarWiraswastaPengusaha<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaWiraswastaPengusaha<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_WiraswastaPengusaha<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahWiraswastaPengusaha["Penanam"] +  arrayJumlahWiraswastaPengusaha["Produksi"] +  arrayJumlahWiraswastaPengusaha["Bandar"] +  arrayJumlahWiraswastaPengusaha["Pengedar"] +  arrayJumlahWiraswastaPengusaha["Pengguna"];

    // PEKERJAAN Sopir / Tukang Ojek
    var arrayJumlahSopirTukangOjek = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamSopirTukangOjek<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiSopirTukangOjek<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarSopirTukangOjek<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarSopirTukangOjek<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaSopirTukangOjek<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_SopirTukangOjek<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahSopirTukangOjek["Penanam"] +  arrayJumlahSopirTukangOjek["Produksi"] +  arrayJumlahSopirTukangOjek["Bandar"] +  arrayJumlahSopirTukangOjek["Pengedar"] +  arrayJumlahSopirTukangOjek["Pengguna"];

    // PEKERJAAN Ikut Orang Tua
    var arrayJumlahIkutOrangTua = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamIkutOrangTua<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiIkutOrangTua<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarIkutOrangTua<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarIkutOrangTua<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaIkutOrangTua<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_IkutOrangTua<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahIkutOrangTua["Penanam"] +  arrayJumlahIkutOrangTua["Produksi"] +  arrayJumlahIkutOrangTua["Bandar"] +  arrayJumlahIkutOrangTua["Pengedar"] +  arrayJumlahIkutOrangTua["Pengguna"];
    
    // PEKERJAAN Ibu Rumah Tangga
    var arrayJumlahIbuRumahTangga = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamIbuRumahTangga<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiIbuRumahTangga<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarIbuRumahTangga<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarIbuRumahTangga<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaIbuRumahTangga<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_IbuRumahTangga<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahIbuRumahTangga["Penanam"] +  arrayJumlahIbuRumahTangga["Produksi"] +  arrayJumlahIbuRumahTangga["Bandar"] +  arrayJumlahIbuRumahTangga["Pengedar"] +  arrayJumlahIbuRumahTangga["Pengguna"];

    // PEKERJAAN Tidak Kerja
    var arrayJumlahTidakKerja = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamTidakKerja<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiTidakKerja<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarTidakKerja<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarTidakKerja<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaTidakKerja<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_TidakKerja<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahTidakKerja["Penanam"] +  arrayJumlahTidakKerja["Produksi"] +  arrayJumlahTidakKerja["Bandar"] +  arrayJumlahTidakKerja["Pengedar"] +  arrayJumlahTidakKerja["Pengguna"];

    // PEKERJAAN Notaris
    var arrayJumlahNotaris = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamNotaris<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiNotaris<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarNotaris<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarNotaris<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaNotaris<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_Notaris<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahNotaris["Penanam"] +  arrayJumlahNotaris["Produksi"] +  arrayJumlahNotaris["Bandar"] +  arrayJumlahNotaris["Pengedar"] +  arrayJumlahNotaris["Pengguna"];

    // PEKERJAAN TNI
    var arrayJumlahTNI = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamTNI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiTNI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarTNI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarTNI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaTNI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_TNI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahTNI["Penanam"] +  arrayJumlahTNI["Produksi"] +  arrayJumlahTNI["Bandar"] +  arrayJumlahTNI["Pengedar"] +  arrayJumlahTNI["Pengguna"];
    
    // PEKERJAAN POLRI
    var arrayJumlahPOLRI = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamPOLRI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiPOLRI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarPOLRI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarPOLRI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaPOLRI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_POLRI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahPOLRI["Penanam"] +  arrayJumlahPOLRI["Produksi"] +  arrayJumlahPOLRI["Bandar"] +  arrayJumlahPOLRI["Pengedar"] +  arrayJumlahPOLRI["Pengguna"];

    // PEKERJAAN PNS
    var arrayJumlahPNS = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamPNS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiPNS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarPNS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarPNS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaPNS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_PNS<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahPNS["Penanam"] +  arrayJumlahPNS["Produksi"] +  arrayJumlahPNS["Bandar"] +  arrayJumlahPNS["Pengedar"] +  arrayJumlahPNS["Pengguna"];

    // PEKERJAAN PEMBANTU
    var arrayJumlahPEMBANTU = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamPEMBANTU<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiPEMBANTU<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarPEMBANTU<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarPEMBANTU<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaPEMBANTU<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_PEMBANTU<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahPEMBANTU["Penanam"] +  arrayJumlahPEMBANTU["Produksi"] +  arrayJumlahPEMBANTU["Bandar"] +  arrayJumlahPEMBANTU["Pengedar"] +  arrayJumlahPEMBANTU["Pengguna"];

    // PEKERJAAN NAPI
    var arrayJumlahNAPI = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamNAPI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiNAPI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Bandar" : parseInt(document.getElementsByClassName('BandarNAPI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarNAPI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaNAPI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText),
    };
    document.getElementsByClassName('JML_NAPI<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  arrayJumlahNAPI["Penanam"] +  arrayJumlahNAPI["Produksi"] +  arrayJumlahNAPI["Bandar"] +  arrayJumlahNAPI["Pengedar"] +  arrayJumlahNAPI["Pengguna"];
    
    // JUMLAH BERAT BB
    var arrayJumlahBERAT_BB = {
        "Penanam" : parseInt(document.getElementsByClassName('PenanamBERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText.split(" ")[0]),
        "PenanamSatuan" : document.getElementsByClassName('PenanamBERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText.split(" ")[1],
        "Produksi" : parseInt(document.getElementsByClassName('ProduksiBERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText.split(" ")[0]),
        "ProduksiSatuan" : document.getElementsByClassName('ProduksiBERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText.split(" ")[1],
        "Bandar" : parseInt(document.getElementsByClassName('BandarBERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText.split(" ")[0]),
        "BandarSatuan" : document.getElementsByClassName('BandarBERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText.split(" ")[1],
        "Pengedar" : parseInt(document.getElementsByClassName('PengedarBERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText.split(" ")[0]),
        "PengedarSatuan" : document.getElementsByClassName('PengedarBERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText.split(" ")[1],
        "Pengguna" : parseInt(document.getElementsByClassName('PenggunaBERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText.split(" ")[0]),
        "PenggunaSatuan" : document.getElementsByClassName('PenggunaBERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText.split(" ")[1],
    };
    var satuanBerat = '';
    if (arrayJumlahBERAT_BB["PenanamSatuan"]) {
        satuanBerat = arrayJumlahBERAT_BB["PenanamSatuan"];
    } else if (arrayJumlahBERAT_BB["ProduksiSatuan"]){
        satuanBerat = arrayJumlahBERAT_BB["ProduksiSatuan"];
    } else if (arrayJumlahBERAT_BB["BandarSatuan"]){
        satuanBerat = arrayJumlahBERAT_BB["BandarSatuan"];
    } else if (arrayJumlahBERAT_BB["PengedarSatuan"]){
        satuanBerat = arrayJumlahBERAT_BB["PengedarSatuan"];
    }else if(arrayJumlahBERAT_BB["PenggunaSatuan"]){
        satuanBerat = arrayJumlahBERAT_BB["PenggunaSatuan"];
    }else{
        satuanBerat = '';
    }
    var totalBerat = arrayJumlahBERAT_BB["Penanam"] +  arrayJumlahBERAT_BB["Produksi"] +  arrayJumlahBERAT_BB["Bandar"] +  arrayJumlahBERAT_BB["Pengedar"] +  arrayJumlahBERAT_BB["Pengguna"];
    document.getElementsByClassName('JML_BERAT_BB<?= str_replace(['/', ' '],'',$kategori) ?>')[0].innerText =  totalBerat + ` ${satuanBerat}`;

});
</script>