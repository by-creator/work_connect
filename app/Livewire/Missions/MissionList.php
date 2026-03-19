<?php

namespace App\Livewire\Missions;

use App\Models\Category;
use App\Models\Mission;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Missions disponibles')]
class MissionList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categoryFilter = '';
    public string $budgetMin = '';
    public string $budgetMax = '';
    public string $durationFilter = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Mission::query()
            ->where('status', 'open')
            ->with(['client', 'category', 'applications']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->budgetMin) {
            $query->where('budget', '>=', $this->budgetMin);
        }

        if ($this->budgetMax) {
            $query->where('budget', '<=', $this->budgetMax);
        }

        if ($this->durationFilter) {
            $query->where('duration', $this->durationFilter);
        }

        $missions = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('livewire.missions.mission-list', compact('missions', 'categories'));
    }
}
