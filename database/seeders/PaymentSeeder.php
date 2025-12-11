<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Order;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        // Create some sample orders first if they don't exist
        $orders = Order::limit(5)->get();

        if ($orders->count() < 5) {
            // Create sample orders
            for ($i = 1; $i <= 5; $i++) {
                $order = Order::create([
                    'user_id' => null,
                    'total' => rand(50, 200),
                    'status' => 'completed',
                    'customer_name' => "Customer $i",
                    'customer_email' => "customer$i@example.com",
                    'customer_phone' => "+123456789$i",
                    'customer_address' => "123 Sample St, City $i, State $i",
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
                $orders->push($order);
            }
        }

        // Create sample payments
        $samplePayments = [
            [
                'payment_intent_id' => 'pi_' . uniqid(),
                'amount' => 150.00,
                'currency' => 'usd',
                'status' => 'succeeded',
                'email' => 'customer1@example.com',
                'order_id' => $orders->get(0)?->id,
            ],
            [
                'payment_intent_id' => 'pi_' . uniqid(),
                'amount' => 89.50,
                'currency' => 'usd',
                'status' => 'succeeded',
                'email' => 'customer2@example.com',
                'order_id' => $orders->get(1)?->id,
            ],
            [
                'payment_intent_id' => 'pi_' . uniqid(),
                'amount' => 245.99,
                'currency' => 'usd',
                'status' => 'pending',
                'email' => 'customer3@example.com',
                'order_id' => $orders->get(2)?->id,
            ],
            [
                'payment_intent_id' => 'pi_' . uniqid(),
                'amount' => 67.25,
                'currency' => 'usd',
                'status' => 'failed',
                'email' => 'customer4@example.com',
                'order_id' => $orders->get(3)?->id,
            ],
            [
                'payment_intent_id' => 'pi_' . uniqid(),
                'amount' => 320.00,
                'currency' => 'usd',
                'status' => 'succeeded',
                'email' => 'customer5@example.com',
                'order_id' => $orders->get(4)?->id,
            ],
            [
                'payment_intent_id' => 'pi_' . uniqid(),
                'amount' => 125.75,
                'currency' => 'usd',
                'status' => 'succeeded',
                'email' => 'john.doe@example.com',
                'order_id' => null, // No order linked
            ],
            [
                'payment_intent_id' => 'pi_' . uniqid(),
                'amount' => 78.30,
                'currency' => 'usd',
                'status' => 'requires_capture',
                'email' => 'jane.smith@example.com',
                'order_id' => null, // No order linked
            ],
        ];

        foreach ($samplePayments as $paymentData) {
            Payment::create(array_merge($paymentData, [
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(1, 30)),
            ]));
        }

        $this->command->info('Sample payments created successfully!');
    }
}
