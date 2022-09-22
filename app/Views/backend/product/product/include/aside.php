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
               <?php echo form_dropdown('catalogueid', $config['dropdown'], set_value('catalogueid', (isset($product['catalogueid'])) ? $product['catalogueid'] : ''), 'data-module= "'.$config['module'].'" class="form-control m-b select2"');?>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="ibox mb20">
   <div class="ibox-title">
      <h5>Lựa chọn dự án </h5>
   </div>
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <div class="form-row">
               <?php echo form_dropdown('project_id', $project, set_value('project_id', (isset($product['project_id'])) ? $product['project_id'] : ''), 'data-module= "'.$config['module'].'" class="form-control m-b select2"');?>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="ibox mb20 ">
   <div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
      <h5 class="choose-image" style="cursor: pointer;margin:0;">Địa chỉ tài sản </h5>
   </div>
   <div class="ibox-content">
      <script>
         var cityid = '<?php echo (isset($_POST['city_id'])) ? $_POST['city_id'] : ((isset($product['city_id'])) ? $product['city_id'] : ''); ?>';
         var districtid = '<?php echo (isset($_POST['district_id'])) ? $_POST['district_id'] : ((isset($product['district_id'])) ? $product['district_id'] : ''); ?>'
         var wardid = '<?php echo (isset($_POST['wardid'])) ? $_POST['wardid'] : ((isset($product['wardid'])) ? $product['wardid'] : ''); ?>'
      </script>
      <div class="form-row mb10">
         <label for="" class="mb5">Thành Phố</label>
         <?php echo form_dropdown('city_id', $province, set_value('city_id', (isset($product['city_id'])) ? $product['city_id'] : ''), 'data-module= "'.$config['module'].'" id="city" class="form-control m-b select2"');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Quận / Huyện</label>
         <?php echo form_dropdown('district_id', ['Chọn Quận/Huyện'], set_value('district_id', (isset($product['district_id'])) ? $product['city_id'] : ''), 'data-module= "'.$config['module'].'" class="form-control m-b select2" id="district"');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Địa chỉ chi tiết</label>
         <?php echo form_input('address', htmlspecialchars_decode(set_value('address', (isset($product['address'])) ? $product['address'] : '')), 'class="form-control" placeholder="" autocomplete="off" ');?>
      </div>
   </div>
</div>

