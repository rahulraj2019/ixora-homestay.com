<?php
    $detailCell = 'padding:10px 0;border-bottom:1px solid #efe8dc;font-size:14px;line-height:1.5;color:#31463c;';
    $labelCell = $detailCell.'width:38%;color:#6b7c72;font-weight:600;';
?>

<?php if (isset($component)) { $__componentOriginal370f17cc972e19a32d2dd654b053e10b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal370f17cc972e19a32d2dd654b053e10b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.emails.branded','data' => ['title' => 'New booking request','eyebrow' => 'Admin alert','preheader' => 'New booking '.e($booking->booking_reference).' from '.e($booking->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('emails.branded'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'New booking request','eyebrow' => 'Admin alert','preheader' => 'New booking '.e($booking->booking_reference).' from '.e($booking->name).'']); ?>
    <p style="margin:0 0 18px;">A new booking enquiry just arrived. Review the details below and respond from the admin panel.</p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 22px;background-color:#faf7f1;border:1px solid #efe8dc;border-radius:12px;">
        <tr>
            <td style="padding:16px 18px;">
                <p style="margin:0 0 4px;font-size:12px;letter-spacing:0.12em;text-transform:uppercase;color:#9a7b45;font-weight:700;">Reference</p>
                <p style="margin:0;font-size:20px;font-family:Georgia,'Times New Roman',serif;color:#173126;font-weight:600;"><?php echo e($booking->booking_reference); ?></p>
            </td>
        </tr>
    </table>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 22px;">
        <tr>
            <td style="<?php echo e($labelCell); ?>">Guest</td>
            <td style="<?php echo e($detailCell); ?>"><?php echo e($booking->name); ?></td>
        </tr>
        <tr>
            <td style="<?php echo e($labelCell); ?>">Email</td>
            <td style="<?php echo e($detailCell); ?>"><?php echo e($booking->email ?: '—'); ?></td>
        </tr>
        <tr>
            <td style="<?php echo e($labelCell); ?>">Phone</td>
            <td style="<?php echo e($detailCell); ?>"><?php echo e($booking->phone); ?></td>
        </tr>
        <tr>
            <td style="<?php echo e($labelCell); ?>">WhatsApp</td>
            <td style="<?php echo e($detailCell); ?>"><?php echo e($booking->whatsapp ?: '—'); ?></td>
        </tr>
        <tr>
            <td style="<?php echo e($labelCell); ?>">Type</td>
            <td style="<?php echo e($detailCell); ?>"><?php echo e($booking->booking_type); ?></td>
        </tr>
        <tr>
            <td style="<?php echo e($labelCell); ?>">Check-in</td>
            <td style="<?php echo e($detailCell); ?>"><?php echo e(optional($booking->check_in)->format('d M Y') ?: '—'); ?></td>
        </tr>
        <tr>
            <td style="<?php echo e($labelCell); ?>">Check-out</td>
            <td style="<?php echo e($detailCell); ?>"><?php echo e(optional($booking->check_out)->format('d M Y') ?: '—'); ?></td>
        </tr>
        <tr>
            <td style="<?php echo e($labelCell); ?>">Guests</td>
            <td style="<?php echo e($detailCell); ?>">
                <?php echo e($booking->guest_count ?: (($booking->adults ?? 0) + ($booking->children ?? 0))); ?>

                (<?php echo e($booking->adults ?? 0); ?> adults, <?php echo e($booking->children ?? 0); ?> kids)
                <br><span style="font-size:12px;color:#6b7c72;">Children are under 10. Guests aged 10+ are counted as adults.</span>
            </td>
        </tr>
        <?php if($booking->event_type): ?>
        <tr>
            <td style="<?php echo e($labelCell); ?>">Event type</td>
            <td style="<?php echo e($detailCell); ?>"><?php echo e($booking->event_type); ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td style="<?php echo e($labelCell); ?>border-bottom:0;">Message</td>
            <td style="<?php echo e($detailCell); ?>border-bottom:0;"><?php echo e($booking->message ?: '—'); ?></td>
        </tr>
    </table>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:8px 0 0;">
        <tr>
            <td align="center" bgcolor="#173126" style="border-radius:999px;background-color:#173126;">
                <a href="<?php echo e(url('/admin/bookings/'.$booking->id)); ?>" style="display:inline-block;padding:14px 28px;font-size:14px;font-weight:700;color:#e8d3a4;text-decoration:none;">
                    View booking in admin
                </a>
            </td>
        </tr>
    </table>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal370f17cc972e19a32d2dd654b053e10b)): ?>
<?php $attributes = $__attributesOriginal370f17cc972e19a32d2dd654b053e10b; ?>
<?php unset($__attributesOriginal370f17cc972e19a32d2dd654b053e10b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal370f17cc972e19a32d2dd654b053e10b)): ?>
<?php $component = $__componentOriginal370f17cc972e19a32d2dd654b053e10b; ?>
<?php unset($__componentOriginal370f17cc972e19a32d2dd654b053e10b); ?>
<?php endif; ?>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/emails/booking-admin.blade.php ENDPATH**/ ?>