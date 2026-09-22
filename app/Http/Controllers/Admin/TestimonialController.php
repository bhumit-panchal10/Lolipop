<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('id', 'desc')->paginate(10);

        return view('admin.testimonial.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'tag'         => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Testimonial::create([
            'name'        => $request->name,
            'tag'         => $request->tag,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('testimonial.index')
            ->with('success', 'Testimonial added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'tag'         => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $testimonial = Testimonial::where('id', $id)->firstOrFail();

        $testimonial->update([
            'name'        => $request->name,
            'tag'         => $request->tag,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('testimonial.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::where('id', $id)->firstOrFail();

        // Hard Delete
        $testimonial->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Testimonial deleted successfully.'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'required|integer',
        ]);

        // Hard Delete
        Testimonial::whereIn('id', $request->ids)->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Selected testimonials deleted successfully.'
        ]);
    }
}
