<?php

namespace App\Http\Controllers;

use App\Filament\Resources\DemoRequests\DemoRequestResource;
use App\Http\Requests\StoreDemoRequestRequest;
use App\Models\DemoRequest;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DemoRequestController extends Controller
{
    public function create(): View
    {
        return view('public.demo-requests.create');
    }

    public function store(StoreDemoRequestRequest $request): RedirectResponse
    {
        if (! $request->filled('website')) {
            $demoRequest = DemoRequest::create([
                ...$request->safe()->except('website'),
                'status' => 'new',
                'locale' => app()->getLocale(),
            ]);

            $admins = User::query()
                ->where('is_owner', true)
                ->orWhereHas('roles', fn ($query) => $query->where('name', 'super-admin'))
                ->get();

            foreach ($admins as $admin) {
                Notification::make()
                    ->title('New demo request')
                    ->body("{$demoRequest->name} from {$demoRequest->company} requested a demo.")
                    ->icon('heroicon-o-play-circle')
                    ->iconColor('info')
                    ->actions([
                        Action::make('view')
                            ->label('Review request')
                            ->url(DemoRequestResource::getUrl('view', [
                                'record' => $demoRequest,
                            ]))
                            ->markAsRead(),
                    ])
                    ->sendToDatabase($admin);
            }
        }

        return redirect()
            ->route('demo-requests.create', ['locale' => app()->getLocale()])
            ->with('demo_request_success', true);
    }
}
