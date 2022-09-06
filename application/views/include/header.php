<!DOCTYPE html>
<html lang="in">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>SI-LAPOR | <?= $title ?></title>
  
  <!-- Icon Page -->
  <link rel="icon" href="<?= base_url("assets/images/logo-ditresnarkoba-poldajatim.png") ?>">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url("assets/adminlte/") ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url("assets/adminlte/") ?>dist/css/adminlte.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url("assets/adminlte/") ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url("assets/adminlte/") ?>plugins/daterangepicker/daterangepicker.css">
  <!-- Toast -->
  <link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins'); ?>/toastr/toastr.min.css">
  <!-- Datatables -->
  <link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins'); ?>/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Select -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <!-- jQuery -->
  <script src="<?= base_url("assets/adminlte/") ?>plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url("assets/adminlte/") ?>plugins/jquery-ui/jquery-ui.min.js"></script>
</head>

<!-- Alert Error -->
<?php
  $error = $this->session->flashdata('error');
  if ($error) {
  ?>
    <script type="text/javascript">
        $(function() {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 5000
          });

          Toast.fire({
            icon: 'error',
            title: '&nbsp;<?php echo $error ?>'
          })
        });
    </script>
  <?php }
?>

<!-- Alert Success -->
<?php
  $success = $this->session->flashdata('success');
  if ($success) {
  ?>
    <script type="text/javascript">
        $(function() {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 5000
          });

          Toast.fire({
            icon: 'success',
            title: '&nbsp;<?php echo $success ?>'
          })
        });
    </script>
  <?php }
  // DATA
    $CI =& get_instance();
    $CI->load->model('Modelchat');
?>

