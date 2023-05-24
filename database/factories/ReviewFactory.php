<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = $this->faker->boolean(50)? User::factory()->create() : null;
        return [
            'review'     => $this->faker->paragraph,
            'rating'     => $this->faker->numberBetween(0, 5),
            'alias'      => isset($user) ?  $user->name : "user_" . $this->faker->word,
            'img_path'   => null,
            'user_id'    => isset($user) ? $user->id :  $this->faker->randomElement(User::pluck('id')->all()),
            'product_id' => $this->faker->randomElement(Product::pluck('id')->all())
        ];
    }


}
