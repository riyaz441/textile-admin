<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BranchMaster;
use App\Models\ComponentTypeMaster;
use App\Models\GemstoneMaster;
use App\Models\LaborMaster;
use App\Models\LocationMaster;
use App\Models\Material;
use App\Models\Measurement;
use App\Models\Product;
use App\Models\ProductCategoryMaster;
use App\Models\SupplierMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data['total_Product_category'] = ProductCategoryMaster::where('status', 'Active')->count();

        $data['masterCards'] = [
            [
                'label' => 'Product Categories',
                'value' => $data['total_Product_category'],
                'icon' => 'bx bx-category',
                'color' => 'primary',
                'note' => 'Active',
            ],
            [
                'label' => 'Branches',
                'value' => BranchMaster::count(),
                'icon' => 'bx bx-store',
                'color' => 'info',
                'note' => 'All locations',
            ],
            [
                'label' => 'Suppliers',
                'value' => SupplierMaster::count(),
                'icon' => 'bx bx-briefcase-alt-2',
                'color' => 'warning',
                'note' => 'Approved',
            ],
            [
                'label' => 'Materials',
                'value' => Material::count(),
                'icon' => 'bx bx-cube',
                'color' => 'success',
                'note' => 'In catalog',
            ],
            [
                'label' => 'Gemstones',
                'value' => GemstoneMaster::count(),
                'icon' => 'bx bx-diamond',
                'color' => 'danger',
                'note' => 'Active stock',
            ],
            [
                'label' => 'Products',
                'value' => Product::count(),
                'icon' => 'bx bx-package',
                'color' => 'primary',
                'note' => 'Live items',
            ],
            [
                'label' => 'Locations',
                'value' => LocationMaster::count(),
                'icon' => 'bx bx-map',
                'color' => 'info',
                'note' => 'Service areas',
            ],
            [
                'label' => 'Component Types',
                'value' => ComponentTypeMaster::count(),
                'icon' => 'bx bx-layer',
                'color' => 'secondary',
                'note' => 'Available',
            ],
        ];

        $data['kpis'] = [
            [
                'label' => 'Monthly Sales',
                'value' => '$48,250',
                'trend' => '+12.4%',
                'trend_class' => 'text-success',
                'icon' => 'bx bx-dollar-circle',
                'sub' => 'vs last month',
            ],
            [
                'label' => 'Orders Processed',
                'value' => '1,284',
                'trend' => '+5.1%',
                'trend_class' => 'text-success',
                'icon' => 'bx bx-cart',
                'sub' => 'Last 30 days',
            ],
            [
                'label' => 'Pending Repairs',
                'value' => '34',
                'trend' => '-2.3%',
                'trend_class' => 'text-danger',
                'icon' => 'bx bx-wrench',
                'sub' => 'Awaiting parts',
            ],
            [
                'label' => 'Average Ticket',
                'value' => '$312',
                'trend' => '+1.9%',
                'trend_class' => 'text-success',
                'icon' => 'bx bx-receipt',
                'sub' => 'Per order',
            ],
        ];

        $data['activity'] = [
            [
                'title' => 'New supplier onboarded',
                'meta' => 'Radiant Gems Co.',
                'time' => '2 hours ago',
            ],
            [
                'title' => 'Branch inventory synced',
                'meta' => 'Downtown HQ',
                'time' => 'Today, 9:15 AM',
            ],
            [
                'title' => 'Material prices updated',
                'meta' => 'Gold 18K, Silver',
                'time' => 'Yesterday, 4:40 PM',
            ],
            [
                'title' => 'Gemstone batch received',
                'meta' => 'Emerald, Sapphire',
                'time' => 'Yesterday, 11:05 AM',
            ],
        ];

        $data['topBranches'] = [
            [
                'name' => 'Downtown HQ',
                'orders' => 412,
                'revenue' => '$24.3k',
                'growth' => '+8%',
                'growth_class' => 'text-success',
            ],
            [
                'name' => 'Uptown Studio',
                'orders' => 318,
                'revenue' => '$19.1k',
                'growth' => '+3%',
                'growth_class' => 'text-success',
            ],
            [
                'name' => 'Riverside',
                'orders' => 205,
                'revenue' => '$11.7k',
                'growth' => '-1%',
                'growth_class' => 'text-danger',
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
