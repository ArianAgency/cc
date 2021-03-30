<?php $__env->startSection('app-body-main-content'); ?>
    <div id="app">

        <report-s-p-a :user="<?php echo e(Auth::user()); ?>"></report-s-p-a>

    </div>

    <script type="application/javascript">
        var Laravel = {
            'csrfToken': '<?php echo e(csrf_token()); ?>'
        };
        // console.log('Laravel = ' + Laravel['csrfToken'])
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.master-admin-template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Club\cc\resources\views/admin/report/report.blade.php ENDPATH**/ ?>