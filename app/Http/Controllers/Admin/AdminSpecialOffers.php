<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpecialOffer;
use Illuminate\Support\Str;

class AdminSpecialOffers extends Controller
{
    public function index()
    {
        $specialOffers = SpecialOffer::all();
        return inertia('Admin/SpecialOffers/Index', ['specialOffers' => $specialOffers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('special_offers'), $uniqueName);
        $imagePath = 'special_offers/' . $uniqueName;

        SpecialOffer::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.special_offers.index')->with('success', 'Special offer created successfully.');
    }

    public function update(Request $request, $id)
    {
        $specialOffer = SpecialOffer::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($specialOffer->image && file_exists(public_path($specialOffer->image))) {
                unlink(public_path($specialOffer->image));
            }
            $image = $request->file('image');
            $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('special_offers'), $uniqueName);
            $specialOffer->image = 'special_offers/' . $uniqueName;
        }

        $specialOffer->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $specialOffer->image,
        ]);

        return redirect()->route('admin.special_offers.index')->with('success', 'Special offer updated successfully.');
    }

    public function destroy($id)
    {
        $specialOffer = SpecialOffer::findOrFail($id);
        if ($specialOffer->image && file_exists(public_path($specialOffer->image))) {
            unlink(public_path($specialOffer->image));
        }
        $specialOffer->delete();

        return redirect()->route('admin.special_offers.index')->with('success', 'Special offer deleted successfully.');
    }
}
