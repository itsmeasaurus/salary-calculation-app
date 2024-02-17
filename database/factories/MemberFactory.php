<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name();
        $email = $this->faker->unique()->safeEmail();

        return [
            'name' => $name,
            'name_slug' => strtolower(str_replace(' ', '_', $name)),
            'email' => $email,
            'address' => $this->faker->address(),
            'position' => $this->faker->jobTitle(),
            'status' => $this->faker->randomElement([
                Member::STATUS_PART_TIME,
                Member::STATUS_PERMANENT,
                Member::STATUS_TRAINING,
                Member::STATUS_LEADER,
            ]),
            'joined_at' => $this->faker->dateTimeBetween('-3 years', '-1 year'),
            'user_id' => User::factory()->create([
                'username' => strtolower(str_replace(' ', '_', $name)),
                'email' => $email,
                'password' => bcrypt('admin')
            ]),
        ];
    }
}
