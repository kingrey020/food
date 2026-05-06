<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // --- BURGERS ---
            [
                'name' => 'Classic Cheeseburger',
                'price' => 150,
                'category' => 'Burgers',
                'description' => 'Juicy beef patty with melted cheddar, pickles, and our secret sauce.',
            ],
            [
                'name' => 'BBQ Bacon Beast',
                'price' => 220,
                'category' => 'Burgers',
                'description' => 'Double patty, crispy bacon, onion rings, and smoky BBQ sauce.',
            ],

            // --- PIZZA ---
            [
                'name' => 'Pepperoni Overload',
                'price' => 380,
                'category' => 'Pizza',
                'description' => 'Loaded with premium pepperoni and mozzarella on a thin crust.',
            ],
            [
                'name' => 'Garden Fresh Pizza',
                'price' => 320,
                'category' => 'Pizza',
                'description' => 'Bell peppers, olives, mushrooms, and onions for the veggie lovers.',
            ],

            // --- SALADS ---
            [
                'name' => 'Chicken Caesar Salad',
                'price' => 180,
                'category' => 'Salads',
                'description' => 'Fresh romaine, grilled chicken, croutons, and creamy dressing.',
            ],

            // --- DRINKS ---
            [
                'name' => 'Iced Caramel Macchiato',
                'price' => 120,
                'category' => 'Drinks',
                'description' => 'Double shot espresso with steamed milk and caramel drizzle.',
            ],
            [
                'name' => 'Fresh Lemonade',
                'price' => 65,
                'category' => 'Drinks',
                'description' => 'Hand-squeezed lemons with a hint of mint.',
            ],
            [
                'name' => 'Coca-Cola Zero',
                'price' => 45,
                'category' => 'Drinks',
                'description' => 'Refreshing 330ml can, zero sugar.',
            ],
        ];

        foreach ($items as $item) {
            Menu::create($item);
        }
    }
}