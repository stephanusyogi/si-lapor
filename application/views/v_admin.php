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
    .fa-eye:hover{
      cursor: pointer;
    }
  </style>
    
  <!-- DATA -->
  <?php 
    $CI =& get_instance();
    $CI->load->model('Modelkesatuan');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4 py-2">
        <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>

          <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fas fa-user-plus"></i>&nbsp;Tambah Administrator</a>
          <hr>

          <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="admin-tab" data-toggle="tab" data-target="#admin" type="button" role="tab" aria-controls="admin" aria-selected="true">Basic Admin</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="superadmin-tab" data-toggle="tab" data-target="#superadmin" type="button" role="tab" aria-controls="superadmin" aria-selected="false">Super Admin</button>
          </li>
          <!-- <li class="nav-item" role="presentation">
            <button class="nav-link" id="principal-tab" data-toggle="tab" data-target="#principal" type="button" role="tab" aria-controls="principal" aria-selected="false">Principal Admin</button>
          </li> -->
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active py-3" id="admin" role="tabpanel" aria-labelledby="admin-tab">
            <table class="table table-pelimpahan datatable table-bordered table-striped" style="width:100%">
                <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Action</th>
                      <th>Nama Administrator</th>
                      <th>NRP</th>
                      <th>Kesatuan</th>
                      <th>No. Telepon</th>
                      <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($dataAdmin)){ ?>
                    <?php 
                        $no = 1;
                        foreach ($dataAdmin as $row_admin) { ?>
                    <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td class="text-center">
                          <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $row_admin['id_admin'] ?>"><i class="fas fa-edit"></i></a>
                          <a href="<?= base_url() ?>admin/delAdmin/<?= $row_admin['id_admin'] ?>" class="btn btn-danger btn-sm hapus-admin"><i class="fas fa-trash"></i></a>
                        </td>
                        <td><?= $row_admin['nama_admin'] ?></td>
                        <td><?= $row_admin['nrp'] ?></td>
                        <td>
                        <?php $choosenKesatuan = $CI->Modelkesatuan->getKesatuanByKode($row_admin['kode_kesatuan']); ?>
                          <?= $choosenKesatuan[0]['nama'] ?>
                        </td>
                        <td><?= $row_admin['notelp'] ?></td>
                        <td><?= $row_admin['created_at'] ?></td>
                    </tr>
                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal<?= $row_admin['id_admin'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Administrator</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="<?= base_url() ?>admin/editAdmin/<?= $row_admin['id_admin'] ?>" method="post">
                            <div class="modal-body">
                              <input type="hidden" name="kode_kesatuan" value="<?= $row_admin['kode_kesatuan'] ?>">
                              <div class="form-group">
                                <label for="">Nama :</label>
                                <input type="text" name="nama_admin" class="form-control" autocomplete="off" placeholder="Masukkan Nama Admin" required value="<?= $row_admin['nama_admin'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="">NRP :</label>
                                <input type="text" name="nrp" class="form-control" autocomplete="off" placeholder="Masukkan NRP Admin" required value="<?= $row_admin['nrp'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="">No. Telepon :</label>
                                <input type="text" name="notelp" class="form-control" autocomplete="off" placeholder="Masukkan No. Telepeon Admin" required value="<?= $row_admin['notelp'] ?>">
                              </div>
                              <div class="form-group ">
                                <label for="">Ubah Password :</label>
                                <div class="input-group">
                                  <input type="password" id="passwordEdit<?= $row_admin['id_admin'] ?>" name="password" class="form-control" autocomplete="off" placeholder="Masukkan Password Admin">
                                  <div class="input-group-append">
                                    <div class="input-group-text">
                                      <script>
                                          function pswVisibiltyEdit(id){
                                            var x = document.getElementById(`passwordEdit${id}`);
                                            if (x.type === "password") {
                                              x.type = "text";
                                            } else {
                                              x.type = "password";
                                            }
                                          }
                                      </script>
                                      <span class="fas fa-eye" onclick="pswVisibiltyEdit(<?= $row_admin['id_admin'] ?>)"></span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <?php $no++; } ?>
                <?php }else{?>
                        <tr>
                            <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Admin Belum Tersedia</p></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
          </div>
          <div class="tab-pane fade py-3" id="superadmin" role="tabpanel" aria-labelledby="superadmin-tab">
            <table class="table table-pelimpahan datatable table-bordered table-striped" style="width:100%">
                <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Action</th>
                      <th>Nama Administrator</th>
                      <th>NRP</th>
                      <th>Kesatuan</th>
                      <th>No. Telepon</th>
                      <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($dataSuperAdmin)){ ?>
                    <?php 
                        $no = 1;
                        foreach ($dataSuperAdmin as $row_superadmin) { ?>
                    <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td class="text-center">
                          <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $row_superadmin['id_admin'] ?>"><i class="fas fa-edit"></i></a>
                          <a href="<?= base_url() ?>admin/delAdmin/<?= $row_superadmin['id_admin'] ?>" class="btn btn-danger btn-sm hapus-admin"><i class="fas fa-trash"></i></a>
                        </td>
                        <td><?= $row_superadmin['nama_admin'] ?></td>
                        <td><?= $row_superadmin['nrp'] ?></td>
                        <td>
                        <?php $choosenKesatuan = $CI->Modelkesatuan->getKesatuanByKode($row_superadmin['kode_kesatuan']); ?>
                          <?= $choosenKesatuan[0]['nama'] ?>
                        </td>
                        <td><?= $row_superadmin['notelp'] ?></td>
                        <td><?= $row_superadmin['created_at'] ?></td>
                    </tr>
                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal<?= $row_superadmin['id_admin'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Administrator</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="<?= base_url() ?>admin/editAdmin/<?= $row_superadmin['id_admin'] ?>" method="post">
                            <div class="modal-body">
                              <input type="hidden" name="kode_kesatuan" value="<?= $row_superadmin['kode_kesatuan'] ?>">
                              <div class="form-group">
                                <label for="">Nama :</label>
                                <input type="text" name="nama_admin" class="form-control" autocomplete="off" placeholder="Masukkan Nama Admin" required value="<?= $row_superadmin['nama_admin'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="">NRP :</label>
                                <input type="text" name="nrp" class="form-control" autocomplete="off" placeholder="Masukkan NRP Admin" required value="<?= $row_superadmin['nrp'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="">No. Telepon :</label>
                                <input type="text" name="notelp" class="form-control" autocomplete="off" placeholder="Masukkan No. Telepeon Admin" required value="<?= $row_superadmin['notelp'] ?>">
                              </div>
                              <div class="form-group ">
                                <label for="">Ubah Password :</label>
                                <div class="input-group">
                                  <input type="password" id="passwordEdit<?= $row_superadmin['id_admin'] ?>" name="password" class="form-control" autocomplete="off" placeholder="Masukkan Password Admin">
                                  <div class="input-group-append">
                                    <div class="input-group-text">
                                      <script>
                                          function pswVisibiltyEdit(id){
                                            var x = document.getElementById(`passwordEdit${id}`);
                                            if (x.type === "password") {
                                              x.type = "text";
                                            } else {
                                              x.type = "password";
                                            }
                                          }
                                      </script>
                                      <span class="fas fa-eye" onclick="pswVisibiltyEdit(<?= $row_superadmin['id_admin'] ?>)"></span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <?php $no++; } ?>
                <?php }else{?>
                        <tr>
                            <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Admin Belum Tersedia</p></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
          </div>
          <div class="tab-pane fade py-3" id="principal" role="tabpanel" aria-labelledby="principal-tab">
            <table class="table table-pelimpahan datatable table-bordered table-striped" style="width:100%">
                <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Action</th>
                      <th>Nama Administrator</th>
                      <th>NRP</th>
                      <th>Kesatuan</th>
                      <th>No. Telepon</th>
                      <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($dataPrincipalAdmin)){ ?>
                    <?php 
                        $no = 1;
                        foreach ($dataPrincipalAdmin as $row_principaladmin) { ?>
                    <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td class="text-center">
                          <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $row_principaladmin['id_admin'] ?>"><i class="fas fa-edit"></i></a>
                          <a href="<?= base_url() ?>admin/delAdmin/<?= $row_principaladmin['id_admin'] ?>" class="btn btn-danger btn-sm hapus-admin"><i class="fas fa-trash"></i></a>
                        </td>
                        <td><?= $row_principaladmin['nama_admin'] ?></td>
                        <td><?= $row_principaladmin['nrp'] ?></td>
                        <td>
                        <?php $choosenKesatuan = $CI->Modelkesatuan->getKesatuanByKode($row_principaladmin['kode_kesatuan']); ?>
                          <?= $choosenKesatuan[0]['nama'] ?>
                        </td>
                        <td><?= $row_principaladmin['notelp'] ?></td>
                        <td><?= $row_principaladmin['created_at'] ?></td>
                    </tr>
                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal<?= $row_principaladmin['id_admin'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Administrator</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="<?= base_url() ?>admin/editAdmin/<?= $row_principaladmin['id_admin'] ?>" method="post">
                            <div class="modal-body">
                              <input type="hidden" name="kode_kesatuan" value="<?= $row_principaladmin['kode_kesatuan'] ?>">
                              <div class="form-group">
                                <label for="">Nama :</label>
                                <input type="text" name="nama_admin" class="form-control" autocomplete="off" placeholder="Masukkan Nama Admin" required value="<?= $row_principaladmin['nama_admin'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="">NRP :</label>
                                <input type="text" name="nrp" class="form-control" autocomplete="off" placeholder="Masukkan NRP Admin" required value="<?= $row_principaladmin['nrp'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="">No. Telepon :</label>
                                <input type="text" name="notelp" class="form-control" autocomplete="off" placeholder="Masukkan No. Telepeon Admin" required value="<?= $row_principaladmin['notelp'] ?>">
                              </div>
                              <div class="form-group ">
                                <label for="">Ubah Password :</label>
                                <div class="input-group">
                                  <input type="password" id="passwordEdit<?= $row_principaladmin['id_admin'] ?>" name="password" class="form-control" autocomplete="off" placeholder="Masukkan Password Admin">
                                  <div class="input-group-append">
                                    <div class="input-group-text">
                                      <script>
                                          function pswVisibiltyEdit(id){
                                            var x = document.getElementById(`passwordEdit${id}`);
                                            if (x.type === "password") {
                                              x.type = "text";
                                            } else {
                                              x.type = "password";
                                            }
                                          }
                                      </script>
                                      <span class="fas fa-eye" onclick="pswVisibiltyEdit(<?= $row_principaladmin['id_admin'] ?>)"></span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <?php $no++; } ?>
                <?php }else{?>
                        <tr>
                            <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Admin Belum Tersedia</p></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
          </div>
        </div>
        <!-- Modal Add -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Add Administrator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="<?= base_url() ?>admin/addAdmin" method="post">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="">Pilih Grup</label>
                    <select name="kode_kesatuan" class="form-control" required>
                      <option disabled selected>Pilih Grup Admin</option>
                      <?php foreach ($kesatuan as $keyKesatuan) { ?>
                        <option value="<?= $keyKesatuan['kode_kesatuan'] ?>"><?= $keyKesatuan['nama'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Nama :</label>
                    <input type="text" name="nama_admin" class="form-control" autocomplete="off" placeholder="Masukkan Nama Admin" required>
                  </div>
                  <div class="form-group">
                    <label for="">NRP :</label>
                    <input type="text" name="nrp" class="form-control" autocomplete="off" placeholder="Masukkan NRP Admin" required>
                  </div>
                  <div class="form-group">
                    <label for="">No. Telepon :</label>
                    <input type="text" name="notelp" class="form-control" autocomplete="off" placeholder="Masukkan No. Telepeon Admin" required>
                  </div>
                  <div class="form-group ">
                    <label for="">Password :</label>
                    <div class="input-group">
                      <input type="password" id="passwordAdd" name="password" class="form-control" autocomplete="off" placeholder="Masukkan Password Admin" required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <script>
                              function pswVisibiltyAdd(){
                                var x = document.getElementById("passwordAdd");
                                if (x.type === "password") {
                                  x.type = "text";
                                } else {
                                  x.type = "password";
                                }
                              }
                          </script>
                          <span class="fas fa-eye" onclick="pswVisibiltyAdd()"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <h4>History Login Admin</h4>
          </div>
          <div class="col-md-6 text-right">
            <a href="<?= base_url() ?>admin/delHistory" class="btn btn-danger btn-sm delHistory"><span><i class="fas fa-trash"></i></span>&nbsp;Clear History</a>
          </div>
        </div>
        <table class="table table-pelimpahan datatable table-bordered table-striped" style="width:100%">
            <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>Nama Administrator</th>
                  <th>NRP</th>
                  <th>Kesatuan</th>
                  <th>Login Time</th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($historyAdmin)){ ?>
                <?php 
                    $no = 1;
                    foreach ($historyAdmin as $row_history) { ?>
                <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td><?= $row_history['nama_admin'] ?></td>
                    <td><?= $row_history['nrp'] ?></td>
                    <td>
                    <?php $choosenKesatuan = $CI->Modelkesatuan->getKesatuanByKode($row_history['kode_kesatuan']); ?>
                      <?= $choosenKesatuan[0]['nama'] ?>
                    </td>
                    <td><?= $row_history["created_at"] ?></td>
                </tr>
                <?php $no++; } ?>
            <?php }else{?>
                    <tr>
                        <td colspan="5" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Login Belum Tersedia</p></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php }else{ ?>
          <table id="table-master-kasus" class="table datatable table-bordered table-striped" style="width:100%">
                <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>Nama Administrator</th>
                      <th>NRP</th>
                      <th>No. Telepon</th>
                      <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($dataAdmin)){ ?>
                    <?php 
                        $no = 1;
                        foreach ($dataAdmin as $row_admin) { ?>
                    <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td><?= $row_admin['nama_admin'] ?></td>
                        <td><?= $row_admin['nrp'] ?></td>
                        <td><?= $row_admin['notelp'] ?></td>
                        <td><?= $row_admin['created_at'] ?></td>
                    </tr>
                    <?php $no++; } ?>
                <?php }else{?>
                        <tr>
                            <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Admin Belum Tersedia</p></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
  <script>
  $(document).ready(function() {
    $(".hapus-admin").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Hapus Administrator?",
        text: "Menghapus admin bersifat permanen pada database, mohon berhati-hati.",
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
    
    $(".delHistory").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Hapus History?",
        text: "Menghapus history admin bersifat permanen pada database, mohon berhati-hati.",
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

  
  <?php 
	function dateIndonesia($waktu_lengkap){
		$nama_hari = array(
			1 => 'Senin',
			2 => 'Selasa',
			3 => 'Rabu',
			4 => 'Kamis',
			5 => 'Jumat',
			6 => 'Sabtu',
			7 => 'Minggu',
		);
		$nama_bulan = array(
			1 =>  'Januari',
			2 =>  'Februari',
			3 =>  'Maret',
			4 =>  'April',
			5 =>  'Mei',
			6 =>  'Juni',
			7 =>  'Juli',
			8 =>  'Agustus',
			9 =>  'September',
			10 =>  'Oktober',
			11 =>  'November',
			12 =>  'Desember',
		);

		$pisah_waktu = explode(" ",$waktu_lengkap);
		$hari = $pisah_waktu[0];
		$tanggal = $pisah_waktu[1];

		$hari_baru = $nama_hari[$hari];

		$pisah_tanggal = explode("/",$tanggal);
		$tanggal_baru = $pisah_tanggal[0]." ".$nama_bulan[$pisah_tanggal[1]]." ".$pisah_tanggal[2];

		return $hari_baru.", ".$tanggal_baru;
	}
  ?>
  