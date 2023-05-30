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
        $user = $this->getUserOrNot();
        return [
            'review'     => $this->faker->paragraph,
            'rating'     => $this->faker->numberBetween(1, 5),
            'alias'      => isset($user) ?  $user->name : "User : " . $this->faker->userName(),
            'image_path'   => null,
            'email'      => isset($user) ? $user->email : $this->faker->email(),
            'user_id'    => isset($user) ? $user->id :  null,
            'product_id' => $this->faker->randomElement(Product::all()) ,
            'created_at' => $this->faker->dateTimeBetween('-3 years','now', 'Europe/Paris'),
            'updated_at' => $this->faker->dateTimeBetween('-3 years','now', 'Europe/Paris'),
        ];
    }

    /**
     * Generate user or not
     *
     * @return User|null
     */
    private function getUserOrNot(): ?User
    {
        return $this->faker->boolean(60) ? $this->faker->randomElement(User::all()) : null;

    }


}
