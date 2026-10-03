<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogger;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(SettingsService $settings): View
    {
        return view('admin.settings.index', [
            'settings' => $settings->all(),
        ]);
    }

    public function update(Request $request, SettingsService $settings, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'business_name' => ['nullable', 'string', 'max:180'],
            'brand_name' => ['nullable', 'string', 'max:80'],
            'tagline' => ['nullable', 'string', 'max:180'],
            'phone_primary' => ['nullable', 'string', 'max:40'],
            'phone_secondary' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:150'],
            'whatsapp' => ['nullable', 'string', 'max:40'],
            'whatsapp_message' => ['nullable', 'string', 'max:500'],
            'address' => ['nullable', 'string', 'max:500'],
            'maps_link' => ['nullable', 'string', 'max:500'],
            'maps_embed' => ['nullable', 'string'],
            'map_query' => ['nullable', 'string', 'max:120'],
            'geo_region' => ['nullable', 'string', 'max:20'],
            'geo_placename' => ['nullable', 'string', 'max:180'],
            'geo_position' => ['nullable', 'string', 'max:60'],
            'geo_latitude' => ['nullable', 'string', 'max:40'],
            'geo_longitude' => ['nullable', 'string', 'max:40'],
            'street_address' => ['nullable', 'string', 'max:255'],
            'address_locality' => ['nullable', 'string', 'max:120'],
            'address_region' => ['nullable', 'string', 'max:120'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'copyright' => ['nullable', 'string', 'max:255'],
            'footer_text' => ['nullable', 'string', 'max:1000'],
            'footer_tagline' => ['nullable', 'string', 'max:180'],
            'footer_script' => ['nullable', 'string', 'max:180'],
            'footer_piece' => ['nullable', 'string', 'max:180'],
            'header_cta_label' => ['nullable', 'string', 'max:80'],
            'booking_email_primary' => ['nullable', 'email', 'max:150'],
            'booking_email_additional' => ['nullable', 'string', 'max:500'],
            'mail_from_name' => ['nullable', 'string', 'max:120'],
            'mail_from_address' => ['nullable', 'email', 'max:150'],
            'mail_reply_to' => ['nullable', 'email', 'max:150'],
            'booking_customer_confirmation' => ['nullable', 'in:0,1'],
            'turnstile_site_key' => ['nullable', 'string', 'max:120'],
            'turnstile_secret_key' => ['nullable', 'string', 'max:120'],
            'logo' => ['nullable', 'string', 'max:255'],
            'favicon' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($data as $key => $value) {
            $group = 'general';
            if (str_starts_with($key, 'booking_') || str_starts_with($key, 'mail_')) {
                $group = 'email';
            } elseif (in_array($key, ['facebook', 'instagram', 'youtube', 'linkedin'], true)) {
                $group = 'social';
            } elseif (in_array($key, ['phone_primary', 'phone_secondary', 'whatsapp', 'whatsapp_message', 'email', 'address', 'maps_link', 'maps_embed', 'map_query', 'geo_region', 'geo_placename', 'geo_position', 'geo_latitude', 'geo_longitude', 'street_address', 'address_locality', 'address_region', 'postal_code'], true)) {
                $group = 'contact';
            }
            $settings->set($group, $key, $value);
        }

        if (! empty($data['booking_email_primary'])) {
            $settings->set('general', 'admin_email', $data['booking_email_primary']);
        }

        $logger->log('settings.updated', null, ['keys' => array_keys($data)]);

        return back()->with('success', 'Settings saved.');
    }
}
