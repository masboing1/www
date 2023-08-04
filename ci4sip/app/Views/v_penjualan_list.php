<?php if ($display == 'form') { ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-3">
                    <label>Mulai Tanggal</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="tanggal1" name="tanggal1" value="<?= $tanggal1; ?>" data-date-format="yyyy-mm-dd">
                    </div>
                </div>
                <div class="col-md-3">
                    <label>Sampai Tanggal</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="tanggal2" name="tanggal2" value="<?= $tanggal2; ?>" data-date-format="yyyy-mm-dd">
                    </div>
                </div>
                <div class="col-md-3">
                    <label>Action</label>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="getdata"><i class="fa fa-eye"></i>
                            Getdata</button>
                        <a href="#" class="btn btn-default" onclick="cetak()"><i class="fa fa-print"></i> Cetak</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="box-body" style="overflow-x:auto;" id="result"></div>
    </div>
    <script>
        $('#tanggal1').datepicker({
            autoclose: true
        });
        $('#tanggal2').datepicker({
            autoclose: true
        });

        function cetak() {
            var tanggal1 = $('#tanggal1').val();
            var tanggal2 = $('#tanggal2').val();
            popupCenter("<?= base_url() . 'penjualanlist/cetak/'; ?>" + tanggal1 + "/" + tanggal2, "Cetak data penjualan", 1024,
                768);
        }

        $(document).ready(function() {

            $("#getdata").click(function(e) {
                var tanggal1 = $("#tanggal1").val();
                var tanggal2 = $("#tanggal2").val();
                $.ajax({
                    url: "<?= base_url(); ?>penjualanlist/getdata",
                    method: "POST",
                    data: {
                        tanggal1: tanggal1,
                        tanggal2: tanggal2
                    },
                    success: function(data) {
                        $('#result').html(data);
                    },
                    error: function(xhr, statusText, errorThrown) {
                        alert(xhr.responseText);
                    }
                })
            })
        });
    </script>
<?php }

if ($display == 'table') { ?>
    <!--- Transaction Table -->
    <div style="overflow-x:auto;">
        <table class="table table-bordered">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Faktur</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>Barang Id</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Harga </th>
                    <th>Jumlah</th>
                    <th>Potongan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                $tot_jumlah = 0;
                $tot_potongan = 0;
                $tot_total = 0;
                foreach ($data as $rs) {
                    $no++;
                    $sub_total = $rs['jumlah'] * $rs['hj'] - $rs['potongan'];
                    $tot_jumlah += $rs['jumlah'];
                    $tot_potongan += $rs['potongan'];
                    $tot_total += $sub_total;
                ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $rs['faktur']; ?></td>
                        <td><?= $rs['tanggal']; ?></td>
                        <td><?= $rs['pelanggan_name']; ?></td>
                        <td><?= $rs['barang_id']; ?></td>
                        <td><?= $rs['name']; ?></td>
                        <td><?= $rs['satuan']; ?></td>
                        <td class="text-right"><?= number_format($rs['hj'], 0, ",", "."); ?></td>
                        <td class="text-right"><?= $rs['jumlah']; ?></td>
                        <td class="text-right"><?= number_format($rs['potongan'], 0, ",", "."); ?></td>
                        <td class="text-right"><?= number_format($sub_total, 0, ",", "."); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center" colspan="8">Total</th>
                    <th class="text-right"><?= number_format($tot_jumlah, 0, ',', '.'); ?></th>
                    <th class="text-right"><?= number_format($tot_potongan, 0, ',', '.'); ?></th>
                    <th class="text-right"><?= number_format($tot_total, 0, ',', '.'); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
<?php }

if ($display == 'cetak') { ?>
    <table border="1" align="center" style="width:900px;margin-bottom:20px;">
        <thead>
            <tr style='background-color:#ccc;'>
                <th style="width:50px;">No</th>
                <th>No Faktur</th>
                <th>Tanggal</th>
                <th>Suplier Name </th>
                <th>Barang Id</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Potongan</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            $tot_jumlah = 0;
            $tot_potongan = 0;
            $tot_total = 0;
            foreach ($data as $rs) {
                $no++;
                $sub_total = $rs['jumlah'] * $rs['hj'] - $rs['potongan'];
                $tot_jumlah += $rs['jumlah'];
                $tot_potongan += $rs['potongan'];
                $tot_total += $sub_total;
            ?>
                <tr>
                    <td style="text-align:center;"><?= $no; ?></td>
                    <td style="padding-left:5px;"><?= $rs['faktur']; ?></td>
                    <td style="padding-left:5px;"><?= $rs['tanggal']; ?></td>
                    <td style="padding-left:5px;"><?= $rs['pelanggan_name']; ?></td>
                    <td style="text-align:center;"><?= $rs['barang_id']; ?></td>
                    <td style="text-align:left;"><?= $rs['name']; ?></td>
                    <td style="text-align:left;"><?= $rs['satuan']; ?></td>
                    <td style="text-align:right;"><?= number_format($rs['hj'], 0, ",", "."); ?></td>
                    <td style="text-align:right;"><?= $rs['jumlah']; ?></td>
                    <td style="text-align:right;"><?= number_format($rs['potongan'], 0, ",", "."); ?></td>
                    <td style="text-align:right;"><?= number_format($sub_total, 0, ",", "."); ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td align="center" colspan="8"><b>Total</b></td>
                <td align="right"><b><?= number_format($tot_jumlah, 0, ',', '.'); ?></b></td>
                <td align="right"><b><?= number_format($tot_potongan, 0, ',', '.'); ?></b></td>
                <td align="right"><b><?= number_format($tot_total, 0, ',', '.'); ?></b></td>
            </tr>
        </tfoot>
    </table>
    <table align="center" style="width:900px; border:none;margin-top:5px;margin-bottom:20px;">
        <tr>
            <td></td>
            <td width="30%" align="center">Banyuwangi, <?= TanggalIndoPanjang(date('Y-m-d')); ?><br><br><br><br>
                ( <?= session()->get('sip_name'); ?> )</td>
        </tr>
    </table>
<?php }; ?>