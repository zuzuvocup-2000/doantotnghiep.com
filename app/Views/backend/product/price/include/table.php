<table class="table table-striped table-bordered table-hover dataTables-example">
   <thead>
   <tr>
        <th style="width: 35px;">
           <input type="checkbox" id="checkbox-all">
           <label for="check-all" class="labelCheckAll"></label>
        </th>
        <th >Tiêu đề</th>
        <th >Khoảng Giá</th>
        <th class="text-center" style="width: 67px;">Vị trí</th>
        <th style="width:150px;">Người tạo</th>
        <th style="width:150px;" class="text-center">Ngày tạo</th>
        <th class="text-center" style="width:88px;">Tình trạng</th>
        <th class="text-center" style="width:103px;">Thao tác</th>
   </tr>
   </thead>
   <tbody>
        <?php if(isset($price['list']) && is_array($price['list']) && count($price['list'])){ ?>
        <?php foreach($price['list'] as $key => $val){ ?>
        <?php
           $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';

        ?>
        <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
           <td>
                <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                <div for="" class="label-checkboxitem"></div>
           </td>
            <td class="text-success text-bold">
               <a href="<?php echo base_url(convertUrl('backend.product.price.update.').$val['id'].'') ?>">
                  <?php echo $val['title']; ?>
               </a>
            </td>
            <td class="text-success text-bold">
               <a href="<?php echo base_url(convertUrl('backend.product.price.update.').$val['id'].'') ?>">
                  <?php echo commas($val['price_min']); ?> - <?php echo commas($val['price_max']); ?>
               </a>
            </td>
           <td class="text-center text-primary">
                <?php echo form_input('order['.$val['id'].']', $val['order'], 'data-module="'.$config['module'].'" data-id="'.$val['id'].'"  class="form-control sort-order" placeholder="Vị trí" style="width:50px;text-align:right;"');?>

           </td>
           <td class="text-primary"><?php echo $val['creator']; ?></td>
           <td class="text-center text-primary"><?php echo gettime($val['created_at'],'Y-d-m') ?></td>
           <td class="text-center td-status" data-field="publish" data-module="<?php echo $config['module']; ?>" data-where="id"><?php echo $status; ?></td>
           <td class="text-center">
                <a type="button" href="<?php echo base_url(convertUrl('backend.product.price.update.'.$val['id'])) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                <a type="button" href="<?php echo base_url(convertUrl('backend.product.price.delete.'.$val['id'])) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
   <?php echo (isset($price['pagination'])) ? $price['pagination'] : ''; ?>
</div>
