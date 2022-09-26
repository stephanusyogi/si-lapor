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
    .section-folder{
      height:35rem;
      overflow-y:scroll;
    }
    .folder-jajaran{
      line-height:15px;
    }
    .folder-jajaran > a{
      font-size: 8rem;
      color:#343a40;
    }
    .folder-jajaran > a:hover{
      color:#7e8b99;
      cursor:pointer;
    }
    .folder-jajaran > p:hover{
      cursor:pointer;
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
          <div class="row">
            <div class="col-md-12 text-center">
              <label for=""><small>Cari Folder :</small></label>
              <div class="d-flex justify-content-center">
                  <input type="text" class="form-control" style="width:30%;" id="ccf_filter_input" onkeyup="filterSuburbs()">
                  <button type="submit" class="btn btn-info mx-2">
                    <i class="fa fa-search"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="row section-folder" id="suburbList">
            <?php foreach($kesatuan as $keyKesatuan){ ?>
              <?php $choosenKesatuan = $CI->Modelkesatuan->getKesatuanByKode($keyKesatuan['kode_kesatuan']); ?>
              <div class="col folder-jajaran mx-2 my-2 text-center" title="<?= $choosenKesatuan[0]['nama'] ?>">
                <a href="<?= base_url() ?>file/viewFileJajaran/<?= $keyKesatuan['kode_kesatuan'] ?>"><i class="fas fa-folder"></i></a>
                <p class="mb-0 titleFolder" data-toggle="tooltip" data-placement="top" title="<?= $choosenKesatuan[0]['nama'] ?>">
                  <?= strlen($choosenKesatuan[0]['nama']) > 18 ? substr($choosenKesatuan[0]['nama'],0,18)."..." : $choosenKesatuan[0]['nama']; ?>
                </p>
              </div>
            <?php } ?>
          </div>
        <?php }else{ ?>
          <!-- Upload File -->
          <form action="<?= base_url() ?>file/uploadFile" method="post" enctype="multipart/form-data">
              <div class="row">
                  <div class="col-md-12">
                      <h4>Upload File</h4>
                      <div class="d-flex">
                          <div class="form-group w-50">
                              <input type="text" class="form-control" name="ket_file" placeholder="Tulis keterangan file..." autocomplete="off" required>
                          </div>
                          <div class="form-group mx-2">
                              <input type="file" class="form-control" name="file" id="file" required>
                          </div>
                      </div>
                      <button type="submit" class="btn btn-info btn-sm">Upload</button>
                  </div>
              </div>
          </form>
          <hr>
          <table id="table-master-kasus" class="table datatable table-bordered table-striped" style="width:100%">
                  <thead>
                      <tr class="text-center">
                      <th>No</th>
                      <th>Action</th>
                      <th>Keterangan File</th>
                      <th>Link Download</th>
                      <th>Uploaded By</th>
                      <th>Created At</th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php if(isset($dataFile)){ ?>
                      <?php 
                          $no = 1;
                          foreach ($dataFile as $row_file) { ?>
                      <tr>
                          <td class="text-center"><?= $no ?></td>
                          <td class="text-center"><a class="hapus-upload-file" href="<?= base_url() ?>file/delFile/<?= $row_file['id_file'] ?>"><i class="fas fa-trash" style="color:red;"></i></a></td>
                          <td><?= $row_file['ket_file'] ?></td>
                          <td>
                              <a href="<?= base_url() ?>file/downloadFile/<?= $row_file['id_file'] ?>">
                                  <?= substr(strstr($row_file['nama_file'], '-'), strlen('-')) ?>
                              </a>
                          </td>
                          <td><?= $row_file['nama_admin'] ?></td>
                          <td><?= $row_file['created_at'] ?></td>
                      </tr>
                      <?php $no++; } ?>
                  <?php }else{?>
                          <tr>
                              <td colspan="5" style="text-align:center;"><p style="color:grey;font-size:18px;">Data File Belum Tersedia</p></td>
                          </tr>
                  <?php } ?>
                  </tbody>
              </table>
          </div>
        <?php } ?>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
    function filterSuburbs() {
        // Declare variables
        var input, filter, ul, li, about,a, title, i, txtValue;
        input = document.getElementById('ccf_filter_input');
        filter = input.value.toUpperCase();
        section = document.getElementById("suburbList");
        div = section.getElementsByTagName('div');
        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < div.length; i++) {
            title = div[i].getAttribute("title");
            txtValue = title;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              div[i].style.display = "";
            } else {
              div[i].style.display = "none";
            }
        }
    }
  $(document).ready(function() {
    $(".hapus-upload-file").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Hapus File?",
        text: "Menghapus file bersifat permanen pada database, mohon berhati-hati.",
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