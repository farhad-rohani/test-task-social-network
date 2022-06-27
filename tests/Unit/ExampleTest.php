<?php

namespace Tests\Unit;

use App\Models\Message;
use App\Models\User;

//use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use LaravelIdea\Helper\App\Models\_IH_User_QB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_all_database()
    {

        $count = 2;

        $users = User::factory($count)
            ->hasAttached(User::factory()->hasImage()->count($count), $this->getPivotApproved(), 'followers')
            ->hasAttached(User::factory()->hasMessages($count)->count($count), $this->getPivotApproved(), 'followings')
            ->hasProfile()
            ->has(Message::factory()->count($count)->hasImage())
            ->hasImage()
            ->create();

        $this->assertDatabaseCount('media', ($count * $count) + ($count * $count) + $count);
        $this->assertDatabaseCount('users', $count + ($count * $count) + ($count * $count));
        $this->assertDatabaseCount('profiles', $count);
        $this->assertDatabaseCount('messages', ($count * $count) + ($count * $count * $count));

        $user = $users[0];

        $this->assertModelExists($user);
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);


        self::assertEquals($count, $user->messages->count());
        self::assertNotEmpty($user->messages[0]->image);

        $user->messages->each(function ($message) {
            $message->image->delete();
            $message->load('image');
            self::assertEmpty($message->image);
            $message->delete();
        });
        $user->load('messages');
        self::assertEmpty($user->messages);

        self::assertNotEmpty($user->profile);
        $user->profile->delete();
        $user->load('profile');
        self::assertEmpty($user->profile);

        self::assertEquals($count, $user->followers->count());
        $user->followers()->detach();
        $user->load('followers');
        self::assertEmpty($user->followers);

        self::assertEquals($count, $user->followings->count());
        $user->followings()->detach();
        $user->load('followings');
        self::assertEmpty($user->followings);

        $user->delete();
        $this->assertModelMissing($user);
        $this->assertDatabaseMissing('users', [
            'email' => $user->email,
        ]);
    }


    public function test_followings()
    {

        $count = 2;
        $users = User::factory($count)
            ->hasAttached(User::factory()->hasMessages($count)->count($count), $this->getPivotApproved(), 'followings')
            ->create();

        $user = $users[0];

        self::assertEquals($count, $user->followings->count());
        $user->followings()->detach();
        $user->load('followings');
        self::assertEmpty($user->followings);


        $user->followings()->attach([
            User::where('id', '!=', $user->id)->first()->id => ['approved_at' => now()->addMinute()]
        ]);


        $users2 = User::whereHas('followings', function ($query) use($user) {
            $query->whereFollowerId($user->id)->approved();
        })->get();
        self::assertEquals(1, $users2->count());

        $user->load('followings');
        self::assertEquals(1, $user->followings->count());
        $user->followings()->detach();
        $user->load('followings');
        self::assertEmpty($user->followings);

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
