<form method="post" action="" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			<div class="col-lg-9 clearfix">
            <div class="ibox mb20">
               <div class="ibox-title" style="padding: 9px 15px 0px;">
                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                     <h5>Thông tin cơ bản <small class="text-danger">Điền đầy đủ các thông tin được mô tả dưới đây</small></h5>
                     <div class="ibox-tools">
                        <button type="submit" name="create" value="create" class="btn btn-primary block full-width m-b">Lưu</button>
                     </div>
                  </div>
               </div>
               <div class="ibox-content">
                  <?php echo view(convertUrl('backend.project.project.include.general')) ?>
               </div>
            </div>
			   <?php echo view(convertUrl('backend.project.project.include.gallery')) ?>
			   <?php echo view(convertUrl('backend.project.project.include.seo')) ?>
				<button type="submit" name="create" value="create" class="btn btn-primary block m-b pull-right">Lưu</button>
			</div>
			<div class="col-lg-3">
            <?php echo view(convertUrl('backend.project.project.include.aside')) ?>
			</div>
		</div>
	</div>
</form>
