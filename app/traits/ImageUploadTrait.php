<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait ImageUploadTrait
{
    public function uploadImage(Request $request, $folder,$Name)
    {
        $request->validate([
            'image' => 'nullable|image|string|max:50|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = $Name . '_' . time() . '.' . $image->extension();
            $image->move(public_path($folder), $imageName);
            return response()->json(['success' => true, 'message' => 'Image uploaded successfully.', 'image_name' => $imageName]);
        }

        return response()->json(['success' => false, 'message' => 'Image upload failed.']);
    }
}
