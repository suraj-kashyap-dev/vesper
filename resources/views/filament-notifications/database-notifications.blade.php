@php
    $notifications = $this->getNotifications();
    $unreadNotificationsCount = $this->getUnreadNotificationsCount();
    $hasNotifications = $notifications->count();
    $isPaginated = $notifications instanceof \Illuminate\Contracts\Pagination\Paginator && $notifications->hasPages();
    $pollingInterval = $this->getPollingInterval();
    $notificationItems = $notifications instanceof \Illuminate\Contracts\Pagination\Paginator
        ? collect($notifications->items())
        : $notifications;
    $notificationAlerts = $notificationItems
        ->map(function (\Illuminate\Notifications\DatabaseNotification $notification): array {
            $data = $notification->getAttribute('data') ?? [];

            return [
                'id' => (string) $notification->getKey(),
                'title' => data_get($data, 'title', 'New notification'),
                'body' => data_get($data, 'body'),
                'status' => data_get($data, 'status', 'info'),
                'icon' => data_get($data, 'icon'),
                'iconColor' => data_get($data, 'iconColor'),
                'unread' => $notification->unread(),
            ];
        })
        ->values();
@endphp

<div
    @if ($pollingInterval)
        wire:poll.{{ $pollingInterval }}
    @endif
    class="fi-no-database vs-topbar-notifications tb-dropdown"
>
    <x-filament::dropdown
        placement="bottom-end"
        teleport
        width="md"
        class="vs-topbar-notifications-dropdown"
    >
        @if ($trigger = $this->getTrigger())
            <x-slot name="trigger">
                {{ $trigger->with(['unreadNotificationsCount' => $unreadNotificationsCount]) }}
            </x-slot>
        @endif

        @script
            <script>
                ;(() => {
                    const vesperDatabaseNotifications = window.vesperDatabaseNotifications ??= {
                        hasBooted: false,
                        seenIds: new Set(),
                        subscribedChannels: new Set(),
                    }

                    const currentNotifications = @js($notificationAlerts)

                    if (! vesperDatabaseNotifications.hasBooted) {
                        currentNotifications.forEach((notification) => {
                            vesperDatabaseNotifications.seenIds.add(notification.id)
                        })

                        vesperDatabaseNotifications.hasBooted = true
                    } else {
                        currentNotifications
                            .filter((notification) => notification.unread && ! vesperDatabaseNotifications.seenIds.has(notification.id))
                            .reverse()
                            .forEach((notification) => {
                                vesperDatabaseNotifications.seenIds.add(notification.id)

                                if (window.FilamentNotification) {
                                    const toast = new window.FilamentNotification()
                                        .title(notification.title ?? 'New notification')

                                    if (notification.body) {
                                        toast.body(notification.body)
                                    }

                                    if (notification.icon) {
                                        toast.icon(notification.icon)
                                    }

                                    if (notification.iconColor) {
                                        toast.iconColor(notification.iconColor)
                                    }

                                    if (typeof toast[notification.status] === 'function') {
                                        toast[notification.status]()
                                    } else {
                                        toast.info()
                                    }

                                    toast.send()

                                    return
                                }

                                window.alert([notification.title, notification.body].filter(Boolean).join('\n\n'))
                            })

                        currentNotifications.forEach((notification) => {
                            vesperDatabaseNotifications.seenIds.add(notification.id)
                        })
                    }
                })()
            </script>
        @endscript

        <div class="vs-topbar-notifications-panel dropdown-panel notif-panel">
            <div class="vs-topbar-notifications-header notif-header">
                <div class="vs-topbar-notifications-title-row">
                    <span class="vs-topbar-notifications-title notif-title">
                        {{ __('filament-notifications::database.modal.heading') }}
                    </span>

                    @if ($unreadNotificationsCount)
                        <span class="vs-topbar-notifications-count">
                            {{ $unreadNotificationsCount }}
                        </span>
                    @endif
                </div>

                @if ($hasNotifications)
                    <div class="vs-topbar-notifications-header-actions">
                        @if ($unreadNotificationsCount && $this->markAllNotificationsAsReadAction?->isVisible())
                            {{ $this->markAllNotificationsAsReadAction }}
                        @endif

                        @if ($this->clearNotificationsAction?->isVisible())
                            {{ $this->clearNotificationsAction }}
                        @endif
                    </div>
                @endif
            </div>

            @if ($hasNotifications)
                <div class="vs-topbar-notifications-list notif-list">
                    @foreach ($notifications as $notification)
                        <div
                            @class([
                                'fi-no-notification-read-ctn notif-item',
                                'fi-no-notification-unread-ctn notif-item unread' => $notification->unread(),
                            ])
                        >
                            {{ $this->getNotification($notification)->inline() }}
                        </div>
                    @endforeach
                </div>

                @if ($broadcastChannel = $this->getBroadcastChannel())
                    @script
                        <script>
                            ;(() => {
                                const vesperDatabaseNotifications = window.vesperDatabaseNotifications ??= {
                                    hasBooted: false,
                                    seenIds: new Set(),
                                    subscribedChannels: new Set(),
                                }

                                const broadcastChannel = @js($broadcastChannel)

                                if (! vesperDatabaseNotifications.subscribedChannels.has(broadcastChannel)) {
                                    window.addEventListener('EchoLoaded', () => {
                                        window.Echo.private(broadcastChannel).listen(
                                            '.database-notifications.sent',
                                            () => {
                                                setTimeout(
                                                    () => $wire.call('$refresh'),
                                                    500,
                                                )
                                            },
                                        )
                                    })

                                    vesperDatabaseNotifications.subscribedChannels.add(broadcastChannel)
                                }

                                if (window.Echo) {
                                    window.dispatchEvent(new CustomEvent('EchoLoaded'))
                                }
                            })()
                        </script>
                    @endscript
                @endif

                @if ($isPaginated)
                    <div class="vs-topbar-notifications-footer notif-footer">
                        <x-filament::pagination :paginator="$notifications" />
                    </div>
                @endif
            @else
                <div class="vs-topbar-notifications-empty">
                    <div class="vs-topbar-notifications-empty-icon" aria-hidden="true">
                        {{ \Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::OutlinedBellSlash) }}
                    </div>

                    <div class="vs-topbar-notifications-empty-heading">
                        {{ __('filament-notifications::database.modal.empty.heading') }}
                    </div>

                    <div class="vs-topbar-notifications-empty-description">
                        {{ __('filament-notifications::database.modal.empty.description') }}
                    </div>
                </div>
            @endif
        </div>
    </x-filament::dropdown>
</div>
