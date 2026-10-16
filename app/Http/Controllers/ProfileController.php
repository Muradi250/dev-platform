<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RuntimeException;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
        $validated = $request->validated();
        $oldAvatar = $user->avatar;
        $newAvatar = null;

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            $newAvatar = $request->file('avatar')->storePublicly('avatars', 'public');

            if (! is_string($newAvatar)) {
                throw new RuntimeException('Unable to store the uploaded profile image.');
            }

            $user->avatar = $newAvatar;
        } elseif ($request->boolean('remove_avatar')) {
            $user->avatar = null;
        }

        $user->save();

        if ($oldAvatar && ($newAvatar || $request->boolean('remove_avatar'))) {
            $this->deleteAvatarFile($oldAvatar);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    private function deleteAvatarFile(string $avatar): void
    {
        if (str_starts_with($avatar, 'avatars/')) {
            $disk = Storage::disk('public');

            if ($disk->exists($avatar) && ! $disk->delete($avatar)) {
                Log::warning('Unable to delete a replaced profile image.', [
                    'avatar' => $avatar,
                ]);
            }

            return;
        }

        $legacyPath = public_path('uploads/avatars/' . basename($avatar));

        if (is_file($legacyPath) && ! unlink($legacyPath)) {
            Log::warning('Unable to delete a legacy profile image.', [
                'avatar' => basename($avatar),
            ]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
