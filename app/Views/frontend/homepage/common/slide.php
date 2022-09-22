<?php  $slide = get_slide(['keyword' => 'main-slide','language' => 'vi']);  ?>
<div class="panel-slide">
   <?php if(isset($slide) && is_array($slide) && count($slide)){ ?>
      <div class="uk-slidenav-position" data-uk-slideshow>
          <ul class="uk-slideshow">
            <?php foreach($slide as $key => $val){ ?>
            <li><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>"></li>
            <?php } ?>
          </ul>
          <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
          <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
          <ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-center">
             <?php foreach($slide as $key => $val){ ?>
              <li data-uk-slideshow-item="<?php echo $key; ?>"><a href=""></a></li>
            <?php } ?>
          </ul>
      </div>
      <?php } ?>
      <img src="public/frontend/resources/img/slide-border.png" alt="border">
</div>
