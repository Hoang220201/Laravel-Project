<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Post::truncate();
        DB::table('category_post')->truncate();
        Schema::enableForeignKeyConstraints();

        $categories = Category::whereIn('name', ['HTML', 'CSS'])->get(['id']);

        //$userId = User::where('email', 'hoang@gmail.com')->value('id');
        //$userId = DB::table('users')->inRandomOrder()->pluck('id')->first(); 
        $userId = User::inRandomOrder()->value('name');
        

        Post::factory()
            ->count(100)
            ->state(function (array $attributes) {
                return ['id' => Str::uuid()];
            })
            ->afterMaking(function (Post $post) use ($userId) {
                // print_r($post);
                $post->user_id = $userId;
            })
            ->afterCreating(function (Post $post) use ($categories) {

                foreach ($categories as $category) {
                    DB::table('category_post')->insert([
                        'category_id' => $category->id,
                        'post_id' => $post->id
                    ]);
                }
            })
            ->create();
    }
}