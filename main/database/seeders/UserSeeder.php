<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        User::create([
            'name' => 'Hoang',
            'email' => 'hoang220201@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
        ]);

        /*$user = User::factory()
        ->has(Post::factory()->count(5), 'posts')
        ->create();*/



        $users = User::factory(20)->unverified()->make()->setHidden([]);

        $users->chunk(5)->each(function ($chunk) {
             $chunk->transform(function ($user) {
                 return array_merge($user->toArray(), ['email_verified_at' => now()]); // override cast email_verified_at when use toArray
             });

            User::insert($chunk->toArray());
        });



        // $users = [];

        // for ($i = 0; $i < 10; $i++) {
        //     $users[] = array_merge((new UserFactory())->definition(), ['id' => Str::uuid()]);
        // }

        // collect($users)->chunk(2)->each(function ($chunk) {
        //     User::insert($chunk->toArray());
        // });


    }
}
