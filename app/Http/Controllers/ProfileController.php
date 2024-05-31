<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\ImageUploadTrait;

class ProfileController extends Controller
{
  public function edit()
  {
    $user = auth()->user();
      return view('admin.profile.index',['user' => $user]);
  }

  use ImageUploadTrait;

    public function profile_upload_image(Request $request)
    {
        return $this->uploadImage($request, 'uploads','profile');
    }


  public function update(Request $request)
  {
      $request->validate([
          'first_name' => 'required|string|min:1|max:35|regex:/[a-zA-Z]/',
          'last_name' => 'required|string|min:1|max:35|regex:/[a-zA-Z]/',
          'old_password' => 'nullable|string|min:8',
          'new_password' => 'nullable|string|min:8|different:old_password',
          'confirmation_password' => 'nullable|string|min:8|same:new_password',
      ], [
        'first_name.required' => __('s.first_name.required'),
        'first_name.string' => __('s.first_name.string'),
        'first_name.max' => __('s.first_name.max', ['max' => 35]),
        'first_name.regex' => __('s.first_name.regex'),
        'last_name.regex' => __('s.last_name.regex'),
        'last_name.required' => __('s.last_name.required'),
        'last_name.string' => __('s.last_name.string'),
        'last_name.max' => __('s.last_name.max', ['max' => 35]),
        'old_password.min' => __('s.old_password.min'),
        'new_password.min' => __('s.new_password.min'),
        'new_password.regex' => __('s.new_password.regex'),
        'new_password.different' => __('s.new_password.different'),
        'confirmation_password.min' => __('s.confirmation_password.min'),
        'confirmation_password.same' => __('s.confirmation_password.same'),
        'image.image' => __('s.image.image'),
        'image.mimes' => __('s.image.mimes'),
        'image.max' => __('s.image.max'),

      ]);


     
      $user = auth()->user();

     
      $user->first_name = $request->input('first_name');
      $user->last_name = $request->input('last_name');
      if($request->input('image')){
          $user->image = $request->input('image');
      }

      if ($request->has('new_password') && Hash::check($request->input('old_password'), $user->password)) {
          $user->password = bcrypt($request->input('new_password'));
      }

      if ($user->save()) {
      return back()->with('success', __('s.user_profile_updated_successfully'));
  } else {
      return back()->with('errors1', __('s.user_profile_update_failed'));
  }
  }
  public function validatePassword(Request $request)
{
    $user = Auth::user();

   
    if (Hash::check($request->input('old_password'), $user->password)) {
        return response()->json(['message' => 'Password matched'], 200);
    } else {
        return response()->json(['message' => 'Password does not match'], 422);
    }
}

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
}
