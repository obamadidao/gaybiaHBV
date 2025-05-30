<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $users = User::all();

        if ($users->count() < 3) {
            User::firstOrCreate(['email' => 'user1@example.com'], [
                'name' => 'User One',
                'password' => bcrypt('password'),
                'role_id' => 2
            ]);
            
            User::firstOrCreate(['email' => 'user2@example.com'], [
                'name' => 'User Two', 
                'password' => bcrypt('password'),
                'role_id' => 2
            ]);
            
            $users = User::all();
        }

        $templates = [
            [
                'rating' => 5,
                'title' => 'Excellent product!',
                'content' => 'Very satisfied with the quality.',
                'pros' => json_encode(['High quality', 'Good design']),
                'cons' => json_encode([]),
                'is_approved' => true,
                'is_verified_purchase' => true,
                'helpful_count' => 10
            ],
            [
                'rating' => 4,
                'title' => 'Good product',
                'content' => 'Overall good but could be better.',
                'pros' => json_encode(['Good quality']),
                'cons' => json_encode(['Price is high']),
                'is_approved' => true,
                'is_verified_purchase' => true,
                'helpful_count' => 5
            ],
            [
                'rating' => 3,
                'title' => 'Average',
                'content' => 'Nothing special about this product.',
                'pros' => json_encode(['OK price']),
                'cons' => json_encode(['Average quality']),
                'is_approved' => false,
                'is_verified_purchase' => false,
                'helpful_count' => 2
            ]
        ];

        foreach ($products as $product) {
            // Lấy users chưa review sản phẩm này
            $availableUsers = $users->filter(function($user) use ($product) {
                return !ProductReview::where('product_id', $product->id)
                                   ->where('user_id', $user->id)
                                   ->exists();
            });
            
            if ($availableUsers->count() > 0) {
                $numReviews = min(2, $availableUsers->count());
                $selectedUsers = $availableUsers->random($numReviews);
                
                foreach ($selectedUsers as $user) {
                    $template = $templates[array_rand($templates)];
                    
                    ProductReview::create([
                        'product_id' => $product->id,
                        'user_id' => $user->id,
                        'rating' => $template['rating'],
                        'title' => $template['title'],
                        'content' => $template['content'],
                        'pros' => $template['pros'],
                        'cons' => $template['cons'],
                        'is_approved' => $template['is_approved'],
                        'is_hidden' => false,
                        'is_verified_purchase' => $template['is_verified_purchase'],
                        'helpful_count' => $template['helpful_count'],
                        'admin_notes' => null,
                        'approved_at' => $template['is_approved'] ? now() : null,
                        'approved_by' => $template['is_approved'] ? 1 : null,
                        'created_at' => now()->subDays(rand(1, 30)),
                        'updated_at' => now()->subDays(rand(0, 10))
                    ]);
                }
            }
        }
    }
} 