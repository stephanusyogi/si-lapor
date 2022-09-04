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
    $CI->load->model('Modelkasus');
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4 py-4">
        <h2>Daftar Pengajuan Perubahan LP</h2>
        <hr>
          <table class="table-pelimpahan table datatable table-bordered table-striped" style="width:100%">
              <thead>
                  <tr class="text-center">
                  <th>No</th>
                  <th>Action</th>
                  <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'): ?>
                  <th>Kesatuan</th>
                  <?php endif; ?>
                  <th>No Laporan Polisi</th>
                  <th>Alasan Perubahan</th>
                  <th>Status</th>
                  <th>Tanggal Pengajuan</th>
                  </tr>
              </thead>
              <tbody>
              <?php if(isset($dataPermohonan)){ ?>
                  <?php 
                  $no = 1;
                  foreach ($dataPermohonan as $rowPermohonan) { 
                  ?>
                  <tr>
                      <td class="text-center"><?= $no ?></td>
                      <td class="text-center">
                      <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'): ?>
                        <div data-toggle="tooltip" data-placement="top" title="Update Status Laporan">
                          <a class="update-ajuan mx-1" href="<?= base_url() ?>permohonan/updatePermohonan/<?= $rowPermohonan['id_permohonan']?>/<?= $rowPermohonan["id_kasus"] ?>" style="cursor:pointer;"><i class="fas fa-check-square" style="color:darkblue;"></i></a>
                        </div>
                      <?php else: ?>  
                        <div data-toggle="tooltip" data-placement="top" title="Hapus Pengajuan">
                          <a class="hapus-ajuan mx-1" href="<?= base_url() ?>permohonan/delPermohonan/<?= $rowPermohonan['id_permohonan']?>"><i class="fas fa-trash" style="color:red;"></i></a>
                        </div>
                      <?php endif; ?>
                      </td>
                      <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'): ?>
                      <td><?php
                      $result = $CI->Modelkesatuan->getKesatuanByKode($rowPermohonan["kode_kesatuan"]);
                      echo $result[0]['nama']; ?>
                      </td>
                      <?php endif; ?>
                      <td><?php 
                        $resultNoLP = $CI->Modelkasus->getByIdKasus($rowPermohonan["id_kasus"], $rowPermohonan["kode_kesatuan"])->result_array();
                        echo $resultNoLP[0]['no_laporanpolisi'];
                      ?></td>
                      <td><?= $rowPermohonan['alasan_permohonan'] ?></td>
                      <td>
                          <?php if($rowPermohonan["isApproved"]){ ?>
                              <button class="btn btn-success btn-sm"><strong><?= ($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER') ? 'Telah Disetujui' : 'Telah Disetujui Silahkan Check Master' ?></strong></button>
                          <?php }else{?>
                              <button class="btn btn-warning btn-sm"><strong>Menunggu Persetujuan</strong></button>
                          <?php } ?>
                      </td>
                      <td>
                        <?= $rowPermohonan['created_at'] ?>
                      </td>
                  </tr>
                  <?php $no++; } ?>
              <?php }else{?>
                      <tr>
                          <td colspan="5" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Pengajuan Belum Tersedia</p></td>
                      </tr>
              <?php } ?>
              </tbody>
          </table>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
    
  $(document).ready(function() {
    
    $(".hapus-ajuan").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Batalkan Pengajuan?",
        text: "Membatalkan pengajuan bersifat permanen pada database, mohon berhati-hati.",
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
    
    $(".update-ajuan").on("click", function (e) {
      e.preventDefault();
      const href = $(this).attr("href");

      Swal.fire({
        title: "Setujui Pengajuan?",
        text: "Menyetujui pengajuan bersifat permanen pada database, mohon berhati-hati.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Approved!",
      }).then((result) => {
        if (result.isConfirmed) {
          document.location.href = href;
        }
      });
    });
  });
  </script>