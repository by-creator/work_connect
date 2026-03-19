<x-layouts::app :title="$mission->title">
    <div class="max-w-5xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl text-green-700 dark:text-green-300 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-300 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Mission Details -->
            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-2">
                            @if($mission->category)
                                <span class="px-2.5 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-medium rounded-full">
                                    {{ $mission->category->name }}
                                </span>
                            @endif
                            @php
                                $statusColors = ['open' => 'bg-blue-100 text-blue-700', 'in_progress' => 'bg-orange-100 text-orange-700', 'completed' => 'bg-green-100 text-green-700'];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$mission->status] ?? 'bg-zinc-100 text-zinc-700' }}">
                                {{ $mission->statusLabel() }}
                            </span>
                        </div>
                        <span class="text-xs text-zinc-400">{{ $mission->created_at->diffForHumans() }}</span>
                    </div>

                    <h1 class="text-xl font-bold text-zinc-900 dark:text-white mb-4">{{ $mission->title }}</h1>

                    <div class="prose prose-sm dark:prose-invert max-w-none text-zinc-700 dark:text-zinc-300">
                        {!! nl2br(e($mission->description)) !!}
                    </div>

                    @if($mission->skills_required && count($mission->skills_required))
                        <div class="mt-5 pt-5 border-t border-zinc-100 dark:border-zinc-700">
                            <h3 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">Compétences requises</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($mission->skills_required as $skill)
                                    <span class="px-3 py-1 bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-sm rounded-lg">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Applications (for client) -->
                @if(auth()->id() === $mission->client_id && $mission->applications->count() > 0)
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                    <div class="p-5 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="font-semibold text-zinc-900 dark:text-white">
                            Candidatures ({{ $mission->applications->count() }})
                        </h2>
                    </div>
                    <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($mission->applications as $application)
                        <div class="p-5">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-zinc-200 dark:bg-zinc-600 rounded-full flex items-center justify-center font-semibold text-zinc-700 dark:text-white text-sm">
                                        {{ $application->freelance->initials() }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-zinc-900 dark:text-white">{{ $application->freelance->name }}</div>
                                        <div class="text-xs text-zinc-500">{{ $application->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-green-600">{{ number_format($application->proposed_price, 0, ',', ' ') }} FCFA</div>
                                    @if($application->estimated_days)
                                        <div class="text-xs text-zinc-500">{{ $application->estimated_days }} jour(s)</div>
                                    @endif
                                </div>
                            </div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3">{{ $application->cover_letter }}</p>
                            @if($mission->status === 'open' && $application->status === 'pending')
                                <flux:button wire:click="acceptApplication({{ $application->id }})" variant="primary" size="sm">
                                    Accepter cette candidature
                                </flux:button>
                            @elseif($application->status === 'accepted')
                                <span class="text-sm font-medium text-green-600">✓ Candidature acceptée</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Apply Form (for freelance) -->
                @auth
                @if(auth()->user()->isFreelance() && $mission->status === 'open')
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
                    @if($hasApplied)
                        <div class="flex items-center gap-3 text-green-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="font-medium">Vous avez déjà postulé à cette mission</span>
                        </div>
                    @elseif(!$showApplyForm)
                        <flux:button wire:click="$set('showApplyForm', true)" variant="primary" class="w-full">
                            Postuler à cette mission
                        </flux:button>
                    @else
                        <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Votre candidature</h3>
                        <form wire:submit="apply" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                                    Lettre de motivation <span class="text-red-500">*</span>
                                </label>
                                <textarea wire:model="cover_letter" rows="4"
                                          placeholder="Expliquez pourquoi vous êtes le meilleur candidat pour cette mission..."
                                          class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                                @error('cover_letter') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                                        Prix proposé (FCFA) <span class="text-red-500">*</span>
                                    </label>
                                    <input wire:model="proposed_price" type="number" min="1000"
                                           placeholder="Ex: 100000"
                                           class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    @error('proposed_price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                                        Délai estimé (jours)
                                    </label>
                                    <input wire:model="estimated_days" type="number" min="1"
                                           placeholder="Ex: 14"
                                           class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <flux:button type="submit" variant="primary">Envoyer ma candidature</flux:button>
                                <flux:button wire:click="$set('showApplyForm', false)" variant="ghost">Annuler</flux:button>
                            </div>
                        </form>
                    @endif
                </div>
                @endif
                @endauth
            </div>

            <!-- Sidebar -->
            <div class="space-y-5">
                <!-- Mission Info -->
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                    <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Détails de la mission</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500">Budget</span>
                            <span class="font-bold text-green-600">{{ number_format($mission->budget, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @if($mission->deadline)
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500">Deadline</span>
                            <span class="font-medium text-zinc-900 dark:text-white">{{ $mission->deadline->format('d/m/Y') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500">Durée</span>
                            <span class="font-medium text-zinc-900 dark:text-white">
                                {{ match($mission->duration) { 'short' => 'Court terme', 'medium' => 'Moyen terme', 'long' => 'Long terme', default => $mission->duration } }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500">Candidatures</span>
                            <span class="font-medium text-zinc-900 dark:text-white">{{ $mission->applications->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Client Info -->
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                    <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">À propos du client</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center font-semibold text-blue-600 text-sm">
                            {{ $mission->client->initials() }}
                        </div>
                        <div>
                            <div class="font-medium text-zinc-900 dark:text-white">{{ $mission->client->name }}</div>
                            @if($mission->client->location)
                                <div class="text-xs text-zinc-500">{{ $mission->client->location }}</div>
                            @endif
                        </div>
                    </div>
                    @if($mission->client->rating > 0)
                        <div class="mt-3 flex items-center gap-1 text-sm text-zinc-600 dark:text-zinc-400">
                            <span class="text-yellow-500">★</span>
                            <span>{{ number_format($mission->client->rating, 1) }}</span>
                            <span class="text-zinc-400">({{ $mission->client->reviewsReceived->count() }} avis)</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
