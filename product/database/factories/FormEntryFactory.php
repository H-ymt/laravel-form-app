<?php

namespace Database\Factories;

use App\Models\FormEntry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FormEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = FormEntry::class;


    public function definition(): array
    {
        static $number = 1;
        return [
            'name' => $this->faker->name(),
            'kana_name' => $this->faker->kanaName(),
            'phone_number' => $this->faker->phoneNumber(),
            'birth_day' => $this->faker->dateTimeBetween('-80 years', '-20years')->format('Y-m-d'),
            'email' => $this->faker->unique()->safeEmail(),
            'additional_info' => "テスト",
            'applied_at' => Carbon::now()->format('Y/m/d H:i'),
            'job_number' => 'csh1lp_nomura',
            'user_id' => str_pad($number++, 3, '0', STR_PAD_LEFT)
        ];
    }
}
