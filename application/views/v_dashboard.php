  <style>
    .diagramTren{
      border:1px solid lightgrey;
    }
    .diagramBB{
      border:1px solid lightgrey;
      height: 30rem;
      overflow-y:scroll;
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
          <div class="diagramTren my-2 px-2 py-2 w-100" id="<?= ($viewDiagramByDate) ? 'scrollToContent' : '' ?>">
              <form action="<?= base_url() ?>dashboard/viewDiagramByDate" method="post">
                <label for="tahunsurat"><small>Tampilkan Seluruh Diagram Berdasarkan Tahun :</small></label>
                <div class="d-flex">
                  <div class="input-group date" id="tahunsurat" data-target-input="nearest" style="width:10%;">
                    <input type="text" name="tahunDiagram" class="form-control datetimepicker-input" data-target="#tahunsurat" required/>
                    <div class="input-group-append" data-target="#tahunsurat" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                  <button class="btn btn-info mx-2" type="submit"><i class="fa fa-search"></i></button>
                  <?php if($btnExitSort): ?>
                    <a class="btn btn-danger" href="<?= base_url()?>">Exit From Diagram View by Date</a>
                  <?php endif; ?>
                </div>
              </form>
              </div>
            <canvas class="chart mt-2" id="myChart" width="300" height="100"></canvas>
          </div>
          <hr>
          <!-- Diagram Barang Bukti -->
          <div class="diagramBB my-2 px-2 py-2 w-100">
            <h5 class="text-center">Diagram Tren Barang Bukti - <?= $tahunDiagram ?></h5>
            <div class="row">
              <div class="col-md-12 text-center">
                <label for=""><small>Cari Barang Bukti :</small></label>
                <div class="d-flex justify-content-center">
                    <input type="text" class="form-control" style="width:30%;" id="ccf_filter_input" onkeyup="filterSuburbs()">
                    <button type="submit" class="btn btn-info mx-2">
                      <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
            <hr>
            <div id="suburbList">
              <canvas class="chart mt-2" id="GanjaChart" height="100" title="Ganja"></canvas>
              <canvas class="chart mt-2" id="GorillaChart" height="100" title="Tembakau Gorilla"></canvas>
              <canvas class="chart mt-2" id="HashishChart" height="100" title="Hashish"></canvas>
              <canvas class="chart mt-2" id="OpiumChart" height="100" title="Opium"></canvas>
              <canvas class="chart mt-2" id="MorphinChart" height="100" title="Morphin"></canvas>
              <canvas class="chart mt-2" id="HeroinChart" height="100" title="Heroin/Putaw"></canvas>
              <canvas class="chart mt-2" id="KokainChart" height="100" title="Kokain"></canvas>
              <canvas class="chart mt-2" id="ExstacyChart" height="100" title="Exstacy/Carnophen"></canvas>
              <canvas class="chart mt-2" id="SabuChart" height="100" title="Sabu"></canvas>
              <canvas class="chart mt-2" id="GolChart" height="100" title="GOL IV"></canvas>
              <canvas class="chart mt-2" id="DaftarChart" height="100" title="Daftar G"></canvas>
              <canvas class="chart mt-2" id="KosmetikChart" height="100" title="Kosmetik"></canvas>
              <canvas class="chart mt-2" id="JamuChart" height="100" title="Jamu"></canvas>
            </div>
          </div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
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
        div = document.getElementById("suburbList");
        canvas = div.getElementsByTagName('canvas');
        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < canvas.length; i++) {
            title = canvas[i].getAttribute("title");
            txtValue = title;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              canvas[i].style.display = "";
            } else {
              canvas[i].style.display = "none";
            }
        }
    }
    <?php if($viewDiagramByDate): ?>
      $('html, body').animate({
          scrollTop: $("#scrollToContent").offset().top
      }, 2000);
    <?php endif; ?>
    $(function () {
      $('#tahunsurat').datetimepicker({
          viewMode: 'years',
          format: 'YYYY'
      });
      $('#tahunsuratBB').datetimepicker({
          viewMode: 'years',
          format: 'YYYY'
      });
    });
  </script>
  <?php include('diagram/diagramDashboard.php') ?>

