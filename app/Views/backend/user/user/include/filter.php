<form action="" method="">
    <div class="uk-flex uk-flex-middle uk-flex-space-between mb20">
        <div class="perpage">
            <div class="uk-flex uk-flex-middle mb10">
                <select name="perpage" class="form-control input-sm perpage filter mr10">
                    <option value="20">20 bản ghi</option>
                    <option value="30">30 bản ghi</option>
                    <option value="40">40 bản ghi</option>
                    <option value="50">50 bản ghi</option>
                    <option value="60">60 bản ghi</option>
                    <option value="70">70 bản ghi</option>
                    <option value="80">80 bản ghi</option>
                    <option value="90">90 bản ghi</option>
                    <option value="100">100 bản ghi</option>
                </select>
            </div>
        </div>
        <div class="toolbox">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <?php
                    $userCatalogue = get_data(['select' => 'id, title','table' => 'user_catalogue','where' => ['deleted_at' => 0],'order_by' => 'title asc']);
                    $userCatalogue = convert_array([
                        'data' => $userCatalogue,
                        'field' => 'id',
                        'value' => 'title',
                        'text' => 'Nhóm Thành Viên',
                    ]);
                ?>
                <?php echo form_dropdown('catalogueid', $userCatalogue, set_value('catalogueid', (isset($_GET['catalogueid'])) ? $_GET['catalogueid'] : 0), 'class="form-control mr10"');?>
                <?php
                     $gender = [
                        -1 => 'Giới Tính',
                        0 => 'Nữ',
                        1 => 'Nam',
                     ];
                    echo form_dropdown('gender', $gender, set_value('gender', (isset($_GET['gender'])) ? $_GET['gender'] : -1),'class="form-control mr10 input-sm perpage filter" style="width:115px"'); 
                ?>
                <div class="uk-search uk-flex uk-flex-middle mr10">
                    <div class="input-group">
                        <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập Từ khóa bạn muốn tìm kiếm..." class="form-control"> 
                        <span class="input-group-btn"> 
                            <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm Kiếm
                        </button> 
                        </span>
                    </div>
                </div>
                <div class="uk-button">
                    <a href="<?php echo base_url('backend/user/user/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Thêm thành viên mới</a>
                </div>
            </div>
        </div>
    </div>
</form>