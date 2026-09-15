<x-filament::dropdown placement="bottom-end" teleport width="xs">
    <x-slot name="trigger">
        <x-filament-panels::topbar.item
            :icon="\Filament\Support\Icons\Heroicon::GlobeAmericas"
            aria-label="Language"
        />
    </x-slot>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item
            tag="a"
            href="{{ route('admin.language', ['locale' => 'en']) }}"
            :icon="\Filament\Support\Icons\Heroicon::GlobeEuropeAfrica"
        >
            English
        </x-filament::dropdown.list.item>

        <x-filament::dropdown.list.item
            tag="a"
            href="{{ route('admin.language', ['locale' => 'fa']) }}"
            :icon="\Filament\Support\Icons\Heroicon::GlobeAsiaAustralia"
        >
            فارسی
        </x-filament::dropdown.list.item>

        <x-filament::dropdown.list.item
            tag="a"
            href="{{ route('admin.language', ['locale' => 'ps']) }}"
            :icon="\Filament\Support\Icons\Heroicon::GlobeAmericas"
        >
            پښتو
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>
