<?php $__env->startSection('app-body-main-content'); ?>
    <!-- Breadcrumb -->
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-body">
                   <customer-score-convertor ></customer-score-convertor>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>



<?php echo $__env->make('customer.master-customer-template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Club\cc\resources\views/customer/main/customer-score-convertor.blade.php ENDPATH**/ ?>