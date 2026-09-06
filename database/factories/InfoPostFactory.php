<?php

namespace Database\Factories;

use App\Models\InfoPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<InfoPost>
 */
class InfoPostFactory extends Factory
{
    protected $model = InfoPost::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => '<p>'.$this->faker->paragraphs(3, true).'</p><p>'.$this->faker->sentence(12).'</p>',
            'is_published' => true,
            'published_at' => $this->faker->dateTimeBetween('-2 weeks', '+1 week'),
        ];
    }
}
