<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        factory(\App\Models\User::class, 1)->create();

        factory(\App\Models\Article::class)
            ->create()
            ->each(function (\App\Models\Article $article) {
                $article->comments()->save(factory(\App\Models\Comment::class)->create());
            });

        factory(\App\Models\People::class, 2)->create();

        factory(\App\Models\Article::class, 3)->create();
    }
}
