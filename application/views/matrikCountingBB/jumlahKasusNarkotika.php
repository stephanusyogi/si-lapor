<script>
    $(document).ready(function(){

        var arrayPsi = ["GOLIII", "GOLIV"];
        var arrayNar = ["Ganja","TembakauGorilla","Hashish","Opium","Morphin","HeroinPutaw","Kokain","ExstacyCarnophen","Sabu"];
        var arrayKes = ["DaftarG","Kosmetik","Jamu"];

        // Count JKN KSS
        var countPSI_JKN_KSS = 0;
        var countNAR_JKN_KSS = 0;
        var countKES_JKN_KSS = 0;
        arrayPsi.forEach(element => {
            countPSI_JKN_KSS += parseInt(document.getElementsByClassName(`JML_KSS${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_JKN_KSS += parseInt(document.getElementsByClassName(`JML_KSS${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_JKN_KSS += parseInt(document.getElementsByClassName(`JML_KSS${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_KSS`)[0].innerText = countPSI_JKN_KSS;
        document.getElementsByClassName(`NAR_KSS`)[0].innerText = countNAR_JKN_KSS;
        document.getElementsByClassName(`KES_KSS`)[0].innerText = countKES_JKN_KSS;

        // Count JKN TSK
        var countPSI_JKN_TSK = 0;
        var countNAR_JKN_TSK = 0;
        var countKES_JKN_TSK = 0;
        arrayPsi.forEach(element => {
            countPSI_JKN_TSK += parseInt(document.getElementsByClassName(`JML_TSK${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_JKN_TSK += parseInt(document.getElementsByClassName(`JML_TSK${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_JKN_TSK += parseInt(document.getElementsByClassName(`JML_TSK${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_TSK`)[0].innerText = countPSI_JKN_TSK;
        document.getElementsByClassName(`NAR_TSK`)[0].innerText = countNAR_JKN_TSK;
        document.getElementsByClassName(`KES_TSK`)[0].innerText = countKES_JKN_TSK;

        // Count JKN Selesai KSS
        var countPSI_JKN_SelesaiKSS = 0;
        var countNAR_JKN_SelesaiKSS = 0;
        var countKES_JKN_SelesaiKSS = 0;
        arrayPsi.forEach(element => {
            countPSI_JKN_SelesaiKSS += parseInt(document.getElementsByClassName(`JML_SelesaiKSS${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_JKN_SelesaiKSS += parseInt(document.getElementsByClassName(`JML_SelesaiKSS${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_JKN_SelesaiKSS += parseInt(document.getElementsByClassName(`JML_SelesaiKSS${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_SelesaiKSS`)[0].innerText = countPSI_JKN_SelesaiKSS;
        document.getElementsByClassName(`NAR_SelesaiKSS`)[0].innerText = countNAR_JKN_SelesaiKSS;
        document.getElementsByClassName(`KES_SelesaiKSS`)[0].innerText = countKES_JKN_SelesaiKSS;

        // Count WNI LK
        var countPSI_WNILK = 0;
        var countNAR_WNILK = 0;
        var countKES_WNILK = 0;
        arrayPsi.forEach(element => {
            countPSI_WNILK += parseInt(document.getElementsByClassName(`JML_WNILK${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_WNILK += parseInt(document.getElementsByClassName(`JML_WNILK${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_WNILK += parseInt(document.getElementsByClassName(`JML_WNILK${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_WNILK`)[0].innerText = countPSI_WNILK;
        document.getElementsByClassName(`NAR_WNILK`)[0].innerText = countNAR_WNILK;
        document.getElementsByClassName(`KES_WNILK`)[0].innerText = countKES_WNILK;

        // Count WNI PR
        var countPSI_WNIPR = 0;
        var countNAR_WNIPR = 0;
        var countKES_WNIPR = 0;
        arrayPsi.forEach(element => {
            countPSI_WNIPR += parseInt(document.getElementsByClassName(`JML_WNIPR${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_WNIPR += parseInt(document.getElementsByClassName(`JML_WNIPR${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_WNIPR += parseInt(document.getElementsByClassName(`JML_WNIPR${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_WNIPR`)[0].innerText = countPSI_WNIPR;
        document.getElementsByClassName(`NAR_WNIPR`)[0].innerText = countNAR_WNIPR;
        document.getElementsByClassName(`KES_WNIPR`)[0].innerText = countKES_WNIPR;

        // Count WNA LK
        var countPSI_WNALK = 0;
        var countNAR_WNALK = 0;
        var countKES_WNALK = 0;
        arrayPsi.forEach(element => {
            countPSI_WNALK += parseInt(document.getElementsByClassName(`JML_WNALK${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_WNALK += parseInt(document.getElementsByClassName(`JML_WNALK${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_WNALK += parseInt(document.getElementsByClassName(`JML_WNALK${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_WNALK`)[0].innerText = countPSI_WNALK;
        document.getElementsByClassName(`NAR_WNALK`)[0].innerText = countNAR_WNALK;
        document.getElementsByClassName(`KES_WNALK`)[0].innerText = countKES_WNALK;

        // Count WNA PR
        var countPSI_WNAPR = 0;
        var countNAR_WNAPR = 0;
        var countKES_WNAPR = 0;
        arrayPsi.forEach(element => {
            countPSI_WNAPR += parseInt(document.getElementsByClassName(`JML_WNAPR${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_WNAPR += parseInt(document.getElementsByClassName(`JML_WNAPR${element}`)[0].innerText);
        });
        arrayPsi.forEach(element => {
            countKES_WNAPR += parseInt(document.getElementsByClassName(`JML_WNAPR${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_WNAPR`)[0].innerText = countPSI_WNAPR;
        document.getElementsByClassName(`NAR_WNAPR`)[0].innerText = countNAR_WNAPR;
        document.getElementsByClassName(`KES_WNAPR`)[0].innerText = countKES_WNAPR;

        // Count USIA 14
        var countPSI_14 = 0;
        var countNAR_14 = 0;
        var countKES_14 = 0;
        arrayPsi.forEach(element => {
            countPSI_14 += parseInt(document.getElementsByClassName(`JML_14${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_14 += parseInt(document.getElementsByClassName(`JML_14${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_14 += parseInt(document.getElementsByClassName(`JML_14${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_14`)[0].innerText = countPSI_14;
        document.getElementsByClassName(`NAR_14`)[0].innerText = countNAR_14;
        document.getElementsByClassName(`KES_14`)[0].innerText = countKES_14;

        // Count USIA 15-18
        var countPSI_1518 = 0;
        var countNAR_1518 = 0;
        var countKES_1518 = 0;
        arrayPsi.forEach(element => {
            countPSI_1518 += parseInt(document.getElementsByClassName(`JML_1518${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_1518 += parseInt(document.getElementsByClassName(`JML_1518${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_1518 += parseInt(document.getElementsByClassName(`JML_1518${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_1518`)[0].innerText = countPSI_1518;
        document.getElementsByClassName(`NAR_1518`)[0].innerText = countNAR_1518;
        document.getElementsByClassName(`KES_1518`)[0].innerText = countKES_1518;

        // Count USIA 19 - 24
        var countPSI_1924 = 0;
        var countNAR_1924 = 0;
        var countKES_1924 = 0;
        arrayPsi.forEach(element => {
            countPSI_1924 += parseInt(document.getElementsByClassName(`JML_1924${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_1924 += parseInt(document.getElementsByClassName(`JML_1924${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_1924 += parseInt(document.getElementsByClassName(`JML_1924${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_1924`)[0].innerText = countPSI_1924;
        document.getElementsByClassName(`NAR_1924`)[0].innerText = countNAR_1924;
        document.getElementsByClassName(`KES_1924`)[0].innerText = countKES_1924;

        // Count USIA 25 - 64
        var countPSI_2564 = 0;
        var countNAR_2564 = 0;
        var countKES_2564 = 0;
        arrayPsi.forEach(element => {
            countPSI_2564 += parseInt(document.getElementsByClassName(`JML_2564${element}`)[0].innerText);
        });
        arrayPsi.forEach(element => {
            countNAR_2564 += parseInt(document.getElementsByClassName(`JML_2564${element}`)[0].innerText);
        });
        arrayPsi.forEach(element => {
            countKES_2564 += parseInt(document.getElementsByClassName(`JML_2564${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_2564`)[0].innerText = countPSI_2564;
        document.getElementsByClassName(`NAR_2564`)[0].innerText = countNAR_2564;
        document.getElementsByClassName(`KES_2564`)[0].innerText = countKES_2564;

        // Count USIA 65
        var countPSI_65 = 0;
        var countNAR_65 = 0;
        var countKES_65 = 0;
        arrayPsi.forEach(element => {
            countPSI_65 += parseInt(document.getElementsByClassName(`JML_65${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_65 += parseInt(document.getElementsByClassName(`JML_65${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_65 += parseInt(document.getElementsByClassName(`JML_65${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_65`)[0].innerText = countPSI_65;
        document.getElementsByClassName(`NAR_65`)[0].innerText = countNAR_65;
        document.getElementsByClassName(`KES_65`)[0].innerText = countKES_65;
        
        // Count Pendidikan Belum Diketahui
        var countPSI_TidakSekolah = 0;
        var countNAR_TidakSekolah = 0;
        var countKES_TidakSekolah = 0;
        arrayPsi.forEach(element => {
            countPSI_TidakSekolah += parseInt(document.getElementsByClassName(`JML_TidakSekolah${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_TidakSekolah += parseInt(document.getElementsByClassName(`JML_TidakSekolah${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_TidakSekolah += parseInt(document.getElementsByClassName(`JML_TidakSekolah${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_TidakSekolah`)[0].innerText = countPSI_TidakSekolah;
        document.getElementsByClassName(`NAR_TidakSekolah`)[0].innerText = countNAR_TidakSekolah;
        document.getElementsByClassName(`KES_TidakSekolah`)[0].innerText = countKES_TidakSekolah;
        
        // Count Pendidikan SD
        var countPSI_SD = 0;
        var countNAR_SD = 0;
        var countKES_SD = 0;
        arrayPsi.forEach(element => {
            countPSI_SD += parseInt(document.getElementsByClassName(`JML_SD${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_SD += parseInt(document.getElementsByClassName(`JML_SD${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_SD += parseInt(document.getElementsByClassName(`JML_SD${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_SD`)[0].innerText = countPSI_SD;
        document.getElementsByClassName(`NAR_SD`)[0].innerText = countNAR_SD;
        document.getElementsByClassName(`KES_SD`)[0].innerText = countKES_SD;
        
        // Count Pendidikan SMP
        var countPSI_SMP = 0;
        var countNAR_SMP = 0;
        var countKES_SMP = 0;
        arrayPsi.forEach(element => {
            countPSI_SMP += parseInt(document.getElementsByClassName(`JML_SMP${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_SMP += parseInt(document.getElementsByClassName(`JML_SMP${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_SMP += parseInt(document.getElementsByClassName(`JML_SMP${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_SMP`)[0].innerText = countPSI_SMP;
        document.getElementsByClassName(`NAR_SMP`)[0].innerText = countNAR_SMP;
        document.getElementsByClassName(`KES_SMP`)[0].innerText = countKES_SMP;
        
        // Count Pendidikan SMA
        var countPSI_SMA = 0;
        var countNAR_SMA = 0;
        var countKES_SMA = 0;
        arrayPsi.forEach(element => {
            countPSI_SMA += parseInt(document.getElementsByClassName(`JML_SMA${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_SMA += parseInt(document.getElementsByClassName(`JML_SMA${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_SMA += parseInt(document.getElementsByClassName(`JML_SMA${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_SMA`)[0].innerText = countPSI_SMA;
        document.getElementsByClassName(`NAR_SMA`)[0].innerText = countNAR_SMA;
        document.getElementsByClassName(`KES_SMA`)[0].innerText = countKES_SMA;
        
        // Count Pendidikan PT
        var countPSI_PT = 0;
        var countNAR_PT = 0;
        var countKES_PT = 0;
        arrayPsi.forEach(element => {
            countPSI_PT += parseInt(document.getElementsByClassName(`JML_PT${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_PT += parseInt(document.getElementsByClassName(`JML_PT${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_PT += parseInt(document.getElementsByClassName(`JML_PT${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_PT`)[0].innerText = countPSI_PT;
        document.getElementsByClassName(`NAR_PT`)[0].innerText = countNAR_PT;
        document.getElementsByClassName(`KES_PT`)[0].innerText = countKES_PT;
        
        // Count Pendidikan PT
        var countPSI_PT = 0;
        var countNAR_PT = 0;
        var countKES_PT = 0;
        arrayPsi.forEach(element => {
            countPSI_PT += parseInt(document.getElementsByClassName(`JML_PT${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_PT += parseInt(document.getElementsByClassName(`JML_PT${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_PT += parseInt(document.getElementsByClassName(`JML_PT${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_PT`)[0].innerText = countPSI_PT;
        document.getElementsByClassName(`NAR_PT`)[0].innerText = countNAR_PT;
        document.getElementsByClassName(`KES_PT`)[0].innerText = countKES_PT;
        
        // Count Pendidikan Belum Diketahui
        var countPSI_BelumDiketahui = 0;
        var countNAR_BelumDiketahui = 0;
        var countKESBelumDiketahui = 0;
        arrayPsi.forEach(element => {
            countPSI_BelumDiketahui += parseInt(document.getElementsByClassName(`JML_BelumDiketahui${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_BelumDiketahui += parseInt(document.getElementsByClassName(`JML_BelumDiketahui${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKESBelumDiketahui += parseInt(document.getElementsByClassName(`JML_BelumDiketahui${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_BelumDiketahui`)[0].innerText = countPSI_BelumDiketahui;
        document.getElementsByClassName(`NAR_BelumDiketahui`)[0].innerText = countNAR_BelumDiketahui;
        document.getElementsByClassName(`KES_BelumDiketahui`)[0].innerText = countKESBelumDiketahui;

        // Count Pekerjaan Pelajar
        var countPSI_Pelajar = 0;
        var countNAR_Pelajar = 0;
        var countKES_Pelajar = 0;
        arrayPsi.forEach(element => {
            countPSI_Pelajar += parseInt(document.getElementsByClassName(`JML_Pelajar${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_Pelajar += parseInt(document.getElementsByClassName(`JML_Pelajar${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_Pelajar += parseInt(document.getElementsByClassName(`JML_Pelajar${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_Pelajar`)[0].innerText = countPSI_Pelajar;
        document.getElementsByClassName(`NAR_Pelajar`)[0].innerText = countNAR_Pelajar;
        document.getElementsByClassName(`KES_Pelajar`)[0].innerText = countKES_Pelajar;

        // Count pekerjaan Mahasiswa
        var countPSI_Mahasiswa = 0;
        var countNAR_Mahasiswa = 0;
        var countKES_Mahasiswa = 0;
        arrayPsi.forEach(element => {
            countPSI_Mahasiswa += parseInt(document.getElementsByClassName(`JML_Mahasiswa${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_Mahasiswa += parseInt(document.getElementsByClassName(`JML_Mahasiswa${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_Mahasiswa += parseInt(document.getElementsByClassName(`JML_Mahasiswa${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_Mahasiswa`)[0].innerText = countPSI_Mahasiswa;
        document.getElementsByClassName(`NAR_Mahasiswa`)[0].innerText = countNAR_Mahasiswa;
        document.getElementsByClassName(`KES_Mahasiswa`)[0].innerText = countKES_Mahasiswa;

        // Count Pekerjaan Swasta
        var countPSI_Swasta = 0;
        var countNAR_Swasta = 0;
        var countKES_Swasta = 0;
        arrayPsi.forEach(element => {
            countPSI_Swasta += parseInt(document.getElementsByClassName(`JML_Swasta${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_Swasta += parseInt(document.getElementsByClassName(`JML_Swasta${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_Swasta += parseInt(document.getElementsByClassName(`JML_Swasta${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_Swasta`)[0].innerText = countPSI_Swasta;
        document.getElementsByClassName(`NAR_Swasta`)[0].innerText = countNAR_Swasta;
        document.getElementsByClassName(`KES_Swasta`)[0].innerText = countKES_Swasta;

        // Count Pekerjaan Buruh Karyawan
        var countPSI_BuruhKaryawan = 0;
        var countNAR_BuruhKaryawan = 0;
        var countKES_BuruhKaryawan = 0;
        arrayPsi.forEach(element => {
            countPSI_BuruhKaryawan += parseInt(document.getElementsByClassName(`JML_BuruhKaryawan${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_BuruhKaryawan += parseInt(document.getElementsByClassName(`JML_BuruhKaryawan${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_BuruhKaryawan += parseInt(document.getElementsByClassName(`JML_BuruhKaryawan${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_BuruhKaryawan`)[0].innerText = countPSI_BuruhKaryawan;
        document.getElementsByClassName(`NAR_BuruhKaryawan`)[0].innerText = countNAR_BuruhKaryawan;
        document.getElementsByClassName(`KES_BuruhKaryawan`)[0].innerText = countKES_BuruhKaryawan;

        // Count Pekerjaan Petani Nelayan
        var countPSI_PetaniNelayan = 0;
        var countNAR_PetaniNelayan = 0;
        var countKES_PetaniNelayan = 0;
        arrayPsi.forEach(element => {
            countPSI_PetaniNelayan += parseInt(document.getElementsByClassName(`JML_PetaniNelayan${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_PetaniNelayan += parseInt(document.getElementsByClassName(`JML_PetaniNelayan${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_PetaniNelayan += parseInt(document.getElementsByClassName(`JML_PetaniNelayan${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_PetaniNelayan`)[0].innerText = countPSI_PetaniNelayan;
        document.getElementsByClassName(`NAR_PetaniNelayan`)[0].innerText = countNAR_PetaniNelayan;
        document.getElementsByClassName(`KES_PetaniNelayan`)[0].innerText = countKES_PetaniNelayan;

        // Count Pekerjaan Pedagang
        var countPSI_Pedagang = 0;
        var countNAR_Pedagang = 0;
        var countKES_Pedagang = 0;
        arrayPsi.forEach(element => {
            countPSI_Pedagang += parseInt(document.getElementsByClassName(`JML_Pedagang${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_Pedagang += parseInt(document.getElementsByClassName(`JML_Pedagang${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_Pedagang += parseInt(document.getElementsByClassName(`JML_Pedagang${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_Pedagang`)[0].innerText = countPSI_Pedagang;
        document.getElementsByClassName(`NAR_Pedagang`)[0].innerText = countNAR_Pedagang;
        document.getElementsByClassName(`KES_Pedagang`)[0].innerText = countKES_Pedagang;

        // Count Pekerjaan Wiraswasta Pengusaha
        var countPSI_WiraswastaPengusaha = 0;
        var countNAR_WiraswastaPengusaha = 0;
        var countKES_WiraswastaPengusaha = 0;
        arrayPsi.forEach(element => {
            countPSI_WiraswastaPengusaha += parseInt(document.getElementsByClassName(`JML_WiraswastaPengusaha${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_WiraswastaPengusaha += parseInt(document.getElementsByClassName(`JML_WiraswastaPengusaha${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_WiraswastaPengusaha += parseInt(document.getElementsByClassName(`JML_WiraswastaPengusaha${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_WiraswastaPengusaha`)[0].innerText = countPSI_WiraswastaPengusaha;
        document.getElementsByClassName(`NAR_WiraswastaPengusaha`)[0].innerText = countNAR_WiraswastaPengusaha;
        document.getElementsByClassName(`KES_WiraswastaPengusaha`)[0].innerText = countKES_WiraswastaPengusaha;

        // Count Pekerjaan Sopir Tukang Ojek
        var countPSI_SopirTukangOjek = 0;
        var countNAR_SopirTukangOjek = 0;
        var countKES_SopirTukangOjek = 0;
        arrayPsi.forEach(element => {
            countPSI_SopirTukangOjek += parseInt(document.getElementsByClassName(`JML_SopirTukangOjek${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_SopirTukangOjek += parseInt(document.getElementsByClassName(`JML_SopirTukangOjek${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_SopirTukangOjek += parseInt(document.getElementsByClassName(`JML_SopirTukangOjek${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_SopirTukangOjek`)[0].innerText = countPSI_SopirTukangOjek;
        document.getElementsByClassName(`NAR_SopirTukangOjek`)[0].innerText = countNAR_SopirTukangOjek;
        document.getElementsByClassName(`KES_SopirTukangOjek`)[0].innerText = countKES_SopirTukangOjek;

        // Count Pekerjaan Ikut Orang Tua
        var countPSI_IkutOrangTua = 0;
        var countNAR_IkutOrangTua = 0;
        var countKES_IkutOrangTua = 0;
        arrayPsi.forEach(element => {
            countPSI_IkutOrangTua += parseInt(document.getElementsByClassName(`JML_IkutOrangTua${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_IkutOrangTua += parseInt(document.getElementsByClassName(`JML_IkutOrangTua${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_IkutOrangTua += parseInt(document.getElementsByClassName(`JML_IkutOrangTua${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_IkutOrangTua`)[0].innerText = countPSI_IkutOrangTua;
        document.getElementsByClassName(`NAR_IkutOrangTua`)[0].innerText = countNAR_IkutOrangTua;
        document.getElementsByClassName(`KES_IkutOrangTua`)[0].innerText = countKES_IkutOrangTua;

        // Count Pekerjaan Ibu Rumah Tangga
        var countPSI_IbuRumahTangga = 0;
        var countNAR_IbuRumahTangga = 0;
        var countKES_IbuRumahTangga = 0;
        arrayPsi.forEach(element => {
            countPSI_IbuRumahTangga += parseInt(document.getElementsByClassName(`JML_IbuRumahTangga${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_IbuRumahTangga += parseInt(document.getElementsByClassName(`JML_IbuRumahTangga${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_IbuRumahTangga += parseInt(document.getElementsByClassName(`JML_IbuRumahTangga${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_IbuRumahTangga`)[0].innerText = countPSI_IbuRumahTangga;
        document.getElementsByClassName(`NAR_IbuRumahTangga`)[0].innerText = countNAR_IbuRumahTangga;
        document.getElementsByClassName(`KES_IbuRumahTangga`)[0].innerText = countKES_IbuRumahTangga;

        // Count Pekerjaan Tidak Kerja
        var countPSI_TidakKerja = 0;
        var countNAR_TidakKerja = 0;
        var countKES_TidakKerja = 0;
        arrayPsi.forEach(element => {
            countPSI_TidakKerja += parseInt(document.getElementsByClassName(`JML_TidakKerja${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_TidakKerja += parseInt(document.getElementsByClassName(`JML_TidakKerja${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_TidakKerja += parseInt(document.getElementsByClassName(`JML_TidakKerja${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_TidakKerja`)[0].innerText = countPSI_TidakKerja;
        document.getElementsByClassName(`NAR_TidakKerja`)[0].innerText = countNAR_TidakKerja;
        document.getElementsByClassName(`KES_TidakKerja`)[0].innerText = countKES_TidakKerja;
 
        // Count Pekerjaan Notaris
        var countPSI_Notaris = 0;
        var countNAR_Notaris = 0;
        var countKES_Notaris = 0;
        arrayPsi.forEach(element => {
            countPSI_Notaris += parseInt(document.getElementsByClassName(`JML_Notaris${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_Notaris += parseInt(document.getElementsByClassName(`JML_Notaris${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_Notaris += parseInt(document.getElementsByClassName(`JML_Notaris${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_Notaris`)[0].innerText = countPSI_Notaris;
        document.getElementsByClassName(`NAR_Notaris`)[0].innerText = countNAR_Notaris;
        document.getElementsByClassName(`KES_Notaris`)[0].innerText = countKES_Notaris;

        // Count Pekerjaan TNI
        var countPSI_TNI = 0;
        var countNAR_TNI = 0;
        var countKES_TNI = 0;
        arrayPsi.forEach(element => {
            countPSI_TNI += parseInt(document.getElementsByClassName(`JML_TNI${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_TNI += parseInt(document.getElementsByClassName(`JML_TNI${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_TNI += parseInt(document.getElementsByClassName(`JML_TNI${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_TNI`)[0].innerText = countPSI_TNI;
        document.getElementsByClassName(`NAR_TNI`)[0].innerText = countNAR_TNI;
        document.getElementsByClassName(`KES_TNI`)[0].innerText = countKES_TNI;

        // Count Pekerjaan POLRI
        var countPSI_POLRI = 0;
        var countNAR_POLRI = 0;
        var countKES_POLRI = 0;
        arrayPsi.forEach(element => {
            countPSI_POLRI += parseInt(document.getElementsByClassName(`JML_POLRI${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_POLRI += parseInt(document.getElementsByClassName(`JML_POLRI${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_POLRI += parseInt(document.getElementsByClassName(`JML_POLRI${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_POLRI`)[0].innerText = countPSI_POLRI;
        document.getElementsByClassName(`NAR_POLRI`)[0].innerText = countNAR_POLRI;
        document.getElementsByClassName(`KES_POLRI`)[0].innerText = countKES_POLRI;

        // Count Pekerjaan PNS
        var countPSI_PNS = 0;
        var countNAR_PNS = 0;
        var countKES_PNS = 0;
        arrayPsi.forEach(element => {
            countPSI_PNS += parseInt(document.getElementsByClassName(`JML_PNS${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_PNS += parseInt(document.getElementsByClassName(`JML_PNS${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_PNS += parseInt(document.getElementsByClassName(`JML_PNS${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_PNS`)[0].innerText = countPSI_PNS;
        document.getElementsByClassName(`NAR_PNS`)[0].innerText = countNAR_PNS;
        document.getElementsByClassName(`KES_PNS`)[0].innerText = countKES_PNS;

        // Count Pekerjaan PEMBANTU
        var countPSI_PEMBANTU = 0;
        var countNAR_PEMBANTU = 0;
        var countKES_PEMBANTU = 0;
        arrayPsi.forEach(element => {
            countPSI_PEMBANTU += parseInt(document.getElementsByClassName(`JML_PEMBANTU${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_PEMBANTU += parseInt(document.getElementsByClassName(`JML_PEMBANTU${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_PEMBANTU += parseInt(document.getElementsByClassName(`JML_PEMBANTU${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_PEMBANTU`)[0].innerText = countPSI_PEMBANTU;
        document.getElementsByClassName(`NAR_PEMBANTU`)[0].innerText = countNAR_PEMBANTU;
        document.getElementsByClassName(`KES_PEMBANTU`)[0].innerText = countKES_PEMBANTU;

        // Count Pekerjaan NAPI
        var countPSI_NAPI = 0;
        var countNAR_NAPI = 0;
        var countKES_NAPI = 0;
        arrayPsi.forEach(element => {
            countPSI_NAPI += parseInt(document.getElementsByClassName(`JML_NAPI${element}`)[0].innerText);
        });
        arrayNar.forEach(element => {
            countNAR_NAPI += parseInt(document.getElementsByClassName(`JML_NAPI${element}`)[0].innerText);
        });
        arrayKes.forEach(element => {
            countKES_NAPI += parseInt(document.getElementsByClassName(`JML_NAPI${element}`)[0].innerText);
        });
        document.getElementsByClassName(`PSI_NAPI`)[0].innerText = countPSI_NAPI;
        document.getElementsByClassName(`NAR_NAPI`)[0].innerText = countNAR_NAPI;
        document.getElementsByClassName(`KES_NAPI`)[0].innerText = countKES_NAPI;

    });
</script>