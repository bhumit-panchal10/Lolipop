<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Productphotos;
use App\Models\Inward;
use App\Models\CategoryMultiple;
use Illuminate\Support\Facades\DB;
use Image;
use App\Models\Attributes;
use App\Models\ProductAttributes;
use App\Models\Ledger;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



class ProductController extends Controller
{
    public function index(Request $request)
    {

        $ProductName = $request->productName;
        // dd($ProductName);
        $Product = Product::select(
            'product.productId',
            'product.categoryId',
            'product.subcategoryid',
            'product.productname',
            'product.rate',
            'product.iStatus',
            DB::raw('(SELECT categoryname FROM category WHERE category.categoryId = product.subcategoryid) AS subcategoryname'),
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
            'category.categoryname'
        )
            ->orderBy('productId', 'desc')
            ->where(['product.isDelete' => 0])
            ->when($request->productName, fn($query, $ProductName) => $query
                ->where('product.productname', 'like', "%$ProductName%"))
            ->join('category', 'product.categoryId', '=', 'category.categoryId')
            ->paginate(14);
        // dd($Product);

        return view('product.index', compact('Product', 'ProductName'));
    }

    public function createview()
    {

        $Category = Category::where('subcategoryid', 0)->orderBy('categoryId', 'desc')->get();

        return view('product.add', compact('Category'));
    }

    public function getsubcategory(Request $request)
    {
        $html = "";
        $SubCategory = Category::where(['isDelete' => 0, 'subcategoryid' => $request->Category])->get();
        // dd($SubCategory);
        $html .= '<option value="" selected >Select Sub Category</option>';
        foreach ($SubCategory as $subcategory) {
            $html .= '<option value=' . $subcategory->categoryId . '>' . $subcategory->categoryname . '</option>';
        }

        echo $html;
    }

    public function getGST(Request $request)
    {
        $category = Category::select('strGST')->whereIn('categoryId', $request->Category)->orderBy('strGST', 'desc')->limit(1)->first();
        echo $category->strGST;
    }

    public function create(Request $request)
    {
        $validator = $request->validate([
            'categoryId' => 'required',
            // 'subcategoryid' => 'required',
            'productname' => 'required|unique:product,productname',
            'photo' => 'required',
        ]);

        $isFeatures = 0;
        if ($request->isFeatures == "on") {
            $isFeatures = 1;
        }

        $ProductLoverCase = Str::lower($request->productname);
        $ProductName = str_replace(' ', '-', $ProductLoverCase);

        $Data = array(
            'categoryId' => $request->categoryId ?? 0,
            'subcategoryid' => $request->subcategoryid ?? 0,
            'productname' => $request->productname,
            'slugname' => $ProductName,
            'description' => $request->description,
            'fabric' => $request->fabric,
            'care' => $request->care,
            'disclaimer' => $request->disclaimer,
            'isFeatures' => $isFeatures ?? 0,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        $InsetedId = DB::table('product')->insertGetId($Data);


        foreach ($request->file('photo') as $file) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $imgName = time() . '_' . mt_rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $destinationPath = $root . '/Product/Thumbnail/';
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $img = Image::make($file->getRealPath());
            if ($img->width() > $img->height()) {
                $img->rotate(270);
            }
            $img->resize(540, 720, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $imgName);



            $destinationpath = $root . '/Product/';
            $file->move($destinationpath, $imgName);

            $data = array(
                'productid' => $InsetedId,
                'strphoto' => $imgName,
                'strIP' => $request->ip(),
                'created_at' => date('Y-m-d H:i:s'),
            );
            DB::table('productphotos')->insert($data);
        }

        return redirect()->route('product.index')->with('success', 'Product Created Successfully.');
    }

    public function GetSelectedSubCategory(Request $request)
    {
        //dd($request);
        $html = "";
        $SubCategory = Category::where(['isDelete' => 0, 'subcategoryid' => $request->Category])->get();
        $html .= '<option value="" selected >Select Sub Category</option>';
        foreach ($SubCategory as $subcategory) {
            if ($request->SubCategory == $subcategory->categoryId) {
                $html .= '<option value=' . $subcategory->categoryId  . ' selected >' . $subcategory->categoryname . '</option>';
            } else {
                $html .= '<option value=' . $subcategory->categoryId . '>' . $subcategory->categoryname . '</option>';
            }
        }
        echo $html;
    }

    public function editview(Request $request, $id)
    {
        $Category = Category::where('subcategoryid', 0)->orderBy('categoryId', 'desc')->get();

        $product = Product::where(['isDelete' => 0, 'productId' => $id])->first();

        $SubCategory = Category::where(['isDelete' => 0, 'categoryId' => $product->subcategoryid])->get();

        return view('product.edit', compact('product', 'Category', 'SubCategory'));
    }

