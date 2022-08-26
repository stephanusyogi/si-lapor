
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


<script>
  $(document).ready(function () {
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
  });
</script>

</body>
</html>
