  <style>
    .diagramTren{
      border:1px solid lightgrey;
    }
  </style>
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
              <a href="<?= base_url('master-kasus') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="<?= base_url('master-kasus') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="<?= base_url('selra') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
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
                <a href="<?= base_url('data-admin') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
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
                <a href="<?= base_url('kasus-menonjol') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
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
                <a href="<?= base_url('data-admin') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          
          </div>
        <?php endif; ?>
        <!-- Main row -->
        <div class="row">
          <div class="diagramTren my-2 px-2 py-2 w-100">
            <form action="<?= base_url() ?>dashboard/viewDiagramByDate" method="post">
              <label for="tahunsurat"><small>Tampilkan Diagram Tindak Pidana Berdasarkan Tahun :</small></label>
              <div class="d-flex">
                <div class="input-group date" id="tahunsurat" data-target-input="nearest" style="width:10%;">
                  <input type="text" name="tahunDiagram" class="form-control datetimepicker-input" data-target="#tahunsurat" required/>
                  <div class="input-group-append" data-target="#tahunsurat" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
                <button class="btn btn-info mx-2" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </form>
            <canvas class="chart mt-2" id="myChart" width="300" height="100"></canvas>
          </div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'bar', // also try bar or other graph types

      // The data for our dataset
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        // Information about the dataset
        datasets: [
          {
            label: "Kasus",
            backgroundColor: '#1C6758',
            borderColor: '#1C6758',
            data: [<?= $dataDiagram['Jan']['KSS'] ?>, <?= $dataDiagram['Feb']['KSS'] ?>, <?= $dataDiagram['Mar']['KSS'] ?>, <?= $dataDiagram['Apr']['KSS'] ?>, <?= $dataDiagram['Mei']['KSS'] ?>, <?= $dataDiagram['Jun']['KSS'] ?>, <?= $dataDiagram['Jul']['KSS'] ?>, <?= $dataDiagram['Agu']['KSS'] ?>, <?= $dataDiagram['Sep']['KSS'] ?>, <?= $dataDiagram['Okt']['KSS'] ?>, <?= $dataDiagram['Nov']['KSS'] ?>, <?= $dataDiagram['Des']['KSS'] ?>],
          },
          {
            label: "Tersangka",
            backgroundColor: '#16213E',
            borderColor: '#16213E',
            data: [<?= $dataDiagram['Jan']['TSK'] ?>, <?= $dataDiagram['Feb']['TSK'] ?>, <?= $dataDiagram['Mar']['TSK'] ?>, <?= $dataDiagram['Apr']['TSK'] ?>, <?= $dataDiagram['Mei']['TSK'] ?>, <?= $dataDiagram['Jun']['TSK'] ?>, <?= $dataDiagram['Jul']['TSK'] ?>, <?= $dataDiagram['Agu']['TSK'] ?>, <?= $dataDiagram['Sep']['TSK'] ?>, <?= $dataDiagram['Okt']['TSK'] ?>, <?= $dataDiagram['Nov']['TSK'] ?>, <?= $dataDiagram['Des']['TSK'] ?>],
          },
          {
            label: "SELRA",
            backgroundColor: '#FF1E00',
            borderColor: '#FF1E00',
            data: [<?= $dataDiagram['Jan']['SELRA'] ?>, <?= $dataDiagram['Feb']['SELRA'] ?>, <?= $dataDiagram['Mar']['SELRA'] ?>, <?= $dataDiagram['Apr']['SELRA'] ?>, <?= $dataDiagram['Mei']['SELRA'] ?>, <?= $dataDiagram['Jun']['SELRA'] ?>, <?= $dataDiagram['Jul']['SELRA'] ?>, <?= $dataDiagram['Agu']['SELRA'] ?>, <?= $dataDiagram['Sep']['SELRA'] ?>, <?= $dataDiagram['Okt']['SELRA'] ?>, <?= $dataDiagram['Nov']['SELRA'] ?>, <?= $dataDiagram['Des']['SELRA'] ?>],
          }
      ]
      },

      // Configuration options
      options: {
        layout: {
          padding: 2,
        },
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Diagram Tren Tindak Pidana Narkotika & Psikotropika <?= $tahunDiagram ?> <?= $this->session->userdata('login_data_admin')['nama'] ?>'
        },
        scales: {
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Jumlah'
            }
          }],
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Bulan'
            }
          }]
        }
      }
    });
    
    $(function () {
      $('#tahunsurat').datetimepicker({
          viewMode: 'years',
          format: 'YYYY'
        });
    });
  </script>

