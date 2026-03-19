<x-layouts::app :title="__('Mes missions')">
    <div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Mes missions</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Gérez toutes vos missions publiées</p>
            </div>
            <a href="{{ route('missions.create') }}" wire:navigate
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Publier une mission
            </a>
        </div>

        @if($missions->isEmpty())
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-16 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="font-medium text-zinc-700 dark:text-zinc-300">Aucune mission publiée</p>
                <p class="text-sm text-zinc-500 mt-1">Publiez votre première mission pour trouver un freelance</p>
            </div>
        @else
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($missions as $mission)
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
                                <span>•</span>
                                <span>{{ $mission->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            @php
                                $statusColors = ['open' => 'bg-blue-100 text-blue-700', 'in_progress' => 'bg-orange-100 text-orange-700', 'completed' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700', 'disputed' => 'bg-yellow-100 text-yellow-700'];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$mission->status] ?? 'bg-zinc-100 text-zinc-700' }}">
                                {{ $mission->statusLabel() }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div>{{ $missions->links() }}</div>
        @endif
    </div>
</x-layouts::app>
