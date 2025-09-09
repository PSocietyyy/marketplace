<?php

namespace App\Livewire\Home;

use App\Models\Profile;
use App\Models\Umkn;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout("layouts.home")]
#[Title("Profile")]
class ProfilePage extends Component
{
    use WithFileUploads;

    // User data
    public $first_name;
    public $last_name;
    public $birth_date;
    public $email;

    // Profile data
    public $full_name;
    public $phone;
    public $address;
    public $avatar;
    public $new_avatar;

    // UMKN data
    public $umkn_name;
    public $umkn_description;
    public $umkn_address;
    public $umkn_phone;
    public $umkn_logo;
    public $new_umkn_logo;

    // States
    public $showCreateUmkn = false;
    public $editingProfile = false;
    public $editingUmkn = false;

    public function mount()
    {
        $user = Auth::user();
        
        // Load user data
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->birth_date = $user->birth_date;
        $this->email = $user->email;

        // Load profile data
        if ($user->profile) {
            $this->full_name = $user->profile->full_name;
            $this->phone = $user->profile->number_phone;
            $this->address = $user->profile->address;
            $this->avatar = $user->profile->photo;
        }

        // Load UMKN data
        if ($user->umkn) {
            $this->umkn_name = $user->umkn->umkn_name;
            $this->umkn_description = $user->umkn->description;
            $this->umkn_address = $user->umkn->address;
            $this->umkn_phone = $user->umkn->number_phone;
            $this->umkn_logo = $user->umkn->logo;
        }
    }

    public function toggleEditProfile()
    {
        $this->editingProfile = !$this->editingProfile;
        if (!$this->editingProfile) {
            $this->mount(); // Reset data if cancelled
        }
    }

    public function toggleEditUmkn()
    {
        $this->editingUmkn = !$this->editingUmkn;
        if (!$this->editingUmkn) {
            $this->mount(); // Reset data if cancelled
        }
    }

    public function toggleCreateUmkn()
    {
        $this->showCreateUmkn = !$this->showCreateUmkn;
        if (!$this->showCreateUmkn) {
            // Reset UMKN form
            $this->umkn_name = '';
            $this->umkn_description = '';
            $this->umkn_address = '';
            $this->umkn_phone = '';
            $this->new_umkn_logo = null;
        }
    }

    public function updateProfile()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'full_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:2048'
        ]);

        $user = Auth::user();

        // Update user data
        $user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birth_date' => $this->birth_date,
        ]);

        // Handle avatar upload
        $avatarPath = $this->avatar;
        if ($this->new_avatar) {
            // Delete old avatar
            if ($this->avatar) {
                Storage::disk('public')->delete($this->avatar);
            }
            $avatarPath = $this->new_avatar->store('avatars', 'public');
        }

        // Update or create profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => $this->full_name,
                'number_phone' => $this->phone,
                'address' => $this->address,
                'photo' => $avatarPath,
            ]
        );

        $this->avatar = $avatarPath;
        $this->new_avatar = null;
        $this->editingProfile = false;

        $this->dispatch('alert', message: 'Profile berhasil diperbarui!', type: 'success');
    }

    public function createUmkn()
    {
        $this->validate([
            'umkn_name' => 'required|string|max:255',
            'umkn_description' => 'required|string|max:1000',
            'umkn_address' => 'required|string|max:500',
            'umkn_phone' => 'required|string|max:20',
            'new_umkn_logo' => 'nullable|image|max:2048'
        ]);

        $user = Auth::user();

        // Check if user already has UMKN
        if ($user->umkn) {
            $this->dispatch('alert', message: 'Anda sudah memiliki UMKN!', type: 'error');
            return;
        }

        // Handle logo upload
        $logoPath = null;
        if ($this->new_umkn_logo) {
            $logoPath = $this->new_umkn_logo->store('umkn-logos', 'public');
        }

        // Create UMKN
        $umkn = Umkn::create([
            'umkn_name' => $this->umkn_name,
            'description' => $this->umkn_description,
            'address' => $this->umkn_address,
            'number_phone' => $this->umkn_phone,
            'logo' => $logoPath,
            'status' => 'pending'
        ]);

        // Update user with UMKN ID
        $user->update(['umkn_id' => $umkn->id]);

        $this->umkn_logo = $logoPath;
        $this->new_umkn_logo = null;
        $this->showCreateUmkn = false;

        $this->dispatch('alert', message: 'UMKN berhasil dibuat!', type: 'success');
        $this->mount(); // Reload data
    }

    public function updateUmkn()
    {
        $this->validate([
            'umkn_name' => 'required|string|max:255',
            'umkn_description' => 'required|string|max:1000',
            'umkn_address' => 'required|string|max:500',
            'umkn_phone' => 'required|string|max:20',
            'new_umkn_logo' => 'nullable|image|max:2048'
        ]);

        $user = Auth::user();

        if (!$user->umkn) {
            $this->dispatch('alert', message: 'UMKN tidak ditemukan!', type: 'error');
            return;
        }

        // Handle logo upload
        $logoPath = $this->umkn_logo;
        if ($this->new_umkn_logo) {
            // Delete old logo
            if ($this->umkn_logo) {
                Storage::disk('public')->delete($this->umkn_logo);
            }
            $logoPath = $this->new_umkn_logo->store('umkn-logos', 'public');
        }

        // Update UMKN
        $user->umkn->update([
            'umkn_name' => $this->umkn_name,
            'description' => $this->umkn_description,
            'address' => $this->umkn_address,
            'number_phone' => $this->umkn_phone,
            'logo' => $logoPath,
        ]);

        $this->umkn_logo = $logoPath;
        $this->new_umkn_logo = null;
        $this->editingUmkn = false;

        $this->dispatch('alert', message: 'UMKN berhasil diperbarui!', type: 'success');
    }

    public function render()
    {
        return view('livewire.home.profile-page');
    }
}