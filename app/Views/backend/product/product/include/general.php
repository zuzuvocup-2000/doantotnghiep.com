<div class="row mb15">
   <div class="col-lg-12">
      <div class="form-row">
         <label class="control-label text-left">
            <span>Tiêu đề Sản phẩm <b class="text-danger">(*)</b></span>
         </label>
         <?php echo form_input('title', validate_input(set_value('title', (isset($product['title'])) ? $product['title'] : '')), 'class="form-control '.(($config['method'] == 'create') ? 'title' : '').'" placeholder="" id="title" autocomplete="off"'); ?>
      </div>
   </div>
</div>
<div class="row mb15">
   <div class="col-lg-12">
      <div class="form-row form-description">
         <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <label class="control-label text-left">
               <span>Mô tả ngắn</span>
            </label>
            <a href="" title="" data-target="description" class="uploadMultiImage">Upload hình ảnh</a>
         </div>
         <?php echo form_textarea('description', htmlspecialchars_decode(html_entity_decode(set_value('description', (isset($product['description'])) ? $product['description'] : ''))), 'class="form-control ck-editor" id="description" placeholder="" autocomplete="off"');?>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-lg-12	">
      <div class="form-row mb15">
         <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <label class="control-label text-left">
               <span>Nội dung</span>
            </label>
            <a href="" title="" data-target="content" class="uploadMultiImage">Upload hình ảnh</a>
         </div>
         <?php echo form_textarea('content', htmlspecialchars_decode(html_entity_decode(set_value('content', (isset($product['content'])) ? $product['content'] : ''))), 'class="form-control ck-editor" id="content" placeholder="" autocomplete="off"');?>
      </div>
      <div class="uk-flex uk-flex-middle uk-flex-space-between">
         <label class="control-label text-left ">
            <span>Nội dung mở rộng</span>
         </label>
         <a href="" title="" class="add-attr" onclick="return false;">Thêm nội dung +</a>
      </div>
   </div>
</div>
