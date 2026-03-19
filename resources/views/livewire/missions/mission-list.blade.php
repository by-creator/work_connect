<div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Missions disponibles</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Trouvez la mission qui correspond à vos compétences</p>
            </div>
            @if(auth()->user()->isClient())
                <a href="{{ route('missions.create') }}" wire:navigate
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Publier une mission
                </a>
            @endif
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="grid md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                        <input wire:model.live="search" type="text" placeholder="Rechercher une mission..."
                               class="w-full pl-10 pr-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>

                <!-- Category -->
                <select wire:model.live="categoryFilter"
                        class="px-3 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Toutes catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <!-- Duration -->
                <select wire:model.live="durationFilter"
                        class="px-3 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Toutes durées</option>
                    <option value="short">Court terme</option>
                    <option value="medium">Moyen terme</option>
                    <option value="long">Long terme</option>
                </select>
            </div>
        </div>

        <!-- Mission Grid -->
        @if($missions->isEmpty())
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-16 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="font-medium text-zinc-700 dark:text-zinc-300">Aucune mission trouvée</p>
                <p class="text-sm text-zinc-500 mt-1">Essayez de modifier vos filtres de recherche</p>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($missions as $mission)
                <a href="{{ route('missions.show', $mission) }}" wire:navigate
                   class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5 hover:border-blue-300 hover:shadow-md transition-all block group">
                    <div class="flex items-start justify-between mb-3">
                        @if($mission->category)
                            <span class="px-2.5 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-medium rounded-full">
                                {{ $mission->category->name }}
                            </span>
                        @else
                            <span class="px-2.5 py-1 bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300 text-xs rounded-full">
                                Non catégorisé
                            </span>
                        @endif
                        <span class="text-xs text-zinc-400">{{ $mission->created_at->diffForHumans() }}</span>
                    </div>

                    <h3 class="font-semibold text-zinc-900 dark:text-white group-hover:text-blue-600 transition-colors mb-2 line-clamp-2">
                        {{ $mission->title }}
                    </h3>

                    <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2 mb-4">
                        {{ $mission->description }}
                    </p>

                    @if($mission->skills_required)
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @foreach(array_slice($mission->skills_required, 0, 3) as $skill)
                                <span class="px-2 py-0.5 bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300 text-xs rounded">{{ $skill }}</span>
                            @endforeach
                            @if(count($mission->skills_required) > 3)
                                <span class="text-xs text-zinc-400">+{{ count($mission->skills_required) - 3 }}</span>
                            @endif
                        </div>
                    @endif

                    <div class="flex items-center justify-between pt-3 border-t border-zinc-100 dark:border-zinc-700">
                        <div>
                            <div class="font-bold text-green-600 text-lg">{{ number_format($mission->budget, 0, ',', ' ') }} FCFA</div>
                            @if($mission->deadline)
                                <div class="text-xs text-zinc-400 mt-0.5">Deadline: {{ $mission->deadline->format('d/m/Y') }}</div>
                            @endif
                        </div>
                        <div class="flex items-center gap-1 text-sm text-zinc-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            {{ $mission->applications->count() }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div>{{ $missions->links() }}</div>
        @endif
</div>
