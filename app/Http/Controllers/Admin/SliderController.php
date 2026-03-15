<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $query = Slider::query();

        if ($request->get('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->get('status') === 'inactive') {
            $query->where('is_active', false);
        }

        $sliders = $query->orderBy('sort_order')->orderBy('id')->paginate(10)
            ->appends($request->only('status'));

        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'link' => ['nullable', 'string', 'max:500'],
            'link_text' => ['nullable', 'string', 'max:100'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'bg_class' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());

            // Optional: resize/optimize here if needed, e.g.:
            // $image = $image->scaleDown(width: 1600);

            $filename = 'slider_' . uniqid() . '.webp';
            $path = 'sliders/' . $filename;

            Storage::disk('public')->put($path, (string) $image->toWebp());

            $data['image'] = $path;
        }

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = (bool) $data['is_active'];

        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'link' => ['nullable', 'string', 'max:500'],
            'link_text' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'bg_class' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }

            $file = $request->file('image');

            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());

            // Optional: resize/optimize here if needed
            // $image = $image->scaleDown(width: 1600);

            $filename = 'slider_' . uniqid() . '.webp';
            $path = 'sliders/' . $filename;

            Storage::disk('public')->put($path, (string) $image->toWebp());

            $data['image'] = $path;
        }

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = (bool) $data['is_active'];

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully.');
    }
}
