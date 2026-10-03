<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaqAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_faq_admin(): void
    {
        $this->get(route('admin.faqs.index'))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_update_and_delete_faq(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.faqs.store'), [
                'question' => 'Is parking free?',
                'answer' => 'Yes, on-site parking is included.',
                'sort_order' => 5,
                'status' => 'active',
            ])
            ->assertRedirect(route('admin.faqs.index'));

        $faq = Faq::query()->where('question', 'Is parking free?')->first();
        $this->assertNotNull($faq);
        $this->assertSame('active', $faq->status);

        $this->actingAs($admin)
            ->put(route('admin.faqs.update', $faq), [
                'question' => 'Is parking included?',
                'answer' => 'Yes, free on-site parking.',
                'sort_order' => 8,
                'status' => 'inactive',
            ])
            ->assertRedirect(route('admin.faqs.index'));

        $faq->refresh();
        $this->assertSame('Is parking included?', $faq->question);
        $this->assertSame('inactive', $faq->status);

        $this->actingAs($admin)
            ->delete(route('admin.faqs.destroy', $faq))
            ->assertRedirect(route('admin.faqs.index'));

        $this->assertSoftDeleted($faq);
    }

    public function test_faq_validation_requires_question_and_answer(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.faqs.store'), [
                'question' => '',
                'answer' => '',
                'status' => 'active',
            ])
            ->assertSessionHasErrors(['question', 'answer']);
    }
}
