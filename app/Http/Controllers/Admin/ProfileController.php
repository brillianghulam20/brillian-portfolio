<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile', ['profile' => Profile::query()->firstOrFail()]);
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        $profile = Profile::query()->firstOrFail();
        $data = $request->safe()->except(['photo', 'resume']);
        foreach (['photo' => 'photo_path', 'resume' => 'resume_path'] as $input => $column) {
            if ($request->hasFile($input)) {
                if ($profile->{$column}) {
                    Storage::disk('public')->delete($profile->{$column});
                }
                $data[$column] = $request->file($input)->store($input === 'photo' ? 'profile' : 'resume', 'public');
            }
        }
        $profile->update($data);

        return back()->with('status', 'Profil berhasil diperbarui.');
    }
}