    public function getEditsubcategory(Request $request)
    {
        $html = "";
        $SubCategory = Category::where(['isDelete' => 0, 'subcategoryid' => $request->Category])->get();
        $html .= '<option value="" selected >Select Sub Category</option>';
        foreach ($SubCategory as $subcategory) {
            $html .= '<option value=' . $subcategory->categoryId . '>' . $subcategory->categoryname . '</option>';
        }

        echo $html;
    }

    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'categoryId' => 'required',
            // 'subcategoryid' => 'required',
            'productname' => 'required|unique:product,productname,' . $id . ',productId',
        ]);

        $isFeatures = 0;
        if ($request->isFeatures == "on") {
            $isFeatures = 1;
        }

        $ProductLoverCase = Str::lower($request->productname);
        $ProductName = str_replace(' ', '-', $ProductLoverCase);

        $update = DB::table('product')
            ->where(['isDelete' => 0, 'productId' => $id])
            ->update([
                'categoryId' => $request->categoryId ?? 0,
                'subcategoryid' => $request->subcategoryid ?? 0,
                'productname' => $request->productname,
                'slugname' => $ProductName,
                'description' => $request->description,
                'fabric' => $request->fabric,
                'care' => $request->care,
                'disclaimer' => $request->disclaimer,
                'isFeatures' => $isFeatures ?? 0,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        // dd($update);


        $img = "";
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                $image = $request->file('photo');
                $imgName = time() . '_' . mt_rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $destinationPath = $root . '/Product/Thumbnail/';
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $img = Image::make($file->getRealPath());
                $img->resize(540, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $imgName);

                $destinationpath = $root . '/Product/';
                $file->move($destinationpath, $imgName);

                $data = array(
                    'productid' => $id,
                    'strphoto' => $imgName,
                    'strIP' => $request->ip(),
                    'created_at' => date('Y-m-d H:i:s'),
                );
                DB::table('productphotos')->insert($data);
            }
        }

        return redirect()->route('product.index')->with('success', 'Product Updated Successfully.');
    }

    //Product Index Page Delete
    public function delete(Request $request)
    {
        $delete = DB::table('productphotos')->where(['isDelete' => 0, 'productid' => $request->productId])->get();

        $root = $_SERVER['DOCUMENT_ROOT'];
        $destinationpath = $root . '/Product/';
        $destinationpath1 = $root . '/Product/Thumbnail/';

        foreach ($delete as $deletes) {
            if (file_exists($destinationpath1 . $deletes->strphoto)) {
                unlink($destinationpath1 . $deletes->strphoto);
            }
            if (file_exists($destinationpath . $deletes->strphoto)) {
                unlink($destinationpath . $deletes->strphoto);
            }
        }

        DB::table('productphotos')->where(['isDelete' => 0, 'productId' => $request->productId])->delete();

        DB::table('product')->where(['isDelete' => 0, 'productId' => $request->productId])->delete();

        return redirect()->route('product.index')->with('success', 'Product Deleted Successfully!.');
    }

    //Product Image Delete In Edit Page
    public function productimage(Request $request, $id)
    {
        $delete = DB::table('productphotos')->where(['isDelete' => 0, 'productphotosid' => $id])->first();

        if ($_SERVER['SERVER_NAME'] == "127.0.0.1") {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $destinationpath = $root . '/Product/';
            $destinationpath1 = $root . '/Product/Thumbnail/';
            if (file_exists($destinationpath1 . $delete->strphoto)) {
                unlink($destinationpath1 . $delete->strphoto);
            }
            if (file_exists($destinationpath . $delete->strphoto)) {
                unlink($destinationpath . $delete->strphoto);
            }
        } else {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $destinationpath = $root . '/Product/';
            $destinationpath1 = $root . '/Product/Thumbnail/';

            if (file_exists($destinationpath1 . $delete->strphoto)) {
                unlink($destinationpath1 . $delete->strphoto);
            }
            if (file_exists($destinationpath . $delete->strphoto)) {
                unlink($destinationpath . $delete->strphoto);
            }
        }
        DB::table('productphotos')->where(['isDelete' => 0, 'productphotosid' => $id])->delete();

        echo 1;
    }

    //Product Photos Listing Page
    public function productphotos(Request $request, $id)
    {
        $datas = Productphotos::orderby('productphotosid', 'desc')->where(['isDelete' => 0, 'productid' => $id])->paginate(5);

        return view('product.photoslist', compact('datas'));
    }

    //In Product Photos Listing Page Photo Delete
    public function productphotosdelete(Request $request)
    {
        $delete = DB::table('productphotos')->where(['isDelete' => 0, 'productphotosid' => $request->productphotosid])->first();

        $root = $_SERVER['DOCUMENT_ROOT'];
        $destinationpath = $root . '/Product/';
        $destinationpath1 = $root . '/Product/Thumbnail/';
        if ($delete->strphoto) {
            unlink($destinationpath1  . $delete->strphoto);
        }
        if ($delete->strphoto) {
            unlink($destinationpath  . $delete->strphoto);
        }

        DB::table('productphotos')->where(['isDelete' => 0, 'productphotosid' => $request->productphotosid])->delete();

        return back()->with('success', 'Product Photo Deleted Successfully!.');
    }

    public function product_attribute(Request $request, $id)
    {
        $Product = Product::select(
            'product.*',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo')
        )
            ->orderBy('productId', 'desc')
            ->where(['product.isDelete' => 0, 'product.productId' => $id])
            ->first();

        $ProductAttributes = ProductAttributes::select(
            'product_attributes.id',
            'product_attributes.product_id',
            'product_attributes.product_attribute_id',
            'product_attributes.product_attribute_size',
            'product_attributes.product_attribute_qty',
            'product_attributes.product_attribute_price',
            'product_attributes.product_attribute_price_without_gst',
            'product_attributes.product_attribute_photo',
            'attributes.name'
        )
            ->orderBY('product_attributes.id', 'desc')
            ->where(['product_id' => $id])
            ->join('attributes', 'product_attributes.product_attribute_id', '=', 'attributes.id')
            ->paginate(25);
        // dd($ProductAttributes);
        $Attribute = Attributes::get();

        return view('product.attribute', compact('Product', 'Attribute', 'ProductAttributes', 'id'));
    }

    public function product_attribute_store(Request $request)
    {
        $id = $request->productid;

        $img = "";
        if ($request->hasFile('product_attribute_photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('product_attribute_photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/ProductAttribute/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }

        $ProductAttribute = ProductAttributes::orderBy('id', 'desc')
            ->where(["product_attributes.product_id" => $request->productid, 'product_attributes.product_attribute_size' => $request->product_attribute_size])
            ->first();
        // dd($ProductAttribute);

        if (isset($ProductAttribute) && $ProductAttribute != "" && $ProductAttribute != null) {
            return redirect()->back()->with('error', 'Size Already Exists');
        } else {
            $Data = array(
                'product_id' => $request->productid ?? 0,
                'product_attribute_id' => $request->product_attribute_id ?? 0,
                'product_attribute_size' => $request->product_attribute_size,
                'product_attribute_qty' => $request->product_attribute_qty,
                'product_attribute_price' => $request->product_attribute_price,
                'product_attribute_photo' => $img ?? null,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $product_attributesId = DB::table('product_attributes')->insertGetId($Data);

            $GetProductAttributes = ProductAttributes::where(['id' => $product_attributesId])->first();

            $opening = Ledger::select('openingBalance', 'closingBalance', 'cr', 'dr', 'iProductId', 'iOrderId')
                ->orderBy('ledger.ledgerId', 'DESC')
                ->where([
                    'ledger.iStatus' => 1,
                    'ledger.isDelete' => 0,
                    'iProductId' => $request->productid,
                    'iSize' => $request->product_attribute_size
                ])
                ->first();
            // dd($opening);

            $cr = $request->product_attribute_qty;
            $dr = 0;
            $openingBalance = $opening->closingBalance ?? 0;
            $closing = ($openingBalance + $cr);

            $Inward = array(
                'iProductId' => $request->productid ?? 0,
                'iSize' => $GetProductAttributes->id ?? 0,
                'iQty' => $request->product_attribute_qty,
                'created_at' => date('Y-m-d H:i:s'),
                'strIP' => $request->ip()
            );
            $InsetedId = DB::table('inward')->insertGetId($Inward);

            $Ledger = array(
                'iProductId' => $request->productid ?? 0,
                'iSize' => $GetProductAttributes->id ?? 0,
                'iInwardId' =>  $InsetedId,
                'iOrderId' =>  0,
                'iOrderDetailId' =>  0,
                'openingBalance' => $openingBalance,
                'cr' => $request->product_attribute_qty ?? 0,
                'dr' =>  $dr,
                'closingBalance' =>  $closing,
                'created_at' => date('Y-m-d H:i:s'),
                'strIP' => $request->ip()
            );
            // dd($Ledger);
            DB::table('ledger')->insert($Ledger);

            return redirect()->route('product.product_attribute', $request->productid)->with('success', 'Product Attribute Created Successfully.');
        }
    }

    public function product_attribute_editview(Request $request, $id)
    {
        $ProductAttributes = ProductAttributes::where(['id' => $id])->first();

        echo json_encode($ProductAttributes);
    }

    public function product_attribute_update(Request $request)
    {
        $update = DB::table('product_attributes')
            ->where(['id' => $request->attributeid])
            ->update([
                'product_attribute_price' => $request->product_attribute_price,
                'product_attribute_size' => $request->product_attribute_size,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'Product Attribute Updated Successfully.');
    }

    public function product_attribute_delete(Request $request)
    {

        DB::table('product_attributes')->where(['id' => $request->id])->delete();


        return back()->with('success', 'Product Attribute Deleted Successfully!.');
    }

    public function product_inward(Request $request, $id)
    {
        $Product = Product::select(
            'product.*',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo')
        )
            ->orderBy('productId', 'desc')
            ->where(['product.isDelete' => 0, 'product.productId' => $id])
            ->first();

        $GetSize = ProductAttributes::where(['product_id' => $id])->get();

        $ProductAttributes = Ledger::select(
            'ledger.iInwardId',
            'ledger.iOrderId',
            'ledger.iOrderDetailId',
            'ledger.iSize',
            'ledger.openingBalance',
            'ledger.cr',
            'ledger.dr',
            'ledger.closingBalance',
            'product.productname',
            'product.productId',
            DB::raw('(select product_attributes.product_attribute_size from product_attributes where product_attributes.id=ledger.iSize limit 1) as Size')
        )
            ->orderBY('ledger.ledgerId', 'asc')
            ->where(['iProductId' => $id])
            ->join('product', 'ledger.iProductId', '=', 'product.productId')
            ->paginate(25);
        // dd($ProductAttributes);
        $Attribute = Attributes::get();

        return view('product.inward', compact('Product', 'Attribute', 'ProductAttributes', 'id', 'GetSize'));
    }

    public function product_inward_store(Request $request)
    {
        $opening = Ledger::select('openingBalance', 'closingBalance', 'cr', 'dr', 'iProductId', 'iOrderId')
            ->orderBy('ledger.ledgerId', 'DESC')
            ->where([
                'ledger.iStatus' => 1,
                'ledger.isDelete' => 0,
                'iProductId' => $request->productid,
                'iSize' => $request->iSize
            ])
            ->first();
        // dd($opening);

        $cr = $request->iQty;
        $dr = 0;
        $openingBalance = $opening->closingBalance ?? 0;
        $closing = ($openingBalance + $cr);

        $Inward = array(
            'iProductId' => $request->productid ?? 0,
            'iSize' => $request->iSize ?? 0,
            'iQty' => $request->iQty,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        $InsetedId = DB::table('inward')->insertGetId($Inward);

        $Ledger = array(
            'iProductId' => $request->productid ?? 0,
            'iSize' => $request->iSize ?? 0,
            // 'iInwardId' =>  1,
            'iInwardId' =>  $InsetedId,
            'iOrderId' =>  0,
            'iOrderDetailId' =>  0,
            'openingBalance' => $openingBalance,
            'cr' => $request->iQty ?? 0,
            'dr' =>  $dr,
            'closingBalance' =>  $closing,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        // dd($Ledger);
        DB::table('ledger')->insert($Ledger);

        return back()->with('success', 'Created Successfully.');
    }

    public function product_inward_delete(Request $request)
    {
        DB::table('inward')->where(['inwardId' => $request->inwardId])->delete();

        return back()->with('success', 'Deleted Successfully!.');
    }

    public function updateStatus($product_id, $status)
    {

        $validate = Validator::make([
            'product_id'   => $product_id,
            'status'    => $status
        ], [
            'product_id'   =>  'required|exists:product,productId',
            'status'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('product.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            Product::where('productId', $product_id)->update(['iStatus' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function inwardData(Request $request, $id)
    {
        $data = Ledger::select(
            'ledger.iInwardId',
            'ledger.iOrderId',
            'ledger.iOrderDetailId',
            'ledger.iSize',
            'ledger.openingBalance',
            'ledger.cr',
            'ledger.dr',
            'ledger.closingBalance',
            'product.productname',
            'product.productId',
            DB::raw('(select product_attributes.product_attribute_size from product_attributes where product_attributes.id=ledger.iSize limit 1) as Size')
        )
            ->orderBY('ledger.ledgerId', 'asc')
            ->where(['iProductId' => $id])
            ->join('product', 'ledger.iProductId', '=', 'product.productId')
            ->get();
        DB::commit();
        echo json_encode($data);
    }
}
