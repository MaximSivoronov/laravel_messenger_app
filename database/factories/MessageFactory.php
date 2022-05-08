<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        do {
            $from = rand(1, 15);
            $to = rand(1, 15);
        } while ($from === $to);

        return [
            'from' => $from,
            'to' => $to,
            'content' => $this->faker->text(),
        ];
    }
}
