<div id="planpage" class="planpage">
      <div class="uk-container uk-container-center">
          <div class="plan-container">
              <div class="plan-container-head">
                  <div class="uk-grid uk-grid-small">
                      <div class="uk-width-small-1-1 uk-width-medium-2-3">
                          <div class="main-plan">
                              <div class="panel-breacum">
                                  <ul class="uk-list uk-clearfix uk-flex">
                                      <li><a href="" title="">Trang chủ</a></li>
                                      <li><a href="<?php echo write_url($canonical) ?>" title="">Danh sách dự án <?php echo $projectTypeDetail['title'] ?> </a></li>
                                  </ul>
                              </div>
                              <div class="plan-slide">
                                 <?php if(isset($project['list']) && is_array($project['list']) && count($project['list'])){ ?>
                                  <div class="owl-carousel owl-theme owl-plan">
                                     <?php foreach($project['list'] as $key => $val){ ?>
                                       <?php if($key > 0) break; ?>
                                      <div class="plan-slide-item">
                                          <div class="thumb"><a href="<?php echo write_url($val['canonical']) ?>" class="image img-cover"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>"></a></div>
                                          <div class="info">
                                              <h3 class="title"><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></h3>
                                              <div class="address"><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['address'] ?>"><?php echo $val['address'] ?></a></div>
                                          </div>
                                      </div>
                                       <?php } ?>
                                  </div>
                                 <?php } ?>
                                 <?php if(isset($project['list']) && is_array($project['list']) && count($project['list'])){ ?>
                                  <div class="plan-article">
                                      <div class="uk-grid uk-grid-small">
                                         <?php foreach($project['list'] as $key => $val){ ?>
                                          <?php if($key == 0) continue;  ?>
                                          <?php if($key > 3) break;  ?>
                                          <div class="uk-width-small-1-1 uk-width-medium-1-3">
                                              <div class="plan-article-item">
                                                  <div class="thumb"><a href="<?php echo write_url($val['canonical']) ?>" class="image img-cover"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>"></a></div>
                                                  <div class="info">
                                                      <h3 class="title"><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title']; ?>"><?php echo $val['title']; ?></a></h3>
                                                      <div class="address"><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['city'] ?>"><?php echo $val['city'] ?></a></div>
                                                  </div>
                                              </div>
                                          </div>
                                          <?php } ?>
                                      </div>
                                  </div>
                                 <?php } ?>
                              </div>

                              <div class="list-plan">
                                  <h2 class="heading-2"><span>Danh sách dự án <?php echo $projectTypeDetail['title'] ?>
                                  <?php echo (isset($detailDistrict) && is_array($detailDistrict)) ? ''.$detailDistrict['name'] : '' ?>
                                   <?php echo (isset($detailCity) && is_array($detailCity)) ? ''.$detailCity['name'] : '' ?> </span></h2>
                                  <?php if(isset($project['list']) && is_array($project['list']) && count($project['list'])){ ?>
                                 <?php foreach($project['list'] as $key => $val){ ?>
                                 <?php if($key <= 3) continue; ?>
                                  <div class="list-plan-item">
                                      <div class="uk-grid uk-grid-small">
                                          <div class="uk-width-small-1-1 uk-width-medium-1-4">
                                              <div class="thumb"><a href="<?php echo write_url($val['canonical']); ?>" title="<?php echo $val['title']; ?>" class="image img-cover"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>"></a></div>
                                          </div>
                                          <div class="uk-width-small-1-1 uk-width-medium-3-4">
                                              <div class="info">
                                                  <h3 class="title"><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></h3>
                                                  <div class="address"><?php echo $val['address'] ?></div>
                                                  <div class="description"><?php echo cutnchar(strip_tags($val['description']), 250); ?></div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                 <?php }} ?>
                                 <?php echo (isset($pagination)) ? $pagination : '' ?>
                              </div>
                          </div>
                      </div>
                      <div class="uk-width-small-1-1 uk-width-medium-1-3">
                          <div class="aside-plan">
                              <div class="aside-plan-search">
                                  <h4 class="title"><span>Tìm kiếm dự án</span></h4>
                                 <form action="<?php echo site_url('frontend/project/catalogue/findProjectByType') ?>" class="content" method="get">
                                      <div class="form-field">
                                          <input type="text" id="projectname" name="keyword" maxlength="100" placeholder="Nhập tên cần tìm" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" autocomplete="off" />
                                      </div>
                                      <div class="form-field">
                                          <select name="project_type_id" id="" class="projectcategory">
                                              <option value="0">Loại dự án</option>
                                              <?php if(isset($projectTypeList) && is_array($projectTypeList) && count($projectTypeList)){ ?>
                                              <?php foreach($projectTypeList as $key => $val){ ?>
                                              <option <?php echo (isset($_GET['project_type_id']) && $_GET['project_type_id'] == $val['id'])  ? 'selected'  : '' ?> value="<?php echo $val['id'] ?>"><?php echo $val['title'] ?></option>
                                             <?php } ?>
                                             <?php } ?>
                                          </select>
                                      </div>

                                      <script>
                                         var cityid = '<?php echo (isset($_GET['city_id'])) ? $_GET['city_id'] : ''; ?>';
                                         var districtid = '<?php echo (isset($_GET['district_id'])) ? $_GET['district_id'] : ''; ?>'
                                         var wardid = ''
                                      </script>
                                      <div class="form-field">
                                         <?php echo form_dropdown('city_id', $city, set_value('city_id'), 'id="city" class="province"');?>
                                      </div>
                                      <div class="form-field">
                                          <?php echo form_dropdown('district_id', ['Chọn Quận/Huyện'], set_value('district_id'), 'class="district" id="district"');?>
                                      </div>
                                      <div class="form-field" style="text-align: center;">
                                          <input type="submit" class="button" value="Tìm kiếm" onclick="SearchProject()" />
                                      </div>
                                  </form>
                              </div>
                              <div class="aside-plan-list">
                                  <h4 class="title"><span>Dự án bất động sản</span></h4>
                                  <?php if(isset($projectTypeList) && is_array($projectTypeList) && count($projectTypeList)){ ?>
                                  <ul class="uk-list uk-clearfix">
                                    <?php foreach($projectTypeList as $key => $val){ ?>
                                       <li><a href="<?php echo project_type_url($val['title'], $val['id']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></li>
                                    <?php } ?>
                                  </ul>
                                 <?php } ?>
                              </div>
                              <div class="aside-navigation-box">
                                 <?php if(isset($province) && is_array($province) && count($province)){ ?>
                                  <div class="item">
                                      <h2 class="title"><span>Dự án bất động sản</span></h2>
                                      <ul class="uk-list uk-clearfix" style="max-height: 100%;">
                                         <?php foreach($province as $key => $val){ ?>
                                          <li><a href="<?php echo project_city_url($val['name'], $val['provinceid']) ?>" title="Ban nha dat Ha Noi">Dự án bất động sản <strong><?php echo format_city_name($val['name']) ?></strong></a> <span class="count">(<?php echo $val['project_count'] ?>)</span></li>
                                          <?php } ?>
                                      </ul>
                                  </div>
                                 <?php } ?>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="project-container-foot">
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
