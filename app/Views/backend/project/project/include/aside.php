<div class="ibox mb20">
   <div class="ibox-title">
      <h5>Lựa chọn danh mục cha </h5>
   </div>
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <div class="form-row mb10">
               <small class="text-danger">Chọn [Root] Nếu không có danh mục cha</small>
            </div>
            <div class="form-row">
               <?php echo form_dropdown('catalogueid', $config['dropdown'], set_value('catalogueid', (isset($project['catalogueid'])) ? $project['catalogueid'] : ''), 'data-module= "'.$config['module'].'" class="form-control m-b select2"');?>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="ibox mb20">
   <div class="ibox-title">
      <h5>Lựa chọn loại dự án </h5>
   </div>
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <div class="form-row mb10">
               <small class="text-danger">Loại Dự Án</small>
            </div>
            <div class="form-row">
               <?php echo form_dropdown('type', $projectType, set_value('type', (isset($project['type'])) ? $project['type'] : ''), 'class="form-control m-b select2"');?>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="ibox mb20 ">
   <div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
      <h5 class="choose-image" style="cursor: pointer;margin:0;">Địa chỉ dự án </h5>
   </div>
   <div class="ibox-content">
      <script>
         var cityid = '<?php echo (isset($_POST['city_id'])) ? $_POST['city_id'] : ((isset($project['city_id'])) ? $project['city_id'] : ''); ?>';
         var districtid = '<?php echo (isset($_POST['district_id'])) ? $_POST['district_id'] : ((isset($project['district_id'])) ? $project['district_id'] : ''); ?>'
         var wardid = '<?php echo (isset($_POST['wardid'])) ? $_POST['wardid'] : ((isset($project['wardid'])) ? $project['wardid'] : ''); ?>'
      </script>
      <div class="form-row mb10">
         <label for="" class="mb5">Thành Phố</label>
         <?php echo form_dropdown('city_id', $province, set_value('city_id', (isset($project['city_id'])) ? $project['city_id'] : ''), 'data-module= "'.$config['module'].'" id="city" class="form-control m-b select2"');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Quận / Huyện</label>
         <?php echo form_dropdown('district_id', ['Chọn Quận/Huyện'], set_value('district_id', (isset($project['district_id'])) ? $project['city_id'] : ''), 'data-module= "'.$config['module'].'" class="form-control m-b select2" id="district"');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Địa chỉ chi tiết</label>
         <?php echo form_input('address', htmlspecialchars_decode(set_value('address', (isset($project['address'])) ? $project['address'] : '')), 'class="form-control" placeholder="" autocomplete="off" ');?>
      </div>
   </div>
</div>


<div class="ibox mb20 ">
   <div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
      <h5 class="choose-image" style="cursor: pointer;margin:0;">Icon </h5>
      <a href="" title="" data-target="image" class="uploadIcon">Upload hình ảnh</a>
   </div>
   <div class="ibox-content">
      <div class="form-row">
         <?php echo form_input('icon', htmlspecialchars_decode(set_value('icon', (isset($project['icon'])) ? $project['icon'] : '')), 'class="form-control icon-display" placeholder="" autocomplete="off"  ');?>
      </div>
   </div>
</div>


<div class="ibox mb20">
   <div class="ibox-title">
      <h5>Hiển thị </h5>
   </div>
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <div class="form-row">
               <div class="text-warning mb15">Quản lý thiết lập hiển thị cho blog này.</div>
               <div class="block clearfix">
                  <div class="i-checks mr30" style="width:100%;">
                     <span style="color:#000;" class="uk-flex uk-flex-middle">
                        <?php echo form_radio('publish', set_value('publish', 1), ((isset($_POST['publish']) && $_POST['publish'] == 1 || (isset($project['publish']) && $project['publish'] == 1)) ? true : (!isset($_POST['publish'])) ? true : false),'class=""  id="publish"  style="margin-top:0;margin-right:10px;" '); ?>
                        <label for="publish" style="margin:0;cursor:pointer;">Cho phép hiển thị trên website</label>
                     </span>
                  </div>
               </div>
               <div class="block clearfix">
                  <div class="i-checks" style="width:100%;">
                     <span style="color:#000;" class="uk-flex uk-flex-middle">
                        <?php echo form_radio('publish', set_value('publish', 0), ((isset($_POST['publish']) && $_POST['publish'] == 0 || (isset($project['publish']) && $project['publish'] == 0)) ? true : false),'class=""   id="no-publish" style="margin-top:0;margin-right:10px;" '); ?>

                        <label for="no-publish" style="margin:0;cursor:pointer;">Không Cho phép hiển thị trên website</label>
                     </span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
