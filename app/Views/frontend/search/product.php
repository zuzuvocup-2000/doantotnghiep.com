<div id="projectpage" class="projectpage">
    <div class="uk-container uk-container-center">
       <div class="project-container">
            <div class="project-container-head">
                <div class="uk-grid uk-grid-small">
                    <div class="uk-width-small-1-1 uk-width-medium-2-3">
                        <div class="main-project">
                            <div class="panel-breacum">
                               <ul class="uk-list uk-clearfix uk-flex">
                                   <li><a href="" title="">Trang chủ</a></li>
                                   <li><a href="" onclick="return false;" title="Tìm kiếm nâng cao">Tìm kiếm nâng cao</a></li>
                               </ul>
                            </div>
                            <?php $now = date("Y/m/d");  ?>
                            <?php $direction = DIRECTION;  ?>
                            <h1 class="heading-1"><span>Tìm kiếm dự án bất động sản</span></h1>
                            <?php if(isset($productList) && is_array($productList) && count($productList)){ ?>
                               <?php foreach($productList as $key => $val){ ?>
                                 <?php
                                    $title = $val['title'];
                                    $canonical = write_url($val['canonical']);
                                    $image = $val['image'];
                                    $description = cutnchar(strip_tags($val['description']), 250);
                                    $area = $val['area'];
                                    $floor = $val['floor'];
                                    $bed = $val['bed'];
                                    $front = $val['front'];
                                 ?>
                               <div class="project-page-item">
                                <div class="timeline"><?php echo gettime($val['created_at']); ?></div>
                                <h3 class="title"><a href="<?php echo $canonical; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h3>
                                <div class="rating"><a href=""><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i><i class="fas fa-star fa-fw"></i></a></div>
                                <div class="uk-grid uk-grid-small">
                                    <div class="uk-width-small-1-1 uk-width-medium-1-5">
                                        <div class="thumb">
                                           <a href="<?php echo $canonical; ?>" title="<?php echo $title; ?>" class="image img-cover"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>"></a>
                                        </div>
                                    </div>
                                    <div class="uk-width-small-1-1 uk-width-medium-4-5">
                                        <div class="info">
                                           <div class="description"><?php echo $description; ?> <a href="<?php echo $canonical; ?>" class="btn-more" title=""><< xem chi tiết >></a></div>
                                           <div class="characteristics uk-flex uk-flex-middle uk-flex-space-between">
                                                <span class="road-width" title="Đường trước nhà 10m"><?php echo $front; ?>m</span>
                                                <span class="floor"><?php echo $floor; ?> lầu</span>
                                                <span class="bedroom"><?php echo $bed; ?> phòng ngủ</span>
                                           </div>
                                           <div class="content uk-flex uk-flex-middle uk-flex-space-between">
                                                <div class="area"><strong>Diện tích: </strong><?php echo $area; ?>m <sup>2</sup></div>
                                                <div class="kt"><strong>KT: </strong><?php echo $val['horizontal'] ?>x<?php echo $val['long'] ?>m</div>
                                                <div class="direction"><strong>Hướng: </strong><?php echo $direction[$val['direction']] ?></div>
                                           </div>
                                           <div class="content uk-flex uk-flex-middle uk-flex-space-between">
                                                <div class="price"><span>Giá: </span><?php echo read_num($val['price']) ?> </div>
                                                <div class="address"><strong><?php echo $val['address']; ?></strong></div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           <?php }} ?>
                           <?php echo (isset($pagination)) ? $pagination : '' ?>
                        </div>
                    </div>
                    <script>
                       var cityid = '<?php echo (isset($_GET['city_id'])) ? $_GET['city_id'] : ''; ?>';
                       var districtid = '<?php echo (isset($_GET['district_id'])) ? $_GET['district_id'] : ''; ?>'
                       var wardid = ''
                    </script>
                    <div class="uk-width-small-1-1 uk-width-medium-1-3">
                        <div class="aside-project-page">
                            <div class="aside-search-item">
                                <form action="<?php echo write_url('tim-kiem-nang-cao') ?>" method="get">
                                    <div class="form-field mb5 uk-flex uk-flex-middle ">
                                        <input type="text" class="location" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword']  :'' ?>" placeholder="Nhập địa điểm cần tìm" autocomplete="off">
                                    </div>
                                    <div class="uk-grid uk-grid-small">
                                        <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                           <div class="search-col">
                                                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                   <?php echo form_dropdown('form', PRODUCT_FORM, set_value('form', (isset($_GET['form'])) ? $_GET['form'] : ''), ' class="demand"');?>
                                                </div>
                                                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                     <?php echo form_dropdown('city_id', $city, set_value('city_id', ((isset($_GET['city_id'])) ? $_GET['city_id'] : '')), 'id="city" class="demand"');?>
                                                </div>
                                                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                    <?php echo form_dropdown('district_id', ['Chọn Quận/Huyện'], set_value('district_id'), 'class="demand" id="district"');?>
                                                </div>
                                                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                    <?php echo form_dropdown('area', AREA, set_value('area', (isset($_GET['area'])) ? $_GET['area'] : ''), 'class="form-control demand m-b select2"');?>
                                                </div>
                                           </div>
                                        </div>
                                        <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                           <div class="search-col">
                                                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                     <?php echo form_dropdown('type', $productType, set_value('type', (isset($_GET['type'])) ? $_GET['type'] : ''), ' class="property-type"');?>
                                                </div>
                                                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                  <?php echo form_dropdown('price_range', $productPrice, set_value('price', (isset($_GET['price_range'])) ? $_GET['price_range']  : ''), ' class="property-type"');?>
                                                </div>
                                                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                     <?php echo form_dropdown('direction', DIRECTION, set_value('direction', (isset($_GET['direction'])) ? $_GET['direction']  : ''), 'class="form-control demand m-b select2"');?>
                                                </div>
                                                <div class="btn-group uk-text-right">
                                                    <div class="btn-search "><button type="submit" name="search" value="search">Tìm kiếm</button></div>
                                                </div>
                                           </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="aside-navigation-box">
                              <?php if(isset($province) && is_array($province) && count($province)){ ?>
                                <div class="item">
                                    <h2 class="title"><span>Mua bán nhà đất, bất động sản</span></h2>
                                    <ul class="uk-list uk-clearfix" style="max-height: 100%;">
                                       <?php foreach($province as $key => $val){ ?>
                                        <li><a href="<?php echo sell_city_url($val['name'], $val['provinceid']) ?>" title="<?php echo $val['name'] ?>">Bán nhà đất <?php echo format_city_name($val['name']); ?></a></li>
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
