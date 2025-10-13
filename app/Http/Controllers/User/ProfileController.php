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
    public function __construct(protected UserService $avatarService)
    {
    }

    public function index(Request $request)
    {
        return Inertia::render('Profile');
    }

    public function updateAvatar(CreateAvatarRequest $request, User $user)
    {
        try {
            $this->avatarService->updateUserAvatar($user, $request->file('avatar'));
            return Inertia::location($request->headers->get('referer'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el avatar: ' . $e->getMessage());
        }
    }
}
