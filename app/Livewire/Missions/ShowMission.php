<?php

namespace App\Livewire\Missions;

use App\Models\Application;
use App\Models\Mission;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ShowMission extends Component
{
    public Mission $mission;
    public string $cover_letter = '';
    public string $proposed_price = '';
    public string $estimated_days = '';
    public bool $showApplyForm = false;

    protected function rules(): array
    {
        return [
            'cover_letter' => ['required', 'string', 'min:30'],
            'proposed_price' => ['required', 'numeric', 'min:1000'],
            'estimated_days' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function apply()
    {
        $this->validate();

        $user = auth()->user();

        if (! $user->isFreelance()) {
            session()->flash('error', 'Seuls les freelances peuvent postuler.');
            return;
        }

        $existing = Application::where('mission_id', $this->mission->id)
            ->where('freelance_id', $user->id)
            ->first();

        if ($existing) {
            session()->flash('error', 'Vous avez déjà postulé à cette mission.');
            return;
        }

        Application::create([
            'mission_id' => $this->mission->id,
            'freelance_id' => $user->id,
            'cover_letter' => $this->cover_letter,
            'proposed_price' => $this->proposed_price,
            'estimated_days' => $this->estimated_days ?: null,
        ]);

        $this->showApplyForm = false;
        $this->reset(['cover_letter', 'proposed_price', 'estimated_days']);
        session()->flash('success', 'Votre candidature a été envoyée !');
    }

    public function acceptApplication(int $applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if ($this->mission->client_id !== auth()->id()) {
            return;
        }

        // Reject all other applications
        Application::where('mission_id', $this->mission->id)
            ->where('id', '!=', $applicationId)
            ->update(['status' => 'rejected']);

        $application->update(['status' => 'accepted']);
        $this->mission->update([
            'freelance_id' => $application->freelance_id,
            'status' => 'in_progress',
        ]);

        session()->flash('success', 'Candidature acceptée ! La mission est maintenant en cours.');
    }

    public function render()
    {
        $this->mission->load(['client', 'category', 'applications.freelance', 'freelance']);

        $hasApplied = auth()->check()
            ? Application::where('mission_id', $this->mission->id)
                ->where('freelance_id', auth()->id())
                ->exists()
            : false;

        return view('livewire.missions.show-mission', compact('hasApplied'))
            ->title($this->mission->title);
    }
}
