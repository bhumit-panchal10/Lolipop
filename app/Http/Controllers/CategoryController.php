<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;



class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $Category = DB::table('category')
            ->select(
                'categoryId',
                DB::raw('(SELECT categoryname FROM category AS cat WHERE category.subcategoryid = cat.categoryId) AS parentname'),
                'strSequence',
                'categoryname AS name',
                'photo AS categoryphoto',
                'strGST',
                'iStatus'
            )
            ->where('isDelete',0)
            ->orderBy('strSequence', 'asc')
            ->paginate(25);
        return view('category.index', compact('Category'));
    }

    public function create(Request $request)
    {
        $Category = Category::where('subcategoryid', 0)->orderBy('categoryname', 'asc')->get();
        return view('category.add', compact('Category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoryname' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // Validation for photo
        ]);
        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/Category/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }

        $CategoryLoverCase = Str::lower($request->categoryname);
        $CategoryName = str_replace(' ', '-', $CategoryLoverCase);

        $Category = Category::where([
            
            'isDelete' => 0,
            'categoryname' => $request->categoryname
        ])
            ->first();

        $Data = array(
            'subcategoryid' => $request->subcategoryid ?? 0,
            'categoryname' => $request->categoryname,
            'slugname' => $CategoryName,
            'strSequence' => $request->strSequence ?? 0,
            'strGST' => $request->strGST ?? 0,
            'photo' => $img,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip(),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        );
        DB::table('category')->insert($Data);
        return redirect()->route('category.index')->with('success', 'Category Created Successfully.');
        // }
    }

    public function chk_unique(Request $request)
    {
        if ($request->categoryname != null && $request->subcategoryid != null) {
            $Category = Category::where([
                
                'isDelete' => 0,
                'categoryname' => $request->categoryname,
                'subcategoryid' => $request->subcategoryid,
            ])
                ->first();
            if ($Category) {
                echo 2;
            } else {
                echo 0;
            }
        } else if ($request->categoryname != null) {
            $Category = Category::where([
                
                'isDelete' => 0,
                'categoryname' => $request->categoryname,
            ])
                ->first();
            if ($Category) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function editview(Request $request, $id)
    {
        $Category = Category::orderBy('categoryname', 'asc')
            ->where([ 'isDelete' => 0])
            ->where('subcategoryid', '==', 0)
            ->get();
        $data = Category::where([ 'isDelete' => 0, 'categoryId' => $id])->first();

        $CategorySelected = Category::where([
             'isDelete' => 0, 'subcategoryid' => $data->subcategoryid
        ])->first();
        return view('category.edit', compact('data', 'Category', 'CategorySelected'));
    }

    public function update(Request $request, $id)
    {
        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/Category/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
            $oldImg = $request->input('hiddenPhoto') ? $request->input('hiddenPhoto') : null;

            if ($oldImg != null || $oldImg != "") {
                if (file_exists($destinationpath . $oldImg)) {
                    unlink($destinationpath . $oldImg);
                }
            }
        } else {
            $oldImg = $request->input('hiddenPhoto');
            $img = $oldImg;
        }


        $CategoryLoverCase = Str::lower($request->categoryname);
        $CategoryName = str_replace(' ', '-', $CategoryLoverCase);

        $update = DB::table('category')
            ->where([ 'isDelete' => 0, 'categoryId' => $id])
            ->update([
                'subcategoryid' => $request->subcategoryid ?? 0,
                'categoryname' => $request->categoryname,
                'strSequence' => $request->strSequence ?? 0,
                'slugname' => $CategoryName,
                'strGST' => $request->strGST ?? 0,
                'photo' => $img,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        return  redirect()->route('category.index')->with('success', 'Category Updated Successfully.');
    }

    public function editchk_unique(Request $request)
    {
        if ($request->categoryname != null && $request->subcategoryid != null) {
            $Category = Category::where([
                
                'isDelete' => 0,
                'categoryname' => $request->categoryname,
                'subcategoryid' => $request->subcategoryid,
            ])
                ->first();
            if ($Category) {
                echo 2;
            } else {
                echo 0;
            }
        } else if ($request->categoryname != null) {
            $Category = Category::where([
                
                'isDelete' => 0,
                'categoryname' => $request->categoryname,
            ])
                ->first();
            if ($Category) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }


    public function delete(Request $request)
    {
        $delete = DB::table('category')->where([ 'isDelete' => 0, 'categoryId' => $request->categoryId])->first();

        $root = $_SERVER['DOCUMENT_ROOT'];
        $destinationpath = $root . '/Category/';
        if ($delete->photo) {
            unlink($destinationpath  . $delete->photo);
        }

        DB::table('category')->where([ 'isDelete' => 0, 'categoryId' => $request->categoryId])->delete();
        
        // $Product = DB::table('product')->where(['iStatus' => 1, 'isDelete' => 0, 'categoryId' => $request->categoryId])->get();
        
        // DB::table('product')->where([ 'isDelete' => 0, 'categoryId' => $request->categoryId])->delete();
        
        // $deleteproductphotos = DB::table('productphotos')->where(['iStatus' => 1, 'isDelete' => 0, 'productid' => $Product->productId])->get();
        
        // $root = $_SERVER['DOCUMENT_ROOT'];
        // $destinationpathproduct = $root . '/Product/';
        // $destinationpathproduct1 = $root . '/Product/Thumbnail/';

        // foreach ($deleteproductphotos as $deleteproductphoto) {
        //     if (file_exists($destinationpathproduct1 . $deleteproductphoto->strphoto)) {
        //         unlink($destinationpathproduct1 . $deleteproductphoto->strphoto);
        //     }
        //     if (file_exists($destinationpathproduct . $deleteproductphoto->strphoto)) {
        //         unlink($destinationpathproduct . $deleteproductphoto->strphoto);
        //     }
        // }
        
        // DB::table('productphotos')->where(['iStatus' => 1, 'isDelete' => 0, 'productId' => $Product->productId])->delete();
        return back()->with('success', 'Category Deleted Successfully!.');
    }
    
    public function updateStatus($category_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'category_id'   => $category_id,
            'status'    => $status
        ], [
            'category_id'   =>  'required|exists:category,categoryId',
            'status'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('category.index')->with('error', $validate->errors()->first());
        }

        try {

            // Update Status
            Category::where('categoryId',$category_id)->update(['iStatus' => $status]);

            // Commit And Redirect on index with Success Message
            return redirect()->route('category.index')->with('success', 'Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
