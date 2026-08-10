<?php

namespace Tests\Feature;

use App\Models\Setting;
use Tests\TestCase;

class FormSettingsTest extends TestCase
{
    public function test_admin_can_update_categories_and_tujuan_options(): void
    {
        $oldCategories = Setting::getCategories();
        $oldTujuan = Setting::getTujuanOptions();

        $categories = [
            ['name' => 'Kategori Baru Test', 'description' => 'Deskripsi Kategori Test'],
        ];
        $tujuanOptions = ['Kepala Lab Test'];

        $response = $this->withSession(['admin_logged_in' => true])
            ->post('/admin/settings', [
                'categories' => json_encode($categories),
                'tujuan_options' => json_encode($tujuanOptions),
                'require_phone' => '1',
                'require_email' => '0',
            ]);

        $response->assertRedirect('/admin/settings');

        $this->assertEquals($categories, Setting::getCategories());
        $this->assertEquals($tujuanOptions, Setting::getTujuanOptions());

        // Restore original state
        Setting::setJson('guest_categories', $oldCategories);
        Setting::setJson('tujuan_options', $oldTujuan);
    }

    public function test_guest_form_displays_updated_settings(): void
    {
        $response = $this->get('/form');

        $response->assertStatus(200);
        $response->assertSee('Kategori Tamu');
    }
}
