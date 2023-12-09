<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
            ]);
    
            $user = Auth::user();
    
            $oldImagePath = public_path('storage/profile_images') . '/' . $user->image;
            if(File::exists($oldImagePath)){
                File::delete($oldImagePath);
            }
    
            $image = $request->file('image');
    
            if(!$image){
                throw new \Exception('No image provided.');
            }
    
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            if(!$image->move(public_path('storage/profile_images'), $imageName)){
                throw new \Exception('Error uploading image.');
            }
    
            $user->image = $imageName;
            $user->save();
    
            return redirect()->back()->with('message', 'Successfully updated profile picture!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function ajaxSearchUsers(Request $request)
    {
        $searchTerm = $request->input('search');

        $users = User::where('name', 'LIKE', '%' . $searchTerm . '%')->get();

        return response()->json($users);
    }
}
