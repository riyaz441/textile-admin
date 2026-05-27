<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function setting(Request $request)
    {
        $about = About::first();

        if (!$request->isMethod('post')) {
            return view('about.about_config', compact('about'));
        }

        $request->validate(
            [
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'image.required' => 'Please upload an image.',
                'image.max' => 'The field must not be greater than 2 MB',
                'image.mimes' => 'Upload a valid image file (e.g., .jpg, .jpeg, .png)',
                'image.image' => 'Upload a valid image file (e.g., .jpg, .jpeg, .png)',
            ]
        );

        if (!$about) {
            $about = new About();
        }

        if ($request->hasFile('image')) {
            if ($about->image && file_exists(public_path('assets/img/' . $about->image))) {
                unlink(public_path('assets/img/' . $about->image));
            }

            $image = $request->file('image');
            $imageName = 'about_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/img'), $imageName);
            $about->image = $imageName;
        }

        $about->save();

        session()->flash('success', 'Updated successfully');
        return redirect('about_setting');
    }
}
