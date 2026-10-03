@extends('admin.layouts.app')
@section('title', 'Settings')
@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="panel">
    @csrf @method('PUT')

    <h2>Business</h2>
    <div class="form-grid">
        @foreach([
            'business_name'=>'Business name','brand_name'=>'Brand','tagline'=>'Tagline','header_cta_label'=>'Header CTA',
            'email'=>'Email','address'=>'Address','maps_link'=>'Maps link',
            'facebook'=>'Facebook','instagram'=>'Instagram','youtube'=>'YouTube','linkedin'=>'LinkedIn',
            'copyright'=>'Copyright','footer_text'=>'Footer text','footer_tagline'=>'Footer tagline',
            'footer_script'=>'Footer script','footer_piece'=>'Footer piece','logo'=>'Logo path','favicon'=>'Favicon path'
        ] as $key => $label)
            <div class="{{ in_array($key, ['address','footer_text','maps_embed'], true) ? 'full' : '' }}">
                <label>{{ $label }}</label>
                @if(in_array($key, ['address','footer_text'], true))
                    <textarea name="{{ $key }}">{{ $settings[$key] ?? '' }}</textarea>
                @else
                    <input name="{{ $key }}" value="{{ $settings[$key] ?? '' }}">
                @endif
            </div>
        @endforeach
        <div class="full"><label>Maps embed HTML</label><textarea name="maps_embed">{{ $settings['maps_embed'] ?? '' }}</textarea></div>
    </div>

    <h2>Call &amp; WhatsApp</h2>
    <p class="muted" style="margin:0 0 1rem">These numbers power the floating Call / WhatsApp buttons, footer, FAQ help card, and booking links across the site.</p>
    <div class="form-grid">
        <div>
            <label>Primary call number</label>
            <input name="phone_primary" value="{{ $settings['phone_primary'] ?? '' }}" placeholder="+91 89215 25086" autocomplete="tel">
            <p class="muted" style="margin:.35rem 0 0;font-size:.85rem">Used for the mobile Call button and primary tel: links.</p>
        </div>
        <div>
            <label>Secondary call number</label>
            <input name="phone_secondary" value="{{ $settings['phone_secondary'] ?? '' }}" placeholder="+91 80757 71824" autocomplete="tel">
            <p class="muted" style="margin:.35rem 0 0;font-size:.85rem">Shown as the alternate phone on contact / FAQ sections.</p>
        </div>
        <div>
            <label>WhatsApp number</label>
            <input name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}" placeholder="918921525086" inputmode="numeric">
            <p class="muted" style="margin:.35rem 0 0;font-size:.85rem">Digits only with country code (e.g. <code>918921525086</code>). No + or spaces needed.</p>
        </div>
        <div class="full">
            <label>WhatsApp default message</label>
            <textarea name="whatsapp_message" rows="3" placeholder="Hi IXORA Homestay! I found you on the website…">{{ $settings['whatsapp_message'] ?? '' }}</textarea>
            <p class="muted" style="margin:.35rem 0 0;font-size:.85rem">Pre-filled when visitors tap the floating WhatsApp button.</p>
        </div>
    </div>

    <h2>Email notifications</h2>
    <p class="muted" style="margin:0 0 1rem">New bookings and contact enquiries are sent to the primary/additional addresses below. Customer confirmation emails use the From address. SMTP must be configured in the server <code>.env</code> (<code>MAIL_MAILER=smtp</code>).</p>
    <div class="form-grid">
        <div><label>Primary admin email</label><input name="booking_email_primary" type="email" value="{{ $settings['booking_email_primary'] ?? '' }}" placeholder="you@yourdomain.com" required></div>
        <div><label>Additional admin emails (comma-separated)</label><input name="booking_email_additional" value="{{ $settings['booking_email_additional'] ?? '' }}" placeholder="other@email.com"></div>
        <div><label>From name</label><input name="mail_from_name" value="{{ $settings['mail_from_name'] ?? '' }}"></div>
        <div><label>From email</label><input name="mail_from_address" type="email" value="{{ $settings['mail_from_address'] ?? '' }}" placeholder="noreply@yourdomain.com"></div>
        <div><label>Reply-to</label><input name="mail_reply_to" type="email" value="{{ $settings['mail_reply_to'] ?? '' }}"></div>
        <div>
            <label>Customer confirmation (booking)</label>
            <select name="booking_customer_confirmation">
                <option value="1" @selected(($settings['booking_customer_confirmation'] ?? '1') === '1')>Enabled</option>
                <option value="0" @selected(($settings['booking_customer_confirmation'] ?? '1') === '0')>Disabled</option>
            </select>
        </div>
        <div><label>Turnstile site key</label><input name="turnstile_site_key" value="{{ $settings['turnstile_site_key'] ?? '' }}"></div>
        <div><label>Turnstile secret key</label><input name="turnstile_secret_key" value="{{ $settings['turnstile_secret_key'] ?? '' }}"></div>
    </div>
    <div class="form-actions form-actions--sticky">
        <button class="btn" type="submit">Save settings</button>
        <span class="muted">Changes apply across the public website immediately.</span>
    </div>
</form>
@endsection
