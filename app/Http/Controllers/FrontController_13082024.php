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


class FrontController extends Controller
{
    public function index(Request $request)
    {
        $Banner = Banner::orderBy('banner.bannerId', 'desc')
            ->where(['banner.iStatus' => 1, 'banner.isDelete' => 0])
            ->get();
        $TrandingProduct = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isStock',
            'product.slugname',
            'product.isFeatures',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT MIN(product_attribute_price)  FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price')
        )
            ->orderBy('productId', 'desc')
            ->where(['iStatus' => 1, 'isDelete' => 0,'isFeatures'=>1])
            ->whereIn('categoryId', function($query) {
                    $query->select('categoryId')
                        ->from('category')
                        ->where('isDelete', 0)
                        ->where('iStatus', 1);
                })
                // ->whereIn('subcategoryId', function($query) {
                //     $query->select('categoryId')
                //         ->from('category')
                //         ->where('isDelete', 0)
                //         ->where('iStatus', 1);
                // })
            ->get();
        $TrandingProductCount = $TrandingProduct->count();

        $Product = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isStock',
            'product.slugname',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT MIN(product_attribute_price)  FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price')
        )
            ->orderBy('productId', 'desc')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'isFeatures' => 0])
            ->whereIn('categoryId', function($query) {
                    $query->select('categoryId')
                        ->from('category')
                        ->where('isDelete', 0)
                        ->where('iStatus', 1);
                })
                // ->whereIn('subcategoryId', function($query) {
                //     $query->select('categoryId')
                //         ->from('category')
                //         ->where('isDelete', 0)
                //         ->where('iStatus', 1);
                // })
            ->get();
        $ProductCount = $Product->count();
        
        return view('frontview.index', compact('TrandingProduct', 'TrandingProductCount', 'Product', 'ProductCount','Banner'));

    }

    public function about(Request $request)
    {
        return view('frontview.about');
    }

    public function contactus(Request $request)
    {
        return view('frontview.contact');
    }

    public function contact_us(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'subject' => 'required',
                'email' => 'required',
                'your_message' => 'required',
                'mobile' => 'required|digits:10',
                'captcha' => 'required'
            ]
        );

        $userInput = $request->input('captcha');
        $captcha = session('captcha');

        if ($userInput === $captcha) {
            $data = array(
                'name' => $request->name,
                'subject' => $request->subject,
                'email' => $request->email,
                'mobileNumber' => $request->mobile,
                'message' => $request->your_message,
                "strIp" => $request->ip(),
                "created_at" => date('Y-m-d H:i:s')
            );
            DB::table('inquiry')->insert($data);

            $SendEmailDetails = DB::table('sendemaildetails')
                ->where(['id' => 4])
                ->first();

            $root = $_SERVER['DOCUMENT_ROOT'];
            $file = file_get_contents($root . '/mailers/contactemail.html', 'r');
            $file = str_replace('#name', $data['name'], $file);
            $file = str_replace('#email', $data['email'], $file);
            $file = str_replace('#subject', $data['subject'], $file);
            $file = str_replace('#mobile', $data['mobileNumber'], $file);
            $file = str_replace('#message', $data['message'], $file);

            $setting = DB::table("setting")->select('email')->first();
             $toMail = $setting->email; // "shahkrunal83@gmail.com";//
            // $toMail = "dev5.apolloinfotech@gmail.com";

            $to = $toMail;
            $subject = $SendEmailDetails->strSubject;
            $message = $file;
            $header = "From:" . $SendEmailDetails->strFromMail . "\r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $message, $header);

            // return back();
            return redirect()->route('contactthankyou');
        } else {
            return redirect()->route('FrontContactUs')->with('invalidcaptcha', 'Invalid captcha code!');
        }
    }
    
    public function contactthankyou()
    {
            return view('frontview.contactthankyou');
        }

    public function products(Request $request, $id = null)
    {
        // dd($request);
        if ($id == null) {
            $Product = Product::select(
                'product.productId',
                'product.categoryId',
                'product.subcategoryid',
                'product.productname',
                'product.rate',
                'product.description',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId LIMIT 1) as photo'),
                 DB::raw('(SELECT COALESCE(MIN(product_attribute_price), 0) FROM product_attributes WHERE  product_attributes.product_id=product.productId   LIMIT 1) as product_attribute_price'),
                // DB::raw('(SELECT MIN(product_attribute_price)  FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price'),
                DB::raw('(SELECT COUNT(*) FROM ledger WHERE ledger.ledgerId IN (SELECT MAX(ledgerId) FROM ledger WHERE ledger.iProductId=product.productId GROUP BY iSize) AND ledger.closingBalance > 0) as closingBalance')
    )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0])
                ->whereIn('categoryId', function($query) {
                    $query->select('categoryId')
                        ->from('category')
                        ->where('isDelete', 0)
                        ->where('iStatus', 1);
                })
                // ->whereIn('subcategoryId', function($query) {
                //     $query->select('categoryId')
                //         ->from('category')
                //         ->where('isDelete', 0)
                //         ->where('iStatus', 1);
                // })
                ->paginate(16);
            // dd($Product);
            $ProductCount = $Product->count();
        } else {
            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo'),
                 DB::raw('(SELECT COALESCE(MIN(product_attribute_price), 0) FROM product_attributes WHERE  product_attributes.product_id=product.productId LIMIT 1) as product_attribute_price'),
                // DB::raw('(SELECT MIN(product_attribute_price)  FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId LIMIT 1,1) as backphoto')
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'category.slugname' => $id])
                ->join('category', 'product.categoryId', '=', 'category.categoryId')
                ->paginate(16);
            $ProductCount = $Product->count();
            // dd($Product);
        }
        // dd($Product);
        DB::commit();
        return view('frontview.product', compact('Product',  'id', 'ProductCount'));
    }
    
    public function loadMoreProducts(Request $request)
    {
        // dd($request); 
        $page = $request->page; // Get the page number from the request
        $perPage = 16; // Number of products per page
        $offset = ($page - 1) * $perPage; // Calculate the offset for pagination
    
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
            ->whereIn('categoryId', function($query) {
                $query->select('categoryId')
                    ->from('category')
                    ->where('isDelete', 0)
                    ->where('iStatus', 1);
            })
            // ->whereIn('subcategoryId', function($query) {
            //     $query->select('categoryId')
            //         ->from('category')
            //         ->where('isDelete', 0)
            //         ->where('iStatus', 1);
            // })
            ->offset($offset) // Apply pagination offset
            ->limit($perPage) // Apply pagination limit
            ->get();
    
        return response()->json(['products' => $products]);
    }


    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }


    public function checkout(Request $request)
    {
        $Coupon = $request->session()->get('data');

        $session = Session::get('customerid');

        $cartItems = \Cart::getContent();
        // dd($cartItems);
        // dd($cartItems->items['size']);
        $Shipping = Shipping::orderBy('id', 'desc')->first();
        
        $State = State::orderBy('stateName', 'asc')->get();

        return view('frontview.checkout', compact('Shipping', 'Coupon', 'State'));
    }

    public function checkoutstore(Request $request)
    {
            //dd("if");
        try {
            $cartItems = \Cart::getContent();
            //  dd($cartItems);
            $amount = \Cart::getTotal();
            
            $Mobile = Customer::where(['isDelete' => 0, 'iStatus' => 1, 'customermobile' => $request->billPhone])->first();
            
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
            
            $status = true;
            foreach ($cartItems as $cartItem) {
                 $Ledger = Ledger::orderBy('ledgerId', 'desc')->where([
                    'ledger.iStatus' => 1, 'ledger.isDelete' => 0, 'ledger.iProductId' => $cartItem->productid, 'iSize' => $cartItem->size
                ])
                ->join('product_attributes', 'ledger.iSize', '=', 'product_attributes.id')
                ->first();
                $specificId = $request->attributeid; // Change this to the id you want to count
                $count = $cartItems->filter(function ($item) use ($specificId) {
                    return $item->id === $specificId;
                })->sum('quantity');
                
                $closingBalance = (int)$Ledger->closingBalance;   
                if(($closingBalance *  1) > ($count *  1)){
                    
                } else {
                    $status = false;
                }
            }
    
            if($status == true){
    
            $customerid = 0;
            $uniqueNumber = Str::random(16);
            if ($Mobile == null) {
                $Order = array(
                    'firstname' => $request->billFirstName ,
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
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }   
        
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
                    $msg = "Hello , Welcome To The Store. Your Login OTP is $otp";
                    $customer = new Customer();
                    $status = $customer->sendWhatsappMessage($MobileNumber, $key, $msg, $Customer->customerid);
                    // dd($status);
        
                    return redirect()->route('FrontOtp', $Customer->guid);
                } else {
                    return back()->with('notregister', 'Mobile Is Not Registered');
                }
         } catch (\Throwable $th) {
    
                // Rollback & Return Error Message
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());
            }         
    }

    public function register(Request $request)
    {
        return view('frontview.register');
    }

    public function registerstore(Request $request)
    {
        // dd($request);
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
                $status = $customer->sendWhatsappMessage($MobileNumber, $key, $msg, $InsertedId);
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
    }

    public function otp(Request $request, $guid)
    {
        return view('frontview.otp', compact('guid'));
    }

    public function otpsubmit(Request $request)
    {
        // dd($request);
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

                return redirect()->route('FrontIndex');
            } else {
                return back()->with('otpnotmatch', 'OTP Is Not Match');
            }
        } else {
            return back()->with('error', 'Customer Is Not Registered');
        }
    }

    public function profile(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            return view('frontview.profile');
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }

    public function myaccount(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            return view('frontview.myaccount');
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }

    public function myaccountedit(Request $request)
    {
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
    }

    public function myorders(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            $session = Session::get('customerid');
            $Order = Order::where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.customerid' => $session])
                // ->join('product', 'orderdetail.productId', '=', 'product.productId')
                ->paginate(10);
            // dd($Order);
            return view('frontview.myorders', compact('Order'));
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }

    public function myordersdetails(Request $request, $id)
    {
        // dd($request->session());
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
    }

    public function mywishlistpage(Request $request)
    {
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
    }

    public function addwishlist(Request $request)
    {
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
    }

   
    public function bindpriceonsize(Request $request)
    {
        // dd($request);
        $Data = Ledger::orderBy('ledgerId', 'desc')->where([
            'ledger.iStatus' => 1, 'ledger.isDelete' => 0, 'ledger.iProductId' => $request->productid, 'iSize' => $request->size
        ])
             ->join('product_attributes', 'ledger.iSize', '=', 'product_attributes.id')
            ->first();    
            // dd($Data);
        
        return  json_encode($Data);
    }

    public function productdetail(Request $request, $category = null, $id = null)
    {
        // dd($request);
        $ProductDetail = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isStock',
            'product.categoryId',
            'product.subcategoryid',
            'product.isFeatures',
            'product.disclaimer',
            'product.care',
            'product.fabric',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT MIN(product_attribute_price)  FROM product_attributes WHERE  product_attributes.product_id=product.productId ORDER BY product.productId  LIMIT 1) as product_attribute_price')
        )
            ->orderBy('productId', 'DESC')
            ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.slugname' => $category])
            ->first();
            // dd($ProductDetail);
        $Attribute = "";    
        if($ProductDetail){
            $Attribute = ProductAttributes::select('product_attributes.*',DB::raw('(SELECT closingBalance FROM ledger WHERE  ledger.iProductId=product_attributes.product_id and ledger.iSize=product_attributes.id order by ledgerId desc  LIMIT 1) as closingBalance'))->where(['product_attributes.product_id' => $ProductDetail->productId])
                ->get();
        }        
        
        $Category = Category::where(['slugname' => $category])->first();

        $Photos = "";
        if($ProductDetail){
            $Photos = Productphotos::where([
                'productphotos.iStatus' => 1, 'productphotos.isDelete' => 0, 'productphotos.productid' => $ProductDetail->productId
            ])
                ->get();
        }        
        
        return view('frontview.productdetail', compact('ProductDetail', 'Photos',  'Attribute', 'category', 'id'));
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
        return view('frontview.termandcondition', compact('datas'));
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
            DB::rollBack();
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
        // dd($request->all());
        if ($request->Weight == 0) {
            $Data = Product::where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.productId' => $request->productid])
                ->first();
        } else {
            $Data = ProductAttributes::orderBy('id', 'DESC')
                ->where(['product_id' => $request->productid, 'id' => $request->Weight])
                ->first();
        }

        return  json_encode($Data);
    }

   

    public function FrontCategory(Request $request, $id)
    {
        // dd($id);
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
    }
    
     public function loadMoreCategoryProducts(Request $request)
    {
        // dd($request);
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
    }

    public function HeaderSearch(Request $request)
    {
        // dd($request);
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
                    ->when($HeaderSearch, fn ($query, $HeaderSearch) => $query
                        ->where('product.productname', 'LIKE', '%' . $HeaderSearch . '%'))
                    ->when($CategorySearch, fn ($query, $CategorySearch) => $query
                        ->where('product.categoryId', '=', $CategorySearch))
                    ->join('category', 'product.categoryId', '=', 'category.categoryId')
                    ->paginate(16);


        // }

        $ProductCount = $Product->count();
        return view('frontview.Searchdata', compact('Product', 'ProductCount','CategorySearch','HeaderSearch'));
    }
    
    public function loadMoreSearchData (Request $request)
    {
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
                    ->when($HeaderSearch, fn ($query, $HeaderSearch) => $query
                        ->where('product.productname', 'LIKE', '%' . $HeaderSearch . '%'))
                    ->when($CategorySearch, fn ($query, $CategorySearch) => $query
                        ->where('product.categoryId', '=', $CategorySearch))
                    ->join('category', 'product.categoryId', '=', 'category.categoryId')
            ->offset($offset) // Apply pagination offset
            ->limit($perPage) // Apply pagination limit
            ->get();
    
        return response()->json(['products' => $products]);
    }

    public function checkmobile(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required|digits:10', // Ensure phone field is required and has exactly 10 digits
        ]);
    
        $Data = Customer::orderBy('customerid', 'DESC')
            ->where(['customermobile' => $request->phone])
            ->first();
       
        return  json_encode($Data);
    }
    
    public function customerorder(Request $request,$ORDER_ID,$guid)
    {
        // dd($ORDER_ID);
        // dd($guid);
        // J76Ujf0k6CYzJL1x
        //   echo $guid;
        //   echo $ORDER_ID;
            try {    
                 $Total = Order::where(['isDelete' => 0, 'iStatus' => 1, 'order_id' => $ORDER_ID])->first();
                 if($Total){
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
                     ->where(['orderdetail.isDelete' => 0, 'orderdetail.iStatus' => 1, 'orderdetail.orderID' => $ORDER_ID,'orderdetail.customerid'=>$Customer->customerid])
                        ->leftjoin('product', 'orderdetail.productId', '=', 'product.productId')
                        ->get();
                //  dd($Order);
            // if(isset($Order) && $Order != "" && $Order != null && $Order != []){
                 return view('frontview.customerorder',compact('Customer','Order','Total'));
                 
            }else{
                // dd('else');
                return redirect()->route('ordernotavailable');
            }
            } catch (\Throwable $th) { 
    
                // Rollback & Return Error Message
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());
            }   
         
    }
    
    public function ordernotavailable()
    {
        return view('frontview.customerdataerrorpage');
    }
    
}