<div id="homepage" class="homepage">
   <div class="uk-container uk-container-center">
       <div class="homepage-box">
           <div class="panel-search">
               <div class="uk-grid uk-grid-small ">
                   <div class="uk-width-small-1-1 uk-width-medium-1-2">
                       <div class="search-item">
                           <?php echo view_fix('frontend.homepage.common.filter') ?>
                       </div>
                   </div>
                   <div class="uk-width-small-1-1 uk-width-medium-1-2">
                      <?php if(isset($news) && is_array($news) && count($news)){ ?>
                       <div class="search-news">
                           <h3 class="heading-3"><span>Tin tức</span></h3>
                           <div class="uk-grid uk-grid-small">
                               <div class="uk-width-small-1-1 uk-width-medium-1-3">
                                  <?php foreach($news as $key => $val){ if($key > 0) break; ?>
                                   <div class="thumb">
                                       <a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>" class="image img-cover"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title']; ?>"></a>
                                   </div>
                                 <?php } ?>
                               </div>
                               <div class="uk-width-small-1-1 uk-width-medium-2-3">
                                   <div class="info">
                                      <?php foreach($news as $key => $val){ if($key > 0) break; ?>
                                       <h4 class="title"><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></h4>
                                       <div class="description"><?php echo cutnchar(strip_tags(base64_decode($val['description'])), 250) ?></div>
                                       <?php } ?>
                                       <div class="news-other">
                                           <ul class="uk-list uk-clearfix">
                                              <?php foreach($news as $key => $val){ if($key == 0) continue; ?>
                                               <li><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></li>
                                               <?php } ?>
                                           </ul>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                     <?php } ?>
                   </div>
               </div>
           </div>
           <?php if(isset($project) && is_array($project) && count($project)){ ?>
           <div class="panel-hot-project">
               <div class="panel-head uk-flex uk-flex-middle uk-flex-space-between">
                   <h2 class="heading-2"><span>DỰ ÁN NỔI BẬT</span></h2>
                   <div class="btn-more"><a href="<?php echo write_url('du-an') ?>" title="Dự Án">Xem thêm các dự án khác</a></div>
               </div>
               <div class="panel-body">
                   <div class="owl-carousel owl-theme owl-hot-project">
                     <?php foreach($project as $key => $val){ ?>
                     <?php
                        $title = $val['title'];
                        $canonical = write_url($val['canonical']);
                        $image = $val['image'];
                        $address = $val['address'];
                     ?>
                       <div class="hot-project-item">
                           <div class="thumb"><a href="<?php echo $canonical; ?>" class="image img-cover"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>"></a></div>
                           <div class="info">
                               <h3 class="title"><a href="<?php echo $canonical; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h3>
                               <div class="description"><?php echo $address; ?></div>
                               <div class="btn-group uk-flex uk-flex-middle uk-flex-space-between">
                                   <div class="btn-like"><a href="" onclick="return false;" title=""><i class="fas fa-heart fa-fw"></i></a></div>
                                   <div class="btn-cmt"><a href="" onclick="return false;" title=""><i class="fas fa-comment fa-fw"></i></a></div>
                                   <div class="btn-save"><a href="" onclick="return false;" title=""><i class="fas fa-bookmark fa-fw"></i></a></div>
                               </div>
                           </div>
                       </div>
                     <?php } ?>
                   </div>
               </div>
           </div>
         <?php } ?>
           <div class="panel-project">
               <div class="uk-grid uk-grid-small">
                   <div class="uk-width-small-1-1 uk-width-medium-3-4">
                       <div class="project-container">
                          <?php if(isset($productSell) && is_array($productSell) && count($productSell)){ ?>
                           <div class="project-box">
                               <h2 class="heading-2"><span>BẤT ĐỘNG SẢN BÁN</span></h2>
                               <div class="uk-grid uk-grid-small">
                                  <?php foreach($productSell as $key => $val){ ?>
                                   <div class="uk-width-small-1-1 uk-width-medium-1-2 mgcst">
                                       <div class="project-item">
                                          <?php
                                             $title = $val['title'];
                                             $canonical = write_url($val['canonical']);
                                             $price = read_num($val['price']);
                                             $image = $val['image'];
                                             $area = $val['area'];
                                             $district = $val['district'];
                                          ?>
                                           <div class="uk-grid uk-grid-small">
                                               <div class="uk-width-small-1-1 uk-width-medium-1-3">
                                                   <div class="thumb">
                                                       <a href="<?php echo $canonical ?>" title="<?php echo $val['title'] ?>" class="image img-cover"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" /></a>
                                                   </div>
                                               </div>
                                               <div class="uk-width-small-1-1 uk-width-medium-2-3">
                                                   <div class="info">
                                                       <h3 class="title"><a href="<?php echo $canonical ?>" title="<?php echo $val['title'] ?>"><?php echo $title; ?></a></h3>
                                                       <div class="content uk-flex uk-flex-middle uk-flex-space-between">
                                                           <div class="area">
                                                               DT: <span><?php echo $area; ?> m<sup>2</sup></span>
                                                           </div>
                                                           <div class="price">Giá: <span><?php echo $price; ?></span></div>
                                                       </div>
                                                       <div class="content uk-flex uk-flex-middle uk-flex-space-between">
                                                           <div class="adress"><?php echo $district; ?></div>
                                                           <div class="rating">
                                                               <a href="<?php echo $canonical ?>" title="<?php echo $val['title'] ?>">
                                                                   <i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i>
                                                               </a>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                 <?php } ?>
                               </div>
                               <div class="uk-text-right btn-more">
                                   <a href="<?php echo write_url('nha-dat-ban') ?>" title="Xem tất cả">Xem tất cả...</a>
                               </div>
                           </div>
                           <?php } ?>
                           <?php if(isset($productRent) && is_array($productRent) && count($productRent)){ ?>
                           <div class="project-box">
                               <h2 class="heading-2"><span>BẤT ĐỘNG SẢN CHO THUÊ</span></h2>
                               <div class="uk-grid uk-grid-small">
                                  <?php foreach($productRent as $key => $val){ ?>
                                     <?php
                                        $title = $val['title'];
                                        $canonical = write_url($val['canonical']);
                                        $price = read_num($val['price']);
                                        $image = $val['image'];
                                        $area = $val['area'];
                                        $district = $val['district'];
                                     ?>
                                   <div class="uk-width-small-1-1 uk-width-medium-1-2 mgcst">
                                       <div class="project-item">
                                           <div class="uk-grid uk-grid-small">
                                              <div class="uk-width-small-1-1 uk-width-medium-1-3">
                                                 <div class="thumb">
                                                    <a href="<?php echo $canonical ?>" title="<?php echo $val['title'] ?>" class="image img-cover"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" /></a>
                                                 </div>
                                             </div>
                                             <div class="uk-width-small-1-1 uk-width-medium-2-3">
                                                 <div class="info">
                                                    <h3 class="title"><a href="<?php echo $canonical ?>" title="<?php echo $val['title'] ?>"><?php echo $title; ?></a></h3>
                                                    <div class="content uk-flex uk-flex-middle uk-flex-space-between">
                                                         <div class="area">
                                                             DT: <span><?php echo $area; ?> m<sup>2</sup></span>
                                                         </div>
                                                         <div class="price">Giá: <span><?php echo $price; ?> / tháng</span></div>
                                                    </div>
                                                    <div class="content uk-flex uk-flex-middle uk-flex-space-between">
                                                         <div class="adress"><?php echo $district; ?></div>
                                                         <div class="rating">
                                                             <a href="<?php echo $canonical ?>" title="<?php echo $val['title'] ?>">
                                                                 <i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i>
                                                             </a>
                                                         </div>
                                                    </div>
                                                 </div>
                                             </div>
                                           </div>
                                       </div>
                                   </div>
                                 <?php } ?>
                               </div>
                               <div class="uk-text-right btn-more">
                                   <a href="<?php echo write_url('nha-dat-cho-thue') ?>" title="">Xem tất cả...</a>
                               </div>
                           </div>
                           <?php } ?>
                           <?php $banner = get_slide(['keyword' => 'home-banner','language' => 'vi']); ?>
                           <?php if(isset($banner) && is_array($banner) && count($banner)){ ?>
                           <div class="project-banner mb10">
                              <?php foreach($banner as $key => $val){ ?>
                               <div class="thumb">
                                   <a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>" class="image img-cover"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>" /></a>
                               </div>
                              <?php } ?>
                           </div>
                           <?php } ?>
                           <?php 
                                $panel = get_panel([
                                    'locate' => 'home',
                                    'language' => 'vi'
                                ]);
                                $panel_home = [];
                                if(isset($panel) && is_array($panel) && count($panel)){
                                    foreach ($panel as $value) {
                                        $panel_home[$value['keyword']] = $value;
                                    }
                                }
                            ?>
                            <?php if(isset($panel_home['intro']['data']) && is_array($panel_home['intro']['data']) && count($panel_home['intro']['data'])){ ?>
                               <div class="project-box">
                                   <div class="project-box-head uk-flex uk-flex-middle uk-flex-space-between">
                                       <h2 class="heading-2"><span><?php echo $panel_home['intro']['title'] ?></span></h2>
                                       <div class="btn-more"><a href="<?php echo $panel_home['intro']['canonical'].HTSUFFIX ?>" title="">Xem thêm các dự án khác</a></div>
                                   </div>
                                   <div class="project-box-body">
                                        <?php foreach ($panel_home['intro']['data'] as $value) { ?>
                                           <div class="project-item2">
                                               <div class="uk-grid uk-grid-small">
                                                   <div class="uk-width-small-1-1 uk-width-medium-2-5">
                                                       <div class="thumb">
                                                           <a href="" title="<?php echo $value['canonical'].HTSUFFIX ?>" class="image img-cover"><img src="<?php echo !empty($value['image']) ? $value['image'] : $general['homepage_logo'] ?>" alt="" /></a>
                                                       </div>
                                                   </div>
                                                   <div class="uk-width-small-1-1 uk-width-medium-3-5">
                                                       <div class="info">
                                                           <h3 class="title"><a href="" title=""><?php echo $value['title'] ?></a></h3>
                                                           <div class="description"><?php echo $value['description'] ?></div>
                                                           <!-- <div class="time">3 tuần trước</div> -->
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       <?php } ?>
                                   </div>
                               </div>
                           <?php } ?>
                       </div>
                   </div>
                   <div class="uk-width-small-1-1 uk-width-medium-1-4">
                       <div class="aside-homepage">
                          <?php $asideBanner = get_slide(['keyword' => 'aside-banner','language' => 'vi']) ?>
                          <?php if(isset($asideBanner) && is_array($asideBanner) && count($asideBanner)){ ?>
                           <div class="aside-banner">
                              <?php foreach($asideBanner as $key => $val){ ?>
                               <div class="thumb">
                                   <a class="image img-cover" href="<?php echo $val['canonical']; ?>" title="<?php echo $val['title'] ?>"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>" /></a>
                               </div>
                              <?php } ?>
                           </div>
                           <?php } ?>
                           <?php if(isset($broker) && is_array($broker) && count($broker)){ ?>
                           <div class="aside-broker">
                               <h4 class="title"><span>Nhà Môi Giới</span></h4>
                               <?php foreach($broker as $key => $val){ ?>
                               <div class="broker">
                                   <div class="uk-grid uk-grid-small mb5">
                                       <div class="uk-width-small-1-1 uk-width-medium-2-5">
                                           <div class="thumb"><a href="<?php echo write_url(BROKER.$val['id'].'/'.slug($val['fullname'])) ?>" title="<?php echo $val['fullname'] ?>" class="image img-cover"><img src="<?php echo $val['image'] ?>" alt=""></a></div>
                                       </div>
                                       <div class="uk-width-small-1-1 uk-width-medium-3-5">
                                           <div class="info">
                                               <div class="name"><i class="fas fa-user fa-fw"></i> <?php echo $val['fullname'] ?></div>
                                               <div class="phone"><i class="fas fa-phone fa-fw"></i> <?php echo $val['phone'] ?></div>
                                               <div class="address"><i class="fas fa-address-card fa-fw"></i> <?php echo $val['city'] ?></div>
                                               <div class="description"><?php echo $val['description']; ?></div>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="rating">
                                       <span>Được đánh giá:</span>
                                       <a href="" title=""><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i></a>
                                   </div>
                               </div>
                              <?php } ?>
                               <div class="btn-more uk-text-right"><a href="<?php echo write_url('danh-sach-broker') ?>" title="Xem thêm">Xem thêm...</a></div>
                           </div>
                           <?php } ?>
                           <?php if(isset($postCare) && is_array($postCare) && count($postCare)){ ?>
                           <div class="aside-take-care">
                               <h4 class="title"><span>Có thể bạn quan tâm</span></h4>
                               <div class="uk-accordion " data-uk-accordion="">
                                  <?php foreach($postCare as $key => $val){ ?>
                                   <div class="uk-accordion-title uk-flex uk-flex-middle">
                                       <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                       <h5 class="title"><span><?php echo $val['title'] ?></span></h5>
                                   </div>
                                   <div data-wrapper="true" style="height: 0px; position: relative; overflow: hidden;" aria-expanded="false">
                                       <div class="uk-accordion-content">
                                           <a href="<?php echo write_url($val['canonical']); ?>"><?php echo cutnchar(strip_tags(base64_decode($val['description'])), 250); ?></a>
                                       </div>
                                   </div>
                                    <?php } ?>
                               </div>
                           </div>
                           <?php } ?>
                           <?php $asideBanner2 = get_slide(['keyword' => 'aside-banner-2','language' => 'vi']) ?>
                          <?php if(isset($asideBanner2) && is_array($asideBanner2) && count($asideBanner2)){ ?>
                           <div class="aside-banner">
                              <?php foreach($asideBanner2 as $key => $val){ ?>
                              <div class="thumb">
                                   <a class="image img-cover" href="<?php echo $val['canonical']; ?>" title="<?php echo $val['title'] ?>"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>" /></a>
                              </div>
                              <?php } ?>
                           </div>
                           <?php } ?>
                           <?php $sidebarMenu = get_menu(['keyword' => 'sidebar-menu','output' => 'array', 'language' => 'vi']) ?>
                           <?php if(isset($sidebarMenu['data']) && is_array($sidebarMenu['data']) && count($sidebarMenu['data'])){ ?>
                           <div class="aside-project">
                               <h4 class="title"><span>MUA BÁN - CHO THUÊ</span></h4>
                               <div class="uk-grid uk-grid-small">
                                  <?php foreach($sidebarMenu['data'] as $key => $val){ ?>
                                   <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                       <div class="aside-project-item">
                                           <h5 class="title"><span><?php echo $val['title'] ?></span></h5>
                                           <?php if(isset($val['children']) && is_array($val['children']) && count($val['children'])){ ?>
                                           <ul class=" uk-clearfix">
                                             <?php foreach($val['children'] as $keyChild => $valChild){ ?>
                                             <li><a href="<?php echo write_url($valChild['canonical']) ?>" title="<?php echo $valChild['title'] ?>"><?php echo $valChild['title'] ?></a></li>
                                             <?php } ?>
                                           </ul>
                                          <?php } ?>
                                       </div>
                                   </div>
                                    <?php } ?>
                               </div>
                           </div>
                           <?php } ?>
                       </div>
                   </div>
               </div>
           </div>
           <?php $middleMenu = get_menu(['keyword' => 'middle-menu','language' => 'vi','output' => 'array']) ?>
           <?php if(isset($middleMenu) && is_array($middleMenu) && count($middleMenu)){ ?>
           <div class="panel-news">
             <ul class="uk-list uk-clearfix uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-2 uk-grid-width-large-1-4">
                <?php foreach($middleMenu['data'] as $key => $val){ ?>
                 <li><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></li>
               <?php } ?>
             </ul>
           </div>
         <?php } ?>
       </div>
   </div>
</div>
