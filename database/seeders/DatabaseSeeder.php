<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(20)->create();
        for ($i = 2; $i <= 21; $i++) {
            $user = \App\Models\User::find($i);
            $profile = new \App\Models\Profile();
            $profile->user_id = $i;
            $profile->avatar = 'assets/avatar/img4.jpg';
            $profile->display_name = $user->username;
            $profile->save();
        }
        \App\Models\Question::factory(100)->create();
        \App\Models\Answer::factory(400)->create();
        \App\Models\AnswerReply::factory(1000)->create();
    }
}
