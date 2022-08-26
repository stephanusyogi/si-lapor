<script>
    $(document).ready(function(){
        var arrayBB = ["Ganja","TembakauGorilla","Hashish","Opium","Morphin","HeroinPutaw","Kokain","ExstacyCarnophen","Sabu","GOLIV","DaftarG","Kosmetik","Jamu"];

        // Count JKN KSS
        var countJKN_KSS = 0;
        arrayBB.forEach(element => {
        countJKN_KSS += parseInt(document.getElementsByClassName(`JML_KSS${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_KSS`)[0].innerText = countJKN_KSS;

        // Count JKN TSK
        var countJKN_TSK = 0;
        arrayBB.forEach(element => {
        countJKN_TSK += parseInt(document.getElementsByClassName(`JML_TSK${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_TSK`)[0].innerText = countJKN_TSK;

        // Count JKN Selesai KSS
        var countJKN_SelesaiKSS = 0;
        arrayBB.forEach(element => {
        countJKN_SelesaiKSS += parseInt(document.getElementsByClassName(`JML_SelesaiKSS${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_SelesaiKSS`)[0].innerText = countJKN_SelesaiKSS;

        // Count WNI LK
        var countWNILK = 0;
        arrayBB.forEach(element => {
            countWNILK += parseInt(document.getElementsByClassName(`JML_WNILK${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_WNILK`)[0].innerText = countWNILK;

        // Count WNI PR
        var countWNIPR = 0;
        arrayBB.forEach(element => {
            countWNIPR += parseInt(document.getElementsByClassName(`JML_WNIPR${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_WNIPR`)[0].innerText = countWNIPR;

        // Count WNA LK
        var countWNALK = 0;
        arrayBB.forEach(element => {
            countWNALK += parseInt(document.getElementsByClassName(`JML_WNALK${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_WNALK`)[0].innerText = countWNALK;

        // Count WNA PR
        var countWNAPR = 0;
        arrayBB.forEach(element => {
            countWNAPR += parseInt(document.getElementsByClassName(`JML_WNAPR${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_WNAPR`)[0].innerText = countWNAPR;

        // Count USIA 14
        var count14 = 0;
        arrayBB.forEach(element => {
            count14 += parseInt(document.getElementsByClassName(`JML_14${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_14`)[0].innerText = count14;

        // Count USIA 15-18
        var count1518 = 0;
        arrayBB.forEach(element => {
            count1518 += parseInt(document.getElementsByClassName(`JML_1518${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_1518`)[0].innerText = count1518;

        // Count USIA 19 - 24
        var count1924 = 0;
        arrayBB.forEach(element => {
            count1924 += parseInt(document.getElementsByClassName(`JML_1924${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_1924`)[0].innerText = count1924;

        // Count USIA 25 - 64
        var count2564 = 0;
        arrayBB.forEach(element => {
            count2564 += parseInt(document.getElementsByClassName(`JML_2564${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_2564`)[0].innerText = count2564;

        // Count USIA 65
        var count65 = 0;
        arrayBB.forEach(element => {
            count65 += parseInt(document.getElementsByClassName(`JML_65${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_65`)[0].innerText = count65;
        
        // Count Pendidikan Belum Diketahui
        var countTidakSekolah = 0;
        arrayBB.forEach(element => {
            countTidakSekolah += parseInt(document.getElementsByClassName(`JML_TidakSekolah${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_TidakSekolah`)[0].innerText = countTidakSekolah;
        
        // Count Pendidikan SD
        var countSD = 0;
        arrayBB.forEach(element => {
            countSD += parseInt(document.getElementsByClassName(`JML_SD${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_SD`)[0].innerText = countSD;
        
        // Count Pendidikan SMP
        var countSMP = 0;
        arrayBB.forEach(element => {
            countSMP += parseInt(document.getElementsByClassName(`JML_SMP${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_SMP`)[0].innerText = countSMP;
        
        // Count Pendidikan SMA
        var countSMA = 0;
        arrayBB.forEach(element => {
            countSMA += parseInt(document.getElementsByClassName(`JML_SMA${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_SMA`)[0].innerText = countSMA;
        
        // Count Pendidikan PT
        var countPT = 0;
        arrayBB.forEach(element => {
            countPT += parseInt(document.getElementsByClassName(`JML_PT${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_PT`)[0].innerText = countPT;
        
        // Count Pendidikan PT
        var countPT = 0;
        arrayBB.forEach(element => {
            countPT += parseInt(document.getElementsByClassName(`JML_PT${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_PT`)[0].innerText = countPT;
        
        // Count Pendidikan Belum Diketahui
        var countBelumDiketahui = 0;
        arrayBB.forEach(element => {
            countBelumDiketahui += parseInt(document.getElementsByClassName(`JML_BelumDiketahui${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_BelumDiketahui`)[0].innerText = countBelumDiketahui;

        // Count Pekerjaan Pelajar
        var countPelajar = 0;
        arrayBB.forEach(element => {
            countPelajar += parseInt(document.getElementsByClassName(`JML_Pelajar${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_Pelajar`)[0].innerText = countPelajar;

        // Count pekerjaan Mahasiswa
        var countMahasiswa = 0;
        arrayBB.forEach(element => {
            countMahasiswa += parseInt(document.getElementsByClassName(`JML_Mahasiswa${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_Mahasiswa`)[0].innerText = countMahasiswa;

        // Count Pekerjaan Swasta
        var countSwasta = 0;
        arrayBB.forEach(element => {
            countSwasta += parseInt(document.getElementsByClassName(`JML_Swasta${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_Swasta`)[0].innerText = countSwasta;

        // Count Pekerjaan Buruh Karyawan
        var countBuruhKaryawan = 0;
        arrayBB.forEach(element => {
            countBuruhKaryawan += parseInt(document.getElementsByClassName(`JML_BuruhKaryawan${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_BuruhKaryawan`)[0].innerText = countBuruhKaryawan;

        // Count Pekerjaan Petani Nelayan
        var countPetaniNelayan = 0;
        arrayBB.forEach(element => {
            countPetaniNelayan += parseInt(document.getElementsByClassName(`JML_PetaniNelayan${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_PetaniNelayan`)[0].innerText = countPetaniNelayan;

        // Count Pekerjaan Pedagang
        var countPedagang = 0;
        arrayBB.forEach(element => {
            countPedagang += parseInt(document.getElementsByClassName(`JML_Pedagang${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_Pedagang`)[0].innerText = countPedagang;

        // Count Pekerjaan Wiraswasta Pengusaha
        var countWiraswastaPengusaha = 0;
        arrayBB.forEach(element => {
            countWiraswastaPengusaha += parseInt(document.getElementsByClassName(`JML_WiraswastaPengusaha${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_WiraswastaPengusaha`)[0].innerText = countWiraswastaPengusaha;

        // Count Pekerjaan Sopir Tukang Ojek
        var countSopirTukangOjek = 0;
        arrayBB.forEach(element => {
            countSopirTukangOjek += parseInt(document.getElementsByClassName(`JML_SopirTukangOjek${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_SopirTukangOjek`)[0].innerText = countSopirTukangOjek;

        // Count Pekerjaan Ikut Orang Tua
        var countIkutOrangTua = 0;
        arrayBB.forEach(element => {
            countIkutOrangTua += parseInt(document.getElementsByClassName(`JML_IkutOrangTua${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_IkutOrangTua`)[0].innerText = countIkutOrangTua;

        // Count Pekerjaan Ibu Rumah Tangga
        var countIbuRumahTangga = 0;
        arrayBB.forEach(element => {
            countIbuRumahTangga += parseInt(document.getElementsByClassName(`JML_IbuRumahTangga${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_IbuRumahTangga`)[0].innerText = countIbuRumahTangga;

        // Count Pekerjaan Tidak Kerja
        var countTidakKerja = 0;
        arrayBB.forEach(element => {
            countTidakKerja += parseInt(document.getElementsByClassName(`JML_TidakKerja${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_TidakKerja`)[0].innerText = countTidakKerja;
 
        // Count Pekerjaan Notaris
        var countNotaris = 0;
        arrayBB.forEach(element => {
            countNotaris += parseInt(document.getElementsByClassName(`JML_Notaris${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_Notaris`)[0].innerText = countNotaris;

        // Count Pekerjaan TNI
        var countTNI = 0;
        arrayBB.forEach(element => {
            countTNI += parseInt(document.getElementsByClassName(`JML_TNI${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_TNI`)[0].innerText = countTNI;

        // Count Pekerjaan POLRI
        var countPOLRI = 0;
        arrayBB.forEach(element => {
            countPOLRI += parseInt(document.getElementsByClassName(`JML_POLRI${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_POLRI`)[0].innerText = countPOLRI;

        // Count Pekerjaan PNS
        var countPNS = 0;
        arrayBB.forEach(element => {
            countPNS += parseInt(document.getElementsByClassName(`JML_PNS${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_PNS`)[0].innerText = countPNS;

        // Count Pekerjaan PEMBANTU
        var countPEMBANTU = 0;
        arrayBB.forEach(element => {
            countPEMBANTU += parseInt(document.getElementsByClassName(`JML_PEMBANTU${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_PEMBANTU`)[0].innerText = countPEMBANTU;

        // Count Pekerjaan NAPI
        var countNAPI = 0;
        arrayBB.forEach(element => {
            countNAPI += parseInt(document.getElementsByClassName(`JML_NAPI${element}`)[0].innerText);
        });
        document.getElementsByClassName(`JKN_NAPI`)[0].innerText = countNAPI;

    });
</script>