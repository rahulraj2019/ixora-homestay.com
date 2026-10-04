<?php
    $waUrl = whatsapp_url();
    $phone1 = setting('phone_primary', '+91 89215 25086');
    $phone2 = setting('phone_secondary', '+91 80757 71824');
    $tel1 = preg_replace('/\s+/', '', $phone1);
    $tel2 = preg_replace('/\s+/', '', $phone2);
?>
<footer>
    <svg class="leaf leaf-left" viewBox="0 0 240 280" aria-hidden="true"><path fill="#163528" d="M20 260c40-80 30-150 70-200 20 50 10 110-10 160 40-30 90-80 130-70-50 30-90 70-120 110-20-10-46-8-70 0z"/><path fill="#1d4332" d="M40 250c20-60 18-120 48-170 8 40 4 90-12 140z"/><path fill="#214e39" d="M70 240c30-40 80-90 140-100-40 30-80 70-110 120z"/></svg>
    <svg class="leaf leaf-right" viewBox="0 0 260 240" aria-hidden="true"><path fill="#163528" d="M250 20c-70 20-130 70-170 130 50-10 110 0 160 30-40-50-40-110 10-160z"/><path fill="#1c4030" d="M240 40c-50 20-90 60-120 110 40 0 90 10 130 30z"/><path fill="#24543c" d="M230 80c-40 10-90 40-120 80 50-10 100 0 140 20z"/></svg>
    <div class="wrap foot">
        <div class="foot-brand">
            <svg class="foot-mark" viewBox="0 0 64 48" aria-hidden="true"><path fill="#e8d3a4" d="M32 46C30 30 22 16 8 8c12 2 22 8 28 16C40 16 50 8 62 6 46 16 36 30 32 46z"/><path fill="#e8d3a4" d="M32 44c0-14 6-24 16-32-8 8-12 16-14 28 2-12-2-22-10-30 6 10 8 20 8 34z"/></svg>
            <p class="foot-logo"><?php echo e(setting('brand_name', 'IXORA')); ?></p>
            <p class="foot-tag"><?php echo e(setting('footer_tagline', 'Stay | Celebrate | Belong')); ?></p>
            <p class="foot-copy"><?php echo e(setting('footer_text', 'A premium homestay and event venue in Niduvaloor, Kerala, offering serene stays, memorable events, a beautiful courtyard, campfire and grill experiences.')); ?></p>
            <div class="socials">
                <?php if(setting('instagram')): ?>
                    <a class="soc-ig" href="<?php echo e(setting('instagram')); ?>" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24"><path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4zm5 4.6A4.4 4.4 0 1 0 16.4 12 4.4 4.4 0 0 0 12 7.6zm6.1-.9a1 1 0 1 0 1 1 1 1 0 0 0-1-1zM12 9.2A2.8 2.8 0 1 1 9.2 12 2.8 2.8 0 0 1 12 9.2z"/></svg></a>
                <?php endif; ?>
                <?php if(setting('facebook')): ?>
                    <a class="soc-fb" href="<?php echo e(setting('facebook')); ?>" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24"><path d="M14 9h3V6h-3c-2.2 0-4 1.8-4 4v2H8v3h2v7h3v-7h2.6l.4-3H13v-2c0-.6.4-1 1-1z"/></svg></a>
                <?php endif; ?>
                <?php if(setting('youtube')): ?>
                    <a class="soc-yt" href="<?php echo e(setting('youtube')); ?>" target="_blank" rel="noopener" aria-label="YouTube"><svg viewBox="0 0 24 24"><path d="M23 12.2s0-3.2-.4-4.6c-.2-.9-.9-1.6-1.8-1.8C19.2 5.4 12 5.4 12 5.4s-7.2 0-8.8.4c-.9.2-1.6.9-1.8 1.8C1 9 1 12.2 1 12.2s0 3.2.4 4.6c.2.9.9 1.6 1.8 1.8 1.6.4 8.8.4 8.8.4s7.2 0 8.8-.4c.9-.2 1.6-.9 1.8-1.8.4-1.4.4-4.6.4-4.6zM9.8 15.5v-6.6l6.2 3.3z"/></svg></a>
                <?php endif; ?>
                <a class="soc-wa" href="<?php echo e($waUrl); ?>" data-whatsapp-chat data-whatsapp-phone="<?php echo e(whatsapp_number()); ?>" data-whatsapp-text="<?php echo e(whatsapp_message()); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><svg viewBox="0 0 24 24"><path d="M20.5 3.5A11 11 0 0 0 2.1 17.2L1 23l5.9-1.1A11 11 0 0 0 20.5 3.5zm-8.5 17a9.1 9.1 0 0 1-4.6-1.3l-.3-.2-3.5.7.7-3.4-.2-.3A9.1 9.1 0 1 1 12 20.5zm5-6.8c-.3-.1-1.6-.8-1.8-.9s-.4-.1-.6.1-.7.9-.8 1-.3.2-.6.1a7.4 7.4 0 0 1-2.2-1.4 8.2 8.2 0 0 1-1.5-1.9c-.2-.3 0-.4.1-.6l.4-.5.2-.3a.5.5 0 0 0 0-.5c0-.1-.6-1.4-.8-1.9s-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 2.9 2.9 0 0 0-.9 2.2 5 5 0 0 0 1.1 2.7 11.5 11.5 0 0 0 4.4 3.9c.5.2 1 .4 1.5.6a3.6 3.6 0 0 0 1.6.1 2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .2-1.2c-.1-.1-.3-.2-.6-.3z"/></svg></a>
            </div>
            <p class="foot-script"><?php echo e(setting('footer_script', 'Stay Closer to Nature')); ?> <span class="gold-line"></span></p>
        </div>
        <div>
            <h3>Explore</h3>
            <ul class="foot-links">
                <li><a href="<?php echo e(route('home')); ?>">Home <span>›</span></a></li>
                <!-- <li><a href="<?php echo e(route('page.show', 'stay')); ?>">Stay <span>›</span></a></li> -->
                <!-- <li><a href="<?php echo e(route('page.show', 'events')); ?>">Events <span>›</span></a></li> -->
                <li><a href="<?php echo e(route('page.show', 'gallery')); ?>">Gallery <span>›</span></a></li>
                <li><a href="<?php echo e(route('page.show', 'about')); ?>">About Us <span>›</span></a></li>
                <li><a href="<?php echo e(route('page.show', 'reviews')); ?>">Reviews <span>›</span></a></li>
                <li><a href="<?php echo e(route('page.show', 'faq')); ?>">FAQ <span>›</span></a></li>
                <li><a href="<?php echo e(route('page.show', 'contact')); ?>">Contact Us <span>›</span></a></li>
            </ul>
        </div>
        <div>
            <h3>Our Services</h3>
            <ul class="foot-links">
                <li><a href="<?php echo e(route('page.show', 'stay')); ?>">Homestay in Kerala <span>›</span></a></li>
                <li><a href="<?php echo e(route('page.show', 'events')); ?>">Event Venue <span>›</span></a></li>
                <li><a href="<?php echo e(route('page.show', 'stay')); ?>">Family Stay <span>›</span></a></li>
                <li><a href="<?php echo e(route('page.show', 'events')); ?>">Private Events <span>›</span></a></li>
                <li><a href="<?php echo e(route('page.show', 'gallery')); ?>">Campfire &amp; Grill <span>›</span></a></li>
                <li><a href="<?php echo e(route('page.show', 'explore')); ?>">Weekend Getaway <span>›</span></a></li>
            </ul>
        </div>
        <div>
            <h3>Contact</h3>
            <ul class="contact-list">
                <li><a href="tel:<?php echo e($tel1); ?>"><i><svg viewBox="0 0 24 24"><path d="M6.6 2.8h2.4c.4 0 .7.3.8.7l1 3.2a.8.8 0 0 1-.3.9L8.8 9.1a10.5 10.5 0 0 0 6.1 6.1l1.5-1.7a.8.8 0 0 1 .9-.3l3.2 1c.4.1.7.4.7.8v2.4a1.6 1.6 0 0 1-1.7 1.6A16.2 16.2 0 0 1 4.9 4.5a1.6 1.6 0 0 1 1.7-1.7z"/></svg></i><span><?php echo e($phone1); ?></span></a></li>
                <?php if($phone2): ?>
                    <li><a href="tel:<?php echo e($tel2); ?>"><i><svg viewBox="0 0 24 24"><path d="M6.6 2.8h2.4c.4 0 .7.3.8.7l1 3.2a.8.8 0 0 1-.3.9L8.8 9.1a10.5 10.5 0 0 0 6.1 6.1l1.5-1.7a.8.8 0 0 1 .9-.3l3.2 1c.4.1.7.4.7.8v2.4a1.6 1.6 0 0 1-1.7 1.6A16.2 16.2 0 0 1 4.9 4.5a1.6 1.6 0 0 1 1.7-1.7z"/></svg></i><span><?php echo e($phone2); ?></span></a></li>
                <?php endif; ?>
                <li><a href="<?php echo e(homestay_maps_link()); ?>" target="_blank" rel="noopener"><i><svg viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2a7 7 0 0 0-7 7c0 5.2 7 13 7 13s7-7.8 7-13a7 7 0 0 0-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg></i><span><?php echo nl2br(e(setting('address', "Building No. 7-334, Ixora Homestay,\nNiduvaloor Gate, Niduvaloor, 670142"))); ?></span></a></li>
            </ul>
            <a class="foot-wa" href="<?php echo e($waUrl); ?>" data-whatsapp-chat data-whatsapp-phone="<?php echo e(whatsapp_number()); ?>" data-whatsapp-text="<?php echo e(whatsapp_message()); ?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24"><path d="M20.5 3.5A11 11 0 0 0 2.1 17.2L1 23l5.9-1.1A11 11 0 0 0 20.5 3.5zm-8.5 17a9.1 9.1 0 0 1-4.6-1.3l-.3-.2-3.5.7.7-3.4-.2-.3A9.1 9.1 0 1 1 12 20.5z"/></svg> Book on WhatsApp →</a>
        </div>
    </div>
    <div class="wrap legal">
        <span><?php echo e(setting('copyright', '© '.date('Y').' IXORA. All Rights Reserved.')); ?></span>
        <nav>
            <a href="<?php echo e(route('page.show', 'privacy')); ?>">Privacy Policy</a>
            <a href="<?php echo e(route('page.show', 'terms')); ?>">Terms &amp; Conditions</a>
            <a href="<?php echo e(route('page.show', 'sitemap')); ?>">Sitemap</a>
        </nav>
        <span class="piece"><?php echo e(setting('footer_piece', 'A Piece of Kerala, Just for You')); ?> <span class="gold-line"></span></span>
    </div>
</footer>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/partials/footer.blade.php ENDPATH**/ ?>