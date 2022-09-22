<div id="exppage" class="exppage">
      <div class="uk-container uk-container-center">
          <div class="exp-container">
              <div class="exp-container-head">
                  <div class="panel-breacum">
                      <ul class="uk-list uk-clearfix uk-flex">
                          <li><a href="" title="">Trang chủ</a></li>
                          <?php foreach($breadcrumb as $key => $val){ ?>
                          <li><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></li>
                        <?php } ?>
                      </ul>
                  </div>

                  <div class="main-exp">
                      <div class="uk-grid uk-grid-small">
                          <div class="uk-width-small-1-1 uk-width-medium-7-10 border-right">
                              <div class="post-wrapper">
                                 <h1 class="post-title"><?php echo $object['title'] ?></h1>
                                 <div class="description">
                                    <?php echo $object['description']; ?>
                                 </div>
                                 <div class="content">
                                    <?php echo $object['content']; ?>
                                 </div>
                              </div>
                          </div>
                          <div class="uk-width-small-1-1 uk-width-medium-3-10">
                              <div class="aside-exp">
                                 <?php if(isset($hotPost) && is_array($hotPost) && count($hotPost)){ ?>
                                  <div class="hotarticle">
                                      <h4 class="title"><span>Tin nổi bật</span></h4>
                                      <ul>
                                         <?php foreach($hotPost as $key => $val){ ?>
                                          <li><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></li>
                                          <?php } ?>
                                      </ul>
                                  </div>
                                 <?php } ?>
                                 <?php if(isset($mostView) && is_array($mostView) && count($mostView)){ ?>
                                  <div class="mostreader">
                                      <h4 class="title"><span>Tin nhiều người đọc</span></h4>
                                      <ul>
                                         <?php foreach($mostView as $key => $val){ ?>
                                          <li><a href="<?php echo write_urL($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></li>
                                          <?php } ?>
                                      </ul>
                                  </div>
                                 <?php } ?>
                                 <?php if(isset($experience) && is_array($experience) && count($experience)){ ?>
                                  <div class="aside-exp-article">
                                  <h4 class="title"><span>Kinh nghiệm mua</span></h4>
                                      <div class="content">
                                         <?php foreach($experience as $key => $val){ ?>
                                          <?php if($key > 0) break; ?>
                                          <div class="aside-article-item">
                                              <div class="thumb"><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>" class="image img-cover"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>"></a></div>
                                              <div class="info">
                                                  <h5 class="title"><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></h5>
                                              </div>
                                          </div>
                                          <?php } ?>
                                          <?php foreach($experience as $key => $val){ ?>
                                           <?php if($key == 0) continue; ?>
                                          <div class="aside-article-list">
                                              <div class="uk-grid uk-grid-small">
                                                  <div class="uk-width-small-1-1 uk-width-medium-1-4">
                                                      <div class="thumb"><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $title; ?>" class="image img-cover"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>"></a></div>
                                                  </div>
                                                  <div class="uk-width-small-1-1 uk-width-medium-3-4">
                                                      <div class="info">
                                                          <h5 class="title"><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></h5>
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
                      </div>
                  </div>
              </div>
              <div class="exp-container-foot">
                  <div class="house-bottom-navigation">
                     <?php if(isset($province) && is_array($province) && count($province)){ ?>
                      <ul class="uk-list uk-clearfix">
                         <?php foreach($province as $key => $val){ ?>
                          <li>
                              <a href="<?php echo sell_city_url($val['name'], $val['provinceid']) ?>">Nhà đất <b><?php echo format_city_name($val['name']); ?></b></a>
                          </li>
                           <?php } ?>
                      </ul>
                     <?php } ?>
                  </div>
              </div>
          </div>
      </div>
  </div>
