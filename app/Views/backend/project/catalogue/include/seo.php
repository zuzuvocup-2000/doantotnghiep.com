<div class="ibox ibox-seo mb20">
   <div class="ibox-title">
      <div class="uk-flex uk-flex-middle uk-flex-space-between">
         <h5>Cấu hình SEO</h5>
         <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="edit">
               <a href="#" class="edit-seo">Chỉnh sửa SEO</a>
            </div>
         </div>
      </div>
   </div>
   <div class="ibox-content">
      <div class="row">
         <div class="col-lg-12">
            <?php
               $metaTitle = (isset($_POST['meta_title'])) ? $_POST['meta_title'] : ((isset($projectCatalogue['meta_title']) && $projectCatalogue['meta_title'] != '') ? $projectCatalogue['meta_title'] : '') ;
               $googleLink = (isset($_POST['canonical'])) ? $_POST['canonical'] : ((isset($projectCatalogue['canonical']) && $projectCatalogue['canonical'] != '') ? BASE_URL.$projectCatalogue['canonical'].HTSUFFIX : BASE_URL.'duong-dan-website'.HTSUFFIX) ;
               $metaDescription = (isset($_POST['meta_description'])) ? $_POST['meta_description'] : ((isset($projectCatalogue['meta_description']) && $projectCatalogue['meta_description'] != '') ? $projectCatalogue['meta_description'] : '') ;
            ?>
            <div class="google">
               <div class="g-title"><?php echo $metaTitle; ?></div>
               <div class="g-link"><?php echo $googleLink ?></div>
               <div class="g-description" id="metaDescription">
                  <?php echo $metaDescription; ?>

               </div>
            </div>
         </div>
      </div>

      <div class="seo-group hidden">
         <hr>
         <div class="row mb15">
            <div class="col-lg-12">
               <div class="form-row">
                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                     <label class="control-label ">
                        <span>Tiêu đề SEO</span>
                     </label>
                     <span style="color:#9fafba;"><span id="titleCount">0</span> ký tự</span>
                  </div>
                  <?php echo form_input('meta_title', htmlspecialchars_decode(html_entity_decode(set_value('meta_title', (isset($projectCatalogue['meta_title'])) ? $projectCatalogue['meta_title'] : ''))), 'class="form-control meta-title" placeholder="" autocomplete="off"');?>
               </div>
            </div>
         </div>
         <div class="row mb15">
            <div class="col-lg-12">
               <div class="form-row">
                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                     <label class="control-label ">
                        <span>Mô tả SEO</span>
                     </label>
                     <span style="color:#9fafba;"><span id="descriptionCount">0</span> Ký Tự</span>
                  </div>
                  <?php echo form_textarea('meta_description', set_value('meta_description', (isset($projectCatalogue['meta_description'])) ? $projectCatalogue['meta_description'] : ''), 'class="form-control meta-description" id="seoDescription" placeholder="" autocomplete="off"');?>
               </div>
            </div>
         </div>
         <div class="row mb15">
            <div class="col-lg-12">
               <div class="form-row">
                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                     <label class="control-label ">
                        <span>Đường dẫn <b class="text-danger">(*)</b></span>
                     </label>
                  </div>
                  <div class="outer">
                     <div class="uk-flex uk-flex-middle">
                        <div class="base-url"><?php echo base_url(); ?></div>
                        <?php echo form_input('canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($projectCatalogue['canonical'])) ? $projectCatalogue['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off" data-flag="0" ');?>
                        <?php echo form_hidden('original_canonical', htmlspecialchars_decode(html_entity_decode(set_value('original_canonical', (isset($projectCatalogue['canonical'])) ? $projectCatalogue['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off"');?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

   </div>

</div>
