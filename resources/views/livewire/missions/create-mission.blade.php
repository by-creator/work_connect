<x-layouts::app :title="__('Publier une mission')">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Publier une mission</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Décrivez votre besoin pour attirer les meilleurs freelances</p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl text-green-700 dark:text-green-300 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit="save" class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 space-y-6">

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                    Titre de la mission <span class="text-red-500">*</span>
                </label>
                <input wire:model="title" type="text" placeholder="Ex: Développer un site e-commerce en Laravel"
                       class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <!-- Category & Duration -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Catégorie</label>
                    <select wire:model="category_id"
                            class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Choisir une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Durée estimée <span class="text-red-500">*</span></label>
                    <select wire:model="duration"
                            class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="short">Court terme (moins de 1 mois)</option>
                        <option value="medium">Moyen terme (1 à 3 mois)</option>
                        <option value="long">Long terme (plus de 3 mois)</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                    Description de la mission <span class="text-red-500">*</span>
                </label>
                <textarea wire:model="description" rows="6"
                          placeholder="Décrivez en détail votre besoin, les livrables attendus, le contexte du projet..."
                          class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <!-- Budget & Deadline -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                        Budget (FCFA) <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="budget" type="number" min="1000" placeholder="Ex: 150000"
                           class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('budget') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Date limite</label>
                    <input wire:model="deadline" type="date" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('deadline') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Skills -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                    Compétences requises
                </label>
                <input wire:model="skills_input" type="text"
                       placeholder="Ex: Laravel, Vue.js, MySQL (séparées par des virgules)"
                       class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <p class="mt-1 text-xs text-zinc-400">Séparez les compétences par des virgules</p>
            </div>

            <!-- Attachment -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">
                    Fichier joint (optionnel)
                </label>
                <input wire:model="attachment" type="file" accept=".pdf,.doc,.docx,.zip"
                       class="w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400" />
                <p class="mt-1 text-xs text-zinc-400">PDF, DOC, DOCX ou ZIP — Max 10MB</p>
                @error('attachment') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-4 pt-2">
                <flux:button type="submit" variant="primary" class="px-8">
                    <span wire:loading.remove wire:target="save">Publier la mission</span>
                    <span wire:loading wire:target="save">Publication...</span>
                </flux:button>
                <a href="{{ route('dashboard') }}" wire:navigate class="text-sm text-zinc-500 hover:text-zinc-700">Annuler</a>
            </div>
        </form>
    </div>
</x-layouts::app>
