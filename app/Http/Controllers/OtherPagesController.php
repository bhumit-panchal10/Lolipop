<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherPages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class OtherPagesController extends Controller
{
    public function index(Request $request)
    {

        $Setting = OtherPages::orderBy('id', 'desc')->paginate(10);

        return view('setting.otherpages', compact('Setting'));
    }


    public function editview(Request $request, $id)
    {
        $data = OtherPages::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();

        echo json_encode($data);
    }

    public function update(Request $request)
    {
        // dd($request);
        $update = DB::table('other_pages')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
            ->update([
                'pagename' => $request->pagename,
                'description' => $request->description,
                'updated_at' => date('Y-m-d H:i:s'),
                'strIP' => $request->ip(),
            ]);

        return  back()->with('success', 'Updated Successfully.');
    }

    public function viewdetail(Request $request, $id)
    {
        $data = OtherPages::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();

        echo json_encode($data);
    }
}
