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
      <table id="table-master-kasus" class="table datatable table-bordered table-striped" style="width:100%">
            <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>Nama Administrator</th>
                  <th>NRP</th>
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
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->