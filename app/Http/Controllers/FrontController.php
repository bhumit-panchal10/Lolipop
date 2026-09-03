<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerCouponApplyed;
use App\Models\Gallery;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductAttributes;
use App\Models\Productphotos;
use App\Models\Testimonial;
use App\Models\Shipping;
use App\Models\Setting;
use App\Models\State;
use App\Models\Wishlist;
use App\Models\OtherPages;
use App\Models\Banner;
use App\Models\Ledger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Calculation\Token\Stack;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;


class FrontController extends Controller
{
    public function index(Request $request)
    {
        // Main categories
        $categories = DB::table('category')
            ->select(
                'categoryId',
                'categoryname',
                'photo',
                'meta_description',
                'slugname'
            )
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->where('subcategoryid', 0)
            ->orderBy('categoryId', 'asc')
            ->get();

        // First category
        $firstCategory = $categories->first();

        // First category subcategories
        $subCategories = collect();

        if ($firstCategory) {
            $subCategories = DB::table('category')
                ->select(
                    'categoryId',
                    'subcategoryid',
                    'categoryname',
                    'photo',
                    'meta_description',
                    'slugname'
                )
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->where('subcategoryid', $firstCategory->categoryId)
                ->orderBy('categoryId', 'asc')
                ->get();
        }

        return view('frontview.index', compact(
            'categories',
            'subCategories',
            'firstCategory'
        ));
    }

