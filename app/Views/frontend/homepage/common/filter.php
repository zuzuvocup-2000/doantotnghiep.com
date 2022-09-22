<form action="<?php echo write_url('tim-kiem-nang-cao') ?>" method="get">
    <div class="form-field mb5 uk-flex uk-flex-middle ">
       <label for="">Địa điểm</label>
       <input type="text" name="keyword" class="location" placeholder="Nhập địa điểm cần tìm" autocomplete="off">
    </div>
    <script>
       var cityid = '<?php echo (isset($_POST['city_id'])) ? $_POST['city_id'] : ''; ?>';
       var districtid = '<?php echo (isset($_POST['district_id'])) ? $_POST['district_id'] : ''; ?>'
       var wardid = ''
    </script>
    <div class="uk-grid uk-grid-small">
       <div class="uk-width-small-1-1 uk-width-medium-1-2">
            <div class="search-col">
                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                    <label for="">Loại tin</label>
                    <?php echo form_dropdown('form', PRODUCT_FORM, set_value('form'), ' class="demand"');?>
                </div>
                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                    <label for="">Tỉnh/Thành</label>
                    <?php echo form_dropdown('city_id', $province, set_value('city_id'), 'id="city" class="demand"');?>
                </div>
                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                    <label for="">Hướng</label>
                    <?php echo form_dropdown('direction', DIRECTION, set_value('direction'), 'class="form-control demand m-b select2"');?>
                </div>
                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                    <label for="">Diện tích</label>
                    <?php echo form_dropdown('area', AREA, set_value('area'), 'class="form-control demand m-b select2"');?>
                </div>
            </div>
       </div>
       <div class="uk-width-small-1-1 uk-width-medium-1-2">
            <div class="search-col">
                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                    <label for="">Loại BĐS</label>
                    <?php echo form_dropdown('type', $productType, set_value('type', (isset($product['type'])) ? $product['type'] : ''), ' class="property-type"');?>
                </div>
                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                    <label for="">Quận huyện</label>
                    <?php echo form_dropdown('district_id', ['Chọn Quận/Huyện'], set_value('district_id'), 'class="demand" id="district"');?>
                </div>
                <div class="form-field uk-flex uk-flex-middle uk-flex-space-between">
                    <label for="">Mức giá</label>
                    <?php echo form_dropdown('price_range', $productPrice, set_value('price'), ' class="property-type"');?>
                </div>
            </div>
       </div>
    </div>
    <div class="btn-group">
       <div class="btn-search uk-text-center"><button type="submit" name="search" value="search">Tìm kiếm</button></div>
       <div class="btn-advanced uk-text-right"><a href="/tim-kiem-nang-cao.html" rel="nofollow">Tìm kiếm nâng cao</a></div>
    </div>
</form>
