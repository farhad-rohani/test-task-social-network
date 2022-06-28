<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Lib\Lib;
use App\Http\Controllers\Controller;
use App\Http\Resources\RelationResource;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\Relation;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use Lib;

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user', [
            'only' => ['index','show','destroy'],
        ]);
    }

    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
    }

    public function followers(User $user, Request $request)
    {
        $relation_QB = Relation::whereFollowingId($user->id)->with('follower.profile.image', 'follower.profile:id,user_id');
        $relations = $this->filterFollow($relation_QB, $request)->paginate();
        return RelationResource::collection($relations);
    }


    public function followings(User $user, Request $request)
    {
        $relation_QB = Relation::whereFollowerId($user->id)->with('following.profile.image', 'following.profile:id,user_id');
        $relations = $this->filterFollow($relation_QB, $request)->paginate();
        return RelationResource::collection($relations);
    }

    public function follow(User $user)
    {
        if (auth()->user()->followings()->whereFollowingId($user->id)->exists()) {
            abort(500, 'already follow ' . $user->name );
        }
            auth()->user()->followings()->attach($user);
            abort(200, 'follow ' . $user->name . ' successful');
    }
}
