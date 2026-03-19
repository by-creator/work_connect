<?php

namespace App\Livewire\Missions;

use App\Models\Category;
use App\Models\Mission;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateMission extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $description = '';
    public string $budget = '';
    public string $deadline = '';
    public string $category_id = '';
    public string $duration = 'short';
    public string $skills_input = '';
    public $attachment = null;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:10', 'max:255'],
            'description' => ['required', 'string', 'min:30'],
            'budget' => ['required', 'numeric', 'min:1000'],
            'deadline' => ['nullable', 'date', 'after:today'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'duration' => ['required', 'in:short,medium,long'],
            'skills_input' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'max:10240'],
        ];
    }

    public function save()
    {
        $this->validate();

        $skills = array_filter(array_map('trim', explode(',', $this->skills_input)));

        $attachmentPath = null;
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('missions/attachments', 'public');
        }

        Mission::create([
            'client_id' => auth()->id(),
            'category_id' => $this->category_id ?: null,
            'title' => $this->title,
            'description' => $this->description,
            'budget' => $this->budget,
            'deadline' => $this->deadline ?: null,
            'duration' => $this->duration,
            'skills_required' => $skills,
            'attachment' => $attachmentPath,
        ]);

        session()->flash('success', 'Votre mission a été publiée avec succès !');

        return $this->redirect(route('missions.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.missions.create-mission', [
            'categories' => Category::all(),
        ]);
    }
}
