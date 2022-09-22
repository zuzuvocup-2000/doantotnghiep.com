<section id="body">
    <div id="prdcatalogue-page" class="page-body pt50 pb50">
        <div class="uk-container uk-container-center">
           <div class="panel-product mb30">
             <div class="panel-head">
                <div class="heading-1"><span>Tìm kiếm theo từ khóa: <?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : '' ?></span></div>
             </div>
               <div class="medical-section-body">
                   <div class="uk-grid uk-grid-small">
                      <?php if(isset($productList) && is_array($productList) && count($productList)){
                           foreach ($productList as $val) {
                      ?>
                           <div class="uk-width-large-1-4 uk-width-1-2 mb10">
                              <div class="post-item-1">
                                 <a href="<?php echo write_url($val['canonical']) ?>" class="image img-cover"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>"></a>
                                 <div class="info">
                                    <h3 class="name"><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></h3>
                                    <div class="description"><?php echo strip_tags(base64_decode($val['description'])) ?></div>
                                    <div class="readmore"><a href="<?php echo write_url($val['canonical']) ?>">Đọc tiếp</a></div>
                                 </div>
                              </div>
                           </div>
                      <?php }} ?>
                   </div>
                   <div id="pagination">
                      <?php echo (isset($pagination)) ? $pagination : ''; ?>
                   </div>
               </div>
           </div>
        </div>
    </div>
</section>
