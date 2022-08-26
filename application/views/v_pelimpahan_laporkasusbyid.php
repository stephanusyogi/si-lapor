  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid pt-2">
        <div class="alert alert-warning" role="alert">
          Silahkan mengisi formulir dibawah ini. Harap mengisi data dengan benar dan akurat !
        </div>
        <h5>Kasus Pelimpahan No. Laporan Polisi :</h5>
        <h4><strong><?= $dataKasus['no_laporanpolisi'] ?></strong></h4>
        <form action="<?= base_url() ?>pelimpahan/updateKasus/<?= $dataKasus['id_kasus'] ?>" method="post">
          <div class="form-group">
            <label for="tkp">Tempat Kejadian Perkara</label>
            <select name="tkp" id="tkp" class="form-control w-50" required>
                <option value="<?= $dataKasus['tkp'] ?>" selected><?= $dataKasus['tkp'] ?></option>
              <option disabled>Pilih TKP</option>
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
            <textarea class="form-control" name="deskripsi_waktudantkp" id="deskripsi_waktudantkp" rows="5" required placeholder="Tulis keterangan perkara disini"><?= $dataKasus['deskripsi_waktudantkp'] ?></textarea>
          </div>
          <div class="form-group">
            <label for="pasal">Pasal</label>
            <textarea class="form-control" name="pasal" id="pasal" rows="5" required placeholder="Tulis keterangan pasal yang ditangguhkan disini"><?= $dataKasus['pasal'] ?></textarea>
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
