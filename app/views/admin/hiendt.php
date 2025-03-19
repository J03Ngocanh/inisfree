<div class="dashboard-box">
    <?php if (empty($salesData)) { ?>
        <p>No revenue data.</p>
    <?php } else { ?>
        <?php foreach ($salesData as $sale) { ?>
            <div class="box">
                <h3>Revenue for <?php echo $sale['thang']; ?> - <?php echo $sale['nam']; ?></h3>
                <p><?php echo number_format($sale['doanhThu'], 0, ',', '.'); ?> VND</p>
            </div>
        <?php } ?>
    <?php } ?>
</div>
