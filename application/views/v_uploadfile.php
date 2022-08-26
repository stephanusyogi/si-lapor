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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4 py-2">
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
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
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