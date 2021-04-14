<div class="error-page">
    <?php if (@$Error["statusCode"] > 200) { ?>
    <h2 class="headline <?= @$Error["error"]["class"] ?>"><?= $Error["statusCode"] ?></h2>
    <?php } ?>
    <div class="error-content">
        <?php if (@$Error["error"]["type"]) { ?>
        <h3><i class="fas fa-exclamation-triangle <?= @$Error["error"]["class"] ?>"></i> <?= @$Error["error"]["type"] ?></h3>
        <?php } ?>
        <p><?= @$Error["error"]["description"] ?></p>
    </div>
    <!-- /.error-content -->
</div>
<!-- /.error-page -->