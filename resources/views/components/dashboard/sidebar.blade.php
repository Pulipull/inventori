@props(['user'])

@php
    $role = trim((string) $user->role);
    $isBuyer = $role === 'user';
    $isAdmin = $role === 'admin';
    $isSuperAdmin = $role === 'super_admin';
    $canOperate = $isAdmin || $isSuperAdmin;

    $link = fn(string $label, ?string $route = null, array $params = [], ?string $url = null) => [
        'label' => $label,
        'route' => $route,
        'params' => $params,
        'url' => $url,
    ];

    $groups = [
        'Dashboard' => [
            $link('Dashboard', 'dashboard'),
        ],
    ];

    if ($isBuyer) {
        $groups['Buyer'] = [
            $link('Checkout', 'checkout.index'),
            $link('Order History', null, [], route('dashboard').'#order-history'),
            $link('Tracking', 'tracking.index'),
            $link('Profile'),
            $link('Notifications', 'notification-preferences.edit'),
            $link('Feedback', 'feedback.index'),
        ];
    }

    if ($canOperate) {
        $groups['Inventory'] = [
            $link('Inventory', 'items.index'),
            $link('Categories', 'categories.index'),
            $link('Transactions', 'transactions.index'),
        ];

        $groups['CRM'] = [
            $link('CRM', 'customers.index'),
            $link('Feedback Management', 'crm.feedback.index'),
        ];

        $groups['Reporting'] = [
            $link('Stock Report', 'reports.stock'),
            $link('Sales Report', 'reports.sales'),
            $link('Payment Report', 'reports.payments'),
            $link('Revenue Report', 'reports.revenue'),
        ];

        $groups['Communication'] = [
            $link('Notifications', 'notifications.index'),
            $link('Chat', 'chat.index'),
        ];
    }

    if ($isSuperAdmin) {
        $groups['System'] = [
            $link('User Management', 'admin.users.index'),
            $link('Storage', 'storage.files'),
            $link('System Center', 'system.index'),
            $link('Report Export', 'reports.exports.index'),
            $link('Settings', 'settings.index'),
        ];
    }
@endphp

<aside class="flex flex-col border-b border-gray-200/70 bg-white lg:sticky lg:top-0 lg:h-screen lg:w-72 lg:shrink-0 lg:overflow-hidden lg:border-b-0 lg:border-r">
    <div class="shrink-0 px-5 py-6">
        <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-4">
            <img src="{{ asset('brand/nexstock-logo.svg') }}" alt="NexStock" class="h-14 w-14 shrink-0 rounded-2xl object-cover shadow-lg shadow-blue-950/10">
            <span class="min-w-0">
                <span class="block truncate text-lg font-semibold tracking-normal text-slate-950">NexStock</span>
                <span class="block text-xs font-medium text-slate-500">Enterprise Inventory Platform</span>
            </span>
        </a>
        <span class="mt-4 inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold uppercase tracking-normal text-blue-700">
            {{ str_replace('_', ' ', $role) }}
        </span>
    </div>

    <nav class="flex gap-4 overflow-x-auto px-4 pb-4 text-sm lg:min-h-0 lg:flex-1 lg:grid lg:gap-5 lg:overflow-y-auto lg:overflow-x-hidden lg:px-4 lg:pb-6 lg:pr-3">
        @foreach ($groups as $group => $links)
            <div class="min-w-44 lg:min-w-0">
                <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-normal text-slate-400">{{ $group }}</p>
                <div class="grid gap-1">
                    @foreach ($links as $item)
                        @php
                            $routeDefinition = $item['route'] ? \Illuminate\Support\Facades\Route::getRoutes()->getByName($item['route']) : null;
                            $routeIsNavigable = $routeDefinition && in_array('GET', $routeDefinition->methods(), true);
                            $href = $item['url'] ?? ($routeIsNavigable ? route($item['route'], $item['params']) : null);
                            $active = $routeIsNavigable ? request()->routeIs($item['route'], $item['route'].'.*') : false;
                        @endphp

                        @if ($href)
                            <a
                                href="{{ $href }}"
                                class="rounded-2xl px-3 py-2.5 font-medium transition {{ $active ? 'bg-blue-50 text-blue-700 shadow-sm shadow-blue-100/60' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' }}"
                            >
                                {{ $item['label'] }}
                            </a>
                        @else
                            <span class="cursor-not-allowed rounded-2xl px-3 py-2.5 font-medium text-slate-400">
                                {{ $item['label'] }}
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    <form method="post" action="{{ route('logout') }}" class="shrink-0 border-t border-gray-100 px-5 py-5">
        @csrf
        <button type="submit" class="w-full rounded-2xl bg-slate-950 px-4 py-3 text-left text-sm font-semibold text-white shadow-lg shadow-slate-200 transition hover:bg-blue-700">
            Keluar
        </button>
    </form>
</aside>
