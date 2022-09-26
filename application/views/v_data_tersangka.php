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
    .bootstrap-select button{
        background: white!important;
        text-transform: inherit!important;
        font-weight: normal!important;
    }
    .foto-tsk {
      width: 200px; /* You can set the dimensions to whatever you want */
      height: 200px;
      object-fit: cover;
      border-radius:15px;
    }
  </style>
  <!-- DATA -->
  <?php 
    $CI =& get_instance();
    $CI->load->model('Modelbarangbukti');
    $CI->load->model('Modeltersangka');
    $CI->load->model('Modeladmin');
    $CI->load->model('Modelkesatuan');
    $CI->load->model('Modelpermohonan');
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="mb-2 text-center">
            <h1 class="m-0">MASTER FILE IDENTITAS TERSANGKA</h1>
            <h2 class="m-0">(<?= $this->session->userdata('login_data_admin')['nama'] ?>)</h2>
          </div>
        </div><!-- /.container-fluid -->
      </div>
      <hr class="my-2">
      
      <table id="table-master-kasus" class="table datatable table-hover table-bordered table-striped " style="width:100%">
            <thead>
                <tr class="text-center">
                  <th>No</th> 
                  <th>Identitas Tersangka</th>
                  <th>No Laporan Polisi</th>
                  <th>Tanggal Input LP</th>
                  <th>Foto</th>
                  <th>Sidik Jari & Rumus Doctiloskopi</th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($dataKasus)){ ?>
                <?php 
                $no = 1;
                $account_numbers = array();
                foreach ($dataKasus as $row_kasus) { 
                    $display = FALSE;
                    if(!in_array($row_kasus["no_laporanpolisi"], $account_numbers)) {
                        array_push($account_numbers, $row_kasus["no_laporanpolisi"]);
                        $display = TRUE;
                    }
                  ?>
                <tr>
                    <td class="text-center"><?= ($display) ? $no : "" ?></td>
                    <td>
                      <ul>
                        <li><strong>NAMA</strong> : <?= $row_kasus["nama"] ?></li>
                        <li><strong>ALAMAT</strong> : <?= $row_kasus["alamat"] ?></li>
                        <li><strong>NIK</strong> : <?= $row_kasus["nik"] ?></li>
                        <li><strong>AGAMA</strong> : <?= $row_kasus["agama"] ?></li>
                        <li><strong>JENIS KELAMIN</strong> : <?= $row_kasus["jenis_kelamin"] ?></li>
                        <li><strong>KEWARGANAGARAAN</strong> : <?= $row_kasus["status_kewarganegaraan"] ?></li>
                        <li><strong>STATUS</strong> : <?= $row_kasus["status"] ?></li>
                      </ul>
                    </td>
                    <td><?= $display ? $row_kasus["no_laporanpolisi"] : ""; ?></td>
                    <td><?= $display ? dateIndonesia(date('N j/n/Y', strtotime($row_kasus["created_at"]))) : ""; ?></td>
                    <td class="text-center" style="vertical-align: middle;">
                      <?php if(!empty($row_kasus["file_foto"])): ?>
                        <a class="test-popup-link" href="<?= base_url() ?>uploads/fotoTersangka/<?= $row_kasus["file_foto"] ?>"><img src="<?= base_url() ?>uploads/fotoTersangka/<?= $row_kasus["file_foto"] ?>" alt="Rounded image" class="foto-tsk"></a>
                        <hr>
                      <?php endif; ?>
                      <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER'): ?>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#uploadFotoModal<?= $row_kasus["id_kasus"] ?>">Upload Foto Tersangka</button>
                      <?php endif; ?>
                    </td>
                    <td>This feature is on development.</td>
                </tr>
                <!-- Modal Upload Foto -->
                <div class="modal fade" id="uploadFotoModal<?= $row_kasus["id_kasus"] ?>" tabindex="-1" aria-labelledby="uploadFotoModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="uploadFotoModalLabel">Upload / Ubah Foto Tersangka</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="<?= base_url() ?>data/uploadFoto/<?= $row_kasus['id_tersangka'] ?>" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                          <input type="file" class="form-control" name="file" id="sampul-<?= $row_kasus['id_kasus'] ?>" onchange="previewImg(<?= $row_kasus['id_kasus'] ?>)" required>
                          <img class="img-thumbnail" id="img-preview-<?= $row_kasus['id_kasus'] ?>">
                          <script>
                              function previewImg(id) {
                                  const sampule = document.querySelector('#sampul-' + id);
                                  const imgPreview = document.querySelector('#img-preview-' + id);
                                  
                                  const fileSampule = new FileReader();
                                  fileSampule.readAsDataURL(sampule.files[0]);

                                  fileSampule.onload = function(e) {
                                      imgPreview.src = e.target.result;
                                  }
                              }
                          </script>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <?php ($display) ? $no++ : $no; } ?>
            <?php }else{?>
                    <tr>
                        <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Master Belum Tersedia</p></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script src="<?= base_url() ?>assets/js/magnific-popup/jquery.magnific-popup.js"></script>
  <script>
      $(document).ready(function($) {
        $('.test-popup-link').magnificPopup({
          type:'image',
          mainClass: 'mfp-with-zoom', // this class is for CSS animation below

          zoom: {
            enabled: true, // By default it's false, so don't forget to enable it

            duration: 300, // duration of the effect, in milliseconds
            easing: 'ease-in-out', // CSS transition easing function

            // The "opener" function should return the element from which popup will be zoomed in
            // and to which popup will be scaled down
            // By defailt it looks for an image tag:
            opener: function(openerElement) {
              // openerElement is the element on which popup was initialized, in this case its <a> tag
              // you don't need to add "opener" option if this code matches your needs, it's defailt one.
              return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
          }
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
  