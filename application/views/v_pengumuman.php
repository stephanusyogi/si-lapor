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
    .section-pengumuman{
      height: 30rem;
      overflow-y: scroll;
    }
    .pengumuman-title{
      position:relative;
    }
    .btn-action{
      position:absolute;
      right: 15px;
      top:15px;
    }
  </style>
  
  <!-- DATA -->
  <?php 
    $CI =& get_instance();
    $CI->load->model('Modelpengumuman');
    $CI->load->model('Modelkesatuan');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4 py-2">
        <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>

          <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><span><i class="fas fa-plus"></i></span> Tambah Pengumuman</button>
          <!-- Modal Add Pengumuman -->
          <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addModalLabel">Tambah Pengumuman</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="<?= base_url('pengumuman/addPengumuman') ?>" method="post" enctype="multipart/form-data">
                  <div class="modal-body py-2">
                    <div class="form-group">
                      <label for="">Judul</label>
                      <input type="text" name="judul" class="form-control" placeholder="Masukkan Judul Pengumuman" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                      <label for="">Deskripsi</label>
                      <textarea class="form-control" name="deskripsi" rows="10" placeholder="Masukkan Deskripsi Pengumuman" autocomplete="off" required></textarea>
                    </div>
                    <div class="form-group">
                      <label for="">Upload File <small style="color:red;">*opsional</small></label>
                      <input type="file" class="form-control" name="nama_file" id="file">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Publish</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <hr>
          <div class="container">
            <div class="section-pengumuman card">
              <div class="card-body">
                <h3 class="mb-4">Pengumuman</h3>
                <?php 
                if(!empty($dataPengumuman)){
                foreach($dataPengumuman as $keyPengumuman){ ?>
                  <div class="accordion" id="accordion<?= $keyPengumuman['id_pengumuman'] ?>">
                      <div class="card">
                        <div class="card-header pengumuman-title" id="heading<?= $keyPengumuman['id_pengumuman'] ?>">
                          <h2 class="mb-0">
                            <button class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?= $keyPengumuman['id_pengumuman'] ?>" aria-expanded="true" aria-controls="collapseOne">
                              <?= $keyPengumuman['judul'] ?>
                              <br>
                              <small><?= $keyPengumuman['created_at'] ?></small>
                            </button>
                          </h2>
                          <div class="btn-action">
                            <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#belumBacaModal<?= $keyPengumuman['id_pengumuman'] ?>"><i class="fas fa-eye"></i></a>
                            <a href="<?= base_url() ?>pengumuman/delPengumuman/<?= $keyPengumuman['id_pengumuman'] ?>" class="btn btn-danger btn-sm delBtn" data-toggle="tooltip" data-placement="top" title="Hapus Pengumuman"><i class="fas fa-trash"></i></a>
                          </div>
                        </div>
                        <!-- Modal Belum Baca -->
                        <div class="modal fade" id="belumBacaModal<?= $keyPengumuman['id_pengumuman'] ?>" tabindex="-1" aria-labelledby="belumBacaModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="belumBacaModalLabel">Daftar Jajaran Belum Baca Pengumuman</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <?php $dataBelumBaca =  $CI->Modelpengumuman->getBelumBaca($keyPengumuman['id_pengumuman']);
                                  $no = 1;?>
                                    <?php foreach ($dataBelumBaca as $keyBelumBaca) { ?>
                                      <div class="col-md-3 text-left">
                                        <?php $dataKesatuan =  $CI->Modelkesatuan->getKesatuanByKode($keyBelumBaca['kode_kesatuan']);?>
                                        <h5><?= $no.". ".$dataKesatuan[0]["nama"] ?></h5>
                                      </div>
                                    <?php $no++; } ?>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="collapse<?= $keyPengumuman['id_pengumuman'] ?>" class="collapse" aria-labelledby="heading<?= $keyPengumuman['id_pengumuman'] ?>" data-parent="#accordion<?= $keyPengumuman['id_pengumuman'] ?>">
                          <div class="card-body text-justify">
                            <?= $keyPengumuman['deskripsi'] ?>
                            <?php if(!empty($keyPengumuman['nama_file'])): ?>
                            <br>
                            <br>
                            <a href="<?= base_url() ?>pengumuman/downloadFile/<?= $keyPengumuman['id_pengumuman'] ?>"><span><i class="fas fa-download"></i></span> Download File</a>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                  </div>
                <?php } }else{ ?>
                  <h2 class="text-center">Data Belum Tersedia</h2>
                <?php } ?>
              </div>
            </div>
          </div>

        <?php }else{ ?>

        <div class="container">
          <div class="section-pengumuman card">
            <div class="card-body">
              <?php 
              if(!empty($dataPengumuman)){
              foreach($dataPengumuman as $keyPengumuman){ ?>
                <div class="accordion" id="accordion<?= $keyPengumuman['id_pengumuman'] ?>">
                    <div class="card">
                      <div class="card-header pengumuman-title" id="heading<?= $keyPengumuman['id_pengumuman'] ?>">
                        <h2 class="mb-0">
                          <button id="titleCard<?= $keyPengumuman['id_pengumuman'] ?>" class="btn btn-block text-left <?= (!$keyPengumuman['isRead']) ? 'font-weight-bold' : '' ?>" type="button" data-toggle="collapse" data-target="#collapse<?= $keyPengumuman['id_pengumuman'] ?>" aria-expanded="true" aria-controls="collapseOne" onclick=readPengumuman(<?= $keyPengumuman['id_pengumuman'] ?>,<?= $keyPengumuman['id_pengumuman_tujuan'] ?>)>
                            <?= $keyPengumuman['judul'] ?>
                            <br>
                            <small><?= $keyPengumuman['created_at'] ?></small>
                          </button>
                        </h2>
                        <div class="btn-action">
                          <a href="<?= base_url() ?>pengumuman/delPengumumanTujuan/<?= $keyPengumuman['id_pengumuman_tujuan'] ?>" class="btn btn-danger btn-sm delBtn" data-toggle="tooltip" data-placement="top" title="Hapus Pengumuman"><i class="fas fa-trash"></i></a>
                        </div>
                      </div>
                      <div id="collapse<?= $keyPengumuman['id_pengumuman'] ?>" class="collapse" aria-labelledby="heading<?= $keyPengumuman['id_pengumuman'] ?>" data-parent="#accordion<?= $keyPengumuman['id_pengumuman'] ?>">
                        <div class="card-body text-justify">
                          <?= $keyPengumuman['deskripsi'] ?>
                          <?php if(!empty($keyPengumuman['nama_file'])): ?>
                          <br>
                          <br>
                          <a href="<?= base_url() ?>pengumuman/downloadFile/<?= $keyPengumuman['id_pengumuman'] ?>"><span><i class="fas fa-download"></i></span> Download File</a>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                </div>
              <?php } }else{ ?>
                <h2 class="text-center">Data Belum Tersedia</h2>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <script>
  function readPengumuman(id, idTujuan){
    var titlePengumuman = document.getElementById(`titleCard${id}`);
    if (titlePengumuman.classList.contains("font-weight-bold")) {
      titlePengumuman.classList.remove("font-weight-bold");
      
      var xhrPengumuman = new XMLHttpRequest();
      xhrPengumuman.open("POST", `<?= base_url() ?>pengumuman/bacaPengumuman/${idTujuan}`, true);
      xhrPengumuman.onload = () => {
          if (xhrPengumuman.readyState === XMLHttpRequest.DONE) {
              if (xhrPengumuman.status === 200) {
                const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  showCloseButton: true,
                  timer: 5000
                });

                Toast.fire({
                  icon: 'success',
                  title: 'Pengumuman Berhasil Dibaca'
                })
              }
          }
      }
      xhrPengumuman.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhrPengumuman.send();
    }
  }
  $(document).ready(function() {
    $(".delBtn").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Hapus Pengumuman?",
        text: "Menghapus pengumuman bersifat permanen pada database, mohon berhati-hati.",
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
  });
  </script>