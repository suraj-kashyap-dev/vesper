<button
    aria-label="{{ __('filament-panels::layout.actions.open_database_notifications.label') }}"
    type="button"
    class="fi-topbar-database-notifications-btn vs-topbar-action-btn vs-topbar-notifications-trigger tb-btn"
>
    {{ \Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::OutlinedBell) }}

    @if ($unreadNotificationsCount)
        <span class="vs-topbar-notifications-dot" aria-hidden="true"></span>
    @endif
</button>
