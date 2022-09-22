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
                    <a href="<?php echo base_url(convertUrl('backend.member.catalogue.create')) ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Thêm Nhóm Member mới</a>
                </div>
           </div>
        </div>
   </div>
</form>
