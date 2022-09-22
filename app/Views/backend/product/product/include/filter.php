<form action="" class="form-search mb20" method="">
   <div class="uk-flex uk-flex-middle uk-flex-space-between mb20">
        <div class="perpage">
           <div class="uk-flex uk-flex-middle ">
             <select name="perpage" class="form-control input-sm perpage filter mr10" style="width:120px;">
                <?php for($i = 20; $i<=100; $i+= 10){ ?>
                <option value="20"><?php echo $i; ?> bản ghi</option>
                <?php } ?>
             </select>
                <div class="form-row cat-wrap">
                    <?php echo form_dropdown('catalogueid', $config['dropdown'], set_value('catalogueid', (isset($_GET['catalogueid'])) ? $_GET['catalogueid'] : ''), 'class="form-control m-b select2 mr10" style="width:150px;"');?>
                </div>
                <div class="uk-search uk-flex uk-flex-middle mr10 ml10">
                    <div class="input-group">
                       <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập Từ khóa bạn muốn tìm kiếm..." class="form-control">
                       <span class="input-group-btn">
                           <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm Kiếm
                       </button>
                       </span>
                    </div>
                </div>
           </div>

        </div>
        <div class="toolbox">
           <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="uk-button">
                    <a href="<?php echo base_url(convertUrl('backend.product.product.create')) ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Thêm BĐS Mới</a>
                </div>
           </div>
        </div>
   </div>
</form>