    public function getSubCategories(Request $request)
    {
        $categoryId = $request->category_id;

        $category = DB::table('category')
            ->select(
                'categoryId',
                'categoryname',
                'slugname',
                'meta_description'
            )
            ->where('categoryId', $categoryId)
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->first();

        $subCategories = DB::table('category')
            ->select(
                'categoryId',
                'subcategoryid',
                'categoryname',
                'slugname',
                'photo',
                'meta_description'
            )
            ->where('subcategoryid', $categoryId)
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->orderBy('categoryId', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'category' => $category,
            'subCategories' => $subCategories
        ]);
    }


    // public function getSubCategories(Request $request)
    // {
    //     $categoryId = $request->category_id;

    //     $category = DB::table('category')
    //         ->select(
    //             'categoryId',
    //             'categoryname',
    //             'meta_description'
    //         )
    //         ->where('categoryId', $categoryId)
    //         ->where('iStatus', 1)
    //         ->where('isDelete', 0)
    //         ->first();

    //     $subCategories = DB::table('category')
    //         ->select(
    //             'categoryId',
    //             'subcategoryid',
    //             'categoryname',
    //             'photo',
    //             'meta_description',
    //             'slugname'
    //         )
    //         ->where('subcategoryid', $categoryId)
    //         ->where('iStatus', 1)
    //         ->where('isDelete', 0)
    //         ->orderBy('categoryId', 'asc')
    //         ->get();

    //     return response()->json([
    //         'status' => true,
    //         'category' => $category,
    //         'subCategories' => $subCategories
    //     ]);
    // }

    public function about(Request $request)
    {
        DB::beginTransaction();
        try {
            return view('frontview.about');
            DB::commit();
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function trackorder(Request $request)
    {
        DB::beginTransaction();
        try {
            return view('frontview.trackorder');
            DB::commit();
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function contactus(Request $request)
    {
        DB::beginTransaction();
        try {
            return view('frontview.contact');
            DB::commit();
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function contact_us(Request $request)
    {
        try {

            $request->validate([
                'first_name'   => 'required|string',
                'last_name'    => 'required|string',
                'email'        => 'required|email',
                'phone_number' => 'required|digits:10',
                'subject'      => 'required',
                'message'      => 'required',
                'captcha'      => 'required|captcha',
            ], [
                'captcha.required' => 'Captcha is required.',
                'captcha.captcha'  => 'Invalid captcha code.',
            ]);


            // Captcha is already validated above
            $data = [
                'first_name'   => $request->first_name,
                'last_name'    => $request->last_name,
                'subject'      => $request->subject,
                'email'        => $request->email,
                'mobileNumber' => $request->phone_number,
                'message'      => $request->message,
                'strIp'        => $request->ip(),
                'created_at'   => now(),
            ];

            DB::table('inquiry')->insert($data);

            $sendEmail = DB::table('sendemaildetails')
                ->where('id', 4)
                ->first();

            $setting = DB::table('setting')
                ->select('email')
                ->first();

            // Contact name
            $fullName = trim($request->first_name . ' ' . $request->last_name);

            // Email HTML template
            $root = $_SERVER['DOCUMENT_ROOT'];

            $htmlBody = file_get_contents(
                $root . '/mailers/contactemail.html'
            );

            $htmlBody = str_replace(
                [
                    '#name',
                    '#email',
                    '#subject',
                    '#mobile',
                    '#message'
                ],
                [
                    $fullName,
                    $data['email'],
                    $data['subject'],
                    $data['mobileNumber'],
                    nl2br(e($data['message']))
                ],
                $htmlBody
            );


            $toMail  = $setting->email ?? null;
            $subject = $sendEmail->strSubject ?? 'New Contact Inquiry';


            if (!$toMail) {
                throw new \Exception(
                    'No recipient email configured in setting.email'
                );
            }


            Mail::html($htmlBody, function ($m) use (
                $toMail,
                $subject,
                $sendEmail
            ) {

                $m->to($toMail)
                    ->subject($subject);

                if (!empty($sendEmail->strFromMail)) {
                    $m->from(
                        $sendEmail->strFromMail,
                        $sendEmail->strTitle ?? ''
                    );
                }
            });


            Log::info("Contact mail sent to {$toMail}");

            return redirect()
                ->route('contactthankyou')
                ->with('success', 'Your inquiry has been submitted successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {

            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Throwable $th) {

            Log::error('Contact inquiry error', [
                'error' => $th->getMessage()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $th->getMessage());
        }
    }

    public function contactthankyou()
    {
        try {
            return view('frontview.contactthankyou');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function products(Request $request, $id = null)
    {
        $currentCategory = null;
        $parentCategoryId = null;

        if ($id) {

            $currentCategory = DB::table('category')
                ->where('slugname', $id)
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->first();

            if ($currentCategory) {

                if ($currentCategory->subcategoryid == 0) {

                    // Parent category
                    $parentCategoryId = $currentCategory->categoryId;
                } else {

                    // Subcategory
                    $parentCategoryId = $currentCategory->subcategoryid;
                }
            }
        }

        $categories = DB::table('category')
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->where('subcategoryid', 0)
            ->when($parentCategoryId, function ($query) use ($parentCategoryId) {

                $query->where('categoryId', $parentCategoryId);
            })
            ->orderBy('created_at', 'desc')
            ->get();




        $subCategories = DB::table('category')
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->where('subcategoryid', '>', 0)
            ->when($parentCategoryId, function ($query) use ($parentCategoryId) {

                $query->where('subcategoryid', $parentCategoryId);
            })
            ->orderBy('created_at', 'desc')
            ->get();


        $sizes = DB::table('product_attributes')
            ->whereNotNull('product_attribute_size')
            ->where('product_attribute_size', '<>', '')
            ->select('product_attribute_size')
            ->distinct()
            ->orderBy('product_attribute_size', 'asc')
            ->pluck('product_attribute_size');


        $Product = Product::select(
            'product.productId',
            'product.categoryId',
            'product.subcategoryid',
            'product.productname',
            'product.rate',
            'product.description',
            'product.slugname',

            DB::raw('(
            SELECT strphoto
            FROM productphotos
            WHERE productphotos.productid = product.productId
            LIMIT 1
        ) as photo'),

            DB::raw('(
            SELECT COALESCE(
                MIN(product_attribute_price), 0
            )
            FROM product_attributes
            WHERE product_attributes.product_id = product.productId
        ) as product_attribute_price'),
            DB::raw('(
            SELECT id
            FROM product_attributes
            WHERE product_attributes.product_id = product.productId
            ORDER BY product_attribute_price ASC, id ASC
            LIMIT 1
        ) as lowest_attribute_id'),
            DB::raw('(
            SELECT product_attribute_size
            FROM product_attributes
            WHERE product_attributes.product_id = product.productId
            ORDER BY product_attribute_price ASC, id ASC
            LIMIT 1
        ) as lowest_attribute_size')
        )
            ->join(
                'category',
                'category.categoryId',
                '=',
                'product.categoryId'
            )
            ->where('product.iStatus', 1)
            ->where('product.isDelete', 0);


        if ($currentCategory) {

            // Parent category
            if ($currentCategory->subcategoryid == 0) {

                $Product->where(
                    'product.categoryId',
                    $currentCategory->categoryId
                );
            } else {

                // Subcategory
                $Product->where(
                    'product.categoryId',
                    $currentCategory->subcategoryid
                );

                $Product->where(
                    'product.subcategoryid',
                    $currentCategory->categoryId
                );
            }
        }

        $parentCategories = array_values(array_filter((array) $request->input('category', []), 'is_numeric'));
        $subCategoriesFilter = array_values(array_filter((array) $request->input('subcategory', []), 'is_numeric'));
        $priceRanges = array_filter((array) $request->input('price', []), function ($range) {
            return is_string($range) && preg_match('/^\d+(?:-\d+)?$/', $range);
        });
        $selectedSizes = array_values(array_filter((array) $request->input('size', []), function ($size) {
            return is_scalar($size) && trim((string) $size) !== '';
        }));

        if ($parentCategories || $subCategoriesFilter) {
            $Product->where(function ($query) use ($parentCategories, $subCategoriesFilter) {
                if ($parentCategories) {
                    $query->whereIn('product.categoryId', $parentCategories);
                }

                if ($subCategoriesFilter) {
                    $method = $parentCategories ? 'orWhere' : 'where';
                    $query->{$method . 'In'}('product.subcategoryid', $subCategoriesFilter);
                }
            });
        }

        if ($priceRanges) {
            $priceConditions = [];
            $priceBindings = [];
            foreach ($priceRanges as $range) {
                [$minimum, $maximum] = array_pad(explode('-', $range, 2), 2, null);
                $priceConditions[] = 'product_attribute_price between ? and ?';
                $priceBindings[] = (int) $minimum;
                $priceBindings[] = $maximum !== null ? (int) $maximum : PHP_INT_MAX;
            }

            $Product->whereRaw(
                'product.productId in (select product_id from product_attributes where ' . implode(' or ', $priceConditions) . ')',
                $priceBindings
            );
        }

        if ($selectedSizes) {
            $Product->whereExists(function ($query) use ($selectedSizes) {
                $query->select(DB::raw(1))
                    ->from('product_attributes')
                    ->whereColumn('product_attributes.product_id', 'product.productId')
                    ->whereIn('product_attribute_size', $selectedSizes);
            });
        }



        switch ($request->sort) {

            case 'low':

                $Product->orderBy(
                    'product_attribute_price',
                    'asc'
                );

                break;

            case 'high':

                $Product->orderBy(
                    'product_attribute_price',
                    'desc'
                );

                break;

            default:

                $Product->orderBy(
                    'product.productId',
                    'desc'
                );

                break;
        }



        $Product = $Product
            ->paginate(16)
            ->withQueryString();


        $ProductCount = $Product->total();



        return view('frontview.product', compact(
            'Product',
            'ProductCount',
            'categories',
            'subCategories',
            'sizes',
            'id',
            'currentCategory',
            'parentCategoryId'
        ));
    }

    // public function products(Request $request, $id = null)
    // {
    //     DB::beginTransaction();
    //     try {

    //         // $sizeselect = "";
    //         // if ((isset($request->sizeselect) && $request->sizeselect != null) || Session::get('sizeselect')) {
    //         //     //dd("if");
    //         //     if (isset($request->sizeselect) && $request->sizeselect != "") {
    //         //         $sizeselect = $request->sizeselect;
    //         //         //Session::put('sizeselect',$sizeselect);
    //         //     } else if (Session::get('sizeselect')) {
    //         //         $sizeselect = Session::get('sizeselect');
    //         //     } else {
    //         //         $sizeselect = $request->session()->forget('sizeselect');
    //         //     }
    //         //     $Product = Product::leftJoin('product_attributes', 'product.productId', '=', 'product_attributes.product_id')
    //         //         ->leftJoin('ledger', function ($join) {
    //         //             $join->on('product.productId', '=', 'ledger.iProductId')
    //         //                 ->on('product_attributes.id', '=', 'ledger.iSize')
    //         //                 ->whereRaw('ledger.ledgerId = (SELECT MAX(ledgerId) FROM ledger WHERE ledger.iProductId = product.productId AND ledger.iSize = product_attributes.id)');
    //         //         })
    //         //         ->leftJoin('productphotos', 'product.productId', '=', 'productphotos.productid')
    //         //         ->select(
    //         //             'product_attributes.id',
    //         //             'product.productId',
    //         //             'product.categoryId',
    //         //             'product.subcategoryid',
    //         //             'product.productname',
    //         //             'product.rate',
    //         //             'product.description',
    //         //             'product.slugname',
    //         //             DB::raw('(SELECT strphoto FROM productphotos WHERE productphotos.productid = product.productId LIMIT 1) as photo'),
    //         //             'product_attributes.product_attribute_price',
    //         //             'ledger.closingBalance',
    //         //             'product_attributes.product_attribute_size'
    //         //         )
    //         //         ->when($sizeselect, function ($query) use ($sizeselect) {
    //         //             $query->Where('product_attributes.product_attribute_size', $sizeselect);
    //         //         })
    //         //         //->where('product_attributes.product_attribute_size', $sizeselect)
    //         //         ->where('product.iStatus', 1)
    //         //         ->where('product.isDelete', 0)
    //         //         ->where('ledger.closingBalance', '>', 0)
    //         //         ->whereIn('product.categoryId', function ($query) {
    //         //             $query->select('categoryId')
    //         //                 ->from('category')
    //         //                 ->where('isDelete', 0)
    //         //                 ->where('iStatus', 1);
    //         //         })
    //         //         ->groupBy(
    //         //             'product_attributes.id',
    //         //             'product.productId',
    //         //             'product.categoryId',
    //         //             'product.subcategoryid',
    //         //             'product.productname',
    //         //             'product.rate',
    //         //             'product.description',
    //         //             'product.slugname',
    //         //             'product_attributes.product_attribute_price',
    //         //             'product_attributes.product_attribute_size',
    //         //             'ledger.closingBalance'
    //         //         )->orderBy('productId', 'desc')
    //         //         ->paginate(16);
    //         //     // dd($Product);
    //         //     $ProductCount = $Product->count();
    //         // } else if ($id == null) {
    //         //     //dd("else if");
    //         //     $Product = Product::select(
    //         //         'product.productId',
    //         //         'product.categoryId',
    //         //         'product.subcategoryid',
    //         //         'product.productname',
    //         //         'product.rate',
    //         //         'product.description',
    //         //         'product.slugname',
    //         //         DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId LIMIT 1) as photo'),
    //         //         DB::raw('(SELECT COALESCE(MIN(product_attribute_price), 0) FROM product_attributes WHERE  product_attributes.product_id=product.productId   LIMIT 1) as product_attribute_price')
    //         //         // DB::raw('(SELECT MIN(product_attribute_price)  FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price'),
    //         //         //DB::raw('(SELECT COUNT(*) FROM ledger WHERE ledger.ledgerId IN (SELECT MAX(ledgerId) FROM ledger WHERE ledger.iProductId=product.productId GROUP BY iSize) AND ledger.closingBalance > 0) as closingBalance')
    //         //     )
    //         //         ->join('category', 'category.categoryId', '=', 'product.categoryId')
    //         //         ->orderBy('productId', 'desc')
    //         //         ->where(['product.iStatus' => 1, 'product.isDelete' => 0])
    //         //         // ->whereIn('categoryId', function ($query) {
    //         //         //     $query->select('categoryId')
    //         //         //         ->from('category')
    //         //         //         ->where('isDelete', 0)
    //         //         //         ->where('iStatus', 1);
    //         //         // })
    //         //         ->paginate(16);

    //         /*$Product = Product::select(
    //                 'product.productId',
    //                 'product.categoryId',
    //                 'product.subcategoryid',
    //                 'product.productname',
    //                 'product.rate',
    //                 'product.description',
    //                 'product.slugname',
    //                 DB::raw('productphotos.strphoto as photo'),
    //                 DB::raw('COALESCE(MIN(product_attributes.product_attribute_price), 0) as product_attribute_price'),
    //                 DB::raw('COUNT(DISTINCT ledger.iSize) as closingBalance')
    //             )
    //             ->leftJoin('productphotos', 'product.productId', '=', 'productphotos.productid')
    //             ->leftJoin('product_attributes', 'product.productId', '=', 'product_attributes.product_id')
    //             ->leftJoin('ledger', function ($join) {
    //                 $join->on('product.productId', '=', 'ledger.iProductId')
    //                     ->whereRaw('ledger.ledgerId IN (SELECT MAX(ledgerId) FROM ledger GROUP BY iSize)')
    //                     ->where('ledger.closingBalance', '>', 0);
    //             })
    //             ->where('product.iStatus', 1)
    //             ->where('product.isDelete', 0)
    //             ->whereIn('product.categoryId', function ($query) {
    //                 $query->select('categoryId')
    //                     ->from('category')
    //                     ->where('isDelete', 0)
    //                     ->where('iStatus', 1);
    //             })
    //             ->groupBy(
    //                 'product.productId',
    //                 'product.categoryId',
    //                 'product.subcategoryid',
    //                 'product.productname',
    //                 'product.rate',
    //                 'product.description',
    //                 'product.slugname',
    //                 'productphotos.strphoto'
    //             )
    //             ->orderBy('product.productId', 'desc')
    //             ->paginate(16);*/
    //         // dd($Product);
    //         //     $ProductCount = $Product->count();
    //         //     DB::disconnect();
    //         // } else {
    //         //     //dd("else");
    //         //     $Product = Product::select(
    //         //         'product.productId',
    //         //         'product.productname',
    //         //         'product.rate',
    //         //         'product.weight',
    //         //         'product.description',
    //         //         'product.isFeatures',
    //         //         'product.isStock',
    //         //         'product.slugname',
    //         //         DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo'),
    //         //         DB::raw('(SELECT COALESCE(MIN(product_attribute_price), 0) FROM product_attributes WHERE  product_attributes.product_id=product.productId LIMIT 1) as product_attribute_price'),
    //         //         // DB::raw('(SELECT MIN(product_attribute_price)  FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price'),
    //         //         DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId LIMIT 1,1) as backphoto')
    //         //     )
    //         //         ->orderBy('productId', 'desc')
    //         //         ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'category.slugname' => $id])
    //         //         ->join('category', 'product.categoryId', '=', 'category.categoryId')
    //         //         ->paginate(16);
    //         //     $ProductCount = $Product->count();
    //         //     // dd($Product);

    //         // }
    //         //$sizeselect = $request->sizeselect ?? "";
    //         //$request->session()->put('sizeselect', $sizeselect);
    //         // dd($Product);
    //         DB::commit();
    //         // return view('frontview.product', compact('Product',  'id', 'ProductCount', 'sizeselect'));
    //         return view('frontview.product');
    //     } catch (\Throwable $th) {
    //         // Rollback and return with Error
    //         DB::rollBack();
    //         return redirect()->back()->withInput()->with('error', $th->getMessage());
    //     }
    // }

    public function loadMoreProducts(Request $request)
    {
        DB::beginTransaction();
        try {
            $page = $request->page; // Get the page number from the request
            $perPage = 16; // Number of products per page
            $offset = ($page - 1) * $perPage; // Calculate the offset for pagination
            if (isset($request->sizeselect) && $request->sizeselect != null) {
                //dd("sizeselect");
                $products = Product::leftJoin('product_attributes', 'product.productId', '=', 'product_attributes.product_id')
                    ->leftJoin('ledger', function ($join) {
                        $join->on('product.productId', '=', 'ledger.iProductId')
                            ->on('product_attributes.id', '=', 'ledger.iSize')
                            ->whereRaw('ledger.ledgerId = (SELECT MAX(ledgerId) FROM ledger WHERE ledger.iProductId = product.productId AND ledger.iSize = product_attributes.id)');
                    })
                    ->leftJoin('productphotos', 'product.productId', '=', 'productphotos.productid')
                    ->select(
                        'product_attributes.id',
                        'product.productId',
                        'product.categoryId',
                        'product.subcategoryid',
                        'product.productname',
                        'product.rate',
                        'product.description',
                        'product.slugname',
                        DB::raw('(SELECT strphoto FROM productphotos WHERE productphotos.productid = product.productId LIMIT 1) as photo'),
                        'product_attributes.product_attribute_price',
                        'ledger.closingBalance',
                        'product_attributes.product_attribute_size'
                    )
                    ->where('product_attributes.product_attribute_size', $request->sizeselect)
                    ->where('product.iStatus', 1)
                    ->where('product.isDelete', 0)
                    ->where('ledger.closingBalance', '>', 0)
                    ->whereIn('product.categoryId', function ($query) {
                        $query->select('categoryId')
                            ->from('category')
                            ->where('isDelete', 0)
                            ->where('iStatus', 1);
                    })
                    ->groupBy(
                        'product_attributes.id',
                        'product.productId',
                        'product.categoryId',
                        'product.subcategoryid',
                        'product.productname',
                        'product.rate',
                        'product.description',
                        'product.slugname',
                        'product_attributes.product_attribute_price',
                        'product_attributes.product_attribute_size',
                        'ledger.closingBalance'
                    )
                    // ->whereIn('subcategoryId', function($query) {
                    //     $query->select('categoryId')
                    //         ->from('category')
                    //         ->where('isDelete', 0)
                    //         ->where('iStatus', 1);
                    // })
                    ->offset($offset) // Apply pagination offset
                    ->limit($perPage) // Apply pagination limit
                    ->get();
                // dd($Product);
                //$ProductCount = $Product->count();
            } else {
                $products = Product::select(
                    'product.productId',
                    'product.categoryId',
                    'product.subcategoryid',
                    'product.productname',
                    'product.rate',
                    'product.description',
                    'product.slugname',
                    DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                    DB::raw('(SELECT COALESCE(MIN(product_attribute_price), 0) FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price'),
                    // DB::raw('(SELECT MIN(product_attribute_price)  FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price'),
                    DB::raw('(SELECT COUNT(*) FROM ledger WHERE ledger.ledgerId IN (SELECT MAX(ledgerId) FROM ledger WHERE iProductId=product.productId GROUP BY iSize) AND ledger.closingBalance > 0) as closingBalance')
                )
                    ->orderBy('productId', 'desc')
                    ->where(['product.iStatus' => 1, 'product.isDelete' => 0])
                    ->join('category', 'category.categoryId', '=', 'product.categoryId')
                    // ->whereIn('categoryId', function ($query) {
                    //     $query->select('categoryId')
                    //         ->from('category')
                    //         ->where('isDelete', 0)
                    //         ->where('iStatus', 1);
                    // })
                    // ->whereIn('subcategoryId', function($query) {
                    //     $query->select('categoryId')
                    //         ->from('category')
                    //         ->where('isDelete', 0)
                    //         ->where('iStatus', 1);
                    // })
                    ->offset($offset) // Apply pagination offset
                    ->limit($perPage) // Apply pagination limit
                    ->get();
            }
            //DB::disconnect();
            DB::commit();
            return response()->json(['products' => $products]);
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }


    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }


    public function checkout(Request $request)
    {
        DB::beginTransaction();
        try {
            $Coupon = $request->session()->get('data');

            $session = Session::get('customerid');

            $cartItems = \Cart::getContent();
            // dd($cartItems);
            // dd($cartItems->items['size']);
            $Shipping = Shipping::orderBy('id', 'desc')->first();

            $State = State::orderBy('stateName', 'asc')->get();

            return view('frontview.checkout', compact('Shipping', 'Coupon', 'State', 'cartItems'));
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function checkoutstore(Request $request)
    {

        $request->validate([
            'billPhone' => 'required|digits:10',
            'billFirstName' => 'required',
            'billLastName' => 'required',
            'billEmail' => 'required|email',
            'billStreetAddress1' => 'required',
            'billStreetAddress2' => 'required',
            'billState' => 'required',
            'shipping_city' => 'required',
            'strCountry' => 'required',
            'billPinCode' => 'required|digits:6',
        ], [
            'billPhone.required' => 'Please enter your phone number.',
            'billPhone.digits' => 'Phone number must be exactly 10 digits.',
            'billFirstName.required' => 'Please enter your first name.',
            'billLastName.required' => 'Please enter your last name.',
            'billEmail.required' => 'Please enter your email address.',
            'billEmail.email' => 'Please enter a valid email address.',
            'billStreetAddress1.required' => 'Address Line 1 is required.',
            'billStreetAddress2.required' => 'Address Line 2 is required.',
            'billState.required' => 'Please select your state.',
            'shipping_city.required' => 'Please enter your city.',
            'strCountry.required' => 'Country is required.',
            'billPinCode.required' => 'Please enter your postal code.',
            'billPinCode.digits' => 'Postal code must be exactly 6 digits.',
        ]);
        // dd($request->all());
        // DB::beginTransaction();
        // try {
        $cartItems = \Cart::getContent();

        $amount = \Cart::getTotal();

        $Mobile = Customer::where(['isDelete' => 0, 'iStatus' => 1, 'customermobile' => $request->billPhone])->first();
        // dd($Mobile);
        // foreach ($cartItems as $cartItem) {

        //      $Ledger = Ledger::orderBy('ledgerId', 'desc')->where([
        //             'ledger.iStatus' => 1, 'ledger.isDelete' => 0, 'ledger.iProductId' => $cartItem->productid, 'iSize' => $cartItem->size
        //         ])
        //         ->join('product_attributes', 'ledger.iSize', '=', 'product_attributes.id')
        //         ->first();
        //     $closingBalance = (int)$Ledger->closingBalance;

        //     $specificId = $cartItem->id;
        //     $count = $cartItem->filter(function ($item) use ($specificId) {
        //         return $item->id === $specificId;
        //     })->sum('quantity');

        //     if (isset($Ledger) &&  ($closingBalance * 1) > ($count * 1)) {

        //     }

        // }

        $status = $cartItems->isNotEmpty();
        foreach ($cartItems as $cartItem) {
            $ledger = Ledger::where([
                'ledger.iStatus' => 1,
                'ledger.isDelete' => 0,
                'ledger.iProductId' => $cartItem->productid,
                'ledger.iSize' => $cartItem->id,
            ])
                ->orderByDesc('ledger.ledgerId')
                ->first();

            $closingBalance = (int) ($ledger->closingBalance ?? 0);
            if ($closingBalance < (int) $cartItem->quantity) {
                $status = false;
                break;
            }
        }

        if ($status == true) {

            $customerid = 0;
            $uniqueNumber = Str::random(16);
            if ($Mobile == null) {
                $Order = array(
                    'firstname' => $request->billFirstName,
                    'lastname' =>  $request->billLastName,
                    'customername' => $request->billFirstName . ' ' . $request->billLastName,
                    'guid' => $uniqueNumber,
                    'customermobile' => $request->billPhone,
                    'customermobile1' => $request->billPhone1,
                    'customeremail' => $request->billEmail,

                    'address' => $request->billStreetAddress1,
                    'address1' => $request->billStreetAddress2,
                    'state' => $request->billState,
                    'city' => $request->shipping_city,
                    'pincode' => $request->billPinCode,
                    'country' => $request->strCountry,
                    'created_at' => date('Y-m-d H:i:s'),
                    'strIP' => $request->ip()
                );
                $customerid = DB::table('customer')->insertGetId($Order);
            } else {
                $customerid = $Mobile->customerid;
            }

            $Order = array(
                'customerid' => $customerid,
                'shipping_cutomerName' => $request->billFirstName . ' ' . $request->billLastName,
                // 'shipping_companyName' => $request->billCompanyName,
                'shipping_mobile' => $request->billPhone,
                'shipping_mobile1' => $request->billPhone1,
                'shipping_email' => $request->billEmail,
                'shiiping_address1' => $request->billStreetAddress1,
                'shiiping_address2' => $request->billStreetAddress2,
                'shipping_city' => $request->shipping_city,
                'shiiping_state' => $request->billState,
                'shipping_pincode' => $request->billPinCode,
                // 'orderNote' => $request->billNotes,
                'country' => $request->strCountry,
                'amount' => $amount,
                // 'discount' => $request->discount,
                // 'shipping_Charges' => $request->shippingcharges,
                'netAmount' => $amount,
                'created_at' => date('Y-m-d H:i:s'),
                'strIP' => $request->ip()
            );
            $OrderId = DB::table('order')->insertGetId($Order);
            // try {
            //     DB::enableQueryLog();
            //     $OrderId = DB::table('order')->insertGetId($Order);
            //     Log::info('Insert Query:', DB::getQueryLog());
            //     // Output the Order ID
            //     dd($OrderId);
            // } catch (\Exception $e) {
            //     // Log the error
            //     Log::error('Error inserting order:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            //     // Output the error message
            //     dd('Error inserting order: ' . $e->getMessage());
            // }
            foreach ($cartItems as $cartItem) {
                $OrderDetail = array(
                    'orderID' => $OrderId,
                    'customerid' => $customerid,
                    'categoryId' => $cartItem->categoryId,
                    'subcategoryid' => $cartItem->subcategoryid,
                    'productId' => $cartItem->productid,
                    'quantity' => $cartItem->quantity,
                    'size' => $cartItem->size,
                    'rate' => $cartItem->price,
                    'info' => $cartItem->info,
                    'amount' => $cartItem->price * $cartItem->quantity,
                    'created_at' => date('Y-m-d H:i:s'),
                    "strIP" => $request->ip()
                );
                $GetId = DB::table('orderdetail')->insertGetId($OrderDetail);
            }
            return redirect()->route('razorpay.index', $OrderId);
        } else {
            session()->flash('outofstock', 'Product is Out Of Stock!');
            return back()->with('error', 'Some Product is Out Of Stock!');
        }
        //DB::commit();
        // } catch (\Throwable $th) {

        //     // Rollback & Return Error Message
        //     //DB::rollBack();
        //     return redirect()->back()->with('error', $th->getMessage());
        // }
    }

    public function payment_success()
    {
        return view('frontview.payment_success');
    }

    public function payment_fail()
    {
        return view('frontview.payment_fail');
    }

    public function frontlogin(Request $request)
    {
        return view('frontview.login');
    }

    public function frontloginstore(Request $request)
    {
        $request->validate(
            [
                'customermobile' => 'required',
            ],
            [
                'customermobile.required' => 'Mobile is required!',
            ]
        );
        try {
            $Customer = Customer::where('customermobile', $request->get('customermobile'))->first();

            if (isset($Customer) && (!empty($Customer))) {
                $uniqueNumber = Str::random(16);
                $otp = mt_rand(100000, 999999);

                $update = Customer::where('customerid', $Customer->customerid)
                    ->update([
                        'otp' => $otp,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                $MobileNumber = $request->customermobile;
                $Setting = Setting::where(["id" => 1])->first();
                $key = $Setting->api_key;
                $msg = "Your OTP for login to https://TheWardrobeFashion.in is " . $otp . ". Do not share this code with anyone. – The Wardrobe Fashion.";

                $customer = new Customer();
                //$status = $customer->WhatsappMessage($MobileNumber, $msg);
                $status = $customer->sendMessage($MobileNumber, $msg, "1707176528866290420");

                if (!empty($Customer->customeremail)) {

                    \Mail::raw($msg, function ($message) use ($Customer) {
                        $message->to($Customer->customeremail)
                            ->subject('Your Login OTP – The Wardrobe Fashion');
                    });

                    // dd("Email Sent To: " . $Customer->customeremail, $msg);
                }

                // dd($status);
                return redirect()->route('FrontOtp', $Customer->guid);
            } else {

                return back()->with('notregister', 'Mobile Is Not Registered');
            }
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function register(Request $request)
    {
        return view('frontview.register');
    }

    public function registerstore(Request $request)
    {
        try {
            $request->validate(
                [
                    'customername' => 'required',
                    'customeremail' => 'required',
                    'customermobile' => 'required|unique:customer,customermobile|numeric|digits:10',
                    'captcha' => 'required'
                ],
                [
                    'captcha.required' => 'Captcha is required!',
                    'customername.required' => 'Name is required!',
                    'customeremail.required' => 'Email is required!',
                    'customeremail.unique'    => 'Email is already used!',
                    'customermobile.required' => 'Mobile is required!',
                    'customermobile.unique'    => 'Mobile is already used!',
                    'customermobile.numeric'    => 'Mobile is only numeric allowed!',
                    'customermobile.digits'    => 'Mobile is only 10 digits allowed!'
                ]
            );

            $password = $request->password;
            $confirmpass = $request->confirmpassword;

            $userInput = $request->input('captcha');
            $captcha = session('captcha');

            if ($userInput === $captcha) {
                // dd('if');
                if ($password == $confirmpass) {
                    $uniqueNumber = Str::random(16);
                    $otp = mt_rand(100000, 999999);

                    $Data = array(
                        'customername' => $request->customername,
                        'guid' => $uniqueNumber,
                        'otp' => $otp,
                        'customermobile' => $request->customermobile,
                        'customermobile1' => $request->customermobile1,
                        'customeremail' => $request->customeremail,
                        'created_at' => date('Y-m-d H:i:s'),
                        "strIP" => $request->ip()
                    );
                    $InsertedId = DB::table('customer')->insertGetId($Data);

                    $MobileNumber = $request->customermobile;
                    $Setting = Setting::where(["id" => 1])->first();
                    $key = $Setting->api_key;
                    $msg = "Hello , Welcome To The Store. Your OTP is $otp";
                    $customer = new Customer();
                    $status = $customer->WhatsappMessage($MobileNumber, $key, $msg, $InsertedId);
                    // dd($status);
                    return redirect()->route('FrontOtp', $uniqueNumber);
                } else {
                    return back()->with('error', 'Something Went Wrong!');
                }
            } else {
                // dd('else');
                // return back()->with('invalidcaptcha', 'Invalid captcha code!');
                return redirect()->route('FrontRegister')->with('invalidcaptcha', 'Invalid captcha code!');
            }
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function otp(Request $request, $guid)
    {
        return view('frontview.otp', compact('guid'));
    }

    public function otpsubmit(Request $request)
    {
        try {
            $request->validate(
                [
                    'otp' => 'required',
                ],
                [
                    'otp.required' => 'OTP is required!',
                ]
            );

            $Customer = Customer::where('guid', $request->guid)->first();

            if (isset($Customer) && (!empty($Customer))) {
                if ($Customer->otp == $request->otp) {
                    $request->session()->put('customerid', $Customer->customerid);
                    $request->session()->put('customername', $Customer->customername);
                    $request->session()->put('customermobile', $Customer->customermobile);
                    $request->session()->put('customermobile1', $Customer->customermobile1);
                    $request->session()->put('customeremail', $Customer->customeremail);
                    return redirect()->route('myorders');
                } else {
                    return back()->with('otpnotmatch', 'OTP Is Not Match');
                }
            } else {
                return back()->with('error', 'Customer Is Not Registered');
            }
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function profile(Request $request)
    {
        try {
            if ($request->session()->get('customerid') != "") {
                return view('frontview.profile');
            } else {
                return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
            }
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function myaccount(Request $request)
    {
        try {
            if ($request->session()->get('customerid') != "") {
                return view('frontview.myaccount');
            } else {
                return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
            }
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function myaccountedit(Request $request)
    {
        try {
            $session = Session::get('customerid');
            $request->session()->forget('customername');
            $request->session()->forget('customeremail');
            $request->session()->forget('customermobile');
            // dd($session);

            // $request->validate(
            //     [
            //         'customeremail' => 'unique:customer,customeremail,' . $session . ',customerid',
            //         'customermobile' => 'unique:customer,customermobile' . $session . ',customerid',
            //     ],
            //     [
            //         'customeremail.unique'    => 'Email is already used!',
            //         'customermobile.unique'    => 'Mobile is already used!',
            //     ]
            // );

            $update = DB::table('customer')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $session])
                ->update([
                    'customername' => $request->customername,
                    'customeremail' => $request->customeremail,
                    'customermobile' => $request->customermobile,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            // dd($update);
            $request->session()->put('customername', $request->customername);
            $request->session()->put('customeremail', $request->customeremail);
            $request->session()->put('customermobile', $request->customermobile);

            return back()->with('myaccountupdatesuccess', 'Profile Updated Successfully!');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function changepassword(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            return view('frontview.changepassword');
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }

    public function changepasswordsubmit(Request $request)
    {
        try {
            $session = Session::get('customerid');
            $newpassword = $request->newpassword;
            $confirmpassword = $request->confirmpassword;

            if ($newpassword == $confirmpassword) {
                $Student = DB::table('customer')
                    ->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $session])
                    ->update([
                        'password' => Hash::make($request->confirmpassword),
                    ]);
                return back()->with('passwordsuccess', 'Change Password Successfully!');
            } else {
                return back()->with('passworderror', 'Password And Confirm Password Not Match!');
            }
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function myorders(Request $request)
    {

        if (!$request->session()->get('customerid')) {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }

        $session = Session::get('customerid');

        $Customer = Customer::where(["customerid" => $session])->first();
        $OrderId = $request->order_id;
        $PhoneNo = $request->phone_no;

        // Base query
        $query = Order::select(
            'order.*',
            'courier.name as courier_name',
            'courier.url',
            'order.docketNo',
        )
            ->where([
                'order.iStatus' => 1,
                'order.isDelete' => 0,
                'order.customerid' => $session
            ])
            ->leftJoin('courier', 'order.courier', '=', 'courier.id')
            ->orderBy('order.order_id', 'DESC');


        // Apply filters only if search fields are used
        if ($OrderId || $PhoneNo) {
            $query->when($OrderId, fn($q) => $q->where('order.order_id', $OrderId))
                ->when($PhoneNo, fn($q) => $q->where('order.shipping_mobile', 'like', "%{$PhoneNo}%"));
        }

        // Use pagination instead of get()
        $Order = $query->get();


        return view('frontview.myorders', compact('Order', 'Customer'));
    }

    public function myordersdetails(Request $request, $id)
    {
        try {
            if ($request->session()->get('customerid') != "") {
                $session = Session::get('customerid');
                $Order = OrderDetail::select(
                    'orderdetail.orderID',
                    'orderdetail.created_at',
                    'orderdetail.quantity',
                    'orderdetail.weight',
                    'orderdetail.rate',
                    // 'orderdetail.size',
                    'orderdetail.amount',
                    'product.productname',
                    DB::raw('(SELECT product_attribute_size FROM product_attributes WHERE  product_attributes.id=orderdetail.size  LIMIT 1) as size'),
                    DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo')
                )
                    ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.customerid' => $session, 'orderdetail.orderID' => $id])
                    ->join('product', 'orderdetail.productId', '=', 'product.productId')
                    ->get();
                // dd($Order);
                echo json_encode($Order);
                // return view('frontview.myordersdetails', compact('Order'));
            } else {
                return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
            }
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function mywishlistpage(Request $request)
    {
        try {
            if ($request->session()->get('customerid') != "") {
                $session = Session::get('customerid');
                $wishlist = wishlist::select(
                    'product.productId',
                    'product.productname',
                    'product.slugname',
                    'wishlist.price',
                    DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo'),
                )
                    ->orderBY('id', 'desc')
                    ->where(['wishlist.iStatus' => 1, 'wishlist.isDelete' => 0, 'wishlist.customerid' => $session])
                    ->join("product", "wishlist.productid", '=', 'product.productId')
                    ->get();
                // dd($wishlist);

                return view('frontview.mywishlist', compact('wishlist'));
            } else {
                return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
            }
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function addwishlist(Request $request)
    {
        try {
            $session = Session::get('customerid');
            $wishlist = Wishlist::where(['wishlist.iStatus' => 1, 'wishlist.isDelete' => 0, 'wishlist.customerid' => $session, 'productid' => $request->productid])
                ->count();

            if (isset($session) && (!empty($session))) {
                if ($wishlist == 0) {
                    $data = array(
                        "customerid" => $session,
                        "productid" => $request->productid,
                        "price" => $request->product_attribute_size,
                        'created_at' => date('Y-m-d H:i:s'),
                        'strIP' => $request->ip()
                    );
                    wishlist::create($data);
                    return back()->with('wishlistsuccess', 'Product Added To Wishlist!');
                } else {
                    return back()->with('wishlisterror', 'Product Is Already In Your Wishlist');
                }
            } else {
                return redirect()->route('FrontLogin');
            }
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }


    public function bindpriceonsize(Request $request)
    {
        try {
            $Data = Ledger::orderBy('ledgerId', 'desc')->where([
                'ledger.iStatus' => 1,
                'ledger.isDelete' => 0,
                'ledger.iProductId' => $request->productid,
                'iSize' => $request->size
            ])
                ->join('product_attributes', 'ledger.iSize', '=', 'product_attributes.id')
                ->first();
            // dd($Data);

            return  json_encode($Data);
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function productdetail(Request $request, $category = null, $id = null)
    {
        try {
            if (!$id) {
                $legacyProduct = Product::where('slugname', $category)
                    ->where('iStatus', 1)
                    ->where('isDelete', 0)
                    ->firstOrFail();
                $id = $legacyProduct->slugname;
                $category = Category::where('categoryId', $legacyProduct->subcategoryid)->value('slugname');
            }

            $subcategory = Category::where('slugname', $category)
                ->where('subcategoryid', '>', 0)
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->firstOrFail();

            $ProductDetail = Product::where('slugname', $id)
                ->where('subcategoryid', $subcategory->categoryId)
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->firstOrFail();

            $parentCategory = Category::where('categoryId', $subcategory->subcategoryid)
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->first();

            $Attribute = ProductAttributes::where('product_id', $ProductDetail->productId)
                ->orderBy('product_attribute_size')
                ->get();

            $Photos = Productphotos::where('productid', $ProductDetail->productId)
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->get();

            return view('frontview.productdetail', compact(
                'ProductDetail',
                'Photos',
                'Attribute',
                'subcategory',
                'parentCategory'
            ));
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function CancellationandRefund()
    {
        $datas = OtherPages::where(['iStatus' => 1, 'isDelete' => 0, 'id' => 2])->first();
        return view('frontview.CancellationandRefund', compact('datas'));
    }

    public function ShippingandDelivery()
    {
        $datas = OtherPages::where(['iStatus' => 1, 'isDelete' => 0, 'id' => 3])->first();
        return view('frontview.ShippingandDelivery', compact('datas'));
    }

    public function termandcondition()
    {
        $datas = OtherPages::where(['iStatus' => 1, 'isDelete' => 0, 'id' => 1])->first();
        //return view('frontview.termandcondition', compact('datas'));
        return view('frontview.termandcondition');
    }

    public function privacypolicy()
    {
        $datas = OtherPages::where(['iStatus' => 1, 'isDelete' => 0, 'id' => 4])->first();
        return view('frontview.privacypolicy', compact('datas'));
    }

    public function noReturnNoExchange()
    {
        try {
            $datas = OtherPages::where(['iStatus' => 1, 'isDelete' => 0, 'id' => 5])->first();
            return view('frontview.noReturnNoExchange', compact('datas'));
        } catch (\Throwable $th) {
            // Rollback & Return Error Message
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function Frontlogout(Request $request)
    {
        $request->session()->forget('customerid');
        $request->session()->forget('customername');
        $request->session()->forget('customermobile');
        $request->session()->forget('customermobile1');
        $request->session()->forget('customeremail');

        return redirect()->route('FrontIndex');
    }



    public function weightBind(Request $request)
    {
        try {
            if ($request->Weight == 0) {
                $Data = Product::where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.productId' => $request->productid])
                    ->first();
            } else {
                $Data = ProductAttributes::orderBy('id', 'DESC')
                    ->where(['product_id' => $request->productid, 'id' => $request->Weight])
                    ->first();
            }

            return  json_encode($Data);
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }



    public function FrontCategory(Request $request, $id)
    {
        try {
            $Category = Category::orderBy('categoryId', 'desc')->get();

            if ($id == null) {
                $Product = Product::select(
                    'product.productId',
                    'product.productname',
                    'product.rate',
                    'product.weight',
                    'product.description',
                    'product.isFeatures',
                    'product.isStock',
                    'product.slugname',
                    DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                    DB::raw('(SELECT MIN(product_attribute_price)  FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price')
                )
                    ->orderBy('productId', 'desc')
                    ->where(['product.iStatus' => 1, 'product.isDelete' => 0])
                    ->paginate(16);
                // dd($Product);
                $ProductCount = $Product->count();
            } else {
                $Product = Product::select(
                    'product.productId',
                    'product.categoryId',
                    'product.subcategoryid',
                    'product.productname',
                    'product.description',
                    'product.slugname',
                    DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                    DB::raw('(SELECT MIN(product_attribute_price)  FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price')
                )
                    ->orderBy('productId', 'desc')
                    ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'category.slugname' => $id])
                    ->join('category', 'product.categoryId', '=', 'category.categoryId')
                    ->paginate(16);
                $ProductCount = $Product->count();
            }
            return view('frontview.category', compact('Product', 'Category', 'id', 'ProductCount'));
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function loadMoreCategoryProducts(Request $request)
    {
        try {
            $page = $request->page; // Get the page number from the request
            $perPage = 16; // Number of products per page
            $offset = ($page - 1) * $perPage; // Calculate the offset for pagination
            $id = $request->categoryid;
            if ($id == null) {
                // dd('if');
                $products = Product::select(
                    'product.productId',
                    'product.productname',
                    'product.rate',
                    'product.weight',
                    'product.description',
                    'product.isFeatures',
                    'product.isStock',
                    'product.slugname',
                    DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                    DB::raw('(SELECT MIN(product_attribute_price)  FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price')
                )
                    ->orderBy('productId', 'desc')
                    ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
                    ->offset($offset) // Apply pagination offset
                    ->limit($perPage) // Apply pagination limit
                    ->get();
            } else {
                // dd('else');
                $products = Product::select(
                    'product.productId',
                    'product.categoryId',
                    'product.subcategoryid',
                    'product.productname',
                    'product.description',
                    'product.slugname',
                    DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                    DB::raw('(SELECT MIN(product_attribute_price)  FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price')
                )
                    ->orderBy('productId', 'desc')
                    ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'category.slugname' => $id])
                    ->join('category', 'product.categoryId', '=', 'category.categoryId')
                    ->offset($offset) // Apply pagination offset
                    ->limit($perPage) // Apply pagination limit
                    ->get();
            }

            return response()->json(['products' => $products]);
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function HeaderSearch(Request $request)
    {
        try {
            $CategorySearch = $request->categorysearch;
            $HeaderSearch = $request->headersearch;

            if ($request->categorysearch == 0) {
                $CategorySearch = 0;
            } else {
                $CategorySearch = $request->categorysearch;
            }

            $Product = Product::select(
                'product.productId',
                'product.categoryId',
                'product.subcategoryid',
                'product.productname',
                'product.description',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE productphotos.productid=product.productId ORDER BY product.productId LIMIT 1) as photo'),
                DB::raw('(SELECT MIN(product_attribute_price) FROM product_attributes WHERE product_attributes.product_id=product.productId ORDER BY product.productId LIMIT 1) as product_attribute_price')
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0])
                // ->join('category', 'product.categoryId', '=', 'category.categoryId')
                /*->whereIn('product.categoryId', function ($query) {
                    $query->select('categoryId')
                        ->from('category')
                        ->where('category.isDelete', 0)
                        ->where('category.iStatus', 1);
                })*/
                // ->whereIn('product.subcategoryId', function ($query) {
                //     $query->select('categoryId')
                //         ->from('category')
                //         ->where('category.isDelete', 0)
                //         ->where('category.iStatus', 1);
                // })
                ->when($HeaderSearch, fn($query, $HeaderSearch) => $query
                    ->where('product.productname', 'LIKE', '%' . $HeaderSearch . '%'))
                ->when($CategorySearch, fn($query, $CategorySearch) => $query
                    ->where('product.categoryId', '=', $CategorySearch))
                ->join('category', 'product.categoryId', '=', 'category.categoryId')
                ->paginate(16);


            // }

            $ProductCount = $Product->count();
            return view('frontview.Searchdata', compact('Product', 'ProductCount', 'CategorySearch', 'HeaderSearch'));
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function loadMoreSearchData(Request $request)
    {
        try {
            $CategorySearch = $request->CategorySearch;
            $HeaderSearch = $request->HeaderSearch;

            if ($request->CategorySearch == 0) {
                $CategorySearch = 0;
            } else {
                $CategorySearch = $request->CategorySearch;
            }
            // dd($request);
            $page = $request->page; // Get the page number from the request
            $perPage = 16; // Number of products per page
            $offset = ($page - 1) * $perPage; // Calculate the offset for pagination

            $products = Product::select(
                'product.productId',
                'product.categoryId',
                'product.subcategoryid',
                'product.productname',
                'product.description',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE productphotos.productid=product.productId ORDER BY product.productId LIMIT 1) as photo'),
                DB::raw('(SELECT MIN(product_attribute_price) FROM product_attributes WHERE product_attributes.product_id=product.productId ORDER BY product.productId LIMIT 1) as product_attribute_price')
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0])
                ->whereIn('product.categoryId', function ($query) {
                    $query->select('categoryId')
                        ->from('category')
                        ->where('category.isDelete', 0)
                        ->where('category.iStatus', 1);
                })
                // ->whereIn('product.subcategoryId', function ($query) {
                //     $query->select('categoryId')
                //         ->from('category')
                //         ->where('category.isDelete', 0)
                //         ->where('category.iStatus', 1);
                // })
                ->when($HeaderSearch, fn($query, $HeaderSearch) => $query
                    ->where('product.productname', 'LIKE', '%' . $HeaderSearch . '%'))
                ->when($CategorySearch, fn($query, $CategorySearch) => $query
                    ->where('product.categoryId', '=', $CategorySearch))
                ->join('category', 'product.categoryId', '=', 'category.categoryId')
                ->offset($offset) // Apply pagination offset
                ->limit($perPage) // Apply pagination limit
                ->get();

            return response()->json(['products' => $products]);
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function checkmobile(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'phone' => 'required|digits:10', // Ensure phone field is required and has exactly 10 digits
            ]);

            $Data = Customer::orderBy('customerid', 'DESC')
                ->where(['customermobile' => $request->phone])
                ->first();

            return  json_encode($Data);
        } catch (\Throwable $th) {
            // Rollback and return with Error
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function customerorder(Request $request, $ORDER_ID, $guid)
    {
        // dd($ORDER_ID);
        // dd($guid);
        // J76Ujf0k6CYzJL1x
        //   echo $guid;
        //   echo $ORDER_ID;
        try {
            $Total = Order::where(['isDelete' => 0, 'iStatus' => 1, 'order_id' => $ORDER_ID])->first();
            if ($Total) {
                // dd('if');
                $Customer = Customer::where(['isDelete' => 0, 'iStatus' => 1, 'guid' => $guid])->first();
                //   dd($Customer);
                $Order = OrderDetail::select(
                    'product.productname',
                    'orderdetail.quantity',
                    'orderdetail.productId',
                    'orderdetail.customerid',
                    'orderdetail.orderID',
                    'orderdetail.rate',
                    'orderdetail.size',
                    DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),

                )
                    ->where(['orderdetail.isDelete' => 0, 'orderdetail.iStatus' => 1, 'orderdetail.orderID' => $ORDER_ID, 'orderdetail.customerid' => $Customer->customerid])
                    ->leftjoin('product', 'orderdetail.productId', '=', 'product.productId')
                    ->get();
                //  dd($Order);
                // if(isset($Order) && $Order != "" && $Order != null && $Order != []){
                return view('frontview.customerorder', compact('Customer', 'Order', 'Total', 'ORDER_ID'));
            } else {
                // dd('else');
                return redirect()->route('ordernotavailable');
            }
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function ordernotavailable()
    {
        return view('frontview.customerdataerrorpage');
    }
}
