<?php

namespace Modules\Payments\Tests\Feature\Dashboard;

use App\Http\Middleware\VerifyCsrfToken;
use Astrotomic\Translatable\Validation\RuleFactory;
use Modules\Payments\Entities\Payment;
use Tests\TestCase;

class PaymentTest extends TestCase
{


    /** @test */
    public function it_can_display_list_of_payments()
    {
        $this->actingAsAdmin();

        $payment = Payment::factory()->create();

        $response = $this->get(route('dashboard.payments.index'));

        $response->assertSuccessful();

        $response->assertSee(e($payment->name));
    }

    /** @test */
    public function it_can_display_payment_details()
    {
        $this->actingAsAdmin();

        $payment = Payment::factory()->create();

        $response = $this->get(route('dashboard.payments.show', $payment));

        $response->assertSuccessful();

        $response->assertSee(e($payment->name));
    }

    /** @test */
    public function it_can_create_payments()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class); // remove if test fails
        $this->actingAsAdmin();

        $this->assertEquals(0, Payment::count());

        $response = $this->post(
            route('dashboard.payments.store'),
            RuleFactory::make(
                [
                    '%name%' => 'Clothes',
                    'active' => true,
                ]
            )
        );
        $response->assertRedirect();
        $this->assertEquals(1, Payment::count());
    }

    /** @test */
    public function it_can_display_payments_edit_form()
    {
        $this->actingAsAdmin();

        $payment = Payment::factory()->create();

        $response = $this->get(route('dashboard.payments.edit', [$payment]));

        $response->assertSuccessful();

        $response->assertSee(trans('payments::payments.actions.edit'));
    }

    /** @test */
    public function it_can_update_payments()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class); // remove if test fails
        $this->actingAsAdmin();

        $payment = Payment::factory()->create();

        $response = $this->put(
            route('dashboard.payments.update', [$payment]),
            RuleFactory::make(
                [
                    '%name%' => 'Clothes',
                    'active' => true,
                ]
            )
        );

        $response->assertRedirect();

        $payment->refresh();

        $this->assertEquals($payment->name, 'Clothes');
    }

    /** @test */
    public function it_can_delete_payments()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class); // remove if test fails
        $this->actingAsAdmin();

        $payment = Payment::factory()->create();

        $response = $this->delete(route('dashboard.payments.destroy', [$payment]));
        $response->assertRedirect();

        $this->assertEquals(Payment::count(), 0);
    }
}
