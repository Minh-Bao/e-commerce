<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($this->faker));
        return [
            'name'             => $this->faker->boolean(66) ? $this->faker->words(3, true) : $this->faker->word(),
            'description'      => $this->faker->paragraphs(4, true),
            'price'            => $this->faker->randomFloat(2, 15.50, 2556.25),
            'product_img_path' => $this->faker->imageUrl($width = 800, $height = 600),
            'image_alt'        => $this->faker->sentence(5),
            'quantity'         => $this->faker->boolean(80) ? $this->faker->numberBetween(15, 2500) : 0,
        ];
    }
}
