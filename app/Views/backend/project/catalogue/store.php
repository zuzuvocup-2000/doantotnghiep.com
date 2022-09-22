<form method="post" action="" class="form-horizontal box" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			<div class="col-lg-9 clearfix">
            <?php echo view_fix('backend.project.catalogue.include.general') ?>
            <?php echo view_fix('backend.project.catalogue.include.gallery') ?>
            <?php echo view_fix('backend.project.catalogue.include.seo') ?>
				<button type="submit" name="create" value="create" class="btn btn-primary block m-b pull-right">Lưu</button>
			</div>
			<div class="col-lg-3">
			   <?php echo view_fix('backend.project.catalogue.include.aside') ?>
			</div>
		</div>
	</div>
</form>
