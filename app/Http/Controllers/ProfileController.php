<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\UserService;

class ProfileController extends Controller
{
    public function __construct(private UserService $service) {}

    public function show()
    {
        return view('profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        $this->service->updateProfile(Auth::id(), $data);
        return back()->with('success', 'Профиль обновлён!');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $result = $this->service->changePassword(Auth::id(), $request->validated());
        return $result
            ? back()->with('success', 'Пароль успешно изменён!')
            : back()->withErrors(['old_password' => 'Старый пароль неверен.']);
    }

    public function removeAvatar()
    {
        $this->service->updateProfile(Auth::id(), ['remove_avatar' => true]);
        return back()->with('success', 'Фото профиля удалено!');
    }
} 