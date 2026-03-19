<div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">
                    Bonjour, {{ auth()->user()->name }} 👋
                </h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Gérez vos missions et recrutez les meilleurs freelances</p>
            </div>
            <a href="{{ route('missions.create') }}" wire:navigate
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Publier une mission
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                <div class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stats['missions_posted'] }}</div>
                <div class="text-sm text-zinc-500 mt-1">Missions publiées</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                <div class="text-2xl font-bold text-blue-600">{{ $stats['missions_open'] }}</div>
                <div class="text-sm text-zinc-500 mt-1">En attente</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                <div class="text-2xl font-bold text-orange-500">{{ $stats['missions_in_progress'] }}</div>
                <div class="text-sm text-zinc-500 mt-1">En cours</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                <div class="text-2xl font-bold text-green-600">{{ $stats['missions_completed'] }}</div>
                <div class="text-sm text-zinc-500 mt-1">Terminées</div>
            </div>
        </div>

        <!-- Recent Missions -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="flex items-center justify-between p-5 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Mes dernières missions</h2>
                <a href="{{ route('missions.my') }}" wire:navigate class="text-sm text-blue-600 hover:underline">Voir tout</a>
            </div>
            @if($recentMissions->isEmpty())
                <div class="p-10 text-center text-zinc-500 dark:text-zinc-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="font-medium">Aucune mission publiée</p>
                    <p class="text-sm mt-1">Commencez par publier votre première mission</p>
                </div>
            @else
                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($recentMissions as $mission)
                    <div class="p-5 flex items-center justify-between hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('missions.show', $mission) }}" wire:navigate
                               class="font-medium text-zinc-900 dark:text-white hover:text-blue-600 truncate block">
                                {{ $mission->title }}
                            </a>
                            <div class="flex items-center gap-3 mt-1 text-sm text-zinc-500">
                                <span>{{ number_format($mission->budget, 0, ',', ' ') }} FCFA</span>
                                <span>•</span>
                                <span>{{ $mission->applications->count() }} candidature(s)</span>
                                @if($mission->category)
                                    <span>•</span>
                                    <span>{{ $mission->category->name }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="ml-4">
                            @php
                                $statusColors = ['open' => 'bg-blue-100 text-blue-700', 'in_progress' => 'bg-orange-100 text-orange-700', 'completed' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700'];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$mission->status] ?? 'bg-zinc-100 text-zinc-700' }}">
                                {{ $mission->statusLabel() }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
</div>
