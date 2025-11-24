<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookingStatus;

class BookingStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            [
                'name' => 'pending',
                'color' => '#ffc107',
                'order_index' => 1,
                'description' => 'Ожидание подтверждения'
            ],
            [
                'name' => 'confirmed',
                'color' => '#17a2b8',
                'order_index' => 2,
                'description' => 'Подтверждено'
            ],
            [
                'name' => 'paid',
                'color' => '#28a745',
                'order_index' => 3,
                'description' => 'Оплачено'
            ],
            [
                'name' => 'cancelled',
                'color' => '#dc3545',
                'order_index' => 4,
                'description' => 'Отменено'
            ],
            [
                'name' => 'completed',
                'color' => '#6c757d',
                'order_index' => 5,
                'description' => 'Завершено'
            ],
        ];

        foreach ($statuses as $status) {
            BookingStatus::firstOrCreate(
                ['name' => $status['name']],
                $status
            );
        }

        echo "Созданы статусы бронирований:\n";
        $createdStatuses = BookingStatus::all();
        foreach ($createdStatuses as $status) {
            echo "- {$status->name}: {$status->description}\n";
        }
    }
}