<style>
  .content-wrapper > .content{
    padding: 4rem 0.5rem!important;
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?= base_url("assets/images/logo-ditresnarkoba-poldajatim.PNG") ?>" alt="Logo Ditresnarkoba-Poldajatim" style="width:25%;height:auto;">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url($menuLink) ?>" class="nav-link"><?= $title ?></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-info navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-user-circle"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-success elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url("dashboard")?>" class="brand-link">
      <img src="<?= base_url("assets/images/") ?>logo-ditresnarkoba-poldajatim.png" alt="Ditresnarkoba polda jatim logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SI-LAPOR</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url("assets/images/") ?>police_icon.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?= base_url("dashboard") ?>" class="d-block" data-toggle="tooltip" data-placement="top" title="<?= $this->session->userdata('login_data_admin')['nama_admin'] ?>"><?= strlen($this->session->userdata('login_data_admin')['nama_admin']) > 18 ? substr($this->session->userdata('login_data_admin')['nama_admin'],0,15)."..." : $this->session->userdata('login_data_admin')['nama_admin']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= base_url("dashboard")?>" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>DASHBOARD</p>
            </a>
          </li>
          <li class="nav-header">DATA MANAGEMENT</li>
          <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER'){ ?>
            <li class="nav-item">
              <a href="<?= site_url("lapor-ungkap-kasus") ?>" class="nav-link">
                <i class="nav-icon fas fa-bullhorn"></i>
                <p>
                  LAPOR KASUS
                </p>
              </a>
            </li>
          <?php } ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                PANGKALAN DATA
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url("master-kasus") ?>" class="nav-link">
                  <i class="fas fa-file-contract nav-icon"></i>
                  <p>Data Kasus (Master)</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("selra") ?>" class="nav-link">
                  <i class="nav-icon fas fa-balance-scale"></i>
                  <p>Data Selesai Perkara</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("matrik-kasus") ?>" class="nav-link">
                  <i class="fas fa-building nav-icon"></i>
                  <p>Matrik Ungkap Kasus</p>
                </a>
              </li>
              <li class="nav-item">
                <a target="_blank" href="<?= base_url("matrik-barang-bukti") ?>" class="nav-link">
                  <i class="fas fa-archive nav-icon"></i>
                  <p>Matrik Barang Bukti</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("daftar-permohonan-edit") ?>" class="nav-link">
                  <i class="fas fa-hands-helping nav-icon"></i>
                  <p>Daftar Pengajuan Edit</p>
                  <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'): ?>
                  <span class="badge badge-warning right" id="countPermohonan"></span>
                  <?php endif; ?>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">PELIMPAHAN</li>
          <li class="nav-item">
            <a href="<?= base_url("kasus-pelimpahan") ?>" class="nav-link">
              <i class="fas fa-folder-open nav-icon"></i>
              <p><?= ($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER') ? 'PELIMPAHAN MASTER' : 'DAFTAR PELIMPAHAN' ?></p>
            </a>
          </li>
          <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER'){ ?>
            <li class="nav-item">
              <a href="<?= base_url("riwayat-pelimpahan") ?>" class="nav-link">
                <i class="fas fa-book nav-icon"></i>
                <p>RIWAYAT PELIMPAHAN</p>
              </a>
            </li>
          <?php } ?>
          <li class="nav-header">COMMUNICATION</li>
          <li class="nav-item">
            <a href="<?= base_url('chat') ?>" class="nav-link">
              <i class="fas fa-comments nav-icon"></i>
              <p>CHAT</p>
              <span class="badge badge-warning right" id="countMsg"></span>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('pengumuman') ?>" class="nav-link">
              <i class="fas fa-satellite-dish nav-icon"></i>
              <p>PENGUMUMAN</p>
              <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER'): ?>
              <span class="badge badge-warning right" id="countPengumuman"></span>
              <?php endif; ?>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>upload-file" class="nav-link">
              <i class="fas fa-folder nav-icon"></i>
              <p><?= ($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER') ? 'UPLOAD FILES' : 'FILE JAJARAN' ?></p>
            </a>
          </li>
          <li class="nav-header">OTHERS</li>
          <li class="nav-item">
            <a href="<?= base_url() ?>data-admin" class="nav-link">
              <i class="fas fa-users nav-icon"></i>
              <p><?= ($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER') ? 'DATA ADMIN' : 'MANAGEMENT ADMIN' ?></p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <script>
      setInterval(() => {
        let xhrCount = new XMLHttpRequest();
        xhrCount.open("POST", "<?= base_url() ?>chat/countMsg", true);
        xhrCount.onload = () => {
            if (xhrCount.readyState === XMLHttpRequest.DONE) {
                if (xhrCount.status === 200) {
                    let data = xhrCount.response;
                    document.getElementById("countMsg").textContent = data;
                }
            }
        }
        xhrCount.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhrCount.send();
        
        <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'): ?>
          let xhrCountPermohonan = new XMLHttpRequest();
          xhrCountPermohonan.open("POST", "<?= base_url() ?>permohonan/countPermohonan", true);
          xhrCountPermohonan.onload = () => {
              if (xhrCountPermohonan.readyState === XMLHttpRequest.DONE) {
                  if (xhrCountPermohonan.status === 200) {
                      let data = xhrCountPermohonan.response;
                      document.getElementById("countPermohonan").textContent = data;
                  }
              }
          }
          xhrCountPermohonan.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhrCountPermohonan.send();
        <?php endif; ?>
      },2000);

      <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] != 'ADMINSUPER'): ?>
        setInterval(() => {
          let xhrCountPengumuman = new XMLHttpRequest();
          xhrCountPengumuman.open("POST", "<?= base_url() ?>pengumuman/countPengumuman", true);
          xhrCountPengumuman.onload = () => {
              if (xhrCountPengumuman.readyState === XMLHttpRequest.DONE) {
                  if (xhrCountPengumuman.status === 200) {
                      let data = xhrCountPengumuman.response;
                      document.getElementById("countPengumuman").textContent = data;
                  }
              }
          }
          xhrCountPengumuman.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhrCountPengumuman.send();
        },2000);
      <?php endif; ?>
  </script>