<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MediaFactory extends Factory
{
    protected $model = Media::class;

    public function definition(): array
    {
        return [
            'model_id' => $this->faker->randomNumber(),
            'model_type' => $this->faker->word(),
            'name' => $this->faker->name(),
            'file_name' => $this->faker->name(),
            'mime_type' => $this->faker->word(),
            'size' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
