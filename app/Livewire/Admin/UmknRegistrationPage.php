<?php

namespace App\Livewire\Admin;

use App\Models\Umkn;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout("layouts.admin")]
#[Title("Pendaftaran Umkn")]
class UmknRegistrationPage extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function getUmkns()
    {
        $query = Umkn::where('status', 'pending');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('umkn_name', 'like', '%' . $this->search . '%')
                  ->orWhere('number_phone', 'like', '%' . $this->search . '%');
            });
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function clearFilters()
    {
        $this->reset(['search']);
    }

    public function approvedUmkn($id)
    {
        $umkn = Umkn::findOrFail($id);
        $umkn->update([
            'status' => 'approved'
        ]);
        $this->dispatch('alert', message: 'Berhasil menerima Umkn', type: 'success');
        $this->resetPage();
    }

    public function rejectedUmkn($id)
    {
        $umkn = Umkn::findOrFail($id);
        $umkn->update([
            'status' => 'rejected'
        ]);
        $this->dispatch('alert', message: 'Berhasil menolak Umkn', type: 'success');
        $this->resetPage();
    }

    public function render()
    {
        $umkns = $this->getUmkns();

        return view('livewire.admin.umkn-registration-page', [
            'umkns' => $umkns,
        ]);
    }
}
