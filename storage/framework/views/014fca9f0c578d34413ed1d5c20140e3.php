
<?php $__env->startSection('title', $page->exists ? 'Edit page' : 'Create page'); ?>
<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e($page->exists ? route('admin.pages.update', $page) : route('admin.pages.store')); ?>" class="panel">
    <?php echo csrf_field(); ?>
    <?php if($page->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
    <div class="form-grid">
        <div><label>Title</label><input name="title" value="<?php echo e(old('title', $page->title)); ?>" required></div>
        <div><label>Slug</label><input name="slug" value="<?php echo e(old('slug', $page->slug)); ?>"></div>
        <div>
            <label>Status</label>
            <select name="status">
                <?php $__currentLoopData = ['published','draft']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php if(old('status', $page->status ?: 'draft') === $s): echo 'selected'; endif; ?>><?php echo e($s); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div><label>Template</label><input name="template" value="<?php echo e(old('template', $page->template)); ?>" placeholder="home, stay, booking…"></div>
        <div class="full"><label>Meta title</label><input name="meta_title" value="<?php echo e(old('meta_title', $page->meta_title)); ?>"></div>
        <div class="full"><label>Meta description</label><textarea name="meta_description"><?php echo e(old('meta_description', $page->meta_description)); ?></textarea></div>
        <div><label>Canonical URL</label><input name="canonical_url" value="<?php echo e(old('canonical_url', $page->canonical_url)); ?>"></div>
        <div><label>Robots</label><input name="robots" value="<?php echo e(old('robots', $page->robots ?: 'index, follow')); ?>"></div>
        <div><label>OG title</label><input name="og_title" value="<?php echo e(old('og_title', $page->og_title)); ?>"></div>
        <div><label>OG image path</label><input name="og_image" value="<?php echo e(old('og_image', $page->og_image)); ?>"></div>
        <div class="full"><label>OG description</label><textarea name="og_description"><?php echo e(old('og_description', $page->og_description)); ?></textarea></div>
        <div><label>Twitter title</label><input name="twitter_title" value="<?php echo e(old('twitter_title', $page->twitter_title)); ?>"></div>
        <div><label>Twitter image</label><input name="twitter_image" value="<?php echo e(old('twitter_image', $page->twitter_image)); ?>"></div>
        <div class="full"><label>Twitter description</label><textarea name="twitter_description"><?php echo e(old('twitter_description', $page->twitter_description)); ?></textarea></div>
    </div>
    <div class="form-actions form-actions--sticky">
        <button class="btn" type="submit">Save page</button>
    </div>
</form>

<?php if($page->exists): ?>
<div class="panel">
    <h2>Content blocks</h2>
    <p style="color:#5c6b62">Active blocks appear on the public page <strong>above the footer</strong> (after the page template). Keep status = active.</p>
    <form method="POST" action="<?php echo e(route('admin.pages.blocks.store', $page)); ?>" class="toolbar">
        <?php echo csrf_field(); ?>
        <div><label>Type</label>
            <select name="block_type">
                <?php $__currentLoopData = ['hero','text','image_text','gallery','features','amenities','cta','testimonials','faq','attractions','rooms','events','stats','contact','map','video','html']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($t); ?>"><?php echo e($t); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div><label>Title</label><input name="title"></div>
        <div><label>Status</label><select name="status"><option value="active">active</option><option value="inactive">inactive</option></select></div>
        <button class="btn" type="submit">Add block</button>
    </form>

    <?php $__currentLoopData = $page->blocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="panel" style="background:#faf8f4">
            <form method="POST" action="<?php echo e(route('admin.blocks.update', $block)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="form-grid">
                    <div><label>Block #<?php echo e($block->id); ?> (<?php echo e($block->block_type); ?>)</label><input name="title" value="<?php echo e($block->title); ?>"></div>
                    <div><label>Subtitle</label><input name="subtitle" value="<?php echo e($block->subtitle); ?>"></div>
                    <div class="full"><label>Content</label><textarea name="content"><?php echo e($block->content); ?></textarea></div>
                    <div><label>Sort</label><input type="number" name="sort_order" value="<?php echo e($block->sort_order); ?>"></div>
                    <div><label>Status</label><select name="status"><option value="active" <?php if($block->status==='active'): echo 'selected'; endif; ?>>active</option><option value="inactive" <?php if($block->status==='inactive'): echo 'selected'; endif; ?>>inactive</option></select></div>
                </div>
                <p style="margin-top:.7rem">
                    <button class="btn" type="submit">Update block</button>
                </p>
            </form>
            <form method="POST" action="<?php echo e(route('admin.blocks.destroy', $block)); ?>" onsubmit="return confirm('Delete block?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="btn danger" type="submit">Delete block</button>
            </form>

            <h3>Items</h3>
            <?php $__currentLoopData = $block->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <form method="POST" action="<?php echo e(route('admin.block-items.update', $item)); ?>" class="panel">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <div class="form-grid">
                        <div><label>Title</label><input name="title" value="<?php echo e($item->title); ?>"></div>
                        <div><label>Subtitle</label><input name="subtitle" value="<?php echo e($item->subtitle); ?>"></div>
                        <div class="full"><label>Description</label><textarea name="description"><?php echo e($item->description); ?></textarea></div>
                        <div><label>Image path</label><input name="image" value="<?php echo e($item->image); ?>"></div>
                        <div><label>Link</label><input name="link" value="<?php echo e($item->link); ?>"></div>
                        <div><label>Button label</label><input name="button_label" value="<?php echo e($item->button_label); ?>"></div>
                        <div><label>Button URL</label><input name="button_url" value="<?php echo e($item->button_url); ?>"></div>
                        <div><label>Sort</label><input type="number" name="sort_order" value="<?php echo e($item->sort_order); ?>"></div>
                        <div><label>Status</label><select name="status"><option value="active" <?php if($item->status==='active'): echo 'selected'; endif; ?>>active</option><option value="inactive" <?php if($item->status==='inactive'): echo 'selected'; endif; ?>>inactive</option></select></div>
                    </div>
                    <p><button class="btn" type="submit">Save item</button></p>
                </form>
                <div class="row-actions" style="margin:.5rem 0 1rem">
                    <form method="POST" action="<?php echo e(route('admin.block-items.duplicate', $item)); ?>"><?php echo csrf_field(); ?><button class="btn line btn-sm" type="submit">Duplicate</button></form>
                    <form method="POST" action="<?php echo e(route('admin.block-items.destroy', $item)); ?>" onsubmit="return confirm('Delete item?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn danger btn-sm" type="submit">Delete</button></form>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <form method="POST" action="<?php echo e(route('admin.block-items.store', $block)); ?>" class="toolbar">
                <?php echo csrf_field(); ?>
                <div><label>New item title</label><input name="title" required></div>
                <div><label>Image</label><input name="image" placeholder="assets/images/..."></div>
                <input type="hidden" name="status" value="active">
                <button class="btn secondary" type="submit">Add item</button>
            </form>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<form method="POST" action="<?php echo e(route('admin.pages.destroy', $page)); ?>" onsubmit="return confirm('Delete this page?')" class="panel">
    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
    <button class="btn danger" type="submit">Delete page</button>
</form>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/admin/pages/form.blade.php ENDPATH**/ ?>