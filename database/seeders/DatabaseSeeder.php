<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Message;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $users = User::factory(2)
            ->hasAttached(User::factory()->hasImage()->count(random_int(0, 5)), $this->getPivotApproved(), 'followers')
            ->hasAttached(User::factory()->hasMessages(random_int(0, 5))->count(random_int(0, 5)), $this->getPivotApproved(), 'followings')
            ->hasProfile()
            ->has(Message::factory()->count(random_int(0,5))->hasImage())
            ->hasImage()
            ->create();
    }

    /**
     * @return null[]
     * @throws \Exception
     */
    public function getPivotApproved(): array
    {
        return ['approved_at' => (bool)random_int(0, 1) ? now()->toDateTime() : null];
    }
}
