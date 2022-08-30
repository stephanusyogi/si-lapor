<?php 
    // $namaKesatuan = $this->session->userdata('login_data_admin')['nama'];
    // header("Content-type: application/vnd-ms-excel");
    // header("Content-Disposition: attachment; filename=Laporan Selesai Perkara ({$namaKesatuan}) - Periode {$dateNow}.xls");
?>

<style>
    .title-doc{
        padding-top:10rem;
    }
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
    $CI->load->model('Modelbarangbukti');
    $CI->load->model('Modeltersangka');
    $CI->load->model('Modelkesatuan');
?>

<div class="container">
    <h5>Status Kasus Selesai (SP3 / RJ / Tahap II)</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>
                    <th>Kesatuan</th>
                <?php } ?>
                <th>No Laporan Polisi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if(isset($dataCC)){ ?>
            <?php 
            $no = 1;
            foreach ($dataCC as $rowCC) { 
            ?>
            <tr>
                <td class="text-center"><?= $no ?></td>
                <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>
                    <td><?php
                        $result = $CI->Modelkesatuan->getKesatuanByKode($rowCC["kode_kesatuan"]);
                        echo $result[0]['nama']; ?>
                    </td>
                <?php } ?>
                <td><?= $rowCC["no_laporanpolisi"]; ?></td>
                <td>
                    <?php if(empty($rowCC["status_kasus"])){ ?>
                        <button class="btn btn-warning btn-sm"><strong>Belum Diketahui</strong></button>
                    <?php }else if ($rowCC["status_kasus"] == 'TAHAP II'){ ?>
                        <button class="btn btn-success btn-sm"><strong>Tahap II</strong></button>
                    <?php }else if($rowCC["status_kasus"] == 'SP3'){ ?>
                        <button class="btn btn-success btn-sm"><strong>SP3</strong></button>
                    <?php }else{?>
                        <button class="btn btn-success btn-sm"><strong>RJ</strong></button>
                    <?php } ?>
                </td>
            </tr>
            <?php $no++; } ?>
        <?php }else{?>
                <tr>
                    <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Selra Belum Tersedia</p></td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
    <br>
    <br>
    <h5>Status Kasus Belum Diketahui</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>
                    <th>Kesatuan</th>
                <?php } ?>
                <th>No Laporan Polisi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if(isset($dataCT)){ ?>
            <?php 
            $no = 1;
            foreach ($dataCT as $rowCT) { 
            ?>
            <tr>
                <td class="text-center"><?= $no ?></td>
                <?php if($this->session->userdata('login_data_admin')['kodekesatuan'] == 'ADMINSUPER'){ ?>
                    <td><?php
                        $result = $CI->Modelkesatuan->getKesatuanByKode($rowCT["kode_kesatuan"]);
                        echo $result[0]['nama']; ?>
                    </td>
                <?php } ?>
                <td><?= $rowCT["no_laporanpolisi"]; ?></td>
                <td>
                    <?php if(empty($rowCT["status_kasus"])){ ?>
                        <button class="btn btn-warning btn-sm"><strong>Belum Diketahui</strong></button>
                    <?php }else if ($rowCT["status_kasus"] == 'TAHAP II'){ ?>
                        <button class="btn btn-success btn-sm"><strong>Tahap II</strong></button>
                    <?php }else if($rowCT["status_kasus"] == 'SP3'){ ?>
                        <button class="btn btn-success btn-sm"><strong>SP3</strong></button>
                    <?php }else{?>
                        <button class="btn btn-success btn-sm"><strong>RJ</strong></button>
                    <?php } ?>
                </td>
            </tr>
            <?php $no++; } ?>
        <?php }else{?>
                <tr>
                    <td colspan="1" style="text-align:center;"><p style="color:grey;font-size:18px;">Data Selra Belum Tersedia</p></td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
</div>