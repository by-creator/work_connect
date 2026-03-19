<x-layouts::app :title="__('Tableau de bord')">
    <div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">
                    Bonjour, {{ auth()->user()->name }} 👋
                </h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Trouvez des missions et développez votre activité freelance</p>
            </div>
            <a href="{{ route('missions.index') }}" wire:navigate
               class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                Parcourir les missions
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                <div class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stats['applications_sent'] }}</div>
                <div class="text-sm text-zinc-500 mt-1">Candidatures envoyées</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                <div class="text-2xl font-bold text-green-600">{{ $stats['applications_accepted'] }}</div>
                <div class="text-sm text-zinc-500 mt-1">Acceptées</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                <div class="text-2xl font-bold text-orange-500">{{ $stats['missions_in_progress'] }}</div>
                <div class="text-sm text-zinc-500 mt-1">En cours</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                <div class="text-2xl font-bold text-blue-600">{{ $stats['missions_completed'] }}</div>
                <div class="text-sm text-zinc-500 mt-1">Terminées</div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Mes candidatures récentes -->
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                <div class="p-5 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Mes candidatures récentes</h2>
                </div>
                @if($recentApplications->isEmpty())
                    <div class="p-8 text-center text-zinc-500 text-sm">
                        Vous n'avez pas encore postulé à des missions.
                    </div>
                @else
                    <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($recentApplications as $application)
                        <div class="p-4">
                            <a href="{{ route('missions.show', $application->mission) }}" wire:navigate
                               class="font-medium text-zinc-900 dark:text-white hover:text-blue-600 text-sm block truncate">
                                {{ $application->mission->title }}
                            </a>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-xs text-zinc-500">
                                    {{ number_format($application->proposed_price, 0, ',', ' ') }} FCFA proposé
                                </span>
                                @php
                                    $statusColors = ['pending' => 'bg-yellow-100 text-yellow-700', 'accepted' => 'bg-green-100 text-green-700', 'rejected' => 'bg-red-100 text-red-700'];
                                @endphp
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$application->status] ?? '' }}">
                                    {{ $application->statusLabel() }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Missions ouvertes récentes -->
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between p-5 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Nouvelles missions</h2>
                    <a href="{{ route('missions.index') }}" wire:navigate class="text-sm text-blue-600 hover:underline">Voir tout</a>
                </div>
                @if($openMissions->isEmpty())
                    <div class="p-8 text-center text-zinc-500 text-sm">
                        Aucune mission ouverte pour le moment.
                    </div>
                @else
                    <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($openMissions as $mission)
                        <div class="p-4">
                            <a href="{{ route('missions.show', $mission) }}" wire:navigate
                               class="font-medium text-zinc-900 dark:text-white hover:text-blue-600 text-sm block truncate">
                                {{ $mission->title }}
                            </a>
                            <div class="flex items-center gap-2 mt-1 text-xs text-zinc-500">
                                <span class="font-medium text-green-600">{{ number_format($mission->budget, 0, ',', ' ') }} FCFA</span>
                                @if($mission->category)
                                    <span>•</span>
                                    <span>{{ $mission->category->name }}</span>
                                @endif
                                <span>•</span>
                                <span>{{ $mission->applications->count() }} candidats</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Profile completeness hint -->
        @if(!auth()->user()->bio || !auth()->user()->skills)
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-5">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <p class="text-sm font-medium text-blue-900 dark:text-blue-100">Complétez votre profil pour plus de visibilité</p>
                    <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">Ajoutez votre bio et vos compétences pour attirer plus de clients.</p>
                    <a href="{{ route('profile.edit') }}" wire:navigate class="inline-block mt-2 text-sm font-medium text-blue-600 hover:underline">
                        Compléter mon profil →
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-layouts::app>
