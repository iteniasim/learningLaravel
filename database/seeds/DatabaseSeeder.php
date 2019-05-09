<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $threads = factory('App\Thread', 10)->create();
        $threads->each(
            function ($thread) {
                return factory('App\Reply', 2)->create(['thread_id' => $thread->id]);
            }
        );
    }
}
