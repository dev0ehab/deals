<?php

namespace Modules\Payments\Tests\Feature\Dashboard;

use Modules\Payments\Entities\Payment;
use Tests\TestCase;

class PaymentFilterTest extends TestCase
{


    /** @test */
    public function it_can_filter_payments_by_name()
    {
        $this->actingAsAdmin();

        $this->app->setLocale('ar');

        Payment::factory()->create([
            'name:ar' => 'ملابس',
        ]);

        Payment::factory()->create([
            'name:ar' => 'هواتف',
        ]);

        $this->get(route('dashboard.payments.index', [
            'name' => 'ملابس',
        ]))
            ->assertSuccessful()
            ->assertSee(trans('payments::payments.actions.filter'))
            ->assertSee('ملابس')
            ->assertDontSee('هواتف');
    }
}
