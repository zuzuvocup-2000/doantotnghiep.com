<?php
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $languageList = get_list_language(['currentLanguage' => $language]);
?>
<script>
    var _module = '<?php echo $config['module'] ?>';
</script>

<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý Sản Phẩm</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url(convertUrl('backend.dashboard.dashboard.index')) ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý Sản Phẩm</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title uk-flex uk-flex-middle uk-flex-space-between">
                    <div class="uk-flex uk-flex-middle">
                        <h5 class="mb0 ">Quản lý Sản Phẩm </h5>
                        <div class="uk-button ml20">
                            <a href="<?php echo base_url(convertUrl('backend.product.catalogue.index')) ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> QL Nhóm Sản phẩm</a>
                        </div>
                    </div>
                    <?php echo view_fix('backend.product.product.include.toolbox') ?>
                </div>
                <div class="ibox-content">
                    <?php echo view_fix('backend.product.product.include.filter') ?>
                    <?php echo view_fix('backend.product.product.include.table') ?>
                </div>
            </div>
        </div>
    </div>
</div>
