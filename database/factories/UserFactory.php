<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'student_id' => $this->faker->unique()->numberBetween(10000, 99999),
           
            'password' => static::$password ??= \Illuminate\Support\Facades\Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'student',
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'father_name' => fake()->name('male'),
            'mother_name' => fake()->name('female'),
            'gender' => fake()->randomElement(['male', 'female']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * حالة خاصة لإنشاء مستخدم مدير (Admin).
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'name' => 'shadi',
            'student_id' => '2599', // هنا يمكنك وضع الرقم التعريفي الخاص بالمدير
            'password' => '55550000',

        ]);
    }
}
