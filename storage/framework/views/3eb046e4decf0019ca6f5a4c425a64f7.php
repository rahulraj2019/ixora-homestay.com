<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'eyebrow' => null,
    'preheader' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title',
    'eyebrow' => null,
    'preheader' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e($preheader ?? $title); ?></title>
</head>
<body style="margin:0;padding:0;background-color:#f3efe7;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#1a2e24;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
<?php if($preheader): ?>
<div style="display:none;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;">
    <?php echo e($preheader); ?>

</div>
<?php endif; ?>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f3efe7;margin:0;padding:0;width:100%;">
    <tr>
        <td align="center" style="padding:28px 12px;">
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;background-color:#ffffff;border-radius:18px;overflow:hidden;border:1px solid #e5ddd0;">

                <tr>
                    <td align="center" style="background-color:#173126;padding:28px 28px 22px;">
                        <a href="<?php echo e($siteUrl); ?>" style="text-decoration:none;display:inline-block;">
                            <img
                                src="<?php echo e($logoUrl); ?>"
                                alt="<?php echo e($brandName); ?> Homestay"
                                width="168"
                                style="display:block;width:168px;max-width:70%;height:auto;border:0;outline:none;text-decoration:none;background-color:transparent;"
                            >
                        </a>
                        <p style="margin:14px 0 0;font-size:12px;letter-spacing:0.18em;text-transform:uppercase;color:#e8d3a4;font-weight:600;">
                            <?php echo e($tagline); ?>

                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="height:4px;line-height:4px;font-size:0;background-color:#c6a36a;">&nbsp;</td>
                </tr>

                <?php if($eyebrow): ?>
                <tr>
                    <td style="padding:26px 32px 0;background-color:#ffffff;">
                        <p style="margin:0;font-size:12px;letter-spacing:0.14em;text-transform:uppercase;color:#9a7b45;font-weight:700;">
                            <?php echo e($eyebrow); ?>

                        </p>
                    </td>
                </tr>
                <?php endif; ?>

                <tr>
                    <td style="padding:<?php echo e($eyebrow ? '10px' : '28px'); ?> 32px 8px;background-color:#ffffff;">
                        <h1 style="margin:0;font-family:Georgia,'Times New Roman',serif;font-size:28px;line-height:1.25;color:#173126;font-weight:600;">
                            <?php echo e($title); ?>

                        </h1>
                    </td>
                </tr>

                <tr>
                    <td style="padding:12px 32px 28px;background-color:#ffffff;font-size:15px;line-height:1.65;color:#31463c;">
                        <?php echo e($slot); ?>

                    </td>
                </tr>

                <tr>
                    <td style="background-color:#12261d;padding:28px 28px 18px;color:#f7f3ec;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="padding-bottom:16px;border-bottom:1px solid #3a5044;">
                                    <p style="margin:0 0 4px;font-family:Georgia,'Times New Roman',serif;font-size:22px;color:#e8d3a4;letter-spacing:0.08em;">
                                        <?php echo e($brandName); ?>

                                    </p>
                                    <p style="margin:0;font-size:13px;color:#c9d5ce;font-style:italic;">
                                        <?php echo e($script); ?>

                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top:18px;font-size:13px;line-height:1.7;color:#d7e0db;">
                                    <p style="margin:0 0 10px;white-space:pre-line;"><?php echo e($address); ?></p>

                                    <p style="margin:0 0 4px;">
                                        <a href="tel:<?php echo e($phoneTel); ?>" style="color:#e8d3a4;text-decoration:none;"><?php echo e($phone); ?></a>
                                        <?php if($phone2): ?>
                                            &nbsp;·&nbsp;
                                            <a href="tel:<?php echo e($phone2Tel); ?>" style="color:#e8d3a4;text-decoration:none;"><?php echo e($phone2); ?></a>
                                        <?php endif; ?>
                                    </p>

                                    <p style="margin:0 0 4px;">
                                        <a href="mailto:<?php echo e($email); ?>" style="color:#e8d3a4;text-decoration:none;"><?php echo e($email); ?></a>
                                    </p>

                                    <?php if($whatsappUrl): ?>
                                    <p style="margin:0 0 14px;">
                                        <a href="<?php echo e($whatsappUrl); ?>" style="color:#e8d3a4;text-decoration:none;">WhatsApp booking</a>
                                    </p>
                                    <?php endif; ?>

                                    <p style="margin:0 0 6px;">
                                        <a href="<?php echo e($siteUrl); ?>" style="color:#f7f3ec;text-decoration:underline;">Website</a>
                                        &nbsp;·&nbsp;
                                        <a href="<?php echo e($bookingUrl); ?>" style="color:#f7f3ec;text-decoration:underline;">Book stay</a>
                                        &nbsp;·&nbsp;
                                        <a href="<?php echo e($exploreUrl); ?>" style="color:#f7f3ec;text-decoration:underline;">Explore</a>
                                        &nbsp;·&nbsp;
                                        <a href="<?php echo e($mapsUrl); ?>" style="color:#f7f3ec;text-decoration:underline;">Directions</a>
                                    </p>

                                    <?php if($instagram || $facebook || $youtube): ?>
                                    <p style="margin:12px 0 0;">
                                        <?php if($instagram): ?>
                                            <a href="<?php echo e($instagram); ?>" style="color:#e8d3a4;text-decoration:none;margin-right:12px;">Instagram</a>
                                        <?php endif; ?>
                                        <?php if($facebook): ?>
                                            <a href="<?php echo e($facebook); ?>" style="color:#e8d3a4;text-decoration:none;margin-right:12px;">Facebook</a>
                                        <?php endif; ?>
                                        <?php if($youtube): ?>
                                            <a href="<?php echo e($youtube); ?>" style="color:#e8d3a4;text-decoration:none;">YouTube</a>
                                        <?php endif; ?>
                                    </p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="background-color:#0e1c16;padding:14px 24px;font-size:11px;line-height:1.5;color:#8fa397;">
                        © <?php echo e($year); ?> <?php echo e($businessName); ?>. All rights reserved.<br>
                        <?php echo e($piece); ?>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/components/emails/branded.blade.php ENDPATH**/ ?>