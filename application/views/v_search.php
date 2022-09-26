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
    $CI->load->model('Modelkesatuan');
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4 py-4">
        <h2>Pencarian Data</h2>
        <div class="alert alert-warning" role="alert">
          Perhatian! Harap melakukan pencarian sesuai dengan format arahan!
        </div>
        <hr>
        <form action="<?= base_url("dashboard/searchData") ?>" method="post">
        <?php if($kategoriPencarian == 'nolp'){ ?>
          <input type="hidden" name="kategoriPencarian" value="nolp">
          <h4>Format Laporan Polisi :</h4>
          <select id="kesatuan" name="kesatuan" class="form-control" style="width:20%;">
            <option value="polres">Polres</option>
            <option value="polsek">Polsek</option>
          </select>
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
                <input type="text" name="tahunsurat" class="form-control datetimepicker-input" autocomplete="off" data-target="#tahunsurat" /><div class="input-group-append" data-target="#tahunsurat" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div>
                <p class="mb-0">/SPKT.</p><p class="mb-0">
                  <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER'): ?>
                    <?= $this->session->userdata('login_data_admin')['kode_lp'] ?></p>
                  <?php else: ?>
                    <select name="kode_kesatuan" class="form-control" data-live-search="true" required>
                      <?php foreach ($kesatuan as $keyKesatuan) { ?>
                        <option value="<?= $keyKesatuan['kode_lp'] ?>"><?= $keyKesatuan['kode_lp'] ?></option>
                      <?php } ?>
                    </select>
                  <?php endif; ?>
                <p class="mb-0">/POLDA JAWA TIMUR</p></div>
          </div>
          <button type="submit" class="btn btn-primary btn-sm">Cari <span><i class="fas fa-search"></i></span></button>
        <?php }else{ ?>
            <input type="hidden" name="kategoriPencarian" value="namatsk">
            <div class="form-group">
              <label for="">Tulis Nama Tersangka yang Ingin Anda Cari :</label>
              <input name="searchValue" type="text" class="form-control py-4" placeholder="Masukkan Nama Tersangka Disini. Contoh: Fajar Nugraha, Dwi Lestari, Budi, dsb." autocomplete="off" required>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Cari <span><i class="fas fa-search"></i></span></button>
        <?php } ?>
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
        <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER'): ?>
        document.getElementById('namaKesatuanPolsek').innerHTML = "<?= $this->session->userdata('login_data_admin')['nama'] ?>"
        <?php else: ?>
        document.getElementById('namaKesatuanPolsek').innerHTML = `<select name="kode_kesatuan" class="form-control" data-live-search="true" required><?php foreach ($kesatuan as $keyKesatuan) { ?><option value="<?= $keyKesatuan['nama'] ?>"><?= $keyKesatuan['nama'] ?></option><?php } ?></select>`
        <?php endif; ?>

        $('#tahunsuratpolsek').datetimepicker({
          viewMode: 'years',
          format: 'YYYY'
        });
      }else{
        $(`.formatPolsek`).remove();
        // Append Element Format LP Polres
        const formatLP = $(`<div class="d-flex align-items-center formatPolres"><p class="mb-0">LP/A/</p><input type="number" class="form-control" name="nosurat" id="nosurat" autocomplete="off" placeholder="" required style="width:10%;"><p class="mb-0">/</p><select name="bulansurat" id="bulansurat" class="form-control" style="width:10%;"><option selected disabled></option><option value="I">I</option><option value="II">II</option><option value="III">III</option><option value="IV">IV</option><option value="V">V</option><option value="VI">VI</option><option value="VII">VII</option><option value="VIII">VIII</option><option value="IX">IX</option><option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option></select><p class="mb-0">/</p><div class="input-group date" id="tahunsuratpolres" data-target-input="nearest" style="width:10%;"><input type="text" class="form-control datetimepicker-input" name="tahunsurat" data-target="#tahunsuratpolres" /><div class="input-group-append" data-target="#tahunsuratpolres" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div><p class="mb-0">/SPKT.</p><p class="mb-0" id="namaKesatuanPolres"></p><p class="mb-0">/POLDA JAWA TIMUR</p></div>`);

        $('#formatLP').append(formatLP);
        <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER'): ?>
          document.getElementById('namaKesatuanPolres').innerHTML = "<?= $this->session->userdata('login_data_admin')['kode_lp'] ?>";
        <?php else: ?>
          document.getElementById('namaKesatuanPolres').innerHTML = `<select name="kode_kesatuan" class="form-control" data-live-search="true" required><?php foreach ($kesatuan as $keyKesatuan) { ?><option value="<?= $keyKesatuan['kode_lp'] ?>"><?= $keyKesatuan['kode_lp'] ?></option><?php } ?></select>`;
        <?php endif; ?>
        
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
  