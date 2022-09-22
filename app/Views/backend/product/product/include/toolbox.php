<div class="ibox-tools">
   <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
   </a>
     <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-wrench"></i>
   </a>
   <ul class="dropdown-menu dropdown-user">
        <li><a href="#" class="delete-all" data-module="<?php echo $config['module']; ?>">Xóa tất cả</a>
        </li>
        <li><a href="#" class="clone-all" data-toggle="modal" data-target="#clone_modal" data-module="<?php echo $config['module']; ?>">Sao chép</a>
        <li><a href="#" class="status" data-value="0" data-field="publish" data-module="<?php echo $config['module']; ?>" title="Cập nhật trạng thái Sản Phẩm">Deactive Sản Phẩm</a>
        </li>
        <li><a href="#" class="status" data-value="1" data-field="publish" data-module="<?php echo $config['module']; ?>" data-title="Cập nhật trạng thái Sản Phẩm">Active Sản Phẩm</a>
        </li>
   </ul>
   <a class="close-link">
        <i class="fa fa-times"></i>
   </a>
</div>
