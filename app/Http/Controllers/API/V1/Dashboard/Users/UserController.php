<?php

namespace App\Http\Controllers\API\V1\Dashboard\Users;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use APIResponse;

    public function index(Request $request)
    {

        $users = User::query()
            ->when(($request->has('key') && !empty($request->get('key'))), function ($q) {
                $key = request()->input('key');
                $value = request()->input('value');
                $q->where($key, 'like', '%' . $value . '%');
            })
            ->paginate(15)
            ->withQueryString();

        return $this->success(200, 'success', $users);
    }

    public function bannedUsers(Request $request)
    {

        $users = User::query()
            ->onlyTrashed()
            ->when(($request->has('key') && !empty($request->get('key'))), function ($q) {
                $key = request()->input('key');
                $value = request()->input('value');
                $q->where($key, 'like', '%' . $value . '%');
            })
            ->paginate(15)
            ->withQueryString();
        return $this->success(200, 'success', $users);
    }

    public function reStore(User $user)
    {
        if (!$user->trashed()) {
            return $this->error(404, 'The Requested User Coudld Be Found Or Its Not Deleted', []);
        }

        $user->restore();
        $user->ban_message = null;
        $user->save();
        return $this->success(202, "Restored Successfully", []);
    }

    public function show(User $user, Request $request)
    {
        return $this->success(200, 'success', UserResource::make($user));
    }

    public function update()
    {
    }

    public function delete(User $user, Request $request)
    {
        if ($user->trashed()) {
            $user->forceDelete();
            return $this->success(202, "User Deleted Successfully From The Website", []);
        }

        $request->validate([
            'ban_message' => ['string', 'required'],
        ]);
        $user->ban_message = $request->ban_message;
        $user->save();
        $user->delete();
        return $this->success(202, "User Banned Successfully", []);
    }
}
