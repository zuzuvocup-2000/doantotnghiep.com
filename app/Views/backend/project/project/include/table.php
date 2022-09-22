<table class="table table-striped table-bordered table-hover dataTables-example">
   <thead>
   <tr>
        <th style="width: 35px;">
           <input type="checkbox" id="checkbox-all">
           <label for="check-all" class="labelCheckAll"></label>
        </th>
        <th >ID</th>
        <th >Tiêu đề sản phẩm</th>
        <th  class="text-center">Địa chỉ</th>
        <th class="text-center" style="width: 67px;">Vị trí</th>
        <th class="text-center" style="width:88px;">Tình trạng</th>
        <th class="text-center" style="width:140px;">Thao tác</th>
   </tr>
   </thead>
   <tbody>

        <?php if(isset($project['list']) && is_array($project['list']) && count($project['list'])){ ?>
        <?php foreach($project['list'] as $key => $val){ ?>
        <?php
           $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
        ?>

        <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
           <td>
                <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                <div for="" class="label-checkboxitem"></div>
           </td>
           <td><?php echo $val['id'] ?></td>
           <td>
                <div class="uk-flex uk-flex-middle">
                    <div class="image mr5">
                       <span class="image-post img-cover"><img src="<?php echo ((isset($val['image']) ? $val['image'] : 'public/not-found.png')); ?>" alt="<?php echo $val['title']; ?>" /></span>
                    </div>
                    <div class="main-info">
                       <div class="title">
                           <a class="maintitle" href="<?php echo site_url(convertUrl('backend.project.project.update.'.$val['id'])); ?>" title=""><?php echo $val['title']; ?></a>
                       </div>
                       <div class="catalogue" style="font-size:10px">
                           <span style="color:#f00000;">Nhóm hiển thị: </span>
                           <a class="" style="color:#333;" href="<?php echo site_url(convertUrl('backend.project.project.index?catalogueid='.$val['cat_id'])); ?>" title=""><?php echo $val['cat_title'] ?></a>
                       </div>
                    </div>
                </div>
           </td>
           <td class="text-center update_price td-status" >
                <div class="view_price text-success">
                    <?php echo $val['address']; ?>
                </div>
           </td>
           <td class="text-center text-primary">
                <?php echo form_input('order['.$val['id'].']', $val['order'], 'data-module="'.$config['module'].'" data-id="'.$val['id'].'"  class="form-control sort-order" placeholder="Vị trí" style="width:50px;text-align:right;"');?>

           </td>
           <?php if(isset($languageList) && is_array($languageList) && count($languageList)){ ?>
           <?php foreach($languageList as $keyLanguage => $valLanguage){ ?>
           <td class="text-center "><a class="text-small <?php echo ($val[$valLanguage['canonical'].'_detect'] > 0 ) ? 'text-success' : 'text-danger' ?> " href="<?php echo base_url('backend/translate/translate/translateProduct/'.$val['id'].'/'.$config['module'].'/'.$valLanguage['canonical'].'') ?>">
                <?php echo ($val[$valLanguage['canonical'].'_detect'] > 0 ) ? 'Đã Dịch' : 'Chưa Dịch' ?>
           </a></td>
           <?php }} ?>

           <td class="text-center td-status" data-field="publish" data-module="<?php echo $config['module']; ?>" data-where="id"><?php echo $status; ?></td>
           <td class="text-center">
                <a type="button" href="<?php echo base_url(convertUrl('backend.project.project.update.'.$val['id'])) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                <a type="button" href="<?php echo base_url(convertUrl('backend.project.project.delete.'.$val['id'])) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
           </td>
        </tr>
        <?php }}else{ ?>
           <tr>
                <td colspan="100%"><span class="text-danger">Không có dữ liệu phù hợp...</span></td>
           </tr>
        <?php } ?>
   </tbody>

</table>
<div id="pagination">
   <?php echo (isset($project['pagination'])) ? $project['pagination'] : ''; ?>
</div>
