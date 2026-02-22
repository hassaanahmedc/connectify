<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            'Technology',
            'Programming',
            'Artificial Intelligence',
            'Web Development',
            'Mobile Development',
            'Gaming',
            'Science',
            'Startups',
            'Design',
            'Cybersecurity',
            'Data Science',
            'DevOps'
        ];

        foreach($topics as $topic) {
            Topic::create([
                'name' => $topic,
                'slug' => Str::slug($topic)
            ]);
        };
    }
}
