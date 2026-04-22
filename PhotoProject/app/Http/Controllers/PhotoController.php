<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
  public function create()
  {
    $photos = Photo::latest()->paginate(8);
    return view('upload', compact('photos'));
  }

  public function storeSingle(Request $request)
  {
    $request->validate([
      'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
    ]);

    $image = $request->file('image');
    $name = time() . '_' . $image->getClientOriginalName();
    $image->move(public_path('images'), $name);

    Photo::create(['image' => $name]);

    return redirect()->route('photos.upload')->with('success_single', 'Single image uploaded successfully!');
  }

  public function storeMultiple(Request $request)
  {
    $request->validate([
      'images'   => 'required|array|min:1',
      'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
    ]);

    foreach ($request->file('images') as $image) {
      $name = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('images'), $name);
      Photo::create(['image' => $name]);
    }

    return redirect()->route('photos.upload')->with('success_multiple', 'Multiple images uploaded successfully!');
  }

  public function destroy(Photo $photo)
  {
    $path = public_path('images/' . $photo->image);
    if (file_exists($path)) {
      unlink($path);
    }
    $photo->delete();

    return redirect()->route('photos.upload')->with('success_delete', 'Image deleted successfully!');
  }
}
