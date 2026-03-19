<?php

namespace App\Livewire;

use App\Models\Application;
use App\Models\Mission;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Tableau de bord')]

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();

        if ($user->isClient()) {
            $stats = [
                'missions_posted' => Mission::where('client_id', $user->id)->count(),
                'missions_open' => Mission::where('client_id', $user->id)->where('status', 'open')->count(),
                'missions_in_progress' => Mission::where('client_id', $user->id)->where('status', 'in_progress')->count(),
                'missions_completed' => Mission::where('client_id', $user->id)->where('status', 'completed')->count(),
            ];
            $recentMissions = Mission::where('client_id', $user->id)
                ->with(['applications', 'category'])
                ->latest()
                ->limit(5)
                ->get();

            return view('livewire.dashboard-client', compact('stats', 'recentMissions'));
        }

        // Freelance dashboard
        $stats = [
            'applications_sent' => Application::where('freelance_id', $user->id)->count(),
            'applications_accepted' => Application::where('freelance_id', $user->id)->where('status', 'accepted')->count(),
            'missions_in_progress' => Mission::where('freelance_id', $user->id)->where('status', 'in_progress')->count(),
            'missions_completed' => Mission::where('freelance_id', $user->id)->where('status', 'completed')->count(),
        ];
        $recentApplications = Application::where('freelance_id', $user->id)
            ->with(['mission.client', 'mission.category'])
            ->latest()
            ->limit(5)
            ->get();
        $openMissions = Mission::where('status', 'open')
            ->with(['client', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.dashboard-freelance', compact('stats', 'recentApplications', 'openMissions'));
    }
}
