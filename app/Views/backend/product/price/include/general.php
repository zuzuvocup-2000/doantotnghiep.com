<div class="row mb15">
   <div class="col-lg-12">
      <div class="form-row">
         <label class="control-label text-left">
            <span>Tiêu đề <b class="text-danger">(*)</b></span>
         </label>
         <?php echo form_input('title', validate_input(set_value('title', (isset($price['title'])) ? $price['title'] : '')), 'class="form-control '.(($config['method'] == 'create') ? 'title' : '').'" placeholder="" id="title" autocomplete="off"'); ?>
      </div>
   </div>
</div>
<div class="row mb15">
   <div class="col-lg-6">
      <div class="form-row">
         <label class="control-label text-left">
            <span>Giá Min <b class="text-danger">(*)</b></span>
         </label>
         <?php echo form_input('price_min', validate_input(set_value('price_min', (isset($price['price_min'])) ? $price['price_min'] : '')), 'class="form-control int" placeholder="" autocomplete="off"'); ?>
      </div>
   </div>

   <div class="col-lg-6">
      <div class="form-row">
         <label class="control-label text-left">
            <span>Giá Max <b class="text-danger">(*)</b></span>
         </label>
         <?php echo form_input('price_max', validate_input(set_value('price_min', (isset($price['price_max'])) ? $price['price_max'] : '')), 'class="form-control int" placeholder="" autocomplete="off"'); ?>
      </div>
   </div>
</div>
