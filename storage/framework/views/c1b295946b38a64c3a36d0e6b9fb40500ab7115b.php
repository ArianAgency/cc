<?php $__env->startSection('app-header'); ?>
    <?php echo $__env->make('admin.main.app-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('app-body-sidebar'); ?>
    <?php echo $__env->make('admin.main.app-body-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('app-body-aside-menu'); ?>
    <?php echo $__env->make('admin.main.app-body-aside-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.coreui.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Club\cc\resources\views/admin/master-admin-template.blade.php ENDPATH**/ ?>