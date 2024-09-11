<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Tab;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 users
        $users = User::factory(10)->create();


        // For each user, create collections and tags
        $users->each(function ($user) {
            $collections = Collection::factory(5)->create(['user_id' => $user->id]);
            $tags = Tag::factory(3)->create(['user_id' => $user->id]);

            // For each collection, create tabs
            $collections->each(function ($collection) {
                Tab::factory(3)->create(['collection_id' => $collection->id]);
            });
        });
    }
}
