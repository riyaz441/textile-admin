<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Websetting;
use App\Models\OpeningHour;

class WebsettingController extends Controller
{
    private array $weekDays = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    ];

    public function setting(Request $request)
    {
        $setting = Websetting::first();
        $openingHours = $setting
            ? $setting->openingHours->keyBy('day_name')
            : collect();

        if (!$request->isMethod('post')) {
            return view('websetting/web_config', [
                'setting' => $setting,
                'weekDays' => $this->weekDays,
                'openingHours' => $openingHours,
            ]);
        }

        $request->validate(
            [
                'contact_person' => [
                    'required',
                    'regex:/^[A-Za-z.\s-]+$/',
                ],
                'contact_email' => [
                    'required',
                    'email',
                    'regex:/^[a-z0-9.]+@[a-z]+\.[a-z]{2,}$/',
                ],
                'contact_phone' => [
                    'required',
                    'regex:/^(?:\+91|91|0)?[789]\d{9}$/',
                ],
                'landline_no' => [
                    'nullable',
                    'regex:/^[0-9+\-\s()]{6,20}$/',
                ],
                'sales_email' => [
                    'nullable',
                    'email',
                ],
                'address' => 'required|regex:/^(?!.*<\s*script\b[^>]*>).*$/i',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
                'fav_icon' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
                'opening_hours' => ['nullable', 'array'],
                'adding_work' => [
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        $items = collect(explode(',', (string) $value))
                            ->map(fn($item) => trim($item))
                            ->filter(fn($item) => $item !== '')
                            ->values();

                        if ($items->count() > 6) {
                            $fail('You can enter maximum 6 values only.');
                        }
                    },
                ],
            ],
            [
                'contact_person.regex' => 'This field is an invalid format',
                'contact_email.email' => 'Enter a valid email address (e.g., example@domain.com)',
                'contact_email.regex' => 'Enter a valid email address (e.g., example@domain.com)',
                'contact_phone.regex' => 'This field is an invalid format',
                'landline_no.regex' => 'This field is an invalid format',
                'sales_email.email' => 'Enter a valid email address (e.g., example@domain.com)',
                'address.regex' => 'This field is an invalid format',
                'logo.max' => 'The field must not be greater than 1 MB',
                'logo.mimes' => 'Upload a valid logo file (e.g., .jpg, .jpeg, .png)',
                'logo.image' => 'Upload a valid logo file (e.g., .jpg, .jpeg, .png)',
                'fav_icon.max' => 'The field must not be greater than 1 MB',
                'fav_icon.mimes' => 'Upload a valid favicon file (e.g., .jpg, .jpeg, .png)',
                'fav_icon.image' => 'Upload a valid favicon file (e.g., .jpg, .jpeg, .png)',
                'adding_work.string' => 'This field is an invalid format',
            ]
        );

        foreach ($this->weekDays as $day) {
            $from = trim((string) data_get($request->opening_hours, $day . '.from', ''));
            $to = trim((string) data_get($request->opening_hours, $day . '.to', ''));

            if (($from !== '' && $to === '') || ($from === '' && $to !== '')) {
                return back()
                    ->withErrors(['opening_hours' => "Please enter both from and to time for {$day}."])
                    ->withInput();
            }
        }

        if (!$setting) {
            $setting = new Websetting();
        }

        $setting->contact_person = $request->contact_person;
        $setting->contact_email = $request->contact_email;
        $setting->contact_phone = $request->contact_phone;
        $setting->landline_no = $request->landline_no;
        $setting->sales_email = $request->sales_email;
        $setting->address = $request->address;
        $setting->adding_work = collect(explode(',', (string) $request->adding_work))
            ->map(fn($item) => trim($item))
            ->filter(fn($item) => $item !== '')
            ->take(6)
            ->implode(', ');

        if ($request->hasFile('logo')) {
            if ($setting->logo && file_exists(public_path('assets/img/' . $setting->logo))) {
                unlink(public_path('assets/img/' . $setting->logo));
            }
            $image = $request->file('logo');
            $imageName = 'logo' . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/img'), $imageName);
            $setting->logo = $imageName;
        }

        if ($request->hasFile('fav_icon')) {
            if ($setting->fav_icon && file_exists(public_path('assets/img/' . $setting->fav_icon))) {
                unlink(public_path('assets/img/' . $setting->fav_icon));
            }
            $image = $request->file('fav_icon');
            $imageName = 'fav_icon' . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/img'), $imageName);
            $setting->fav_icon = $imageName;
        }

        $setting->save();

        foreach ($this->weekDays as $index => $day) {
            $from = trim((string) data_get($request->opening_hours, $day . '.from', ''));
            $to = trim((string) data_get($request->opening_hours, $day . '.to', ''));

            OpeningHour::updateOrCreate(
                [
                    'websetting_id' => $setting->id,
                    'day_name' => $day,
                ],
                [
                    'day_index' => $index + 1,
                    'from_time' => $from !== '' ? $from : null,
                    'to_time' => $to !== '' ? $to : null,
                ]
            );
        }

        session()->flash('success', 'Updated successfully');
        return redirect('web_setting');
    }

    public function admin(Request $request)
    {
        $setting = Websetting::first();

        if (!$request->isMethod('post')) {
            return view('adminsetting.admin_set_config', compact('setting'));
        } else {
            $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg|max:1024',
                'fav_icon' => 'image|mimes:jpeg,png,jpg|max:1024',],
                [
                    'logo.max' => 'The field must not be greater than 1 MB',
                    'logo.mimes' => 'Upload a valid Upload logo file (e.g., .jpg, .jpeg, .png)',
                    'logo.image' => 'Upload a valid Upload logo file (e.g., .jpg, .jpeg, .png)',
                    'fav_icon.max' => 'The field must not be greater than 1 MB',
                    'fav_icon.mimes' => 'Upload a valid Upload logo file (e.g., .jpg, .jpeg, .png)',
                    'fav_icon.image' => 'Upload a valid Upload logo file (e.g., .jpg, .jpeg, .png)',
                ]
            );

            if ($request->hasfile('logo')) {
                if ($setting->logo && file_exists(public_path('assets/img/' . $setting->logo))) {
                    unlink(public_path('assets/img/' . $setting->logo));
                }
                $image = $request->file('logo');
                $imageName = 'logo' . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/img'), $imageName);

                $setting->logo = $imageName;
                $setting->save();
            }

            if ($request->hasfile('fav_icon')) {
                if ($setting->fav_icon && file_exists(public_path('assets/img/' . $setting->fav_icon))) {
                    unlink(public_path('assets/img/' . $setting->fav_icon));
                }
                $image = $request->file('fav_icon');
                $imageName = 'fav_icon' . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/img'), $imageName);

                $setting->fav_icon = $imageName;
                $setting->save();
            }
            session()->flash('success', 'Updated successfully');
            return redirect('admin_setting');
        }
    }
}
