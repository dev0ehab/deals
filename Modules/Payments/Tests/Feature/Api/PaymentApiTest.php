<?php

namespace Modules\Payments\Tests\Feature\Api;

use Modules\Payments\Entities\Payment;
use Tests\TestCase;

class PaymentApiTest extends TestCase
{


    /** @test */
    public function it_can_display_list_of_payments()
    {
        $payment = Payment::factory()->create();

        $response = $this->get(route('payments.index'));

        $response->assertSuccessful();

        $response->assertSee(e($payment->name));
    }

    /** @test */
    public function it_can_display_list_of_payments_details()
    {
        $payment = Payment::factory()->create();

        $response = $this->get(route('payments.show', $payment));

        $response->assertSuccessful();

        $response->assertSee(e($payment->name));
    }
}
