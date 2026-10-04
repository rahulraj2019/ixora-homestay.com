<?php
    $detailCell = 'padding:10px 0;border-bottom:1px solid #efe8dc;font-size:14px;line-height:1.5;color:#31463c;';
    $labelCell = $detailCell.'width:38%;color:#6b7c72;font-weight:600;';
?>

<?php if (isset($component)) { $__componentOriginal370f17cc972e19a32d2dd654b053e10b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal370f17cc972e19a32d2dd654b053e10b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.emails.branded','data' => ['title' => 'We received your booking','eyebrow' => 'Booking confirmation','preheader' => 'Thanks '.e($booking->name).' — your reference is '.e($booking->booking_reference).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('emails.branded'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'We received your booking','eyebrow' => 'Booking confirmation','preheader' => 'Thanks '.e($booking->name).' — your reference is '.e($booking->booking_reference).'']); ?>
    <p style="margin:0 0 16px;">Hi <?php echo e($booking->name); ?>,</p>
    <p style="margin:0 0 18px;">
        Thank you for choosing <strong><?php echo e($brandName); ?></strong> at Niduvaloor Gate, Kannur.
        We have received your booking request and will confirm availability and rates shortly.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 22px;background-color:#faf7f1;border:1px solid #efe8dc;border-radius:12px;">
        <tr>
            <td style="padding:16px 18px;">
                <p style="margin:0 0 4px;font-size:12px;letter-spacing:0.12em;text-transform:uppercase;color:#9a7b45;font-weight:700;">Your reference</p>
                <p style="margin:0;font-size:22px;font-family:Georgia,'Times New Roman',serif;color:#173126;font-weight:600;"><?php echo e($booking->booking_reference); ?></p>
            </td>
        </tr>
    </table>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 22px;">
        <tr>
            <td style="<?php echo e($labelCell); ?>">Stay type</td>
            <td style="<?php echo e($detailCell); ?>"><?php echo e($booking->booking_type); ?></td>
        </tr>
        <tr>
            <td style="<?php echo e($labelCell); ?>">Check-in</td>
            <td style="<?php echo e($detailCell); ?>"><?php echo e(optional($booking->check_in)->format('d M Y') ?: 'To be confirmed'); ?></td>
        </tr>
        <tr>
            <td style="<?php echo e($labelCell); ?>border-bottom:0;">Check-out</td>
            <td style="<?php echo e($detailCell); ?>border-bottom:0;"><?php echo e(optional($booking->check_out)->format('d M Y') ?: 'To be confirmed'); ?></td>
        </tr>
    </table>

    <p style="margin:0 0 20px;">
        Our team usually replies on WhatsApp or phone. Keep your reference handy — it helps us find your request quickly.
    </p>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" bgcolor="#173126" style="border-radius:999px;background-color:#173126;">
                <a href="<?php echo e($whatsappUrl ?: $contactUrl); ?>" style="display:inline-block;padding:14px 28px;font-size:14px;font-weight:700;color:#e8d3a4;text-decoration:none;">
                    Chat on WhatsApp
                </a>
            </td>
            <td width="12">&nbsp;</td>
            <td align="center" style="border-radius:999px;border:1px solid #c6a36a;">
                <a href="<?php echo e($siteUrl); ?>" style="display:inline-block;padding:13px 24px;font-size:14px;font-weight:700;color:#173126;text-decoration:none;">
                    Visit website
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
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/emails/booking-customer.blade.php ENDPATH**/ ?>