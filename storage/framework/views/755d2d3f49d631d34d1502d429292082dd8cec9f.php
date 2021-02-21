<?php $__env->startSection('app-header'); ?>
    <pos-header></pos-header>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('app-body-sidebar'); ?>
    <pos-side-bar></pos-side-bar>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('app-body-main-content'); ?>
    <pos-s-p-a></pos-s-p-a>
<?php $__env->stopSection(); ?>






<?php echo $__env->make('layouts.coreui.empty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Club\cc\resources\views/pos/master-pos-template.blade.php ENDPATH**/ ?>