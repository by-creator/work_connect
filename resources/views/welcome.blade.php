<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    @include('partials.head')
    <style>
        .gradient-hero {
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 40%, #0ea5e9 100%);
        }
    </style>
</head>
<body class="bg-white dark:bg-zinc-900 font-sans antialiased">

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white/95 dark:bg-zinc-900/95 backdrop-blur border-b border-zinc-200 dark:border-zinc-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="flex aspect-square size-8 items-center justify-center rounded-md bg-blue-600">
                        <span class="text-xs font-bold text-white">WC</span>
                    </div>
                    <span class="font-bold text-lg text-zinc-900 dark:text-white">WorkConnect</span>
                </div>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="#comment-ca-marche" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-blue-600 transition-colors">Comment ça marche</a>
                    <a href="#categories" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-blue-600 transition-colors">Catégories</a>
                    <a href="#tarifs" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-blue-600 transition-colors">Tarifs</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-600 transition-colors">
                                Tableau de bord
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-600 transition-colors">
                                Connexion
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    S'inscrire gratuitement
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-hero py-20 px-4">
        <div class="max-w-5xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 text-white text-sm px-4 py-1.5 rounded-full mb-6">
                <span class="size-2 bg-green-400 rounded-full"></span>
                Plateforme 100% sécurisée — Paiement escrow intégré
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight mb-6">
                Trouvez un freelance<br class="hidden md:block">
                <span class="text-sky-300">rapidement au Sénégal</span>
            </h1>
            <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
                Connectez entreprises et freelances pour des missions à distance. Travaillez en toute confiance grâce au paiement sécurisé.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
                        Accéder au tableau de bord
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Publier une mission
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-blue-500/30 text-white font-semibold rounded-xl border border-white/30 hover:bg-blue-500/50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                        Trouver un travail
                    </a>
                @endauth
            </div>

            <!-- Stats -->
            <div class="mt-16 grid grid-cols-3 gap-8 max-w-lg mx-auto">
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">500+</div>
                    <div class="text-sm text-blue-200 mt-1">Freelances</div>
                </div>
                <div class="text-center border-x border-white/20">
                    <div class="text-3xl font-bold text-white">200+</div>
                    <div class="text-sm text-blue-200 mt-1">Missions postées</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">95%</div>
                    <div class="text-sm text-blue-200 mt-1">Satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comment ça marche -->
    <section id="comment-ca-marche" class="py-20 px-4 bg-zinc-50 dark:bg-zinc-800">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-3">Comment ça marche ?</h2>
                <p class="text-zinc-500 dark:text-zinc-400">Simple, rapide et sécurisé</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Pour les clients -->
                <div class="bg-white dark:bg-zinc-900 rounded-2xl p-8 shadow-sm border border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Pour les clients</h3>
                    </div>
                    <div class="space-y-4">
                        @foreach ([
                            ['1', 'Créez votre compte', 'Inscription rapide, vérification identité sécurisée'],
                            ['2', 'Publiez votre mission', 'Décrivez le projet, budget, deadline et compétences requises'],
                            ['3', 'Choisissez votre freelance', 'Recevez les candidatures et sélectionnez le meilleur profil'],
                            ['4', 'Paiement sécurisé', 'Payez via escrow, les fonds sont libérés à la validation'],
                        ] as [$num, $title, $desc])
                        <div class="flex gap-4">
                            <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex-shrink-0 flex items-center justify-center text-sm font-bold">{{ $num }}</div>
                            <div>
                                <div class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $title }}</div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $desc }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pour les freelances -->
                <div class="bg-white dark:bg-zinc-900 rounded-2xl p-8 shadow-sm border border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Pour les freelances</h3>
                    </div>
                    <div class="space-y-4">
                        @foreach ([
                            ['1', 'Créez votre profil', 'Ajoutez vos compétences, portfolio et tarifs'],
                            ['2', 'Parcourez les offres', 'Trouvez des missions qui correspondent à votre expertise'],
                            ['3', 'Postulez facilement', 'Envoyez votre candidature avec proposition de prix'],
                            ['4', 'Recevez vos paiements', 'Paiement garanti via Orange Money, Wave ou carte bancaire'],
                        ] as [$num, $title, $desc])
                        <div class="flex gap-4">
                            <div class="w-8 h-8 bg-green-600 text-white rounded-full flex-shrink-0 flex items-center justify-center text-sm font-bold">{{ $num }}</div>
                            <div>
                                <div class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $title }}</div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $desc }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Catégories -->
    <section id="categories" class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-3">Catégories populaires</h2>
                <p class="text-zinc-500 dark:text-zinc-400">Des compétences adaptées à tous vos besoins</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ([
                    ['💻', 'Développement web', '120+ missions'],
                    ['🎨', 'Design & Graphisme', '85+ missions'],
                    ['✍️', 'Rédaction', '60+ missions'],
                    ['📱', 'Marketing Digital', '45+ missions'],
                    ['🎬', 'Vidéo & Animation', '30+ missions'],
                    ['📊', 'Comptabilité', '25+ missions'],
                    ['🔧', 'IT & Systèmes', '40+ missions'],
                    ['📞', 'Service client', '35+ missions'],
                ] as [$icon, $name, $count])
                <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5 hover:border-blue-300 hover:shadow-md transition-all cursor-pointer group">
                    <div class="text-2xl mb-2">{{ $icon }}</div>
                    <div class="font-semibold text-zinc-800 dark:text-zinc-200 text-sm group-hover:text-blue-600 transition-colors">{{ $name }}</div>
                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ $count }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sécurité & Paiement -->
    <section class="py-20 px-4 bg-zinc-50 dark:bg-zinc-800">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-3">Sécurité & Confiance</h2>
                <p class="text-zinc-500 dark:text-zinc-400">Votre argent est protégé à chaque étape</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="font-bold text-zinc-900 dark:text-white mb-2">Paiement Escrow</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Les fonds sont bloqués sur la plateforme jusqu'à la validation du travail. Zéro risque pour les deux parties.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-bold text-zinc-900 dark:text-white mb-2">Identités Vérifiées</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Chaque utilisateur est vérifié par OTP. Travaillez uniquement avec des profils authentiques.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <h3 class="font-bold text-zinc-900 dark:text-white mb-2">Médiation Intégrée</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">En cas de litige, notre équipe intervient rapidement pour analyser les preuves et trouver une solution équitable.</p>
                </div>
            </div>

            <!-- Moyens de paiement -->
            <div class="mt-12 bg-white dark:bg-zinc-900 rounded-2xl p-8 border border-zinc-200 dark:border-zinc-700">
                <h3 class="text-center font-bold text-zinc-900 dark:text-white mb-6">Moyens de paiement acceptés</h3>
                <div class="flex flex-wrap justify-center gap-4">
                    @foreach (['Orange Money', 'Wave', 'Free Money', 'Carte bancaire', 'Virement bancaire'] as $method)
                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-600 rounded-xl text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        {{ $method }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Tarifs / Commission -->
    <section id="tarifs" class="py-20 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-3">Tarification transparente</h2>
                <p class="text-zinc-500 dark:text-zinc-400">Commencez gratuitement, payez uniquement quand vous réussissez</p>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-8 shadow-sm">
                    <h3 class="font-bold text-xl text-zinc-900 dark:text-white mb-2">Pour les clients</h3>
                    <div class="text-4xl font-bold text-blue-600 mb-1">Gratuit</div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">pour publier des missions</p>
                    <ul class="space-y-3">
                        @foreach (['Publication d\'offres illimitée', 'Réception de candidatures', 'Messagerie intégrée', '5-15% de commission par projet', 'Paiement sécurisé escrow'] as $item)
                        <li class="flex items-center gap-3 text-sm text-zinc-700 dark:text-zinc-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-blue-600 rounded-2xl p-8 shadow-lg">
                    <h3 class="font-bold text-xl text-white mb-2">Pour les freelances</h3>
                    <div class="text-4xl font-bold text-white mb-1">Gratuit</div>
                    <p class="text-sm text-blue-200 mb-6">pour créer votre profil</p>
                    <ul class="space-y-3">
                        @foreach (['Profil avec portfolio', 'Candidature aux offres', 'Messagerie avec les clients', '5-15% de commission par projet', 'Paiement garanti via escrow'] as $item)
                        <li class="flex items-center gap-3 text-sm text-white">
                            <svg class="w-5 h-5 text-blue-200 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="gradient-hero py-20 px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Prêt à rejoindre WorkConnect ?</h2>
            <p class="text-blue-100 text-lg mb-8">Connectez le talent aux opportunités. Travaillez sans frontières.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
                    Accéder à mon espace
                </a>
            @else
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
                    Créer mon compte gratuitement
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-zinc-900 text-zinc-400 py-10 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="flex aspect-square size-7 items-center justify-center rounded bg-blue-600">
                        <span class="text-xs font-bold text-white">WC</span>
                    </div>
                    <span class="font-semibold text-white">WorkConnect</span>
                    <span class="text-sm">— Le freelance sécurisé au Sénégal</span>
                </div>
                <p class="text-sm">© {{ date('Y') }} WorkConnect Sénégal. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

</body>
</html>