<div class="ibox mb20 ">
   <div class="ibox-title uk-flex-middle uk-flex uk-flex-space-between">
      <h5 class="choose-image" style="cursor: pointer;margin:0;">Thông tin chung </h5>
   </div>
   <div class="ibox-content">
      <div class="form-row mb10">
         <label for="" class="mb5">Mã tin</label>
         <?php echo form_input('code', htmlspecialchars_decode(set_value('code', (isset($product['code'])) ? $product['code'] : '')), 'class="form-control" placeholder="" autocomplete="off" ');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Hình Thức</label>
         <?php echo form_dropdown('form', PRODUCT_FORM, set_value('form', (isset($product['form'])) ? $product['form'] : ''), 'data-module= "'.$config['module'].'" class="form-control m-b select2"');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Giá bán/cho thuê</label>
         <?php echo form_input('price', htmlspecialchars_decode(set_value('price', (isset($product['price'])) ? commas($product['price']) : 0)), 'class="form-control int" placeholder="" autocomplete="off" ');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Loại Bất động sản</label>
         <?php echo form_dropdown('type', $productType, set_value('type', (isset($product['type'])) ? $product['type'] : ''), 'data-module= "'.$config['module'].'" class="form-control m-b select2"');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Hướng</label>
         <?php echo form_dropdown('direction', DIRECTION, set_value('direction', (isset($product['direction'])) ? $product['direction'] : ''), 'data-module= "'.$config['module'].'" class="form-control m-b select2"');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Diện tích</label>
         <?php echo form_input('area', htmlspecialchars_decode(set_value('area', (isset($product['area'])) ? $product['area'] : '')), 'class="form-control float" placeholder="" autocomplete="off" ');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Chiều ngang</label>
         <?php echo form_input('horizontal', htmlspecialchars_decode(set_value('horizontal', (isset($product['horizontal'])) ? $product['horizontal'] : '')), 'class="form-control float" placeholder="" autocomplete="off" ');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Chiều dài</label>
         <?php echo form_input('long', htmlspecialchars_decode(set_value('long', (isset($product['long'])) ? $product['long'] : '')), 'class="form-control float" placeholder="" autocomplete="off" ');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Đường trước nhà</label>
         <?php echo form_input('front', htmlspecialchars_decode(set_value('front', (isset($product['front'])) ? $product['front'] : '')), 'class="form-control float" placeholder="" autocomplete="off" ');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Số lầu</label>
         <?php echo form_input('floor', htmlspecialchars_decode(set_value('floor', (isset($product['floor'])) ? $product['floor'] : '')), 'class="form-control float" placeholder="" autocomplete="off" ');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Phòng ngủ</label>
         <?php echo form_input('bed', htmlspecialchars_decode(set_value('bed', (isset($product['bed'])) ? $product['bed'] : '')), 'class="form-control int" placeholder="" autocomplete="off" ');?>
      </div>
      <div class="form-row mb10">
         <label for="" class="mb5">Pháp lý</label>
         <?php echo form_input('juridical', htmlspecialchars_decode(set_value('juridical', (isset($product['juridical'])) ? $product['juridical'] : '')), 'class="form-control float" placeholder="" autocomplete="off" ');?>
      </div>
      <div class="form-row mb10">
         <div class="row">
            <div class="col-lg-6">
               <div class="uk-flex uk-flex-middle">
                  <input type="checkbox" name="dining_room" value="1" <?php echo (isset($product['dining_room']) && $product['dining_room'] == 1) ? 'checked' : ''; ?> id="dining_room">
                  <label for="dining_room" class="ml5">Phòng ăn</label>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="uk-flex uk-flex-middle">
                  <input type="checkbox" name="kitchen" value="1" <?php echo (isset($product['kitchen']) && $product['kitchen'] == 1) ? 'checked' : ''; ?> id="kitchen">
                  <label for="kitchen" class="ml5">Nhà bếp</label>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="uk-flex uk-flex-middle">
                  <input type="checkbox" name="terrace" value="1" <?php echo (isset($product['terrace']) && $product['terrace'] == 1) ? 'checked' : ''; ?> id="terrace">
                  <label for="terrace" class="ml5">Sân thượng</label>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="uk-flex uk-flex-middle">
                  <input type="checkbox" name="parking" value="1" <?php echo (isset($product['parking']) && $product['parking'] == 1) ? 'checked' : ''; ?> id="parking">
                  <label for="parking" class="ml5">Chỗ để xe</label>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="uk-flex uk-flex-middle">
                  <input type="checkbox" name="own" value="1" <?php echo (isset($product['own']) && $product['own'] == 1) ? 'checked' : ''; ?> id="own">
                  <label for="own" class="ml5">Chính chủ</label>
               </div>
            </div>
         </div>

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
         <?php echo form_input('icon', htmlspecialchars_decode(set_value('icon', (isset($product['icon'])) ? $product['icon'] : '')), 'class="form-control icon-display" placeholder="" autocomplete="off"  ');?>
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
                        <?php echo form_radio('publish', set_value('publish', 1), ((isset($_POST['publish']) && $_POST['publish'] == 1 || (isset($product['publish']) && $product['publish'] == 1)) ? true : (!isset($_POST['publish'])) ? true : false),'class=""  id="publish"  style="margin-top:0;margin-right:10px;" '); ?>
                        <label for="publish" style="margin:0;cursor:pointer;">Cho phép hiển thị trên website</label>
                     </span>
                  </div>
               </div>
               <div class="block clearfix">
                  <div class="i-checks" style="width:100%;">
                     <span style="color:#000;" class="uk-flex uk-flex-middle">
                        <?php echo form_radio('publish', set_value('publish', 0), ((isset($_POST['publish']) && $_POST['publish'] == 0 || (isset($product['publish']) && $product['publish'] == 0)) ? true : false),'class=""   id="no-publish" style="margin-top:0;margin-right:10px;" '); ?>

                        <label for="no-publish" style="margin:0;cursor:pointer;">Không Cho phép hiển thị trên website</label>
                     </span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
