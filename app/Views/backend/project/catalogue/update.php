<?php
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Cập nhật nhóm dự án</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>">Dashboard</a>
			</li>
			<li class="active"><strong>Cập nhật nhóm dự án</strong></li>
		</ol>
	</div>
</div>
<?php echo view_fix('backend.project.catalogue.store'); ?>
