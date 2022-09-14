<footer class="main-footer">
    <strong>Copyright &copy; 2022 DITRESNARKOBA POLDA JATIM.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="text-center" style="margin-top: 10px;">
      <img class="profile-user-img img-fluid img-circle" src="<?= base_url(); ?>assets/images/logo_user.png" alt="User profile picture">
    </div>
    <h3 class="profile-username text-center"><?= $this->session->userdata("login_data_admin")['nama'] ?></h3>
    <p class="text-muted text-center"><?= $this->session->userdata("login_data_admin")['nama_admin'] ?></p>
    <a href="<?= base_url('logout') ?>" class="btn btn-success btn-block" style="color:white;">Logout</a>
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url("assets/adminlte/") ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url("assets/adminlte/") ?>dist/js/adminlte.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url("assets/adminlte/") ?>plugins/moment/moment.min.js"></script>
<script src="<?= base_url("assets/adminlte/") ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url("assets/adminlte/") ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Toast -->
<script src="<?= base_url('assets/adminlte/plugins'); ?>/toastr/toastr.min.js"></script>  
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>/assets/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>/assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Select -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
  var windowURL = window.location.href;
  pageURL = '<?php echo base_url() . $menuLink ?>';
  var x = $('a[href="' + pageURL + '"]');
  x.addClass('active');
  x.parent().parent().parent().addClass('menu-open');
  x.parent().parent().parent().children().first().addClass('active');
  var y = $('a[href="' + windowURL + '"]');
  y.addClass('active');
  y.parent().parent().parent().addClass('menu-open');
  y.parent().parent().parent().children().first().addClass('active');
</script>

<script>
  $(document).ready(function () {

    $("body").addClass("sidebar-collapse");
    
      $('[data-toggle="tooltip"]').tooltip();

      $('#table-full-fitur').DataTable();
      $('#table-master-kasus').dataTable( {
        "ordering": false
      } );
      $('#table-matrik-kasus').dataTable( {
        "ordering": false
      } );
      $('.table-pelimpahan').dataTable( {
        "ordering": false
      } );
      $('.table-selra').dataTable( {
        "lengthMenu": [5],
      } );
  });
</script>

</body>
</html>
