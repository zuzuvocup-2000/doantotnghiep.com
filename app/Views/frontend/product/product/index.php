<div id="articlepage" class="articlepage">
     <div class="uk-container uk-container-center">
         <div class="article-container">
             <div class="panel-breacum">
                 <ul class="uk-list uk-clearfix uk-flex">
                     <li><a href="" title="">Trang chủ</a></li>
                     <?php foreach($breadcrumb as $key => $val){ ?>
                     <li><a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></li>
                     <?php } ?>
                 </ul>
             </div>
             <div class="article-container-head">
                 <div class="uk-grid uk-grid-small">
                     <div class="uk-width-small-1-1 uk-width-medium-2-3">
                        <div class="article-content">
                             <div class="article-content-head">
                                 <h1 class="heading-1"><span><?php echo $object['title'] ?></span></h1>
                                 <div class="timeline uk-text-right">Ngày đăng: <?php echo $object['created_at'] ?></div>
                             </div>
                             <div class="article-content-body">
                                 <div class="info">
                                    <?php echo $object['description']; ?>
                                 </div>
                                 <div class="moreinfor">
                                     <span class="price">
                                        <span class="label">Giá: </span>
                                        <span class="value"> <?php echo read_num($object['price']) ?> <?php echo ($object['form'] == 2 || $object['form'] == 3) ? '/ tháng' : '' ?></span>
                                     </span>
                                     <span class="square">
                                         <span class="label">Diện tích: </span> <span class="value"> <?php echo $object['area'] ?> m<sup>2</sup></span>
                                     </span>
                                     <div class="clear"></div>
                                 </div>
                                 <div class="address mb10"><span class="label">Địa chỉ tài sản:</span><span class="value"> <?php echo $object['address'] ?></span></div>
                                 <?php $direction = DIRECTION; ?>
                                 <div class="moreinfor1">
                                     <div class="title">Các thông tin khác</div>
                                     <div class="infor">
                                         <table vspace="0" hspace="0" cellspacing="0">
                                             <tbody>
                                                 <tr>
                                                     <td>Mã tin</td>
                                                     <td><?php echo $object['code'] ?></td>
                                                     <td>Hướng</td>
                                                     <td><?php echo $direction[$object['direction']]; ?></td>
                                                     <td>Phòng ăn</td>
                                                     <td>
                                                        <?php echo ($object['dining_room'] == 1) ? '<img src="public/frontend/resources/img/check.gif" />' : '-' ?>
                                                     </td>
                                                 </tr>
                                                 <tr>
                                                     <td>Loại tin</td>
                                                     <td>
                                                        <?php $type = PRODUCT_FORM; ?>
                                                        <?php echo $type[$object['form']] ?>
                                                     </td>
                                                     <td>Đường trước nhà</td>
                                                     <td><?php echo $object['front'] ?></td>
                                                     <td>Nhà bếp</td>
                                                     <td><?php echo ($object['kitchen'] == 1) ? '<img src="public/frontend/resources/img/check.gif" />' : '-' ?></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Loại BDS</td>
                                                     <td><?php echo $object['product_type'] ?></td>
                                                     <td>Pháp lý</td>
                                                     <td><?php echo $object['juridical'] ?></td>
                                                     <td>Sân thượng</td>
                                                     <td><?php echo ($object['terrace'] == 1) ? '<img src="public/frontend/resources/img/check.gif" />' : '-' ?></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Chiều ngang</td>
                                                     <td><?php echo $object['horizontal'] ?>m</td>
                                                     <td>Số lầu</td>
                                                     <td><?php echo $object['floor'] ?></td>
                                                     <td>Chổ để xe hơi</td>
                                                     <td><?php echo ($object['parking'] == 1) ? '<img src="public/frontend/resources/img/check.gif" />' : '-' ?></td>
                                                 </tr>
                                                 <tr>
                                                     <td>Chiều dài</td>
                                                     <td><?php echo $object['long'] ?>m</td>
                                                     <td>Số phòng ngủ</td>
                                                     <td><?php echo $object['bed'] ?></td>
                                                     <td>Chính chủ</td>
                                                     <td><?php echo ($object['own'] == 1) ? '<img src="public/frontend/resources/img/check.gif" />' : '-' ?></td>
                                                 </tr>
                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                                 <div class="image-tab"><span class="view-image selected">Hình ảnh</span></div>
                                 <?php $album = json_decode($object['album'], TRUE); ?>
                                 <?php if(isset($album) && is_array($album) && count($album)){ ?>
                                 <div class="container-gallery">
                                     <div class="swiper mySwiper2">
                                         <div class="swiper-wrapper">
                                            <?php foreach($album as $key => $val){ ?>
                                             <div class="swiper-slide">
                                                 <a class="img-cover img-zoomin" href="<?php echo $val; ?>" data-uk-lightbox="{group:'group-feedback'}" title="Title">
                                                     <img src="<?php echo $val; ?>" />
                                                 </a>
                                             </div>
                                             <?php } ?>
                                         </div>
                                         <div class="swiper-button-next uk-text-center">
                                             <i class="fa fa-angle-right"></i>
                                         </div>
                                         <div class="swiper-button-prev uk-text-center">
                                             <i class="fa fa-angle-left"></i>
                                         </div>
                                     </div>
                                     <div thumbsSlider="" class="swiper mySwiper">
                                         <div class="swiper-wrapper">
                                             <?php foreach($album as $key => $val){ ?>
                                             <div class="swiper-slide">
                                                 <div href="" class="img-cover img-zoomin">
                                                     <img src="<?php echo $val; ?>" />
                                                 </div>
                                             </div>
                                             <?php } ?>
                                         </div>
                                         <div class="swiper-button-next uk-text-center">
                                             <i class="fa fa-angle-right"></i>
                                         </div>
                                         <div class="swiper-button-prev uk-text-center">
                                             <i class="fa fa-angle-left"></i>
                                         </div>
                                     </div>
                                 </div>
                                 <?php } ?>
                                 <!--<div class="btn-save-news uk-text-right"><a href="" title="">Lưu tin</a></div>-->
                                 <div class="reflect-form mt20 uk-hidden">
                                     <div class="title">Phản ánh tin rao vi phạm</div>
                                     <div class="notice">Thông tin phản ánh của Quý khách giúp chúng tôi sàn lọc thông tin tốt hơn và loại trừ các nhà môi giới không trung thực. Xin trân trọng cám ơn.</div>
                                     <div class="content">
                                         <div class="reason">
                                             <div class="uk-flex uk-flex-middle">
                                                <input type="radio" class="reason-item" name="reason" value="1" /> <span>Tài sản đã bán/cho thuê</span>
                                             </div>
                                             <div class="uk-flex uk-flex-middle">
                                                <input type="radio" class="reason-item" name="reason" value="2" /> <span>Tin không có thật</span>
                                             </div>
                                             <div class="uk-flex uk-flex-middle">
                                                <input type="radio" class="reason-item" name="reason" value="3" /> <span>Nội dung không đúng với thực tế</span>
                                             </div>
                                             <div class="uk-flex uk-flex-middle">
                                                <input type="radio" class="reason-item" name="reason" value="4" /> <span>Giá không đúng</span>
                                             </div>
                                             <div class="uk-flex uk-flex-middle">
                                                <input type="radio" class="reason-item" name="reason" value="5" /> <span>Không liên lạc được</span>
                                             </div>
                                             <div class="uk-flex uk-flex-middle">
                                                <input type="radio" class="reason-item" name="reason" value="6" /> <span>Địa chỉ bất động sản không đúng</span>
                                             </div>
                                             <div class="uk-flex uk-flex-middle">
                                                <input type="radio" class="reason-item" name="reason" value="7" /> <span>Lý do khác</span>
                                             </div>
                                             <div class="clear"></div>
                                         </div>
                                         <div class="other-reason">
                                             <textarea class="txtcontent" placeholder="Nội dung phản ánh" maxlength="240"></textarea>
                                         </div>
                                         <div class="check-ignore">
                                             <div class="uk-flex uk-flex-middle mb10">
                                                <input type="checkbox" class="chkdayignore mr5" />
                                                <b class="bdayignore">Tôi không muốn xem tin của người đăng này trong vòng:</b>
                                             </div>
                                             <select class="dayignore mb10" name="dayignore"  style="color: red; background: #eeeeee;">
                                                 <option value="0">Số ngày</option>
                                                 <option value="1">1 ngày</option>
                                                 <option value="3">3 ngày</option>
                                                 <option value="7">7 ngày</option>
                                                 <option value="14">14 ngày</option>
                                                 <option value="21">21 ngày</option>
                                                 <option value="30">30 ngày</option>
                                                 <option value="60">60 ngày</option>
                                                 <option value="90">90 ngày</option>
                                                 <option value="180">180 ngày</option>
                                                 <option value="360">360 ngày</option>
                                             </select>
                                             <i>Tất cả các tin của thành viên này sẽ ẩn đi với bạn trong khoảng thời gian bạn đã chọn.</i>
                                         </div>
                                         <div>
                                             <input class="btnSubmit" type="button" value="Gửi phản ánh" />
                                         </div>
                                     </div>
                                 </div>
                                 <!--<div class="tags">Có thể bạn muốn xem:
                                     <a href="" title="">Cho thuê phòng trọ Hồ Chí Minh</a>
                                     <a href="" title="">Cho thuê phòng trọ Quận Bình Thạnh</a>
                                     <a href="" title="">Cho thuê phòng trọ Phường 25</a>
                                     <a href="" title="">Cho thuê phòng trọ Đường Nguyễn Gia Trí</a>
                                 </div>-->
                                 <div class="notices">
                                     <h3><span>Lưu ý:</span></h3>
                                     <p>Các bạn đang xem tin đăng trong mục "<b><?php echo $detailCatalogue['title'] ?></b>". Các thông tin rao vặt là do người đăng tin đăng tải toàn bộ thông tin. Chúng tôi hoàn toàn không chịu trách nhiệm về bất cứ thông tin nào liên qua đến các thông tin này. Chúng tôi luôn cố gắng để đưa các tin tức nhanh và chính xác nhất cho các bạn.</p>
                                 </div>
                             </div>
                             <?php if(isset($product_general) && is_array($product_general) && count($product_general)){ ?>
                             <div class="article-content-foot">
                                 <h2 class="heading-2"><span>Bất động sản cùng chuyên mục</span></h2>
                                 <?php foreach($product_general as $key => $val){ ?>
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
                                     <div class="uk-grid uk-grid-small">
                                         <div class="uk-width-small-1-1 uk-width-medium-1-5">
                                             <div class="thumb">
                                                 <a href="<?php echo $canonical; ?>" title="<?php echo $title; ?>" class="image img-cover"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>"></a>
                                             </div>
                                         </div>
                                         <div class="uk-width-small-1-1 uk-width-medium-4-5">
                                             <div class="info">
                                                 <div class="characteristics uk-flex uk-flex-middle uk-flex-space-between ">
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
                                 <?php } ?>
                                 <div class="btn-more uk-text-right"><a href="<?php echo write_url($detailCatalogue['canonical']) ?>" title="Xem các tin khác">Xem các tin khác</a></div>
                             </div>
                              <?php } ?>
                        </div>
                     </div>
                     <div class="uk-width-small-1-1 uk-width-medium-1-3">
                        <div class="aside-article" data-uk-sticky="{boundary:true, top:5}">
                             <div class="contact">
                                 <div class="contact-info" style="margin-top: 0px;">
                                     <div class="title">Thông tin liên hệ</div>
                                     <div class="content">
                                         <div class="name"><?php echo $member['fullname'] ?></div>
                                         <div class="fone"><a href="tel:<?php echo $member['phone'] ?>"><?php echo $member['phone'] ?></a></div>
                                         <div class="review-box">
                                             <span class="review-score">Được đánh giá:</span>
                                             <span class="review-star">
                                                 <span class="rate" style="width: 100%;"></span>
                                             </span>
                                         </div>
                                         <?php if($member['owner'] == 'member'){ ?>
                                         <div class="view-more"><a href="/nha-moi-gioi/member-<?php echo $member['id'] ?>.html">Xem thêm 2 tin khác của thành viên này</a></div>
                                       <?php } ?>
                                     </div>
                                 </div>
                             </div>
                             <script>
                              var cityid = '<?php echo (isset($object['city_id'])) ? $object['city_id'] : ''; ?>';
                              var districtid = '<?php echo (isset($object['district_id'])) ? $object['district_id'] : ''; ?>'
                              var wardid = ''
                           </script>
                             <div class="aside-search-item">
                                <form action="<?php echo write_url('tim-kiem-nang-cao') ?>" method="get">
                                    <div class="form-field mb5 uk-flex uk-flex-middle ">
                                        <input type="text" class="location" placeholder="Nhập địa điểm cần tìm" autocomplete="off">
                                    </div>
                                    <div class="uk-grid uk-grid-small">
                                        <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                           <div class="search-col">
                                               <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                   <?php echo form_dropdown('form', PRODUCT_FORM, set_value('form', $object['form']), ' class="demand"');?>
                                               </div>
                                               <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                    <?php echo form_dropdown('city_id', $city, set_value('city_id'), 'id="city" class="demand"');?>
                                               </div>
                                               <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                    <?php echo form_dropdown('district_id', ['Chọn Quận/Huyện'], set_value('district_id'), 'class="demand" id="district"');?>
                                               </div>
                                               <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                    <?php echo form_dropdown('area', AREA, set_value('area'), 'class="form-control demand m-b select2"');?>
                                               </div>
                                           </div>
                                        </div>
                                        <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                           <div class="search-col">
                                               <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                    <?php echo form_dropdown('type', $productType, set_value('type', (isset($object['type'])) ? $object['type'] : ''), ' class="property-type"');?>
                                               </div>
                                               <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                 <?php echo form_dropdown('price_range', $productPrice, set_value('price'), ' class="property-type"');?>
                                               </div>
                                               <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                                                    <?php echo form_dropdown('direction', DIRECTION, set_value('direction'), 'class="form-control demand m-b select2"');?>
                                               </div>
                                               <div class="btn-group uk-text-right">
                                                   <div class="btn-search "><button type="submit" name="search" value="search">Tìm kiếm</button></div>
                                               </div>
                                           </div>
                                        </div>
                                    </div>
                                </form>
                           </div>
                             <?php if(isset($district) && is_array($district) && count($district)){ ?>
                             <div class="aside-navigation-box">
                                 <div class="item">
                                     <h2 class="title"><span> <?php echo ($object['form'] == 0 || $object['form'] == 1) ? 'Bán ' : 'Cho thuê ' ?> <?php echo $object['product_type'] ?> tại <?php echo $object['city_name'] ?></span></h2>
                                     <ul class="uk-list uk-clearfix" style="max-height: 100%;">
                                        <?php foreach($district as $key => $val){ ?>
                                         <li><a href="<?php echo product_by_district_url($val['name'], $val['districtid'], $object['type'], $object['form']) ?>" title="<?php echo $val['name']; ?>">
                                           <?php echo ($object['form'] == 0 || $object['form'] == 1) ? 'Bán đất ' : 'Cho thuê ' ?> <?php echo $val['name'] ?>
                                         </a> <span class="count">(<?php echo $val['count_product'] ?>)</span></li>
                                          <?php } ?>
                                     </ul>
                                 </div>
                             </div>
                           <?php } ?>
                           <?php if(isset($projectByDistrict) && is_array($projectByDistrict) && count($projectByDistrict)){ ?>
                             <div class="aside-navigation-box">
                                 <div class="item">
                                     <h2 class="title"><span><?php echo ($object['form'] == 0 || $object['form'] == 1) ? 'Bán' : 'Cho thuê'; ?> <?php echo $object['product_type'] ?> tại <?php echo $object['district_name'] ?></span></h2>
                                     <ul class="uk-list uk-clearfix" style="max-height: 100%;">
                                        <?php foreach($projectByDistrict as $key => $val){ ?>
                                         <li><a href="<?php echo product_by_project_url($val['title'], $val['id'], $object['form']) ?>" title="<?php echo $val['title'] ?>"><?php echo ($object['form'] == 0 || $object['form'] == 1) ? 'Bán đất ' : 'Cho thuê ' ?> <?php echo $val['title'] ?></a></li>
                                       <?php } ?>
                                     </ul>
                                 </div>
                             </div>
                           <?php } ?>
                        </div>
                     </div>
                 </div>
             </div>
             <div class="article-container-foot">
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
