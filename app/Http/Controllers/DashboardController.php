<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Doctor;
use App\Models\GalleryImage;
use App\Models\GalleryVideo;
use App\Models\Websetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $doctorTotal = Doctor::count();
        $doctorActive = Doctor::where('status', 'Active')->count();
        $doctorInactive = Doctor::where('status', 'Inactive')->count();
        $galleryImageCount = GalleryImage::count();
        $galleryVideoCount = GalleryVideo::count();
        $aboutCount = About::count();
        $websettingCount = Websetting::count();

        $user = Auth::user();
        $profileScore = 0;
        if ($user) {
            $profileFields = [
                $user->name ?? null,
                $user->email ?? null,
                $user->phone_number ?? null,
                $user->address ?? null,
                $user->profile ?? null,
            ];

            foreach ($profileFields as $field) {
                if (!empty($field)) {
                    $profileScore++;
                }
            }
        }

        $data['moduleCards'] = [
            [
                'label' => 'Dashboard Module',
                'value' => 'Active',
                'icon' => 'bx bx-home-smile',
                'color' => 'info',
                'note' => 'Main entry point',
                'url' => url('dashboard'),
            ],
            [
                'label' => 'Doctor Module',
                'value' => $doctorTotal,
                'icon' => 'bx bx-plus-medical',
                'color' => 'success',
                'note' => $doctorActive . ' active / ' . $doctorInactive . ' inactive',
                'url' => route('doctors.index'),
            ],
            [
                'label' => 'About Module',
                'value' => $aboutCount,
                'icon' => 'bx bx-user-circle',
                'color' => 'warning',
                'note' => $aboutCount > 0 ? 'Configured' : 'Not configured',
                'url' => url('about_setting'),
            ],
            [
                'label' => 'Gallery Module',
                'value' => $galleryImageCount + $galleryVideoCount,
                'icon' => 'bx bx-image-alt',
                'color' => 'primary',
                'note' => $galleryImageCount . ' images / ' . $galleryVideoCount . ' videos',
                'url' => route('galleries.index'),
            ],
            [
                'label' => 'Header & Footer Setting',
                'value' => $websettingCount,
                'icon' => 'bx bx-cog',
                'color' => 'dark',
                'note' => $websettingCount > 0 ? 'Configured' : 'Not configured',
                'url' => url('web_setting'),
            ],
            [
                'label' => 'Profile Module',
                'value' => $profileScore . '/5',
                'icon' => 'bx bx-user',
                'color' => 'secondary',
                'note' => 'Profile completion',
                'url' => route('profile'),
            ],
        ];

        $data['moduleStatus'] = [
            [
                'module' => 'Doctor',
                'status' => $doctorTotal > 0 ? 'Ready' : 'Needs data',
                'details' => 'Manage doctor master entries',
            ],
            [
                'module' => 'About',
                'status' => $aboutCount > 0 ? 'Ready' : 'Needs data',
                'details' => 'About section content',
            ],
            [
                'module' => 'Gallery',
                'status' => ($galleryImageCount + $galleryVideoCount) > 0 ? 'Ready' : 'Needs data',
                'details' => 'Photos and videos for website',
            ],
            [
                'module' => 'Header & Footer Setting',
                'status' => $websettingCount > 0 ? 'Ready' : 'Needs setup',
                'details' => 'Website logo and contact settings',
            ],
            [
                'module' => 'Profile',
                'status' => $profileScore >= 3 ? 'Ready' : 'Update recommended',
                'details' => 'Admin profile and security',
            ],
        ];

        return view('dashboard', $data);
    }

    public function profile(Request $request)
    {
        if (!$_POST) {
            $data['user'] = Auth::user();
            return view('profile', $data);
        } else {
            $request->validate(
                [
                    'profile_upload' => 'nullable|image|mimes:jpeg,jpg,png|max:1024|dimensions:width=200,height=200',
                    'name' => 'required|regex:/^[A-Za-z. ]+$/|min:3|max:50',
                    'email' => 'required|email|regex:/^[a-z0-9.]+@[a-z]+\.[a-z]{2,}$/',
                    'password' => 'nullable|min:8|max:16',
                    'phone_number' => 'nullable|regex:/^[0-9+\-\s()]*$/',
                    'address' => 'nullable'
                ],
                [
                    'name.min' => 'Name range from 3 to 50 characters',
                    'name.max' => 'Name range from 3 to 50 characters',
                    'name.regex' => 'This field is an invalid format',
                    'profile_upload.dimensions' => 'Profile upload range from 200 px to 200 px',
                    'profile_upload.mimes' => 'Upload a valid Profile upload file (e.g., .jpg, .jpeg, .png)',
                    'profile_upload.image' => 'Upload a valid Profile upload file (e.g., .jpg, .jpeg, .png)',
                    'password.min' => 'Password range from 8 to 16 characters',
                    'password.max' => 'Password range from 8 to 16 characters',
                    'email.email' => 'Enter a valid email address (e.g., example@domain.com)',
                    'email.regex' => 'Enter a valid email address (e.g., example@domain.com)',
                    'phone_number.regex' => 'This field is an invalid format',
                ]
            );

            $user_id = Auth::user()->id;
            $user = User::find($user_id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone;
            $user->address = $request->address;

            // Profile image upload logic
            if ($request->hasFile('profile_upload')) {
                // Delete old image if exists
                if ($user->profile && file_exists(public_path('assets/img/profile/' . $user->profile))) {
                    unlink(public_path('assets/img/profile/' . $user->profile));
                }

                // Generate unique filename
                $image = $request->file('profile_upload');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Move uploaded file
                $image->move(public_path('assets/img/profile'), $imageName);

                // Save image name to database
                $user->profile = $imageName;
            }

            if (isset($request->password) && !empty($request->password)) {
                $user->password = Hash::make($request->password);
                Auth::login($user);
            }


            $user->save();
            session()->flash('success', 'Profile updated successfully');
        }
        return redirect('profile');
    }
}
