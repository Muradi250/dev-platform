<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrganizationInvitationController extends Controller
{
    public function show(string $token): View
    {
        $membership = $this->findInvitation($token);

        abort_unless(
            in_array(auth()->user()->status, ['pending', 'active'], true),
            403
        );

        abort_unless(
            strcasecmp(
                (string) auth()->user()->email,
                (string) $membership->invite_email
            ) === 0,
            403
        );

        return view('organization-invitations.accept', [
            'membership' => $membership->load('organization'),
        ]);
    }

    public function accept(Request $request, string $token): RedirectResponse
    {
        /** @var User $acceptedUser */
        $acceptedUser = DB::transaction(function () use ($request, $token): User {
            $membership = $this->findInvitation($token, lockForUpdate: true);
            $user = $request->user();

            if (! in_array($user->status, ['pending', 'active'], true)) {
                throw ValidationException::withMessages([
                    'invitation' => 'This account is not eligible to accept an organization invitation.',
                ]);
            }

            if (strcasecmp((string) $user->email, (string) $membership->invite_email) !== 0) {
                throw ValidationException::withMessages([
                    'invitation' => 'Sign in with the email address that received this invitation.',
                ]);
            }

            $alreadyMember = Membership::query()
                ->where('organization_id', $membership->organization_id)
                ->where('user_id', $user->getKey())
                ->whereKeyNot($membership->getKey())
                ->exists();

            if ($alreadyMember) {
                throw ValidationException::withMessages([
                    'invitation' => 'You are already a member of this organization.',
                ]);
            }

            $membership->forceFill([
                'user_id' => $user->getKey(),
                'invite_email' => null,
                'status' => 'active',
                'joined_at' => now(),
                'accepted_at' => now(),
                'invitation_token_hash' => null,
                'invitation_expires_at' => null,
            ])->save();

            if ($user->status === 'pending') {
                $user->forceFill(['status' => 'active'])->save();
            }

            return $user;
        });

        if (! $acceptedUser->hasVerifiedEmail()) {
            $acceptedUser->sendEmailVerificationNotification();
        }

        return redirect()
            ->route('dashboard', ['locale' => app()->getLocale()])
            ->with('status', 'organization-invitation-accepted');
    }

    private function findInvitation(string $token, bool $lockForUpdate = false): Membership
    {
        $query = Membership::query()
            ->where('invitation_token_hash', hash('sha256', $token))
            ->where('status', 'invited')
            ->where('invitation_expires_at', '>', now());

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        return $query->firstOrFail();
    }
}
