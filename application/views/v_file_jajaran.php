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
    $CI->load->model('Modelkesatuan');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4 py-2">
        <div class="table-responsive">
          <table id="table-master-kasus" class="table datatable table-bordered table-striped" style="width:100%">
            <thead>
                <tr class="text-center">
                <th>No</th>
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
          <hr>
          <div class="text-right">
              <a href="<?= base_url() ?>upload-file" class="btn btn-secondary btn-sm">Kembali</a>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->