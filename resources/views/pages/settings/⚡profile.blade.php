<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Paramètres du profil')] class extends Component {
    use ProfileValidationRules;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $location = '';
    public string $bio = '';
    public string $skills_input = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->location = $user->location ?? '';
        $this->bio = $user->bio ?? '';
        $this->skills_input = is_array($user->skills) ? implode(', ', $user->skills) : ($user->skills ?? '');
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            ...$this->profileRules($user->id),
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'skills_input' => ['nullable', 'string'],
        ]);

        $skills = array_filter(array_map('trim', explode(',', $this->skills_input)));

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'location' => $validated['location'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'skills' => $skills ?: null,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Paramètres du profil') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Profil')" :subheading="__('Mettez à jour vos informations personnelles')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <!-- Rôle (lecture seule) -->
            <div class="flex items-center gap-2 px-4 py-3 bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg">
                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Type de compte :</span>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ Auth::user()->isClient() ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                    {{ Auth::user()->roleLabel() }}
                </span>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <flux:input wire:model="name" :label="__('Nom complet')" type="text" required autofocus autocomplete="name" />
                <flux:input wire:model="phone" :label="__('Téléphone')" type="tel" autocomplete="tel" placeholder="+221 77 000 00 00" />
            </div>

            <div>
                <flux:input wire:model="email" :label="__('Adresse email')" type="email" required autocomplete="email" />

                @if ($this->hasUnverifiedEmail)
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Votre adresse email n\'est pas vérifiée.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Renvoyer l\'email de vérification.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('Un nouveau lien de vérification a été envoyé.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <flux:input wire:model="location" :label="__('Localisation')" type="text" placeholder="Ex: Dakar, Sénégal" />

            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Bio</label>
                <textarea wire:model="bio" rows="3" placeholder="Décrivez votre expérience et vos spécialités..."
                          class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
            </div>

            @if(Auth::user()->isFreelance())
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Compétences</label>
                <input wire:model="skills_input" type="text" placeholder="Ex: Laravel, Vue.js, MySQL (séparées par des virgules)"
                       class="w-full px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-zinc-50 dark:bg-zinc-700 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <p class="mt-1 text-xs text-zinc-400">Séparez les compétences par des virgules</p>
            </div>
            @endif

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full" data-test="update-profile-button">
                        {{ __('Enregistrer') }}
                    </flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Profil mis à jour.') }}
                </x-action-message>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:pages::settings.delete-user-form />
        @endif
    </x-pages::settings.layout>
</section>
