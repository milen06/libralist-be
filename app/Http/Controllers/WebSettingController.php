<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use Illuminate\Http\Request;

class WebSettingController extends Controller
{
    public function index()
    {
        $settings = WebSetting::first();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string|max:500',
            'app_logo' => 'nullable|image|max:2048',
        ]);

        $settings = WebSetting::first();

        $data = $request->only(['app_name', 'app_description']);

        // Upload logo baru jika ada
        if ($request->hasFile('app_logo')) {
            if ($settings->app_logo && file_exists(public_path($settings->app_logo))) {
                unlink(public_path($settings->app_logo));
            }

            $file = $request->file('app_logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destination = public_path('uploads/app-logo');

            if (!file_exists($destination)) {
                mkdir($destination, 0775, true);
            }

            $file->move($destination, $filename);
            $data['app_logo'] = 'uploads/app-logo/' . $filename;
        }

        $settings->update($data);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}