<table class="table table-striped table-bordered table-hover dataTables-example">
    <thead>
    <tr>
        <th style="width: 35px;">
           <input type="checkbox" id="checkbox-all">
           <label for="check-all" class="labelCheckAll"></label>
        </th>
        <th >Tiêu đề nhóm</th>
        <th style="width: 100px;">Member</th>
        <th class="text-center" style="width: 100px;">Hoạt động</th>
        <th class="text-center" style="width: 100px;">Tạm Khóa</th>
        <th class="text-center" style="width:88px;">Tình trạng</th>
        <th class="text-center" style="width:103px;">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        <?php if(isset($memberCatalogue['list']) && is_array($memberCatalogue['list']) && count($memberCatalogue['list'])){ ?>
        <?php foreach($memberCatalogue['list'] as $key => $val){ ?>
        <?php
           $status = ($val['publish'] == 1) ? '<span class="text-success">Active</span>'  : '<span class="text-danger">Deactive</span>';
        ?>
        <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
           <td>
                <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                <div for="" class="label-checkboxitem"></div>
           </td>
           <td><?php echo $val['title'] ?></td>
           <td class="text-center text-primary"><?php echo $val['total_member']; ?></td>
           <td class="text-center"><?php echo $val['active'] ?></td>
           <td class="text-center"><?php echo $val['de_active'] ?></td>
           <td class="text-center td-status" data-field="publish" data-module="<?php echo $config['module']; ?>"><?php echo $status; ?></td>
           <td class="text-center">
                <a type="button" href="<?php echo base_url(convertUrl('backend.member.catalogue.update.'.$val['id'])) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                <a type="button" href="<?php echo base_url(convertUrl('backend.member.catalogue.delete.'.$val['id'])) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
    <?php echo (isset($memberCatalogue['pagination'])) ? $memberCatalogue['pagination'] : ''; ?>
</div>
