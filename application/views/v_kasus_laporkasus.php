  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid pt-2">
        <div class="alert alert-warning" role="alert">
          Silahkan mengisi formulir dibawah ini. Harap mengisi data dengan benar dan akurat !
        </div>
        <div class="alert alert-info" role="alert">
          Setelah mengisi deskripsi LP, harap segera dilanjutkan dengan mengisi identitas tersangka dan barangbukti!
        </div>
        <form action="<?= base_url() ?>kasus/addKasus" method="post">
          <h4>Kesatuan :</h4>
          <select id="kesatuan" name="kesatuan" class="form-control" style="width:20%;">
            <option value="polres">Polres</option>
            <option value="polsek">Polsek</option>
          </select>
          <hr>
          <div class="form-group">
              <label for="nolp">Nomor Laporan Polisi</label>
              <div id="formatLP"></div>
              <div class="d-flex align-items-center formatPolres">
                <p class="mb-0">LP/A/</p>
                <input type="number" class="form-control" name="nosurat" id="nosurat" autocomplete="off" placeholder="" required style="width:10%;">
                <p class="mb-0">/</p>
                <select id="bulansurat" name="bulansurat" class="form-control" style="width:10%;"><option selected disabled></option><option value="I">I</option><option value="II">II</option><option value="III">III</option><option value="IV">IV</option><option value="V">V</option><option value="VI">VI</option><option value="VII">VII</option><option value="VIII">VIII</option><option value="IX">IX</option><option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option></select>
                <p class="mb-0">/</p>
                <div class="input-group date" id="tahunsurat" data-target-input="nearest" style="width:10%;">
                <input type="text" name="tahunsurat" class="form-control datetimepicker-input" data-target="#tahunsurat" /><div class="input-group-append" data-target="#tahunsurat" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div>
                <p class="mb-0">/SPKT.</p><p class="mb-0"><?= $this->session->userdata('login_data_admin')['kode_lp'] ?></p><p class="mb-0">/POLDA JAWA TIMUR</p></div>
          </div>
          <div class="form-group">
            <label for="tkp">Tempat Kejadian Perkara</label>
            <select name="tkp" id="tkp" class="form-control w-50" required>
              <option selected disabled>Pilih TKP</option>
              <option value="Hotel/Villa/Kos">Hotel / Villa / Kos</option>
              <option value="Ruko/Gedung/Mall/Pabrik">Ruko / Gedung / Mall / Pabrik</option>
              <option value="Tempat Umum">Tempat Umum</option>
              <option value="Pemukiman/Pondok">Pemukiman / Pondok</option>
              <option value="Diskotik/Tempat Karaoke">Diskotik / Tempat Karaoke</option>
              <option value="Terminal/Bandara/Pelabuhan">Terminal / Bandara / Pelabuhan</option>
              <option value="Rumah Tahanan">Rumah Tahanan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="deskripsi_waktudantkp">Keterangan Deskripsi Waktu & Tempat Kejadian</label>
            <textarea class="form-control" name="deskripsi_waktudantkp" id="deskripsi_waktudantkp" rows="5" required placeholder="Tulis keterangan perkara disini"></textarea>
          </div>
          <div class="form-group">
            <label for="pasal">Pasal</label>
            <textarea class="form-control" name="pasal" id="pasal" rows="5" required placeholder="Tulis keterangan pasal yang ditangguhkan disini"></textarea>
          </div>  
          <div class="text-right mb-2">
            <button type="submit" class="btn btn-secondary">Simpan Data & Lanjutkan</button>
          </div>
        </form>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script>
  $(document).ready(function() {
    $('#kesatuan').on('change', function() {
      
      // alert( this.value );
      if (this.value == 'polsek') {
        $(`.formatPolres`).remove();
        // Append Element Format LP Polsek
        const formatLP = $(`<div class="d-flex align-items-center formatPolsek"><p class="mb-0">LP/A/</p><input type="number" class="form-control" name="nosurat" id="nosurat" autocomplete="off" placeholder="" required style="width:10%;"><p class="mb-0">/</p><select name="bulansurat" id="bulansurat" class="form-control" style="width:10%;"><option selected disabled></option><option value="I">I</option><option value="II">II</option><option value="III">III</option><option value="IV">IV</option><option value="V">V</option><option value="VI">VI</option><option value="VII">VII</option><option value="VIII">VIII</option><option value="IX">IX</option><option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option></select><p class="mb-0">/</p><div class="input-group date" id="tahunsuratpolsek" data-target-input="nearest" style="width:10%;"><input type="text" class="form-control" name="tahunsurat" datetimepicker-input" data-target="#tahunsuratpolsek" /><div class="input-group-append" data-target="#tahunsuratpolsek" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div><p class="mb-0">/SPKT/</p><input type="text" name="namapolsek" class="form-control" id="namapolsek" autocomplete="off" placeholder="Nama Polsek" required style="width:20%;text-transform:uppercase;"><p class="mb-0">/</p><p class="mb-0" id="namaKesatuanPolsek"></p><p class="mb-0">/POLDA JAWA TIMUR</p></div>`);

        $('#formatLP').append(formatLP);
        document.getElementById('namaKesatuanPolsek').innerHTML = "<?= $this->session->userdata('login_data_admin')['nama'] ?>"

        $('#tahunsuratpolsek').datetimepicker({
          viewMode: 'years',
          format: 'YYYY'
        });
      }else{
        $(`.formatPolsek`).remove();
        // Append Element Format LP Polres
        const formatLP = $(`<div class="d-flex align-items-center formatPolres"><p class="mb-0">LP/A/</p><input type="number" class="form-control" name="nosurat" id="nosurat" autocomplete="off" placeholder="" required style="width:10%;"><p class="mb-0">/</p><select name="bulansurat" id="bulansurat" class="form-control" style="width:10%;"><option selected disabled></option><option value="I">I</option><option value="II">II</option><option value="III">III</option><option value="IV">IV</option><option value="V">V</option><option value="VI">VI</option><option value="VII">VII</option><option value="VIII">VIII</option><option value="IX">IX</option><option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option></select><p class="mb-0">/</p><div class="input-group date" id="tahunsuratpolres" data-target-input="nearest" style="width:10%;"><input type="text" class="form-control datetimepicker-input" name="tahunsurat" data-target="#tahunsuratpolres" /><div class="input-group-append" data-target="#tahunsuratpolres" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div><p class="mb-0">/SPKT.</p><p class="mb-0" id="namaKesatuanPolres"></p><p class="mb-0">/POLDA JAWA TIMUR</p></div>`);

        $('#formatLP').append(formatLP);
        document.getElementById('namaKesatuanPolres').innerHTML = "<?= $this->session->userdata('login_data_admin')['kode_lp'] ?>"
        
        $('#tahunsuratpolres').datetimepicker({
          viewMode: 'years',
          format: 'YYYY'
        });
      }
    });
    
    $(function () {
      $('#tahunsurat').datetimepicker({
          viewMode: 'years',
          format: 'YYYY'
        });
    });
  });
</script>