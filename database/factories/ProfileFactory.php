<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $handle = $this->faker->unique()->userName();

        return [
            'user_id' => User::factory(),
            'display_name' => $this->faker->name(),
            'handle' => $handle,
            'bio' => $this->faker->sentences(asText: true),
            //            'avatar_url' => $this->faker->imageUrl(90, 90, 'people'),
            //            'cover_url' => $this->faker->imageUrl(90, 90, 'people'),
            'avatar_url' => 'http://dummyimage.com/90x90/eee/000',
            'cover_url' => 'http://dummyimage.com/1400x640/555/ECA749?text='.$handle,
        ];
    }
}
