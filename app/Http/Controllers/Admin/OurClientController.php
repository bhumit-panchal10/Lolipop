<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OurClient;
use App\Helpers\FileUploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OurClientController extends Controller
{
    private $uploadFolder = 'uploads/clients';

    public function index()
    {
        $clients = OurClient::orderBy('id', 'desc')->paginate(10);

        return view('admin.our-client.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imageName = FileUploadHelper::upload(
            $request->file('image'),
            $this->uploadFolder
        );

        OurClient::create([
            'name'  => $request->name,
            'image' => $imageName,
        ]);

        return redirect()
            ->route('our-client.index')
            ->with('success', 'Client added successfully.');
    }

    public function update(Request $request, $id)
    {
        $client = OurClient::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'  => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'name' => $request->name,
        ];

        if ($request->hasFile('image')) {

            FileUploadHelper::delete(
                $client->image,
                $this->uploadFolder
            );

            $data['image'] = FileUploadHelper::upload(
                $request->file('image'),
                $this->uploadFolder
            );
        }

        $client->update($data);

        return redirect()
            ->route('our-client.index')
            ->with('success', 'Client updated successfully.');
    }

    public function destroy($id)
    {
        $client = OurClient::findOrFail($id);

        // Remove image
        FileUploadHelper::delete(
            $client->image,
            $this->uploadFolder
        );

        // Hard delete
        $client->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Client deleted successfully.'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids'   => 'required|array',
            'ids.*' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Please select at least one record.'
            ], 422);
        }

        $clients = OurClient::whereIn('id', $request->ids)->get();

        foreach ($clients as $client) {

            FileUploadHelper::delete(
                $client->image,
                $this->uploadFolder
            );

            // Hard delete
            $client->delete();
        }

        return response()->json([
            'status'  => true,
            'message' => 'Selected clients deleted successfully.'
        ]);
    }
}
