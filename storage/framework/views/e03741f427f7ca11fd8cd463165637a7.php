
<?php $__env->startSection('title', 'Nearby places'); ?>
<?php $__env->startSection('subtitle', 'Road distance and drive time shown on Explore / Home'); ?>

<?php $__env->startSection('content'); ?>
<div class="toolbar toolbar--split">
    <p class="toolbar__hint">Values are approximate from IXORA Niduvaloor Gate. Save to override the config defaults.</p>
    <a class="btn line" href="<?php echo e(route('page.show', 'explore')); ?>" target="_blank" rel="noopener">View Explore ↗</a>
</div>

<form method="POST" action="<?php echo e(route('admin.nearby-places.update')); ?>" class="panel nearby-form">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="nearby-list">
        <?php $__currentLoopData = $places; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $place): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="nearby-card<?php echo e($place['has_override'] ? ' is-custom' : ''); ?>">
                <header class="nearby-card__head">
                    <div>
                        <h3><?php echo e($place['title']); ?></h3>
                        <p class="nearby-card__meta"><?php echo e($place['type']); ?> · <?php echo e($place['direction']); ?></p>
                    </div>
                    <?php if($place['has_override']): ?>
                        <span class="badge">custom</span>
                    <?php endif; ?>
                </header>

                <input type="hidden" name="places[<?php echo e($i); ?>][title]" value="<?php echo e($place['title']); ?>">

                <div class="nearby-card__fields">
                    <div>
                        <label for="distance-<?php echo e($i); ?>">Distance (km)</label>
                        <input
                            id="distance-<?php echo e($i); ?>"
                            type="number"
                            name="places[<?php echo e($i); ?>][distance_km]"
                            value="<?php echo e(old('places.'.$i.'.distance_km', $place['distance_km'])); ?>"
                            min="0"
                            max="500"
                            step="0.1"
                            inputmode="decimal"
                            required
                        >
                    </div>
                    <div>
                        <label for="drive-<?php echo e($i); ?>">Drive time (min)</label>
                        <input
                            id="drive-<?php echo e($i); ?>"
                            type="number"
                            name="places[<?php echo e($i); ?>][drive_mins]"
                            value="<?php echo e(old('places.'.$i.'.drive_mins', $place['drive_mins'])); ?>"
                            min="0"
                            max="600"
                            inputmode="numeric"
                            required
                        >
                    </div>
                </div>

                <p class="nearby-card__default">Config default: <?php echo e($place['default_distance_km']); ?> km · <?php echo e($place['default_drive_mins']); ?> min</p>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="form-actions form-actions--sticky">
        <button class="btn" type="submit">Save distances</button>
        <span class="muted">Saving the config defaults clears a custom override.</span>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Home\resources\views/admin/nearby-places/index.blade.php ENDPATH**/ ?>