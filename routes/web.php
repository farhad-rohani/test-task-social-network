<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return

        User::
        whereHas('followings', function ($query) {
            $query
                ->whereFollowerId(211)
                ->approved();
        })->
    with(['followings' => function ($query) {
//            $query->whereFollowerId($user->id)->approved();
        $query
            ->whereFollowerId(211)
            ->approved();
    }])->get();




//
    $user = User::with('messages.image')->first();

$user->messages[2]->image->delete();
    return $user->load('messages.image');
//    $user->profile()->create([
//        'description' => 'lorem'
//    ]);
//    \App\Models\Profile::create(['user_id' => 1, 'description' => 'ssssss']);








return
    \App\Models\User::with(['followers', 'followings' => function ($query) {
        $query->approved();
    }])
//        ->whereHas('followers')
        ->whereHas('followings')
        ->first();
    return view('welcome');
});
