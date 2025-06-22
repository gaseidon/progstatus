<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserService
{
    public function __construct(private UserRepository $users) {}

    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->users->create($data);
        Auth::login($user);
        return $user;
    }

    public function login(array $credentials, bool $remember = false): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function updateProfile(int $userId, array $data): void
    {
        $user = $this->users->find($userId);
        $update = [];

        if (isset($data['name'])) {
            $update['name'] = $data['name'];
        }
        if (isset($data['email'])) {
            $update['email'] = $data['email'];
        }

        if (isset($data['remove_avatar']) && $data['remove_avatar']) {
            if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $update['avatar'] = null;
        }
        if (isset($data['avatar']) && $data['avatar']) {
            if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $path = $data['avatar']->store('avatars', 'public');
            $update['avatar'] = $path;
        }
        if (!empty($data['avatar_cropped'])) {
            if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $base64 = $data['avatar_cropped'];
            if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
                $base64 = substr($base64, strpos($base64, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif
                $base64 = base64_decode($base64);
                $filename = 'avatars/' . uniqid() . '.' . $type;
                \Storage::disk('public')->put($filename, $base64);
                $update['avatar'] = $filename;
            }
        }
        if (!empty($update)) {
            $user->update($update);
        }
    }

    public function changePassword(int $userId, array $data): bool
    {
        $user = $this->users->find($userId);
        if (!\Hash::check($data['old_password'], $user->password)) {
            return false;
        }
        $user->update([
            'password' => \Hash::make($data['password'])
        ]);
        return true;
    }
} 