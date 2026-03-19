<?php

use App\Livewire\Dashboard;
use App\Livewire\Missions\CreateMission;
use App\Livewire\Missions\MissionList;
use App\Livewire\Missions\ShowMission;
use App\Models\Mission;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    // Missions
    Route::get('missions', MissionList::class)->name('missions.index');
    Route::get('missions/create', CreateMission::class)->name('missions.create');
    Route::get('missions/mes-missions', function () {
        $missions = Mission::where('client_id', auth()->id())
            ->with(['applications', 'category'])
            ->latest()
            ->paginate(15);
        return view('missions.my-missions', compact('missions'));
    })->name('missions.my');
    Route::get('missions/{mission}', ShowMission::class)->name('missions.show');
});

require __DIR__.'/settings.php';
