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
        <h2>Pengaturan <?= $title ?> (.xls) :</h2>
        <hr>
        <!-- View by Date -->
        <form action="<?php
          switch ($kodeExport) {
            case 'kasusMaster':
                echo base_url().'export/downloadExcel/'.$kodeExport;
                break;
                
            case 'selra':
                echo base_url().'export/downloadExcel/'.$kodeExport;
                break;
                
            case 'matrikKasus':
                echo base_url().'export/downloadExcel/'.$kodeExport;
                break;
                
            case 'matrikBB':
                echo base_url().'export/downloadExcel/'.$kodeExport;
                break;
                
            case 'pelimpahanMaster':
                echo base_url().'export/downloadExcel/'.$kodeExport;
                break;
                
            case 'pelimpahanRiwayat':
                echo base_url().'export/downloadExcel/'.$kodeExport;
                break;
            
            default:
                echo base_url();
                break;
        }
        ?>" method="post">
          <div class="section-date row">
            <div class="col-md-8">
              <div id="formDateSettings">
                <div class="formDate d-flex">
                    <?php
                    if ($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER') { ?>
                      <div class="form-group">
                        <label for="">Pilih Kesatuan</label>
                        <select name="kesatuan" class="form-control" required>
                          <option selected disabled>Pilih Kesatuan...</option>
                          <option value="all">All</option>
                          <?php foreach ($kesatuan as $keyKesatuan) { ?>
                            <option value="<?= $keyKesatuan['kode_kesatuan'] ?>"><?= $keyKesatuan['nama'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    <?php } ?>
                    <div class="form-group mx-2">
                      <label>Pilih Tanggal Awal</label>
                      <div class="input-group date" id="tanggalAwalHarian" data-target-input="nearest">
                        <input type="text" name="tanggalAwal" class="form-control datetimepicker-input" data-target="#tanggalAwalHarian" placeholder="Pilih Tanggal Awal" required autocomplete="off"/>
                        <div class="input-group-append" data-target="#tanggalAwalHarian" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group mx-2">
                      <label>Pilih Tanggal Akhir</label>
                      <div class="input-group date" id="tanggalAkhirHarian" data-target-input="nearest">
                        <input type="text" name="tanggalAkhir" class="form-control datetimepicker-input" data-target="#tanggalAkhirHarian" placeholder="Pilih Tanggal Akhir" autocomplete="off"/>
                        <div class="input-group-append" data-target="#tanggalAkhirHarian" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" id="submitDate" class="btn btn-info btn-sm" onclick="ClearFields();"><span><i class="fas fa-download"></i></span> Download File</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <script>    
  $(document).ready(function() {
    $('#tanggalAwalHarian').datetimepicker({
        format: 'YYYY-MM-DD'
    });
      
    $('#tanggalAkhirHarian').datetimepicker({
        format: 'YYYY-MM-DD'
    });
  });

  function ClearFields() {
    document.getElementsByClassName("input-group-append").value = "";
  }
  </script>
  