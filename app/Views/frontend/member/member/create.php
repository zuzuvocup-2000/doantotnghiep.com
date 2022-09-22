<link rel="stylesheet" href="public/frontend/resources/plugins/dropzone-5.7.0/dist/min/dropzone.min.css">
<script src="public/frontend/resources/plugins/dropzone-5.7.0/dist/min/dropzone.min.js"></script>
<script>
   var cityid = '<?php echo (isset($_POST['city_id'])) ? $_POST['city_id'] : ''; ?>';
   var districtid = '<?php echo (isset($_POST['district_id'])) ? $_POST['district_id'] : ''; ?>'
   var wardid = ''
</script>
<?php
    $ds          = DIRECTORY_SEPARATOR;
    $APPPATH = substr(APPPATH, 0 ,-5);
    $storeFolder_1 = 'image_member';
    $targetFile_1 =  $storeFolder_1.$ds.$ds."member_".$member['id'].$ds.$ds.slug(date('Y-m-d'), strtotime(gmdate('Y-m-d H:i:s', time() + 7*3600))).'-' ;
 ?>
<div id="postpage" class="postpage">
    <form action="" method="post" class="submit-form-post">
        <div class="uk-container uk-container-center">
            <div class="post-container">
                <div class="post-container-head">
                    <div class="uk-grid uk-grid-small">
                        <div class="uk-width-small-1-1 uk-width-medium-3-4">
                            <div class="post-main">
                                <div class="post-info post-form">
                                    <h2 class="title"><span>Thông tin bắt buộc</span></h2>
                                    <div class="form-field uk-flex">
                                        <label for="">Tiêu đề (<span>*</span>)</label>
                                        <?php echo form_input('title', set_value('title'), ' placeholder="Tiêu đề" id="title" autocomplete="off" title="Tiêu đề từ 10 - 90 ký tự" maxlength="90"'); ?>
                                    </div>
                                    <div class="form-field uk-flex">
                                        <label for="">Nội dung  <br> <span style="font-style:italic;color:#555555;font-weight:normal">(Thành viên vui lòng <span style="color:Red;font-weight:bold">KHÔNG</span> nhập số điện thoại trong nội dung)</span></label>
                                        <?php echo form_textarea('content', htmlspecialchars_decode(html_entity_decode(set_value('content'))), 'class="form-control ck-editor" id="content" placeholder="" autocomplete="off"') ?>
                                    </div>
                                    <div class="form-double">
                                        <div class="uk-grid uk-grid-small">
                                            <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                                <div class="form-field uk-flex">
                                                    <label for="">Tên liên hệ </label>
                                                    <?php echo form_input('fullname', set_value('fullname'), ' id="fullname" autocomplete="off" title="Họ và tên từ 10 - 90 ký tự" maxlength="90" placeholder="Họ và tên"'); ?>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                                <div class="form-field uk-flex">
                                                    <label for="">Điện thoại </label>
                                                    <?php echo form_input('phone', set_value('phone'), ' id="phone" autocomplete="off"  placeholder="Số điện thoại"'); ?>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                                <div class="form-field uk-flex">
                                                    <label for="">Loại tin </label>
                                                    <?php echo form_dropdown('form', PRODUCT_FORM, set_value('form'), ' class="loaitin"');?>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                                <div class="form-field uk-flex">
                                                    <label for="">Danh mục BĐS </label>
                                                    <?php echo form_dropdown('catalogueid', $config['dropdown'], set_value('catalogueid'), 'class="form-control m-b select2"');?>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                                <div class="form-field uk-flex">
                                                    <label for="">Loại BĐS </label>
                                                    <?php echo form_dropdown('type', $productType, set_value('type'), ' class="form-control m-b select2"');?>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                                <div class="form-field uk-flex">
                                                    <label for="">Tỉnh / Thành phố </label>
                                                    <?php echo form_dropdown('city_id', $province, set_value('city_id'), 'id="city" class="demand form-control"');?>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                                <div class="form-field uk-flex">
                                                    <label for="">Quận / Huyện </label>
                                                    <?php echo form_dropdown('district_id', ['Chọn Quận/Huyện'], set_value('district_id'), 'class="demand form-control" id="district"');?>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                                <div class="form-field uk-flex">
                                                    <label for="">Địa chỉ  <br> <span style="font-style:italic;color:#555555;font-weight:normal">(Lưu ý(*): Ghi rõ tên đường/phố, phường/xã nếu <span style="color:Red;font-weight:bold">không tìm thấy</span> trong danh sách)</span></label>
                                                    <?php echo form_input('address', set_value('address'), ' id="address" autocomplete="off"  placeholder="Địa chỉ"'); ?>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                                <div class="form-field uk-flex">
                                                    <label for="">Phường / Xã </label>
                                                    <?php echo form_dropdown('ward_id', ['Chọn Phường/Xã'], set_value('ward_id'), 'class="demand form-control" id="ward"');?>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                                <div class="form-field uk-flex">
                                                    <label for="">Dự án </label>
                                                    <?php echo form_dropdown('project', $project_list, set_value('project'), 'class="demand form-control" id="project"');?>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-1-1 uk-width-medium-1-2">
                                                <div class="form-field uk-flex">
                                                    <label for="">Diện tích </label>
                                                    <?php echo form_input('area', set_value('area'), ' id="area" autocomplete="off"  placeholder="Diện tích"'); ?>
                                                    <span class="m2">m<sup>2</sup></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-field uk-flex uk-flex-middle font-custom">
                                        <label class="price" for="">Giá(<span>*</span>)</label>
                                        <?php echo form_input('price', htmlspecialchars_decode(set_value('price')), 'class="form-control price int" placeholder="" autocomplete="off" ');?>
                                    </div>
                                    <div class="note" style="color: #1029AC;font-style: italic;">Cố tình đăng tin thiếu chính xác, <b>sai địa chỉ</b>, <b>sai mức giá</b> (giá thấp hơn giá thực tế), <b>chọn sai dự án</b> sẽ bị <b style="color:Red">khóa tài khoản vĩnh viễn</b></div>
                                </div>
                                <div class="post-other post-form-other">
                                    <h2 class="title"><span>Các thông tin khác</span></h2>
                                    <div class="uk-grid uk-grid-small">
                                        <div class="uk-width-small-1-1 uk-width-medium-4-5">
                                            <div class="uk-grid uk-grid-small">
                                                <div class="uk-width-small-1-1 uk-width-medium-1-2 mgcst">
                                                    <div class="form-field uk-flex uk-flex-middle">
                                                       <label for="">Chiều ngang </label>
                                                       <?php echo form_input('horizontal', htmlspecialchars_decode(set_value('horizontal')), 'class="form-control float" placeholder="" autocomplete="off" ');?>
                                                       <span class="m2">m</span>
                                                    </div>
                                                </div>
                                                <div class="uk-width-small-1-1 uk-width-medium-1-2 mgcst">
                                                    <div class="form-field uk-flex uk-flex-middle">
                                                       <label for="">Chiều dài </label>
                                                       <?php echo form_input('long', htmlspecialchars_decode(set_value('long')), 'class="form-control float" placeholder="" autocomplete="off" ');?>
                                                       <span class="m2">m</span>
                                                    </div>
                                                </div>
                                                <div class="uk-width-small-1-1 uk-width-medium-1-2 mgcst">
                                                    <div class="form-field uk-flex uk-flex-middle">
                                                       <label for="">Hướng </label>
                                                       <?php echo form_dropdown('direction', DIRECTION, set_value('direction'), 'class="form-control m-b select2"');?>
                                                    </div>
                                                </div>
                                                <div class="uk-width-small-1-1 uk-width-medium-1-2 mgcst">
                                                    <div class="form-field uk-flex uk-flex-middle">
                                                       <label for="">Đường trước nhà </label>
                                                       <?php echo form_input('front', htmlspecialchars_decode(set_value('front')), 'class="form-control float" placeholder="" autocomplete="off" ');?>
                                                       <span class="m2">m</span>
                                                    </div>
                                                </div>
                                                <div class="uk-width-small-1-1 uk-width-medium-1-2 mgcst">
                                                    <div class="form-field uk-flex uk-flex-middle">
                                                       <label for="">Pháp lý </label>
                                                       <?php echo form_input('juridical', htmlspecialchars_decode(set_value('juridical')), 'class="form-control " placeholder="" autocomplete="off" ');?>
                                                    </div>
                                                </div>
                                                <div class="uk-width-small-1-1 uk-width-medium-1-2 mgcst">
                                                    <div class="form-field uk-flex uk-flex-middle">
                                                       <label for="">Số lầu </label>
                                                       <?php echo form_input('floor', htmlspecialchars_decode(set_value('floor')), 'class="form-control float" placeholder="" autocomplete="off" ');?>
                                                    </div>
                                                </div>
                                                <div class="uk-width-small-1-1 uk-width-medium-1-2 mgcst">
                                                    <div class="form-field uk-flex uk-flex-middle">
                                                       <label for="">Số phòng ngủ </label>
                                                       <?php echo form_input('bed', htmlspecialchars_decode(set_value('bed')), 'class="form-control int" placeholder="" autocomplete="off" ');?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-small-1-1 uk-width-medium-1-5">
                                            <div class="checkbox uk-flex uk-flex-middle">
                                                <input type="checkbox" name="dining_room" value="1" <?php echo (isset($_POST['dining_room']) && $_POST['dining_room'] == 1) ? 'checked' : ''; ?> id="dining_room">
                                                <label for="dining_room" class="ml5">Phòng ăn</label>
                                            </div>
                                            <div class="checkbox uk-flex uk-flex-middle">
                                                <input type="checkbox" name="kitchen" value="1" <?php echo (isset($_POST['kitchen']) && $_POST['kitchen'] == 1) ? 'checked' : ''; ?> id="kitchen">
                                                <label for="kitchen" class="ml5">Nhà bếp</label>
                                            </div>
                                            <div class="checkbox uk-flex uk-flex-middle">
                                                <input type="checkbox" name="terrace" value="1" <?php echo (isset($_POST['terrace']) && $_POST['terrace'] == 1) ? 'checked' : ''; ?> id="terrace">
                                                <label for="terrace" class="ml5">Sân thượng</label>
                                            </div>
                                            <div class="checkbox uk-flex uk-flex-middle">
                                                <input type="checkbox" name="parking" value="1" <?php echo (isset($_POST['parking']) && $_POST['parking'] == 1) ? 'checked' : ''; ?> id="parking">
                                                <label for="parking" class="ml5">Chỗ để xe</label>
                                            </div>
                                            <div class="checkbox uk-flex uk-flex-middle">
                                                <input type="checkbox" name="own" value="1" <?php echo (isset($_POST['own']) && $_POST['own'] == 1) ? 'checked' : ''; ?> id="own">
                                                <label for="own" class="ml5">Chính chủ</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="map">
                                    <h2 class="title"><span>Bản đồ</span></h2>
                                    <div class="map_description">Để tăng độ tin cậy và tin rao được nhiều người quan tâm hơn, hãy sửa vị trí tin rao của bạn trên bản đồ bằng cách <a href="javascript:void(0)" class="showmap" >Chọn lại vị trí bản đồ<span style="font-size:15px;line-height:17px;">✍</span></a></div>
                                    <?php echo form_textarea('map', htmlspecialchars_decode(html_entity_decode(set_value('map'))), 'class="form-control " id="map" placeholder="" autocomplete="off"') ?>
                                </div>
                                <div class="upload-image">
                                    <h2 class="title"><span>Hình ảnh</span></h2>
                                    <div class="upload-description" style="font-size:14px"><b style="color:Blue">Lưu ý khi đăng ảnh:</b> <span>Sử dụng hình <b>ảnh thật của tài sản</b> hoặc <b>không sử dụng ảnh</b>. Đăng ảnh không phải của tài sản sẽ bị <b style="color:Red">khóa tài khoản vĩnh viễn</b>.</span></div>
                                    <div class="upload">
                                        <div class="wrap-form">
                                            <div class="dropzone" id="demoupload">
                                                <div class=" needsclick dz-clickable" >
                                                    <div class="dz-message needsclick">
                                                        <div class="icon">
                                                            <a type="button" title="upload">
                                                                <svg style="width:80px;height:80px;fill: #d3dbe2;margin-bottom: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><path d="M80 57.6l-4-18.7v-23.9c0-1.1-.9-2-2-2h-3.5l-1.1-5.4c-.3-1.1-1.4-1.8-2.4-1.6l-32.6 7h-27.4c-1.1 0-2 .9-2 2v4.3l-3.4.7c-1.1.2-1.8 1.3-1.5 2.4l5 23.4v20.2c0 1.1.9 2 2 2h2.7l.9 4.4c.2.9 1 1.6 2 1.6h.4l27.9-6h33c1.1 0 2-.9 2-2v-5.5l2.4-.5c1.1-.2 1.8-1.3 1.6-2.4zm-75-21.5l-3-14.1 3-.6v14.7zm62.4-28.1l1.1 5h-24.5l23.4-5zm-54.8 64l-.8-4h19.6l-18.8 4zm37.7-6h-43.3v-51h67v51h-23.7zm25.7-7.5v-9.9l2 9.4-2 .5zm-52-21.5c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5zm0-8c-1.7 0-3 1.3-3 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3zm-13-10v43h59v-43h-59zm57 2v24.1l-12.8-12.8c-3-3-7.9-3-11 0l-13.3 13.2-.1-.1c-1.1-1.1-2.5-1.7-4.1-1.7-1.5 0-3 .6-4.1 1.7l-9.6 9.8v-34.2h55zm-55 39v-2l11.1-11.2c1.4-1.4 3.9-1.4 5.3 0l9.7 9.7c-5.2 1.3-9 2.4-9.4 2.5l-3.7 1h-13zm55 0h-34.2c7.1-2 23.2-5.9 33-5.9l1.2-.1v6zm-1.3-7.9c-7.2 0-17.4 2-25.3 3.9l-9.1-9.1 13.3-13.3c2.2-2.2 5.9-2.2 8.1 0l14.3 14.3v4.1l-1.3.1z"></path></svg>
                                                            </a>
                                                        </div>
                                                        <div class="small-text">Sử dụng nút <b>Chọn hình</b> để thêm hình.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="album" class="input-album">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-upload">
                                    <h2 class="title"><span>Các thông tin khác</span></h2>
                                    <div class="form-upload-item">
                                        <div class="form-field uk-flex">
                                            <input type="radio" name="type_post" class="type_post" value="normal" <?php echo isset($_POST['type_post']) && $_POST['type_post'] == 'normal' ? 'checked' : (!isset($_POST['type_post']) ? 'checked' : '')  ?>  id="type_post">
                                            <label for="type_post">Tin thường</label>
                                        </div>
                                    </div>
                                    <div class="form-upload-vipitem">
                                        <div class="uk-grid uk-grid-collapse">
                                            <div class="uk-width-small-1-1 uk-width-medium-3-5">
                                                <div class="vip">
                                                    <div class="form-field">
                                                        <div class="uk-flex uk-flex-middle">
                                                           <input type="radio" name="type_post" class="type_post" <?php echo isset($_POST['type_post']) && $_POST['type_post'] == 'days' ? 'checked' : ''  ?>  value="days" id="days_type">
                                                           <label for="days_type">Tin VIP ngày</label>
                                                        </div>
                                                       <div class="choose-vip-box">
                                                            <?php echo form_dropdown('type_vip_day', VIP_DAYS, set_value('type_vip_day'), ' class="day_vip_select" onchange="calculator_price_vip()"');?>
                                                            x
                                                            <?php echo form_dropdown('daynumber', DAYS_NUMBER, set_value('daynumber'), ' class="day_type_select"  onchange="calculator_price_vip()"');?>
                                                            <span class="divchiphi"> = <span class="chiphi total_price_vip">0</span>đ</span>
                                                       </div>
                                                    </div>
                                                    <div class="form-field">
                                                        <div class="uk-flex uk-flex-middle">
                                                           <input type="radio" name="type_post" class="type_post" value="months" <?php echo isset($_POST['type_post']) && $_POST['type_post'] == 'months' ? 'checked' : ''  ?>  id="months_type">
                                                           <label for="months_type">Tin VIP tháng</label>
                                                        </div>
                                                       <div class="choose-vip-box">
                                                            <select name="vip_type_month" id="vip_type_month" class="viptype nonselected">
                                                                <option value="">--- Loại VIP ---</option>
                                                                <option value="5">VIP 5 / 250.000đ / tháng</option>
                                                                <option value="4">VIP 4 / 300.000đ / tháng</option>
                                                                <option value="3">VIP 3 / 350.000đ / tháng</option>
                                                                <option value="2">VIP 2 / 500.000đ / tháng</option>
                                                                <option value="1">VIP 1 / 1.000.000đ / tháng</option>
                                                                <option value="0">VIP Đặc Biệt / 2.000.000đ / tháng</option>
                                                            </select>
                                                       </div>
                                                       <div class="notes">
                                                            <ul>
                                                                <li>Tiết kiệm 20% so với đăng tin VIP theo ngày</li>
                                                            </ul>
                                                       </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-1-1 uk-width-medium-2-5">
                                                <div class="info">
                                                    <?php echo $general['post_vip'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="bank">Số dư tài khoản: <span class="tk">0</span>đ</div> -->
                                <div class="note2">
                                    Người mua (hoặc) người thuê có phải trả phí hoa hồng cho người giới thiệu không?
                                    <span class="mr5 uk-flex uk-flex-middle">
                                        <input value="1" name="agent-fee" <?php echo isset($_POST['agent-fee']) && $_POST['agent-fee'] == 1 ? 'checked' : ''  ?> type="radio" id="agent-fee-yes" class="mr10">
                                        <label for="agent-fee-yes">Có trả phí</label>
                                    </span>
                                    <span class=" uk-flex uk-flex-middle">
                                        <input value="0" name="agent-fee" <?php echo isset($_POST['agent-fee']) && $_POST['agent-fee'] == 0 ? 'checked' : ''  ?> type="radio" id="agent-fee-no" class="mr10">
                                        <label for="agent-fee-no">Không  trả phí</label>
                                    </span>
                                </div>
                                <div class="dvagree uk-flex  uk-flex-middle">
                                    <input type="checkbox" id="accept_post">
                                    <label for="accept_post">
                                        <span>Tôi cam kết thông tin mô tả về tài sản là đúng sự thật và tuân thủ theo <a style="color:Blue; text-decoration:none" target="_blank" href="quy-dinh-dang-tin">quy định đăng tin</a> của <?php echo BASE_URL ?>.</span>
                                    </label>
                                </div>
                                <div class="control uk-flex uk-flex-middle uk-flex-right">
                                    <div class="btn-group">
                                        <a class="btn-up" href="" title="" onclick="$('.submit-form-post').submit();return false;">Đăng tin</a>
                                        <!-- <a class="btn-again" href="" title="">Nhập lại</a> -->
                                    </div>
                                </div>
                                <div class="hotline">Nếu gặp khó khăn trong vấn đề đăng tin, xin vòng liên hệ số <b><?php echo $general['contact_hotline'] ?></b> để được hướng dẫn. </div>
                            </div>
                        </div>
                        <div class="uk-width-small-1-1 uk-width-medium-1-4">
                            <div class="aside-post">
                                <div class="instruction">
                                    <div class="title" style="background: #0099CC;height: 28px;line-height: 28px;">Các trang rao vặt hiệu quả khác</div>
                                    <div class="content">
                                        <?php echo $general['post_link'] ?>
                                    </div>
                                </div>
                                <div class="bankck">
                                    <div style="font-weight: bold;font-size: 15px;color: #14a70b;">Hướng dẫn nạp tiền vào tài khoản</div>
                                    <?php echo $general['post_help'] ?>

                                </div>
                                <div class="instruction">
                                    <div class="title">Tin của bạn sẽ không được duyệt hoặc bị xóa nếu</div>
                                    <div class="content">
                                        <?php echo $general['post_delete'] ?>
                                    </div>
                                </div>
                                <div class="instruction">
                                    <div class="title">Hướng đăng tin hiệu quả</div>
                                    <div class="content">
                                        <?php echo $general['post_best'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



<script>

    $(document).ready(function(){
        Dropzone.autoDiscover = false;
        Dropzone.options.demoupload = {
            acceptedFiles:'image/*'
        };
        var myDropzone = new Dropzone("#demoupload",{
            url:"ajax/frontend/upload/index",
            addRemoveLinks: true,
            removedfile: function(file) {
                var name = file.name;

                $.ajax({
                    type: 'POST',
                    url: 'ajax/frontend/upload/delete',
                    data: {name: name,request: 2},
                    sucess: function(data){
                        console.log('success: ' + data);
                    }
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }
        });
        myDropzone.on("complete", function(file) {
            let image = [];
            $('#demoupload .dz-success').each(function(){
                let _this = $(this)
                let attr = _this.find('.dz-image img').attr('alt')
                image.push('<?php echo $targetFile_1 ?>'+attr);
            })
            $('.input-album').val(JSON.stringify(image))
        });
    });
</script>

<script>
    var value_price_day  = JSON.parse('<?php echo json_encode(VIP_DAYS_VALUE) ?>');
</script>
<script>
    function calculator_price_vip (){
        let vip = $('.day_vip_select').val();
        let day = $('.day_type_select').val();
        let total = 0;

        total = parseInt(value_price_day[vip]) * parseInt(day);
        if(Number.isNaN(num)) total = 0;
        $('.total_price_vip').html(addCommas(total))
    }

    function addCommas(nStr){
       nStr = String(nStr);
       nStr = nStr.replace(/\./gi, "");
       let str ='';
       for (i = nStr.length; i > 0; i -= 3){
          a = ( (i-3) < 0 ) ? 0 : (i-3); 
          str= nStr.slice(a,i) + '.' + str; 
       }
       str= str.slice(0,str.length-1); 
       return str;
    }
</script>