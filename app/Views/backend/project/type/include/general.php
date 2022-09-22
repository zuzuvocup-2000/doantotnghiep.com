<div class="row mb15">
   <div class="col-lg-12">
      <div class="form-row">
         <label class="control-label text-left">
            <span>Tiêu đề <b class="text-danger">(*)</b></span>
         </label>
         <?php echo form_input('title', validate_input(set_value('title', (isset($type['title'])) ? $type['title'] : '')), 'class="form-control '.(($config['method'] == 'create') ? 'title' : '').'" placeholder="" id="title" autocomplete="off"'); ?>
      </div>
   </div>
</div>
