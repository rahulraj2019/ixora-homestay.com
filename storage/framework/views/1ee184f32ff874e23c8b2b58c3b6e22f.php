<?php $__env->startSection('title', 'My account'); ?>
<?php $__env->startSection('subtitle', 'Update your login email and password'); ?>
<?php $__env->startSection('content'); ?>

<form method="POST" action="<?php echo e(route('admin.profile.update')); ?>" class="panel form-grid">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div>
        <label for="name">Name</label>
        <input id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required autocomplete="name">
    </div>

    <div>
        <label for="email">Email (login)</label>
        <input id="email" type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required autocomplete="username">
    </div>

    <div class="full">
        <label for="current_password">Current password</label>
        <input id="current_password" type="password" name="current_password" required autocomplete="current-password">
        <p class="muted" style="margin:.35rem 0 0;font-size:.85rem">Required to save any changes.</p>
    </div>

    <div>
        <label for="password">New password</label>
        <input id="password" type="password" name="password" autocomplete="new-password" placeholder="Leave blank to keep current">
    </div>

    <div>
        <label for="password_confirmation">Confirm new password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">
    </div>

    <div class="full form-actions">
        <button class="btn" type="submit">Save account</button>
        <a class="btn line" href="<?php echo e(route('admin.dashboard')); ?>">Cancel</a>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Home\resources\views/admin/profile/edit.blade.php ENDPATH**/ ?>