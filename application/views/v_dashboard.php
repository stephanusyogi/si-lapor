  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <!-- Content Header (Page header) -->
      <div class="content-header mt-2">
        <div class="container-fluid">
          <div class="mb-2 text-center">
            <h1 class="mb-0">Welcome, <strong><?= $this->session->userdata('login_data_admin')['nama'] ?></strong></h1>
            <p class="mb-0">Adminstrator Name : <strong><?= $this->session->userdata('login_data_admin')['nama_admin'] ?></strong></p>
            <p class="mb-0">NRP : <strong><?= $this->session->userdata('login_data_admin')['nrp_admin'] ?></strong></p>
          </div>
          <hr>
        </div><!-- /.container-fluid -->
      </div>
      <div class="container-fluid">
        <!-- Notification -->
        <?php if(isset($displayTSK) || isset($displayBB)): ?>
          <?php if($displayTSK): ?>
            <div class="alert alert-warning" role="alert">
              Perhatian! Anda memiliki data LP dengan data <strong>tersangka</strong> yang belum terisi! Silahkan periksa LP pada menu <strong>Data Kasus (Master)</strong>
            </div>
          <?php endif; ?>
          <?php if($displayBB): ?>
            <div class="alert alert-warning" role="alert">
              Perhatian! Anda memiliki data LP dengan data <strong>barang bukti</strong> yang belum terisi! Silahkan periksa LP pada menu <strong>Data Kasus (Master)</strong>
            </div>
          <?php endif; ?>
        <?php endif; ?>
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $dataDashboard['jumlahKasus'] ?></h3>

                <p>KASUS</p>
              </div>
              <div class="icon">
                <i class="ion ion-folder"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $dataDashboard['jumlahTersangka'] ?></h3>

                <p>TERSANGKA</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3><?= count($dataDashboard['jumlahKasusSelesai']) ?></h3>

                <p>KASUS SELESAI</p>
              </div>
              <div class="icon">
                <i class="ion ion-briefcase"></i>
              </div>
            </div>
          </div>
        </div>
        <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'): ?>
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-dark">
                <div class="inner">
                  <h3><?= $dataDashboard['jumlahAdmin'] ?></h3>

                  <p>ADMINISTRATOR</p>
                </div>
                <div class="icon">
                  <i class="ion ion-happy"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?= $dataDashboard['jumlahKasusMenonjol'] ?></h3>

                  <p>KASUS MENONJOL</p>
                </div>
                <div class="icon">
                  <i class="ion ion-clipboard"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?= $dataDashboard['jumlahLoginToday'] ?></h3>

                  <p>ADMIN LOGIN TODAY</p>
                </div>
                <div class="icon">
                  <i class="ion ion-clock"></i>
                </div>
              </div>
            </div>
          
          </div>
        <?php endif; ?>
        <!-- Main row -->
        <div class="row">

        </div>
        <!-- /.row (main row) -->
        <!-- Image Welcome -->
        <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER'): ?>
          <img class="mb-4" src="<?= base_url() ?>assets/images/bg.PNG" alt="Logo Ditresnarkoba Polda Jatim" style="width:50%;display: block;margin-left: auto;margin-right: auto;">
        <?php endif; ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

