<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TopicSeeder;
use App\Models\User;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Comment;
use App\Models\Likes;
use App\Models\Topic;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()->count(50)->create();
        $this->call(TopicSeeder::class);
        $topics = Topic::all();

        $users->each(function ($user) use ($users, $topics) {
            $posts = Post::factory()->count(3)->create(['user_id' => $user->id]);

            $posts->each(function ($post) use ($users, $topics) {
                PostImage::factory(fake()->numberBetween(1,3))->create([
                    'posts_id' => $post->id
                ]);

                Comment::factory(fake()->numberBetween(1,30))->create([
                    'posts_id' => $post->id,
                    'user_id' => $users->random()->id,
                ]);

                $post->topic()->attach(
                    $topics->random(rand(1,3))->pluck('id')
                );

                $post->likes()->createMany(
                        $users->random(rand(1,10))->map(function ($u) {
                            return ['user_id' => $u->id];
                        })->toArray()
                );
            });
        });
    }
}
