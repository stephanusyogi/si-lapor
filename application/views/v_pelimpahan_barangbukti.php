  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid pt-2">
        <div class="alert alert-warning" role="alert">
          Silahkan mengisi data barang bukti pada formulir dibawah ini. Harap mengisi data dengan benar dan akurat !
        </div>
        <div class="row">
          <div class="col-md-8">
            <h3>Data Barang Bukti</h3>
            <h5>Kasus No. Laporan Polisi : <strong><?= $dataKasus['no_laporanpolisi'] ?></strong></h5>
          </div>
          <div class="col-md-4">
            <h3>Identitas Tersangka :</h3>
            <p class="mb-0"><strong>Nama : </strong><?= $dataTersangka['nama'] ?></p>
            <p class="mb-0"><strong>NIK : </strong><?= $dataTersangka['nik'] ?></p>
            <p class="mb-0"><strong>Status Tersangka : </strong><?= $dataTersangka['status'] ?></p>
          </div>
        </div>
        <hr>
        <form action="<?= base_url("pelimpahan/addBarangBukti/{$dataKasus['id_kasus']}") ?>" method="POST">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="kategori">Kategori BB</label>
                  <select name="kategori" id="kategori" class="form-control" required>
                    <option selected disabled>Pilih Barang Bukti</option>
                    <optgroup label="Narkotika & Psikotropika">
                        <option value="Ganja">Ganja</option>
                        <option value="Tembakau Gorilla">Tembakau Gorilla</option>
                        <option value="Hashish">Hashish</option>
                        <option value="Opium">Opium</option>
                        <option value="Morphin">Morphin</option>
                        <option value="Heroin/Putaw">Heroin/Putaw</option>
                        <option value="Kokain">Kokain</option>
                        <option value="Exstacy/Carnophen">Exstacy/Carnophen</option>
                        <option value="Sabu">Sabu</option>
                        <option value="GOL IV">GOL IV</option>
                    </optgroup>
                    <optgroup label="Okerbaya">
                        <option value="Daftar G">Daftar G</option>
                        <option value="Jamu">Jamu</option>
                        <option value="Kosmetik">Kosmetik</option>
                    </optgroup>
                    <optgroup label="Lainnya">
                        <option value="Lain-lain">Barang Bukti Lain...</option>
                    </optgroup>
                  </select>
                </div>
              </div>
            </div>
            <div id="formBarangBukti"></div>
            <div class="d-flex justify-content-center">
              <button id="submitBB" class="btn btn-info" type="submit" disabled><i class="fas fa-plus-circle"></i> Tambah Barang Bukti</button>
            </div>
          </form>
        <hr>
        <table id="table-full-fitur" class="table datatable table-bordered table-striped " style="width:100%">
          <thead>
              <tr>
                  <th>Action</th>
                  <th>Nama</th>
                  <th>Jumlah</th>
                  <th>Satuan</th>
              </tr>
          </thead>
          <tbody>
          <?php if(isset($dataBarangBukti)){ ?>
            <?php foreach ($dataBarangBukti as $row) { ?>
              <tr>
                <td class="text-center" style="font-size:18px;">
                  <a class="hapus-barang-bukti mx-1" href="<?= base_url("pelimpahan/delBarangBukti/{$row['id_barangbukti']}/{$dataKasus['id_kasus']}/{$dataTersangka['id_tersangka']}") ?>"><i class="fas fa-trash" style="color:red;"></i></a>
                </td>
                <td><?= $row['nama_barangbukti'] ?>&nbsp;<?= ($row['keterangan']) ? "dengan keterangan : ( {$row['keterangan']} )" : '' ?>&nbsp;<?= ($row['berat']) ? "& berat {$row['berat']} gram" : '' ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['satuan'] ?></td>
              </tr>
            <?php } ?>
          <?php }else{?>
                <tr>
                    <td colspan="4" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Barang Bukti Belum Tersedia</p></td>
                    <td style="display: none"></td>
                    <td style="display: none"></td>
                    <td style="display: none"></td>
                </tr>
          <?php } ?>
          </tbody>
        </table>
        <div class="py-4 row">
            <div class="col-md-8">
            </div>
            <div class="col-md-4 text-right">
                <a href="<?= base_url("data-tersangka-pelimpahan/{$dataKasus['id_kasus']}") ?>" class="btn btn-secondary">Kembali ke Data Tersangka</a>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<script>
  $(document).ready(function() {
    
    $(".hapus-barang-bukti").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Hapus Barang Bukti?",
        text: "Menghapus data bersifat permanen pada database, mohon berhati-hati.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Delete!",
      }).then((result) => {
        if (result.isConfirmed) {
          document.location.href = href;
        }
      });
    });

    $('#kategori').on('change', function() {
        $(`.formBB`).remove();

        let valNamaBarangBukti, valSatuan, statusInput, divForm, inputSatuan, inputKeterangan, inputBerat;
        const idTersangka = <?= $dataTersangka['id_tersangka'] ?>;
        
        switch (this.value) {
            case 'Ganja' :
                valNamaBarangBukti = this.value;
                valSatuan = 'gram';
                statusInput = 'readonly';
                inputSatuan = `<label for="satuanGanja">Satuan</label><select class="form-control" name="satuanGanja" id="satuan"><option value="gram">gram</option><option value="batang">batang</option></select>`;
                inputKeterangan = '';
                inputBerat = '';

                break;
            case 'Tembakau Gorilla' :
            case 'Hashish' :
            case 'Opium' :
            case 'Morphin' :
            case 'Heroin/Putaw' :
            case 'Kokain' :
            case 'Sabu' :
            case 'Kokain' :
            case 'Sabu' :
                valNamaBarangBukti = this.value;
                valSatuan = 'gram';
                statusInput = 'readonly';
                inputSatuan = `<label for="satuan">Satuan</label><input class="form-control" type="text" name="satuan" id="satuan" placeholder="Masukkan Satuan Barang Bukti" value="${valSatuan}" autocomplete="off" required ${statusInput}>`;
                inputKeterangan = '';
                inputBerat = '';
                break;
                
            case 'GOL IV' :
            case 'Daftar G' :
                valNamaBarangBukti = this.value;
                valSatuan = 'butir';
                statusInput = 'readonly';
                inputSatuan = `<label for="satuan">Satuan</label><input class="form-control" type="text" name="satuan" id="satuan" placeholder="Masukkan Satuan Barang Bukti" value="${valSatuan}" required ${statusInput}>`;
                inputKeterangan = `<label for="keterangan">Keterangan</label><input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan"  autocomplete="off" required>`;
                inputBerat = ``;
                break;
                
            case 'Exstacy/Carnophen' :
                valNamaBarangBukti = this.value;
                valSatuan = 'butir';
                statusInput = 'readonly';
                inputSatuan = `<label for="satuanEkstasi">Jenis - Satuan</label><select class="form-control" name="satuanEkstasi" id="satuanEkstasi"><option value="butir">Tablet <small>(butir)</small></option><option value="gram">Serbuk <small>(gram)</small></option></select>`;
                inputKeterangan = `<label for="keterangan">Keterangan</label><input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan"  autocomplete="off" required>`;
                inputBerat = ``;
                break;

            case 'Kosmetik' :
            case 'Jamu' :
                valNamaBarangBukti = this.value;
                valSatuan = 'buah';
                statusInput = 'readonly';
                inputSatuan = `<label for="satuan">Satuan</label><input class="form-control" type="text" name="satuan" id="satuan" placeholder="Masukkan Satuan Barang Bukti" value="${valSatuan}" required ${statusInput}>`;inputKeterangan = `<label for="keterangan">Keterangan</label><input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan"  autocomplete="off" required>`;
                inputBerat = ``;
                break;

            default:
                valNamaBarangBukti = '';
                valSatuan = '';
                statusInput = '';
                inputSatuan = `  <label for="satuan">Satuan</label><input class="form-control" type="text" name="satuan" id="satuan" placeholder="Masukkan Satuan Barang Bukti"  autocomplete="off" value="${valSatuan}" required ${statusInput}>`;
                inputKeterangan = `<label for="keterangan">Keterangan</label><input type="text" class="form-control" name="keterangan" id="keterangan" autocomplete="off" placeholder="Masukkan Keterangan">`;
                inputBerat = `<label for="berat">Berat</label><small> (gram)</small><input class="form-control" type="number"  step="0.001" name="berat" id="berat" placeholder="Masukkan Berat Barang Bukti">`;

                break;
        }
        
        divForm = $(`<div class="row form-group formBB"><div class="col-md-6"><input type="hidden" name="id_tersangka" value="${idTersangka}"><label for="nama_barangbukti">Nama Barang Bukti</label><input class="form-control" type="text"  autocomplete="off" name="nama_barangbukti" id="nama_barangbukti" placeholder="Masukkan Nama Barang Bukti" value="${valNamaBarangBukti}" required ${statusInput}>${inputKeterangan}</div><div class="col-md-6"><label for="jumlah">Jumlah</label><input class="form-control" type="number" step="0.001" name="jumlah" id="jumlah" placeholder="Masukkan Jumlah Barang Bukti" required>${inputSatuan}${inputBerat}</div></div>`);

        $('#formBarangBukti').append(divForm);

        $('#submitBB').prop('disabled', false);
    });
  });
</script>