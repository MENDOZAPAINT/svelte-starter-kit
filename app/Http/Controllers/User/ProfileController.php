<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateAvatarRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index()
    {
        return Inertia::render('Profile');
    }
    public function updateUser(Request $request, User $user)
    {
        try {
            $this->userService->updateUser($user, $request->except(['avatar']));
            return redirect()->intended(route('profile.index', absolute: false));

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    public function updateAvatar(CreateAvatarRequest $request, User $user)
    {
        try {
            $this->userService->updateUserAvatar($user, $request->file('avatar'));
            return redirect()->intended(route('profile.index', absolute: false));

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el avatar: ' . $e->getMessage());
        }
    }
}
