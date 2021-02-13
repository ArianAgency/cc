<?php

namespace App\Http\Controllers;

use App\Business;
use App\Category;
use App\Customer;
use App\Service;
use App\User;
use App\X_sens;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\Console\Input\Input;


class AdminController extends Controller
{
    public function home()
    {
        if (Auth::user() != null) {
            Auth::user()->name;
            error_log(Auth::user()->name);
        }

        return view('admin.main.home');
    }

    public function def()
    {
        return view('admin.main.main-BACKUP');
    }

//****************************************************************************Business
    public function business()
    {
        $businesses = Business::all();
        return view('admin.businesses.business-index', compact('businesses'));
    }

    public function businessAction(Request $request)
    {
        $action = $request['action'];
        $business_id = $request['business_id'];

        $result = '';

        try {
            switch ($action) {
                case 'is_active':
                    $value = $request['value'];
                    DB::table('businesses')
                        ->where('id_businesses', $business_id)
                        ->update(['is_active' => $value]);
                    break;
                case 'setCardText':
                    error_log('CHECK 1');
                    $business_id = Auth::user()->businesse_id;
                    $card_text = $request->card_text;
                    error_log($card_text);
                    DB::table('business_card_design')
                        ->where('id_businesses', '=', $business_id)
                        ->update(['card_text' => $card_text]);
                    break;
            }
            $result = 'Done';
            error_log($result);
        } catch (\Illuminate\Database\QueryException $e) {
            $result = 'error';
            error_log($e);
        }

//        error_log($action);
//        error_log($business_id);
//        error_log($result);

        return Response(['action' => $action, 'status' => $result], 200);
    }

    public function business_type(Request $request)
    {

        $type = $request['type'];
        $parent = $request->query('parent');
        error_log('parent = ');
        error_log($parent);
        $businesses = '';

        switch ($type) {
            case 'index':
                $page = $request['page'];

                $businesses = Business::where('parent_id', '=', $parent)
                    ->paginate(10);
                break;
            case 'all':
                $businesses = Business::all();
                $businesses = array('current_page' => 0, 'data' => $businesses);
                break;
        }


        return Response(['status' => 'Done', 'data' => $businesses], 200);
    }

    public function business_get_this(Request $request)
    {
        error_log('business_get_this - ');
        $get_this = $request['this'];
        $availableCardPreNumber = '';
        error_log($get_this);
        $response = array();
        $response['action'] = $get_this;
        switch ($get_this) {
            case 'availableCardPreNumber':
//                $availableCardPreNumber = 5000;
                $availableCardPreNumber = DB::table('businesses')->latest('card_pre_number')->first();
                $availableCardPreNumber = ($availableCardPreNumber->card_pre_number) + 1;
                error_log('$availableCardPreNumber  = ');
                error_log($availableCardPreNumber);
                break;
            case 'bussinessNameByID':
                $businesse_id = $request->businesse_id;
                $business = DB::table('businesses')->where('id_businesses', '=', $businesse_id)->get();
                $response['company_name'] = $business[0]->company_name;
//                error_log('company_name = ');
//                error_log($response['company_name']);
                return Response(['status' => 'Done', 'response' => $response], 200);
                break;
            case 'card_init':

                $business_id = Auth::user()->businesse_id;

                $card = DB::table('business_card_design')->where('id_businesses', '=', $business_id)->get();
                $response['card_bg'] = '/storage/card_bg/' . $card[0]->card_bg_address;
                $response['card_text'] = $card[0]->card_text;

                $logo = DB::table('businesses')->where('id_businesses', '=', $business_id)->get();
                $response['logo'] = '/storage/logo_img/' . $logo[0]->logo_address;


                $business = DB::table('businesses')->where('id_businesses', '=', $business_id)->get();
                $response['company_name'] = $business[0]->company_name;
                $response['brand_name'] = $business[0]->brand_name;

                return Response(['status' => 'Done', 'response' => $response], 200);
                break;
            case 'groupCard_init':

                $business_id = Auth::user()->businesse_id;


                $lastCardNumber = DB::table('customers')->where('registration_origin', '=', $business_id)
                    ->orderBy('created_at', 'desc')->get('card_number');
                $startingCardNumber = '';
                if (count($lastCardNumber) > 0) {
                    $startingCardNumber = $lastCardNumber[0]->card_number + 1;
                } else {
                    $cardPreNumberOfBusiness = DB::table('businesses')->where('id_businesses', '=', $business_id)
                        ->get('card_pre_number');
                    $cardPreNumberOfBusiness = $cardPreNumberOfBusiness[0]->card_pre_number;
                    error_log('$cardPreNumberOfBusiness  = ' . $cardPreNumberOfBusiness);
                    $startingCardNumber = $cardPreNumberOfBusiness . '000000000001';
                }
                $response['starting_card_number'] = $startingCardNumber;

                $card = DB::table('business_card_design')->where('id_businesses', '=', $business_id)->get();
                $response['card_bg'] = '/storage/card_bg/' . $card[0]->card_bg_address;
                $response['card_text'] = $card[0]->card_text;

                $logo = DB::table('businesses')->where('id_businesses', '=', $business_id)->get();
                $response['logo'] = '/storage/logo_img/' . $logo[0]->logo_address;

                $business = DB::table('businesses')->where('id_businesses', '=', $business_id)->get();
                $response['company_name'] = $business[0]->company_name;
                $response['brand_name'] = $business[0]->brand_name;

                return Response(['status' => 'Done', 'response' => $response], 200);
                break;
        }

        return Response(['status' => 'Done', 'availableCardPreNumber' => $availableCardPreNumber], 200);

    }

    public function business_new(Request $request)
    {
        error_log('*******************************');
        error_log('request = ' . $request);
        error_log('*******************************');

//        error_log('image = ' . $request['image']);
//        error_log('$foundation_date = ' . $request->foundation_date);
//        error_log('company_name = ' . $request->company_name);

        $is_it_new_registration = $request->is_it_new_registration;
        $brand_name = $request->brand_name;
        $company_name = $request->company_name;
        $company_type = $request->company_type;
        $foundation_date = $request->foundation_date;
        $register_code = $request->register_code;
        $national_code = $request->national_code;
        $financial_code = $request->financial_code;
        $company_field = $request->company_field;
        $address = $request->address;
        $phone = $request->phone;
        $support_phone = $request->support_phone;
        $mobile = $request->mobile;
        $email = $request->email;
        $work_time = $request->work_time;
        $logo_address = $request->image;
        $instagram_id = $request->instagram_id;
        $instagram_hashtag = $request->instagram_hashtag;
        $company_size = $request->company_size;
        $parent_id = $request->parent_id;
        $bank_account = $request->bank_account;
        $card_pre_number = $request->card_pre_number;
        $registration_origin = $request->registration_origin;
        $website = $request->website;
        $finding_way = $request->finding_way;
        $password = password_hash($request->password, PASSWORD_DEFAULT);
//        error_log('password_hash  = ' . $password);


        if (strlen($instagram_id) == 0) {
            $instagram_id = 'NULL';
        }
        if (strlen($parent_id) == 0) {
            $parent_id = "0";
        }
        if (strlen($registration_origin) == 0) {
            $registration_origin = "1";
        }
        if (strlen($logo_address) == 0) {
            $logo_address = "NULL";
        } elseif (strlen($logo_address) > 0) {
            if (strrpos($logo_address, '/') > 0) {
                $logo_address = substr($logo_address, (strrpos($logo_address, '/')) + 1);
            }
        }
        error_log('$logo_address => ');
        error_log($logo_address);


        $query = "CALL sp_register_new_business  ($is_it_new_registration,'$brand_name', '$company_name', '$company_type', '$foundation_date', '$register_code', '$national_code',
        '$financial_code', '$company_field', '$address', '$phone', '$support_phone', '$mobile',
        '$email', '$work_time', '$logo_address', '$instagram_id','$instagram_hashtag', '$company_size', '$parent_id',
        '$bank_account', '$card_pre_number', '$registration_origin', '$website', '$finding_way', '$password')";

        error_log('sp_register_new_business -> $query = ' . $query);

        try {
            $queryResult = DB:: select(DB::raw($query));
//            error_log('implode = ' . implode(',', $queryResult));
            return Response(['status' => 'done', 'code' => 1, 'data' => $queryResult], 200);

        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
            error_log('query error = ' . $ex->getMessage());
            error_log('query error code= ' . $ex->getCode());
            return Response(['status' => 'Error', 'code' => 2], 409);
        }
    }


//****************************************************************************Business
//****************************************************************************User
    public function user()
    {
        error_log("************");
        return view('admin.users.users-index');
    }

    public function userAction(Request $request)
    {
        $action = $request['action'];
        $user_id = $request['id_user'];
        $value = $request['value'];
        $result = '';

        try {

            switch ($action) {

                case 'is_active':
                    DB::table('users')
                        ->where('id_users', $user_id)
                        ->update(['is_active' => $value]);
                    break;
            }
            $result = 'Done';
            error_log($result);
        } catch (\Illuminate\Database\QueryException $e) {
            $result = 'error';
            error_log($e);
        }


        error_log($action);
        error_log($user_id);
        error_log($result);

        return Response(['action' => $action, 'user_id' => $user_id, 'value' => $value], 200);
    }

    public function user_type(Request $request)
    {
        $type = $request['type'];
        $users = '';

        switch ($type) {
            case 'index':
                $page = $request['page'];
                $users = User::paginate(10);
                break;

            case 'all':
                $users = User::all();
                $users = array('current_page' => 0, 'data' => $users);
                break;
        }


        foreach ($users as $item) {

            $businessName = Business::select('id_businesses', 'brand_name', 'company_name')->where('id_businesses', $item->businesse_id)->get();
            error_log($businessName);
            $item['business'] = $businessName[0];
        }

        return Response(['status' => 'Done', 'data' => $users], 200);
    }

    public function user_get_this(Request $request)
    {
        error_log('user_get_this - ');
        $get_this = $request['this'];
        $availableCardNumber = '';
        $userDetail = '';
        $businessesIndex = '';
        $roles = '';
        $response = array();
        error_log('$get_this = ' . $get_this);

        switch ($get_this) {
            case 'availableCardNumber':
                $businessID = $request['businessID'];
                if ($request['businessID'] == 0) {
                    $businessID = '90';
                }
                $lastCardNumber = DB::table('users')->where('card_number', 'like', $businessID . '%')
                    ->orderBy('created_at', 'desc')->get('card_number');

                error_log('$lastCardNumber = ' . $lastCardNumber);
                error_log('count($lastCardNumber) = ' . count($lastCardNumber));
                if (count($lastCardNumber) > 0) {
                    $availableCardNumber = $lastCardNumber[0]->card_number + 1;
                } else {
                    $cardPreNumberOfBusiness = DB::table('businesses')->where('id_businesses', '=', $businessID)
                        ->get('card_pre_number');
                    $cardPreNumberOfBusiness = $cardPreNumberOfBusiness[0]->card_pre_number;
                    error_log('$cardPreNumberOfBusiness  = ' . $cardPreNumberOfBusiness);
                    $availableCardNumber = $cardPreNumberOfBusiness . '000000000001';
                }
                break;
            case 'formInitData':

                $businessID = '';
                if ($request['businessID'] == 0) {
                    $businessID = '90';
                }
                $lastCardNumber = DB::table('users')->where('card_number', 'like', $request['businessID'] . '%')
                    ->orderBy('created_at', 'desc')->get('card_number');

                if (count($lastCardNumber) > 0) {
                    $availableCardNumber = $lastCardNumber[0]->card_number + 1;
                } else {
                    $availableCardNumber = '9009000000000001';
                }

                //                $roles = DB::table('roles')->get();
                $userDetail = Auth::user();
                $roles = DB::table('roles')->where('id_roles', '>', $userDetail->role_id)->get();
                //                error_log($userDetail->name);
                $business = DB::table('businesses')->where('id_businesses', '=', $userDetail->businesse_id)->get();
                $userDetail['business'] = $business[0];

                if ($userDetail->role_id <= 1) {
                    $businessesIndex = DB::table('businesses')->get();
                } else if ($userDetail->role_id == 2) {
                    $businessesIndex = DB::table('businesses')
                        ->where('parent_id', '=', $userDetail->role_id)
                        ->get();
                } else {
                    $businessesIndex = array();
                }


                break;
            case 'detail':
                $userDetail = Auth::user();
//                error_log($userDetail->name);
                $business = DB::table('businesses')->where('id_businesses', '=', $userDetail->businesse_id)->get();
                $userDetail['business'] = $business[0];
//                error_log($userDetail);
                return Response(['status' => 'Done', 'user' => $userDetail], 200);
                break;
            case 'userDetailByMobile':
                $mobile = $request->mobile;
                error_log('mobile = ');
                error_log($mobile);
                $user_detail = DB::table('users')->where('mobile', '=', $mobile)->get();
                $response['userDetail'] = $user_detail[0];

                $business = DB::table('businesses')->where('id_businesses', '=', $user_detail[0]->businesse_id)->get();
                $response['business'] = $business[0]->brand_name;

                break;
        }
        error_log('End of user_get_this - ' . $get_this);
//        error_log('$availableCardNumber = ' . $availableCardNumber);
        return Response(['status' => 'Done', 'response' => $response, 'availableCardNumber' => $availableCardNumber, 'user' => $userDetail, 'roles' => $roles, 'businessesIndex' => $businessesIndex], 200);
    }

    public function user_do_this_action(Request $request)
    {
        error_log('user_do_this_action -> ');
        $do_this = $request['this'];
        $status = '';
        $response = array();

        switch ($do_this) {
            case 'promotionalCharge':
                $id_target_user = $request['id_target_user'];
                $id_creator_user = $userDetail = Auth::user()->id_users;
                $wallet_charge = $request['wallet_charge'];
                $score_charge = $request['score_charge'];
                $description = $request['description'];
                $creator_user_ip = $_SERVER['REMOTE_ADDR'];

                error_log('$request = ');
                error_log($request);


                $query = "CALL sp_charge_user_add ('$id_target_user', '$wallet_charge',
                                    '$score_charge' ,'$description' ,'$id_creator_user' ,
                                    '$creator_user_ip')";

//                error_log('sp_charge_user_add -> $query = ' . $query);

                try {
                    $queryResult = DB:: select(DB::raw($query));
                    $status = 'Done';
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    $status = 'Failed';
                }
                break;
        }
        error_log('End of user_do_this - ' . $do_this);

        return Response(['status' => $status, 'response' => $response,], 200);
    }

    public function user_new(Request $request)
    {
        error_log('*******************************');
        error_log('request = ' . $request);
        error_log('*******************************');

//        error_log('image = ' . $request['image']);
//        error_log('brand_name = ' . $request->brand_name);
//        error_log('company_name = ' . $request->company_name);

        $is_it_new_registration = $request->is_it_new_registration;
        $name = $request->name;
        $family = $request->family;
        $father_name = $request->father_name;
        $national_code = $request->national_code;
        $gender = $request->gender;
        $mobile = $request->mobile;
        $mobile_verified_at = $request->mobile_verified_at;
        $phone = $request->phone;
        $email = $request->email;
        $email_verified_at = $request->email_verified_at;
        $have_social = $request->have_social;
        $birthday = $request->birthday;
        $marriage_status = $request->marriage_status;
        $wedding_anniversary = $request->wedding_anniversary;
        $education = $request->education;
        $field = $request->field;
        $address = $request->address;
        $registration_origin = $request->registration_origin;
        $website = $request->website;
        $skill = $request->skill;
        $card_number = $request->card_number;
        $wallet = $request->wallet;
        $score = $request->score;
        $businesse_id = $request->businesse_id;
        $role_id = $request->role_id;
        $password = $request->password;

        $bank_account = $request->bank_account;

        $user_ip = $_SERVER['REMOTE_ADDR'];


        $card_number = preg_replace("/[^0-9]/", "", $card_number);
        if (strlen($mobile_verified_at) == 0) {
            $mobile_verified_at = "NULL";
        }
        if (strlen($email_verified_at) == 0) {
            $email_verified_at = "NULL";
        }
        if (strlen($have_social) == 0) {
            $have_social = "1";
        }
        if (strlen($registration_origin) == 0) {
            $registration_origin = "1";
        }
        if (strlen($wedding_anniversary) == 0) {
            $wedding_anniversary = "Null";
        }
        if (strlen($wallet) == 0) {
            $wallet = 0.00;
        }
        if (strlen($score) == 0) {
            $score = 0;
        }
        error_log('$businesse_id = ' . $businesse_id);
        if (strlen($businesse_id) == 0) {
            $businesse_id = 1;
        }
        if (strlen($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $password = password_hash('secret', PASSWORD_DEFAULT);
        }
        if (strlen($card_number) == 0) {
            $lastCardNumber = DB::table('customers')->where('card_number', 'like', '90%')
                ->orderBy('created_at', 'desc')->get('card_number');
            error_log('$lastCardNumber = ' . $lastCardNumber);
            error_log('count($lastCardNumber) = ' . count($lastCardNumber));
            if (count($lastCardNumber) > 0) {

                $card_number = $lastCardNumber[0]->card_number + 1;
                error_log('count($lastCardNumber) > 0');
            } else {
                $card_number = '9009000000000001';
                error_log($card_number);
            }
        }
        if ($role_id == 0) {
            $role_id = 1;
        }


        $query = "CALL sp_register_new_users  ($is_it_new_registration,'$name', '$family', '$father_name', '$national_code', '$gender', '$mobile', '$phone', '$email',
                         $have_social, '$birthday', '$marriage_status', $wedding_anniversary, '$education', '$field', '$address',
                         $registration_origin, '$website', '$skill', '$card_number',$wallet,$score, '$businesse_id', '$role_id', '$user_ip', '$password')";

        error_log('sp_register_new_user -> $query = ' . $query);


        try {
            $queryResult = DB:: select(DB::raw($query));
            return Response(['status' => 'done', 'code' => 1, 'data' => $queryResult], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
            error_log('query error = ' . $ex->getMessage());
            error_log('query error code= ' . $ex->getCode());
            return Response(['status' => 'error', 'code' => 2], 409);
        }
    }

    public function show_user_v_view(Request $request)
    {
        $view = $request['v'];
        $viewInReturn = '';

        error_log("show_" . $view . "_view");

        switch ($view) {
            case 'instant-charge':
                $viewInReturn = 'admin.users.users-instant-charge';
                break;

        }
        return view($viewInReturn);
    }

//****************************************************************************User
//****************************************************************************Customer
//    public function customer(Request $request)
//    {
//        $view = $request['view'];
//        $v = '';
//        error_log('customer view = ' . $view);
//        switch ($view) {
//
//        }
//        error_log('v = '.$v);
//        return view($v);
//    }

    public function customerAction(Request $request)
    {
        $action = $request['action'];
        $customer_id = $request['id_customer'];
        $value = $request['value'];
        $result = '';

        try {

            switch ($action) {

                case 'is_active':
                    DB::table('customer')
                        ->where('id_customers', $customer_id)
                        ->update(['is_active' => $value]);
                    break;
            }
            $result = 'Done';
            error_log($result);
        } catch (\Illuminate\Database\QueryException $e) {
            $result = 'error';
            error_log($e);
        }


        error_log($action);
        error_log($customer_id);
        error_log($result);

        return Response(['action' => $action, 'user_id' => $customer_id, 'value' => $value], 200);
    }

    public function customer_type(Request $request)
    {
        $type = $request['type'];
        $customers = '';

        switch ($type) {
            case 'index':
                $mode = $request['mode'];
                $page = $request['page'];
                error_log('$mode = ');
                error_log($mode);
                switch ($mode) {
                    case 'all':
                        $customers = Customer::paginate(10);
                        break;
                    case 'completed':
                        $customers = Customer::where('name', '!=', '-')->paginate(10);
                        break;
                    case 'null':
                        $customers = Customer::where('name', '=', '-')->paginate(10);
                        break;
                    default:
                        $customers = Customer::where('name', '!=', '-')->paginate(10);
                }
                break;

            case 'all':
                $customers = Customer::all();
                $customers = array('current_page' => 0, 'data' => $customers);
                break;
        }


        return Response(['status' => 'Done', 'data' => $customers], 200);
    }

    public function customer_get_this(Request $request)
    {
        error_log('customer_get_this - ');
        $get_this = $request['this'];
        error_log($get_this);

        $response = array();
        $response['status'] = 'Done';

        switch ($get_this) {
            case 'getFormInitData': //availableCardNumber
                $businessID = $request->businessID;

                $lastCardNumber = DB::table('customers')->where('card_number', 'like', '90%')
                    ->orderBy('created_at', 'desc')->get('card_number');
                error_log('lastCardNumber = ' . $lastCardNumber);
                error_log('count($lastCardNumber) = ' . count($lastCardNumber));
                if (count($lastCardNumber) > 0) {
                    $availableCardNumber = $lastCardNumber[0]->card_number + 1;
                } else {
                    $availableCardNumber = '9009000000000001';
                }
                $response['availableCardNumber'] = $availableCardNumber;

                $categories = DB::table('category')->where('id_business', $businessID)
                    ->get(['id_category', 'category_name']);
                $response['categories'] = $categories;

                break;
            case 'getAllDetail':
                $id_customers = $request['id_customers'];
                $customerDetail = DB::table('customers')->where('id_customers', '=', $id_customers);
                $response['customerDetail'] = $customerDetail;
                break;
            case 'customerDetailByMobile':
                $mobile = $request->mobile;
                error_log('mobile = ');
                error_log($mobile);

                $customer_detail = DB::table('customers')->where('mobile', '=', $mobile)->get();
//                $customer_detail = DB::table('customers')->where('id_customers', '=', 1)->get();
                $response['customerDetail'] = $customer_detail[0];


                $business = DB::table('businesses')->where('id_businesses', '=', $customer_detail[0]->registration_origin)->get();
                $response['business'] = $business[0]->brand_name;

                break;
            case 'categories':
                $category = DB::table('category')->paginate(10);
                $response['response'] = $category;
                break;
            case 'categoriesByBusiness':
                $userBusinessID = Auth::user()->businesse_id;
                $parentBusinessID = DB::table('businesses')
                    ->where('id_businesses', '=', $userBusinessID)
                    ->get('parent_id');
                $filter = ($request->filter) . '%';
                $parentBusinessID = $parentBusinessID[0]->parent_id;
                $category = DB::table('category')
                    ->where([['id_business', '=', $userBusinessID],
                        ['category_name', 'LIKE', '%' . $filter . '%']])
                    ->orWhere('id_business', '=', $parentBusinessID)
                    ->get(['id_category', 'category_name']);
//                $category = DB::table('category')->where(['id_business' => $userBusinessID, 'category_name' => $filter ])->get();
                $response['categoriesByBusiness'] = $category;
                break;
            case 'tags':
                $tag = DB::table('tag')->paginate(10);
                $response['response'] = $tag;
                break;
            case 'tagsByBusiness':
                $userBusinessID = Auth::user()->businesse_id;
                $parentBusinessID = DB::table('businesses')
                    ->where('id_businesses', '=', $userBusinessID)
                    ->get('parent_id');
                $filter = ($request->filter) . '%';
                $parentBusinessID = $parentBusinessID[0]->parent_id;
                $category = DB::table('tag')
                    ->where([['id_business', '=', $userBusinessID],
                        ['tag_name', 'LIKE', '%' . $filter . '%']])
                    ->orWhere('id_business', '=', $parentBusinessID)
                    ->get(['id_tag', 'tag_name']);
//                $category = DB::table('category')->where(['id_business' => $userBusinessID, 'category_name' => $filter ])->get();
                $response['tagsByBusiness'] = $category;
                break;
            case 'selectedCategoriesAndTags':
                $userBusinessID = Auth::user()->businesse_id;
                $id_customer = $request->id_customer;
                $category = DB::table('customerSelectedCategoriesName')->where('id_customer', '=', $id_customer)->get();
                $response['customerSelectedCategoriesName'] = $category;
                $tag = DB::table('customerSelectedTagsName')->where('id_customer', '=', $id_customer)->get();
                $response['customerSelectedTagsName'] = $tag;
                break;
            case 'customerByInput':
                $userBusinessID = Auth::user()->businesse_id;
                $input = $request->input;
                $filterForCustomerSearch = explode(',', $request->filterForCustomerSearch);
                $searchResult = array();
//                error_log('$filterForCustomerSearch = ');
//                error_log($filterForCustomerSearch[0] );
                foreach ($filterForCustomerSearch as $filter) {
//                    $searchQueryResult = DB::table('customers')CUs
//                        ->where($filter, 'like', '%' . $input . '%')
//                        ->get();
                    $searchQueryResult = Customer::
                    where('name', 'like', '%' . $input . '%')
                        ->limit(10)->get();

                    foreach ($searchQueryResult as $result) {
                        if (count($searchResult) > 0) {

                            error_log($result->id_customers);
                            $index = array_search($result->id_customers, array_column($searchResult, "id_customers"));
                            error_log($index);
                            if (false !== $index) {
                                error_log('if');
                            } else {
                                error_log('else');
                                array_push($searchResult, $result);
                            }
                        } else {
                            array_push($searchResult, $result);
                        }
                    }
                }
                $response['searchResult'] = $searchResult;
                break;
            case 'customerByCardNumber':
                $userBusinessID = Auth::user()->businesse_id;
                $card_number = $request->card_number;
                $mode = $request->mode;
                if ($mode == 'null') {
                    $searchQueryResult = Customer::
                    where([['registration_origin', '=', $userBusinessID],
                        ['card_number', 'like', $card_number . '%'],
                        ['name', '=', '-'],
                        ['is_deleted', '!=', 1]])
                        ->limit(10)->get();
                } else {
                    $searchQueryResult = Customer::
                    where([['registration_origin', '=', $userBusinessID],
                        ['card_number', 'like', $card_number . '%'],
                        ['is_deleted', '!=', 1]])
                        ->limit(10)->get();
                }

                $response['searchResult'] = $searchQueryResult;
                break;
            case 'customerNullCardNumber':
                $userBusinessID = Auth::user()->businesse_id;

                $queryResult = Customer::
                where([
                    ['registration_origin', '=', $userBusinessID],
                    ['name', '=', '-'],
                    ['is_deleted', '!=', 1]])
                    ->paginate(10);
                $response['nullCards'] = $queryResult;
                break;
        }

        error_log('$response = ');
        error_log(json_encode($response));

//        return Response(['status' => 'Done', 'availableCardNumber' => $availableCardNumber], 200);
        return Response($response, 200);
    }

    public function customer_new(Request $request)
    {
        error_log('*******************************');
        error_log('request = ' . $request);
        error_log('*******************************');
        $type = $request['type'];
        $numberOfNewRecords = 0;
        error_log($type);
        switch ($type) {
            case 'individual':
                $is_it_new_registration = $request->is_it_new_registration;
                $name = $request->name;
                $family = $request->family;
                $father_name = $request->father_name;
                $national_code = $request->national_code;
                $gender = $request->gender;
                $mobile = $request->mobile;
                $mobile_verified_at = $request->mobile_verified_at;
                $phone = $request->phone;
                $email = $request->email;
                $email_verified_at = $request->email_verified_at;
                $have_social = $request->have_social;
                $birthday = $request->birthday;
                $marriage_status = $request->marriage_status;
                $wedding_anniversary = $request->wedding_anniversary;
                $education = $request->education;
                $field = $request->field;
                $address = $request->address;
                $registration_origin = $request->registration_origin;
                $website = $request->website;
                $finding_way = $request->finding_way;
                $job = $request->job;
                $card_number = $request->card_number;
                $bank_account = $request->bank_account;
                $wallet = $request->wallet;
                $score = $request->score;
                $password = $request->password;
                $categories = ($request->categories);
                $tags = ($request->tags);

                $customer_ip = $_SERVER['REMOTE_ADDR'];

                $card_number = preg_replace("/[^0-9]/", "", $card_number);
                if (strlen($mobile_verified_at) == 0) {
                    $mobile_verified_at = "NULL";
                }
                if (strlen($email_verified_at) == 0) {
                    $email_verified_at = "NULL";
                }
                if (strlen($have_social) == 0) {
                    $have_social = "1";
                }
                if (strlen($registration_origin) == 0) {
                    $registration_origin = "1";
                }
                if (strlen($wedding_anniversary) == 0) {
                    $wedding_anniversary = "Null";
                }
                if (strlen($wallet) == 0) {
                    $wallet = 0.00;
                }
                if (strlen($score) == 0) {
                    $score = 0;
                }
                if (strlen($password)) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                } else {
                    $password = password_hash('secret', PASSWORD_DEFAULT);
                }

                if (strlen($card_number) == 0) {
                    $lastCardNumber = DB::table('customers')->where('card_number', 'like', '90%')
                        ->orderBy('created_at', 'desc')->get('card_number');
                    error_log('$lastCardNumber = ' . $lastCardNumber);
                    error_log('count($lastCardNumber) = ' . count($lastCardNumber));
                    if (count($lastCardNumber) > 0) {

                        $card_number = $lastCardNumber[0]->card_number + 1;
                        error_log('count($lastCardNumber) > 0');
                    } else {
                        $card_number = '9009000000000001';
                        error_log($card_number);
                    }
                }

                $query = "CALL sp_register_new_customer  ($is_it_new_registration,'$name', '$family', '$father_name','$national_code', '$gender', '$mobile', '$phone', '$email',
                                 '$have_social', '$birthday', '$marriage_status', $wedding_anniversary, '$education', '$field', '$address',
                                 '$registration_origin', '$website', '$finding_way', '$job','$card_number','$wallet','$score',
                                 '$customer_ip', '$password')";
                error_log('sp_register_new_customer -> $query = ' . $query);
                if ($is_it_new_registration === 'true') {
                    try {
                        $queryResult = DB:: select(DB::raw($query));
                        $numberOfNewRecords += 1;
                        error_log('query successfull');
                    } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                        error_log('query error = ' . $ex->getMessage());
                        error_log('query error code= ' . $ex->getCode());
                        return Response(['status' => 'error', 'code' => 2], 409);
                    }
                    $id_customer = $queryResult[0]->id_customers;
                } else {
                    $id_customer = $request->id_customer;
                }


                error_log('$id_customer = ');
                error_log($id_customer);
                $categories = json_decode($categories, true);
                $tags = json_decode($tags, true);
//        error_log('$categories = ***');
//        error_log($categories);
//        error_log($categories[0]['id_category']);
//        error_log('***');
                error_log('count($categories) =');
                error_log(count($categories));
                error_log('count($tags) =');
                error_log(count($tags));
                if (count($categories) > 0) {
                    foreach ($categories as $category) {
                        error_log('customer_category_junction');
                        $id_category = $category['id_category'];
                        error_log('$id_category = ');
                        error_log($id_category);
//            DB::table('customer_category_junction')->insert(["id_customer" => $id_customer, "id_category" => $id_category]);
                        $query = "CALL sp_customer_category_junction_add  ('$id_customer','$id_category')";
                        try {
                            $queryResult = DB:: select(DB::raw($query));
                            error_log('sp_customer_category_junction_add query successfull');

                        } catch (\Illuminate\Database\QueryException $ex) {
                            error_log('query error = ' . $ex->getMessage());
                            error_log('query error code= ' . $ex->getCode());
                            return Response(['status' => 'error', 'code' => 2], 409);
                        }
                    }
                } else {
                    $query = "CALL sp_customer_category_junction_add  ('$id_customer','0')";
                    try {
                        $queryResult = DB:: select(DB::raw($query));
                        error_log('sp_customer_category_junction_add query successfull');

                    } catch (\Illuminate\Database\QueryException $ex) {
                        error_log('query error = ' . $ex->getMessage());
                        error_log('query error code= ' . $ex->getCode());
                        return Response(['status' => 'error', 'code' => 2], 409);
                    }
                }

                if (count($tags) > 0) {
                    foreach ($tags as $tag) {
                        error_log('customer_tag_junction');
                        $id_tag = $tag['id_tag'];
                        error_log('$id_tag = ');
                        error_log($id_tag);
//            DB::table('customer_tag_junction')->insert(["id_customer" => $id_customer, "id_tag" => $id_tag]);
                        $query = "CALL sp_customer_tag_junction_add  ('$id_customer','$id_tag')";
                        try {
                            $queryResult = DB:: select(DB::raw($query));
                            error_log('sp_customer_tag_junction_add query successfull');

                        } catch (\Illuminate\Database\QueryException $ex) {
                            error_log('query error = ' . $ex->getMessage());
                            error_log('query error code= ' . $ex->getCode());
                            return Response(['status' => 'error', 'code' => 2], 409);
                        }
                    }
                } else {
                    $query = "CALL sp_customer_tag_junction_add  ('$id_customer','0')";
                    try {
                        $queryResult = DB:: select(DB::raw($query));
                        error_log('sp_customer_tag_junction_add query successfull');

                    } catch (\Illuminate\Database\QueryException $ex) {
                        error_log('query error = ' . $ex->getMessage());
                        error_log('query error code= ' . $ex->getCode());
                        return Response(['status' => 'error', 'code' => 2], 409);
                    }
                }

                break;
            case 'group':
//                $customers = json_decode($request->getContent(), true);
//                error_log($customers['csv'][0]['name']);//assoc
                $customers = json_decode($request->getContent());
//                error_log($customers->csv[0]->name);
                foreach ($customers->csv as $customer) {

                    error_log($customer->name);
                    $is_it_new_registration = 'true';
                    $name = $customer->name;
                    $family = $customer->family;
                    $father_name = $customer->father_name;
                    $national_code = $customer->national_code;
                    $gender = $customer->gender;
                    $mobile = $customer->mobile;
                    $mobile_verified_at = '';
                    $phone = $customer->phone;
                    $email = $customer->email;
                    $email_verified_at = '';
                    $have_social = '1';
                    $birthday = $customer->birthday;
                    $birthday = strtotime($birthday);
                    $birthday = date('Y-m-d', $birthday);
                    $marriage_status = $customer->marriage_status;
                    $wedding_anniversary = $customer->wedding_anniversary;
                    $education = $customer->education;
                    $field = $customer->field;
                    $address = $customer->address;
                    $registration_origin = $customer->registration_origin;
                    $website = $customer->website;
                    $finding_way = $customer->finding_way;
                    $job = $customer->job;
                    $card_number = '';
//                    $bank_account = $customer->bank_account;
                    $wallet = $customer->wallet;
                    $score = $customer->score;
                    $password = 'secret';
//                    $categories = ($customer->categories);
//                    $tags = ($customer->tags);
                    $customer_ip = $_SERVER['REMOTE_ADDR'];


                    $card_number = preg_replace("/[^0-9]/", "", $card_number);
                    if (strlen($mobile_verified_at) == 0) {
                        $mobile_verified_at = "NULL";
                    }
                    if (strlen($email_verified_at) == 0) {
                        $email_verified_at = "NULL";
                    }
                    if (strlen($have_social) == 0) {
                        $have_social = "1";
                    }
                    if (strlen($registration_origin) == 0) {
                        $registration_origin = "1";
                    }
                    if (strlen($wedding_anniversary) == 0) {
                        $wedding_anniversary = "Null";
                    }
                    if (strlen($wallet) == 0) {
                        $wallet = 0.00;
                    }
                    if (strlen($score) == 0) {
                        $score = 0;
                    }
                    if (strlen($password)) {
                        $password = password_hash($password, PASSWORD_DEFAULT);
                    } else {
                        $password = password_hash('secret', PASSWORD_DEFAULT);
                    }

                    if (strlen($card_number) == 0) {

                        $card_pre_number = DB::table('businesses')->where('id_businesses', '=', $registration_origin)
                            ->get('card_pre_number');
                        $card_pre_number = $card_pre_number[0]->card_pre_number;
                        error_log($card_pre_number);
                        $lastCardNumber = DB::table('customers')->where('card_number', 'like', $card_pre_number . '%')
                            ->orderBy('created_at', 'desc')->get('card_number');
                        error_log('$lastCardNumber = ' . $lastCardNumber);
                        error_log('count($lastCardNumber) = ' . count($lastCardNumber));
                        if (count($lastCardNumber) > 0) {

                            $card_number = $lastCardNumber[0]->card_number + 1;
                            error_log('count($lastCardNumber) > 0');
                        } else {
                            $card_number = $card_pre_number . '000000000001';
                            error_log($card_number);
                        }
                    }

                    $query = "CALL sp_register_new_customer  ($is_it_new_registration,'$name', '$family', '$father_name','$national_code', '$gender', '$mobile', '$phone', '$email',
                                 '$have_social', '$birthday', '$marriage_status', $wedding_anniversary, '$education', '$field', '$address',
                                 '$registration_origin', '$website', '$finding_way', '$job','$card_number','$wallet','$score',
                                 '$customer_ip', '$password')";
                    error_log('sp_register_new_customer -> $query = ' . $query);
                    if ($is_it_new_registration === 'true') {
                        try {
                            $queryResult = DB:: select(DB::raw($query));
                            $numberOfNewRecords += 1;
                            error_log('query successfull');
                        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                            error_log('query error = ' . $ex->getMessage());
                            error_log('query error code= ' . $ex->getCode());
                            return Response(['status' => 'error', 'code' => 2], 409);
                        }
                        $id_customer = $queryResult[0]->id_customers;
                    }
                }
                break;
        }

//        return Response(['status' => 'done', 'code' => 1, 'data' => $queryResult], 200);
        return Response(['status' => 'done', 'code' => 1, 'data' => 1, 'numberOfNewRecords' => $numberOfNewRecords], 200);
    }

    public function show_customer_v_view(Request $request)
    {
        $view = $request['v'];
        $viewInReturn = '';
        $activeView = '';
        error_log("show_" . $view . "_view");

        switch ($view) {
            case 'instant-charge':
                $viewInReturn = 'admin.customers.customers-instant-charge';
                break;
            case 'category':
                $viewInReturn = 'admin.customers.customer-category';
                break;
            case 'tag':
                $viewInReturn = 'admin.customers.customer-tag';
                break;
            case 'card':
                $viewInReturn = 'admin.customers.customer-card';
                break;
            case 'group-card':
                $viewInReturn = 'admin.customers.customer-card-group';
                break;
            case 'list':
                $activeView = 'list';
                $viewInReturn = 'admin.customers.customers-index';
                break;
            case 'add':
                $activeView = 'add';
                $viewInReturn = 'admin.customers.customers-index';
                break;
        }
        return view($viewInReturn)->with('activeView', $activeView);
    }

    public function customer_do_this_action(Request $request)
    {
        error_log('customer_do_this_action -> ');
        $do_this = $request['this'];

        $response = array();
        $status = '';

        switch ($do_this) {
            case 'promotionalCharge':
                $id_target_customer = $request['id_target_customer'];
                $id_creator_user = $userDetail = Auth::user()->id_users;
                $wallet_charge = $request['wallet_charge'];
                $score_charge = $request['score_charge'];
                $description = $request['description'];
                $creator_user_ip = $_SERVER['REMOTE_ADDR'];
                error_log('$request = ');
                error_log($request);

                $query = "CALL sp_charge_customer_add ('$id_target_customer', '$wallet_charge',
                                    '$score_charge' ,'$description' ,'$id_creator_user' ,
                                    '$creator_user_ip')";

                try {
                    $queryResult = DB:: select(DB::raw($query));
                    $status = 'Done';
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    $status = 'Failed';
                }
                break;
            case 'createNewCategory':
                $category_name = $request['category_name'];
                $id_creator_user = Auth::user()->id_users;
                $id_business = Auth::user()->businesse_id;
                $description = $request['description'];
                $creator_user_ip = $_SERVER['REMOTE_ADDR'];


                $query = "CALL sp_category_add('$category_name' , '$description' ,
                                 '$id_creator_user' , '$id_business' ,
                                 '$creator_user_ip' )";

                try {
                    $queryResult = DB:: select(DB::raw($query));
                    $status = 'Done';
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    $status = 'Failed';
                }
                break;
            case 'editCategory':
                $id_category = $request['id_category'];
                $category_name = $request['category_name'];
                $id_creator_user = Auth::user()->id_users;
                $id_business = Auth::user()->businesse_id;
                $description = $request['description'];
                $creator_user_ip = $_SERVER['REMOTE_ADDR'];


                $query = "CALL sp_category_edit('$id_category' ,'$category_name' , '$description' ,
                                 '$id_creator_user' ,'$creator_user_ip' )";

                try {
                    $queryResult = DB:: select(DB::raw($query));
                    $status = 'Done';
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    $status = 'Failed';
                }
                break;
            case 'createNewTag':
                $tag_name = $request['tag_name'];
                $id_creator_user = Auth::user()->id_users;
                $id_business = Auth::user()->businesse_id;
                $description = $request['description'];
                $creator_user_ip = $_SERVER['REMOTE_ADDR'];


                $query = "CALL sp_tag_add('$tag_name' , '$description' ,
                                 '$id_creator_user' , '$id_business' ,
                                 '$creator_user_ip' )";

                try {
                    $queryResult = DB:: select(DB::raw($query));
                    $status = 'Done';
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    $status = 'Failed';
                }
                break;
            case 'editTag':
                $id_tag = $request['id_tag'];
                $tag_name = $request['tag_name'];
                $id_creator_user = Auth::user()->id_users;
                $id_business = Auth::user()->businesse_id;
                $description = $request['description'];
                $creator_user_ip = $_SERVER['REMOTE_ADDR'];


                $query = "CALL sp_tag_edit('$id_tag' ,'$tag_name' , '$description' ,
                                 '$id_creator_user' ,'$creator_user_ip' )";

                try {
                    $queryResult = DB:: select(DB::raw($query));
                    $status = 'Done';
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    $status = 'Failed';
                }
                break;
            case 'categoryActivationStatus':
                $id_category = $request['id_category'];
                $value = $request['value'];

                DB::table('category')
                    ->where('id_category', $id_category)
                    ->update(['is_active' => $value]);
                break;
            case 'tagActivationStatus':
                $id_tag = $request['id_tag'];
                $value = $request['value'];

                DB::table('tag')
                    ->where('id_tag', $id_tag)
                    ->update(['is_active' => $value]);
                break;
            case 'nullCard':
                $numberOfCards = $request['count'];
                $start_card_number = $request['startCardNumber'];
                $creator_user_ip = $_SERVER['REMOTE_ADDR'];
                $business_id = Auth::user()->businesse_id;

                $query = "CALL  sp_customer_null_card($start_card_number, '$numberOfCards', '$business_id',
                                       '$creator_user_ip' )";
                $queryResult = '';
                try {
                    $queryResult = DB:: select(DB::raw($query));
                    $status = 'Done';
//                    $response['card_numbers'] = $queryResult;
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    $status = 'Failed';
                    $response['card_numbers'] = 'Failed';
                }


                error_log('$r->id');
//                error_log($queryResult[0]->card_number);

                foreach ($queryResult as $r) {

                    error_log('$r->card_number = ');
                    error_log($r->card_number);

                    $r->qr = 'data:image/png;base64,' . base64_encode(QrCode::format('png')->encoding('UTF-8')->errorCorrection('M')->size(300)->generate($r->card_number));
                }
                $response['card_numbers'] = $queryResult;


                break;
            case 'delete':
                $userBusinessID = Auth::user()->businesse_id;
                $id_customer = $request->id;
                $queryResult = Customer::
                where([
                    ['name', '=', '-'],
                    ['id_customers', '=', $id_customer]])
                    ->update(['is_deleted' => 1]);
                $status = 'Done';
                break;
        }
        error_log('End of customer_do_this - ' . $do_this);

        return Response(['status' => $status, 'response' => $response,], 200);
    }

//****************************************************************************Customer
//****************************************************************************Product / Service
    public function services()
    {
        return view('admin.services.services-index');
    }

    public function show_service_v_view(Request $request)
    {
        $view = $request['v'];
        $viewInReturn = '';
        $activeView = '';

        error_log("show_" . $view . "_view");
        error_log('CHECK');
        switch ($view) {
            case 'list':
                $activeView = 'list';
                $viewInReturn = 'admin.services.services-index';
                break;
            case 'add':
                $activeView = 'add';
                $viewInReturn = 'admin.services.services-index';
                break;
            case 'category':
                $viewInReturn = 'admin.services.services-category';
                break;
            case 'tag':
                $viewInReturn = 'admin.services.services-tag';
                break;
        }
        return view($viewInReturn)->with('activeView', $activeView);
    }

    public function serviceAction(Request $request)
    {
        $action = $request['action'];
        $service_id = $request['id_service'];
        $value = $request['value'];
        $result = '';

        try {

            switch ($action) {

                case 'is_active':
                    DB::table('services')
                        ->where('id_services', $service_id)
                        ->update(['is_active' => $value]);
                    break;
            }
            $result = 'Done';
            error_log($result);
        } catch (\Illuminate\Database\QueryException $e) {
            $result = 'error';
            error_log($e);
        }


        error_log($action);
        error_log($service_id);
        error_log($result);

        return Response(['action' => $action, 'user_id' => $service_id, 'value' => $value], 200);
    }

    public function service_type(Request $request)
    {
        $type = $request['type'];
        $services = '';
        error_log('service_type => ' . $type);
        switch ($type) {
            case 'index':
                $page = $request['page'];
                $services = Service::paginate(10);
                break;

            case 'all':
                $services = Service::all();
                $services = array('current_page' => 0, 'data' => $services);
                break;
        }


        return Response(['status' => 'Done', 'data' => $services], 200);
    }

    public function service_get_this(Request $request)
    {
        error_log($request);
        $get_this = $request['this'];

        error_log('service_get_this - ' . $get_this);
        $response = array();
        $response['status'] = 'Done';

        switch ($get_this) {

            case 'getAllDataForServiceEdit':
                $id_user = $request['userID'];
                $id_business = $request['businessID'];
                error_log('id_user = ' . $id_user);
                error_log('id_business = ' . $id_business);
                $serviceDetail = DB::table('businesses')->where('id_businesses', '=', $id_business)->get();;
                $response['business'] = $serviceDetail[0];
                $userDetail = DB::table('users')->where('id_users', '=', $id_user)->get();;
                $response['user'] = $userDetail[0];
                break;
            case 'categories':
                $category = DB::table('services_category_name')->paginate(10);
                $response['response'] = $category;
                break;
            case 'tags':
                $tag = DB::table('services_tag_name')->paginate(10);
                $response['response'] = $tag;
                break;
            case 'categoriesByBusiness':
                $userBusinessID = Auth::user()->businesse_id;
                $filter = $request->query('filter');
                error_log('$filter');
                error_log($filter);
                $category = DB::table('services_category_name')->where([['id_business', '=', $userBusinessID], ['category_name', 'LIKE', '%' . $filter . '%']])->get(['id_services_category_name', 'category_name']);
//                $category = DB::table('category')->where(['id_business' => $userBusinessID, 'category_name' => $filter ])->get();
                $response['categoriesByBusiness'] = $category;
                break;
            case 'tagsByBusiness':
                $userBusinessID = Auth::user()->businesse_id;
                $filter = ($request->filter);
                error_log('$filter');
                error_log($filter);
                $category = DB::table('services_tag_name')->where([['id_business', '=', $userBusinessID], ['tag_name', 'LIKE', '%' . $filter . '%']])->get(['id_services_tag_name', 'tag_name']);
//                $category = DB::table('category')->where(['id_business' => $userBusinessID, 'category_name' => $filter ])->get();
                $response['tagsByBusiness'] = $category;
                break;
            case 'selectedCategoriesAndTags':
                $userBusinessID = Auth::user()->businesse_id;
                $id_service = $request->query('id_services');
                $category = DB::table('serviceSelectedCategoriesName')->where('id_service', '=', $id_service)->get();
                $response['serviceSelectedCategoriesName'] = $category;
                $tag = DB::table('serviceSelectedTagsName')->where('id_service', '=', $id_service)->get();
                $response['serviceSelectedTagsName'] = $tag;
                break;
        }


//        return Response(['status' => 'Done', 'availableCardNumber' => $availableCardNumber], 200);
        return Response($response, 200);
    }

    public function service_do_this_action(Request $request)
    {
        $do_this = $request['this'];
        error_log('service_do_this_action -> ' . $do_this);


        $response = array();
        $status = '';

        switch ($do_this) {
            case 'createNewCategory':
                $category_name = $request['category_name'];
                $id_creator_user = Auth::user()->id_users;
                $id_business = Auth::user()->businesse_id;
                $description = $request['description'];
                $creator_user_ip = $_SERVER['REMOTE_ADDR'];


                $query = "CALL sp_services_category_name_add('$category_name' , '$description' ,
                                 '$id_creator_user' , '$id_business' ,
                                 '$creator_user_ip' )";

                try {
                    $queryResult = DB:: select(DB::raw($query));
                    $status = 'Done';
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    $status = 'Failed';
                }
                break;
            case 'editCategory':
                $id_category = $request['id_category'];
                $category_name = $request['category_name'];
                $id_creator_user = Auth::user()->id_users;
                $id_business = Auth::user()->businesse_id;
                $description = $request['description'];
                $creator_user_ip = $_SERVER['REMOTE_ADDR'];


                $query = "CALL sp_services_category_name_edit('$id_category' ,'$category_name' , '$description' ,
                                 '$id_creator_user' ,'$creator_user_ip' )";

                try {
                    $queryResult = DB:: select(DB::raw($query));
                    $status = 'Done';
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    $status = 'Failed';
                }
                break;
            case 'createNewTag':
                $tag_name = $request['tag_name'];
                $id_creator_user = Auth::user()->id_users;
                $id_business = Auth::user()->businesse_id;
                $description = $request['description'];
                $creator_user_ip = $_SERVER['REMOTE_ADDR'];


                $query = "CALL sp_services_tag_name_add('$tag_name' , '$description' ,
                                 '$id_creator_user' , '$id_business' ,
                                 '$creator_user_ip' )";

                try {
                    $queryResult = DB:: select(DB::raw($query));
                    $status = 'Done';
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    $status = 'Failed';
                }
                break;
            case 'editTag':
                $id_tag = $request['id_tag'];
                $tag_name = $request['tag_name'];
                $id_creator_user = Auth::user()->id_users;
                $id_business = Auth::user()->businesse_id;
                $description = $request['description'];
                $creator_user_ip = $_SERVER['REMOTE_ADDR'];


                $query = "CALL sp_services_tag_edit('$id_tag' ,'$tag_name' , '$description' ,
                                 '$id_creator_user' ,'$creator_user_ip' )";

                try {
                    $queryResult = DB:: select(DB::raw($query));
                    $status = 'Done';
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    $status = 'Failed';
                }
                break;
            case 'categoryActivationStatus':
                $id_category = $request['id_category'];
                $value = $request['value'];
                error_log('$id_category = ' . $id_category);
                error_log('$value = ' . $value);

                DB::table('services_category_name')
                    ->where('id_services_category_name', $id_category)
                    ->update(['is_active' => $value]);
                break;
            case 'tagActivationStatus':
                $id_tag = $request['id_tag'];
                $value = $request['value'];
                error_log('$id_tag = ' . $id_tag);
                error_log('$value = ' . $value);

                DB::table('services_tag_name')
                    ->where('id_services_tag_name', $id_tag)
                    ->update(['is_active' => $value]);
                break;
        }
        error_log('End of customer_do_this - ' . $do_this);

        return Response(['status' => $status, 'response' => $response,], 200);
    }

    public function service_new(Request $request)
    {
        error_log('*******************************');
        error_log('request = ' . $request);
        error_log('*******************************');

        $type = $request['type'];
        $numberOfNewRecords = 0;
        error_log($type);
        switch ($type) {
            case 'individual':
                $is_it_new_registration = $request->is_it_new_registration;
                $id_services = $request->id_services;
                $id_business = $request->id_business;
                $name = $request->name;
                $sync_code = $request->sync_code;
                $description = $request->description;
                $price = $request->price;
                $is_edited = $request->is_edited;
                $expire_at = $request->expire_at;
                $updated_at = $request->updated_at;
                $is_active = $request->is_active;

                $categories = ($request->categories);
                $tags = ($request->tags);

//        $creator_user_id = auth()->user()->id;
                $creator_user_id = Auth::user()->id_users;

                error_log('$creator_user_id = ');
                error_log($creator_user_id);

                $creator_user_ip = $_SERVER['REMOTE_ADDR'];

                $query = "CALL sp_create_new_service ($is_it_new_registration,'$id_services','$id_business', '$name', '$sync_code',
        '$description', '$price','1', '$creator_user_id', '$creator_user_ip','$expire_at')";
                error_log('sp_create_new_service -> $query = ' . $query);

                try {
                    $queryResult = DB:: select(DB::raw($query));
                    error_log('sp_create_new_service query successfull');
                } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    return Response(['status' => 'error', 'code' => 2], 409);
                }

                $categories = json_decode($categories, true);
                $tags = json_decode($tags, true);
//        error_log('$categories = ***');
//        error_log($categories);
//        error_log($categories[0]['id_category']);
//        error_log('***');
                error_log('count($categories) =');
                error_log(count($categories));
                error_log('count($tags) =');
                error_log(count($tags));

                if (count($categories) > 0) {
                    foreach ($categories as $category) {
                        error_log('service_services_category_name_junction');
                        $id_category = $category['id_services_category_name'];
                        error_log('$id_category = ');
                        error_log($id_category);
                        $query = "CALL sp_service_services_category_name_junction_add  ('$id_services','$id_category')";
                        try {
                            $queryResult = DB:: select(DB::raw($query));
                            error_log('sp_customer_category_junction_add query successfull');

                        } catch (\Illuminate\Database\QueryException $ex) {
                            error_log('query error = ' . $ex->getMessage());
                            error_log('query error code= ' . $ex->getCode());
                            return Response(['status' => 'error', 'code' => 2], 409);
                        }
                    }
                } else {
                    $query = "CALL sp_service_services_category_name_junction_add  ('$id_services','0')";
                    try {
                        $queryResult = DB:: select(DB::raw($query));
                        error_log('sp_service_services_category_name_junction_add query successfull');

                    } catch (\Illuminate\Database\QueryException $ex) {
                        error_log('query error = ' . $ex->getMessage());
                        error_log('query error code= ' . $ex->getCode());
                        return Response(['status' => 'error', 'code' => 2], 409);
                    }
                }

                if (count($tags) > 0) {
                    foreach ($tags as $tag) {
                        error_log('service_services_tag_name_junction');
                        $id_tag = $tag['id_services_tag_name'];
                        error_log('$id_tag = ');
                        error_log($id_tag);
//            DB::table('customer_tag_junction')->insert(["id_customer" => $id_customer, "id_tag" => $id_tag]);
                        $query = "CALL sp_service_services_tag_name_junction_add  ('$id_services','$id_tag')";
                        try {
                            $queryResult = DB:: select(DB::raw($query));
                            error_log('sp_service_services_tag_name_junction_add query successfull');

                        } catch (\Illuminate\Database\QueryException $ex) {
                            error_log('query error = ' . $ex->getMessage());
                            error_log('query error code= ' . $ex->getCode());
                            return Response(['status' => 'error', 'code' => 2], 409);
                        }
                    }
                } else {
                    $query = "CALL sp_service_services_tag_name_junction_add  ('$id_services','0')";
                    try {
                        $queryResult = DB:: select(DB::raw($query));
                        error_log('service_services_tag_name_junction query successfull');

                    } catch (\Illuminate\Database\QueryException $ex) {
                        error_log('query error = ' . $ex->getMessage());
                        error_log('query error code= ' . $ex->getCode());
                        return Response(['status' => 'error', 'code' => 2], 409);
                    }
                }


                break;
            case 'group':
//                $customers = json_decode($request->getContent(), true);
//                error_log($customers['csv'][0]['name']);//assoc
                $services = json_decode($request->getContent());
//                error_log($customers->csv[0]->name);
                error_log('count($services->csv) = ');
                error_log(count($services->csv));

                foreach ($services->csv as $service) {
                    $is_it_new_registration = 'true';
                    $id_business = $service->id_business;
                    $name = $service->name;
                    $sync_code = $service->sync_code;
                    $description = $service->description;
                    $price = $service->price;
                    $expire_at = $service->expire_at;

                    $creator_user_id = Auth::user()->id_users;
                    $creator_user_ip = $_SERVER['REMOTE_ADDR'];

                    $query = "CALL sp_create_new_service ($is_it_new_registration,'1','$id_business', '$name', '$sync_code',
                            '$description', '$price','1', '$creator_user_id', '$creator_user_ip','$expire_at')";
                    error_log('sp_create_new_service -> $query = ' . $query);


                    try {
                        $queryResult = DB:: select(DB::raw($query));
                        $numberOfNewRecords += 1;
                        error_log('query successfull');
                    } catch (\Illuminate\Database\QueryException $ex) {
                        error_log('query error = ' . $ex->getMessage());
                        error_log('query error code= ' . $ex->getCode());
                        return Response(['status' => 'error', 'code' => 2], 409);
                    }

                    error_log('$numberOfNewRecords = ');
                    error_log($numberOfNewRecords);
                }
                break;
        }


        return Response(['status' => 'done', 'code' => 1, 'data' => 1,
            'numberOfNewRecords' => $numberOfNewRecords], 200);

    }

    public function services_load_type(Request $request)
    {
        $type = $request['type'];
        $services = '';
        error_log('services_load_type => ' . $type);
        switch ($type) {
            case 'index':
                $page = $request['page'];
                $services = Service::paginate(10);
                break;

            case 'all':
                $services = Service::all();
                $services = array('current_page' => 0, 'data' => $services);
                break;
        }


        return Response(['status' => 'Done', 'data' => $services], 200);
    }

//****************************************************************************Product / Service
//****************************************************************************X Sens
    public
    function xsenses()
    {
        return view('admin.xsenses.xsenses-index');
    }

    public
    function xsensAction(Request $request)
    {
        $action = $request['action'];
        $service_id = $request['id_service'];
        $value = $request['value'];
        $result = '';

        try {

            switch ($action) {

                case 'is_active':
                    DB::table('customer')
                        ->where('id_services', $service_id)
                        ->update(['is_active' => $value]);
                    break;
            }
            $result = 'Done';
            error_log($result);
        } catch (\Illuminate\Database\QueryException $e) {
            $result = 'error';
            error_log($e);
        }


        error_log($action);
        error_log($service_id);
        error_log($result);

        return Response(['action' => $action, 'user_id' => $service_id, 'value' => $value], 200);
    }

    public
    function xsens_type(Request $request)
    {

        $type = $request['type'];
        $x_senses = '';
        error_log('xsens_type = ' . $type);

        switch ($type) {
            case 'index':
                $page = $request['page'];
                $x_senses = DB::table('v_get_x_sens_table_data')->paginate(10);
                $chords = DB::table('chords')->get();


                break;
            case 'all':
                $x_senses = X_sens::all();
                $x_senses = array('current_page' => 0, 'data' => $x_senses);
                break;
        }


        return Response(['status' => 'Done', 'data' => $x_senses, 'chords' => $chords], 200);
    }

    public
    function xsens_get_this(Request $request)
    {
        error_log($request);
        $get_this = $request['this'];

        error_log('service_get_this - ' . $get_this);
        $response = array();
        $response['status'] = 'Done';

        switch ($get_this) {

            case 'getAllDataForServiceEdit':
                $id_user = $request['userID'];
                $id_business = $request['businessID'];
                error_log('id_user = ' . $id_user);
                error_log('id_business = ' . $id_business);
                $serviceDetail = DB::table('businesses')->where('id_businesses', '=', $id_business)->get();;
                $response['business'] = $serviceDetail[0];
                $userDetail = DB::table('users')->where('id_users', '=', $id_user)->get();;
                $response['user'] = $userDetail[0];
                break;
        }
//        return Response(['status' => 'Done', 'availableCardNumber' => $availableCardNumber], 200);
        return Response($response, 200);
    }

    public
    function xsens_new(Request $request)
    {
        error_log('*******************************');
        error_log('request = ' . $request);
        error_log('*******************************');

//        error_log('image = ' . $request['image']);
//        error_log('brand_name = ' . $request->brand_name);
//        error_log('company_name = ' . $request->company_name);

        $is_it_new_registration = $request->is_it_new_registration;
        $x_sens_name_fa = $request->x_sens_name_fa;
        $x_sens_name_en = $request->x_sens_name_en;
        $first_chord_id = $request->first_chord_id;
        $mid_chord_id = $request->mid_chord_id;
        $last_chord_id = $request->last_chord_id;
        $off_chord = $request->off_chord;
        $description = $request->description;
        if (strlen($off_chord) <= 0) {
            $off_chord = 0;
        }
        if (strlen($last_chord_id) <= 0) {
            $last_chord_id = 0;
        }

        error_log('strlen($last_chord_id) = ');
        error_log(strlen($last_chord_id));

        $last_chord_id = $last_chord_id == '0' ? 'NULL' : $last_chord_id;

        $creator_user_id = Auth::user()->id_users;
        $business_id = Auth::user()->businesse_id;

        error_log('$creator_user_id = ');
        error_log($creator_user_id);

        $creator_user_ip = $_SERVER['REMOTE_ADDR'];

        $sp_name = '';

        if ($is_it_new_registration == 'true') {
            $sp_name = 'sp_create_new_x_sense';
            $query = "CALL sp_create_new_x_sense ('$x_sens_name_fa', '$x_sens_name_en', '$first_chord_id', '$mid_chord_id', $last_chord_id, '$off_chord',
                            '$creator_user_id', '$business_id', '$creator_user_ip','$description')";
        } else if ($is_it_new_registration == 'false') {
            $id_x_senses = $request->id_x_senses;
            $sp_name = 'sp_update_x_sense';
            $query = "CALL sp_update_x_sense ('$id_x_senses','$x_sens_name_fa', '$x_sens_name_en', '$first_chord_id', '$mid_chord_id', $last_chord_id, '$off_chord',
                            '$creator_user_id', '$business_id', '$creator_user_ip','$description')";
        }

        error_log($sp_name . ' -> $query = ' . $query);

        try {
            $queryResult = DB::statement($query);
            return Response(['status' => 'done', 'code' => 1, 'data' => $queryResult], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
            error_log('query error = ' . $ex->getMessage());
            error_log('query error code= ' . $ex->getCode());
            return Response(['status' => 'error', 'code' => 2], 409);
        }
    }

    public
    function xsens_load_type(Request $request)
    {
        $type = $request['type'];
        $services = '';

        switch ($type) {
            case 'index':
                $page = $request['page'];
                $services = Service::paginate(10);
                break;

            case 'all':
                $services = Service::all();
                $services = array('current_page' => 0, 'data' => $services);
                break;
        }


        return Response(['status' => 'Done', 'data' => $services], 200);
    }

//****************************************************************************X Sens
//****************************************************************************services-xsense-junction
    public
    function services_xsense()
    {
        return view('admin.services-xsense.services-xsense-index');
    }

    public
    function services_xsenseAction(Request $request)
    {
        $action = $request['action'];
        $id_services_x_sense_junction = $request['id'];
        $value = $request['value'];
        $result = '';

        try {

            switch ($action) {

                case 'is_active':
                    DB::table('services_x_sense_junction')
                        ->where('id_services_x_sense_junction', $id_services_x_sense_junction)
                        ->update(['is_active' => $value]);
                    break;
            }
            $result = 'Done';
            error_log($result);
        } catch (\Illuminate\Database\QueryException $e) {
            $result = 'error';
            error_log($e);
        }


        error_log($action);
        error_log($id_services_x_sense_junction);
        error_log($result);

        return Response(['action' => $action, '$id_services_x_sense_junction' => $id_services_x_sense_junction, 'value' => $value], 200);
    }

    public
    function services_xsense_type(Request $request)
    {

        $type = $request['type'];
        $services_xsense = '';
        error_log('services_xsense_type = ' . $type);
        $id_business = Auth::user()->businesse_id;


        switch ($type) {
            case 'index':
                $page = $request['page'];
                $services_xsense = DB::table('v_get_SerXsen_table_data')
                    ->where('id_business', '=', $id_business)->paginate(10);
                break;
            case 'all':
                $services_xsense = X_sens::all();
                $services_xsense = array('current_page' => 0, 'data' => $services_xsense);
                break;
        }

        return Response(['status' => 'Done', 'data' => $services_xsense], 200);
    }

    public
    function services_xsense_get_this(Request $request)
    {
//        error_log($request);
        $get_this = $request['this'];

        error_log('services_xsense_get_this -> ' . $get_this);
        $response = array();
        $response['status'] = 'Done';

        switch ($get_this) {

            case 'serXsenList':

                $id_user = Auth::user()->id_users;
                $id_business = Auth::user()->businesse_id;

                if ($id_user == '*') {
                    $services = DB::table('services')->get();
                    $xsens = DB::table('x_senses')->get();
                } else {
                    $services = DB::table('services')->where('id_business', '=', $id_business)->get();
                    $xsens = DB::table('x_senses')->where('business_id', '=', $id_business)->get();
                }

                $response['services'] = $services;
                $response['xsenses'] = $xsens;
                break;
        }
//        return Response(['status' => 'Done', 'availableCardNumber' => $availableCardNumber], 200);
        return Response($response, 200);
    }

    public
    function services_xsense_new(Request $request)
    {
        error_log('*******************************');
        error_log('request = ' . $request);
        error_log('*******************************');

//        error_log('image = ' . $request['image']);
//        error_log('brand_name = ' . $request->brand_name);
//        error_log('company_name = ' . $request->company_name);

        $is_it_new_registration = $request->is_it_new_registration;
        $id_service = $request->id_service;
        $id_x_sense = $request->id_x_sense;
        $off_percent = strlen($request->off_percent) > 0 ? $request->off_percent : '0';
        $score_percent = strlen($request->score_percent) > 0 ? $request->score_percent : '0';
        $cash_back_percent = strlen($request->cash_back_percent) > 0 ? $request->cash_back_percent : '0';
        $cash_back_value = strlen($request->cash_back_value) > 0 ? $request->cash_back_value : '0';
        $expire_at = strlen($request->expire_at) > 0 ? $request->expire_at : date('Y-m-d', strtotime(' +1 day'));

        $creator_user_id = Auth::user()->id_users;
        $business_id = Auth::user()->businesse_id;

        $creator_user_ip = $_SERVER['REMOTE_ADDR'];

        $sp_name = '';

        if ($is_it_new_registration == 'true') {
            $sp_name = 'sp_set_x_sense_on';
            $query = "CALL sp_set_x_sense_on (true, '$id_service','$id_x_sense', '$off_percent', '$score_percent',
                                                     '$cash_back_percent', '$creator_user_id',
                                                     '$creator_user_ip',
                                                     '$expire_at')";
        } else if ($is_it_new_registration == 'false') {
            $id_services_x_sense_junction = $request->id_services_x_sense_junction;
            $cash_back_percent_or_value = $cash_back_value > $cash_back_percent ? $cash_back_value : $cash_back_percent;
            $sp_name = 'sp_update_x_sense_on';
            $query = "CALL sp_update_x_sense_on ('$id_services_x_sense_junction','$id_service','$id_x_sense', '$off_percent', '$score_percent',
                                                     '$cash_back_percent_or_value', '$creator_user_id',
                                                     '$creator_user_ip',
                                                     '$expire_at')";
        }

        error_log($sp_name . ' -> $query = ' . $query);

        try {
            $queryResult = DB::statement($query);
            return Response(['status' => 'done', 'code' => 1, 'data' => $queryResult], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
            error_log('query error = ' . $ex->getMessage());
            error_log('query error code= ' . $ex->getCode());
            return Response(['status' => 'error', 'code' => 2], 409);
        }
    }

//****************************************************************************services-xsense-junction
//****************************************************************************purchase
    public
    function purchase(Request $request)
    {
        $view = $request->view;
        switch ($view) {

            case 'purchase':
                return view('admin.financial.purchase');
                break;
            case 'history':
                return view('admin.financial.purchase-history');
                break;

        }
        return;
    }

    public
    function purchase_get_this(Request $request)
    {
//        error_log($request);
        $get_this = $request['this'];

        error_log('purchase_get_this -> ' . $get_this);
        $response = array();
        $response['status'] = 'Done';

        switch ($get_this) {

            case 'customerDetail':
                $mobile = $request->mobile;
                error_log('mobile = ');
                error_log($mobile);
                $customer_detail = DB::table('customers')->where('mobile', '=', $mobile)->get();
                $response['customerDetail'] = $customer_detail;
                break;
            case 'purchaseList':

                $id_user = Auth::user()->id_users;
                $id_business = Auth::user()->businesse_id;

                if ($id_user == '*') {
                    $services = DB::table('v_get_services_list')->get();
                } else {
                    $services = DB::table('v_get_services_list')
                        ->where([['id_business', '=', $id_business], ['price', '>', '1']])
                        ->get();
                }

                $response['services'] = $services;
                break;
            case 'history':
                $page = $request['page'];
                $id_business = Auth::user()->businesse_id;

                try {
                    $historyList = DB::table('v_get_invoice_history')
                        ->where('id_business', '=', $id_business)
                        ->paginate(10);
                } catch (QueryException   $e) {
                    error_log($e->getMessage());
                }

                $response['historyList'] = $historyList;
                break;
            case 'historyByInput':
                $page = $request['page'];
                $filter = $request['filter'];
                $filterValue = $request['value'];
                $id_business = Auth::user()->businesse_id;
                $searchResult = array();
                error_log('filter = ');
                error_log($filter);
                error_log('value = ');
                error_log($filterValue);

                try {
                    $historyList = DB::table('v_get_invoice_history')
                        ->where([['id_business', '=', $id_business], [$filter, 'like', '%' . $filterValue . '%']])
                        ->limit(10)->get();
                    foreach ($historyList as $result) {
                        if (count($historyList) > 0) {
                            $index = array_search($result->invoice_no, array_column($searchResult, "invoice_no"));
                            error_log($index);
                            if (false !== $index) {
//                                error_log('if');
                            } else {
//                                error_log('else');
                                array_push($searchResult, $result);
                            }
                        } else {
                            array_push($searchResult, $result);
                        }
                    }
                } catch (QueryException   $e) {
                    error_log($e->getMessage());
                }


//                $response['searchResult'] = $searchResult;
                $response['searchResult'] = $historyList;
                break;
            case 'invoiceItems':
                $invoice_no = $request['invoice_number'];
                $id_business = Auth::user()->businesse_id;
                $invoiceItems = [];

                try {
                    $invoiceItems = DB::table('v_getInvoiceItems')
                        ->where('invoice_no', '=', $invoice_no)->get();

                } catch (QueryException   $e) {
                    error_log($e->getMessage());
                }
                $response['invoiceItems'] = $invoiceItems;
                break;
            case 'delete':
                $invoice_no = $request['invoice_number'];
                $id_business = Auth::user()->businesse_id;

                try {


                } catch (QueryException   $e) {
                    error_log($e->getMessage());
                }
                $response['delete'] = 'Done';
                break;
        }
//        return Response(['status' => 'Done', 'availableCardNumber' => $availableCardNumber], 200);
        return Response($response, 200);
    }

    public
    function purchase_do_this(Request $request)
    {
//        error_log($request);
        $do_this = $request['this'];

        error_log('purchase_do_this -> ' . $do_this);
        $response = array();
        $response['status'] = 'Done';

        switch ($do_this) {

            case 'delete':
                $invoice_no = $request['invoice_number'];
                $id_business = Auth::user()->businesse_id;

                try {


                } catch (QueryException   $e) {
                    error_log($e->getMessage());
                }
                $response['delete'] = 'Done';
                break;
        }
        return Response($response, 200);
    }

    public
    function doPurchase_V0(Request $request)
    {
        error_log('*****************************');
        error_log($request);
        error_log('*****************************');
        $req = $request->getContent();
        $req = json_decode($req);
        error_log('$req = ' . $req->services[0]->price);
        error_log('count = ' . count($req->services));

        $id_customer = $req->customer->id_customers;
        $invoice_total_items = $req->invoiceTotalItems;
        $preferred_score_usage_in_percent = $req->preferredPercents->score;
        $preferred_wallet_usage_in_percent = $req->preferredPercents->wallet;
        $sale_user_id = Auth::user()->id_users;
        $businesse_id = Auth::user()->businesse_id;
        $sale_user_ip = $_SERVER['REMOTE_ADDR'];

        $response = array();
        $response['invoiceTotalItems'] = $req->invoiceTotalItems;


        for ($x = 0; $x <= $req->invoiceTotalItems; $x++) {

            $id_service = $req->services[$x]->id_services;
            $count = $req->services[$x]->unit;

            $query = "CALL sp_do_buy_process('$id_customer', '$id_service','$count',
                                   '$invoice_total_items', '$preferred_score_usage_in_percent',
                                  '$preferred_wallet_usage_in_percent',
                                  '$sale_user_id', '$sale_user_ip')";

            try {
                $queryResult = DB:: select(DB::raw($query));

            } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                error_log('query error = ' . $ex->getMessage());
                error_log('query error code= ' . $ex->getCode());
                return Response(['status' => 'error', 'code' => 2], 409);
            }

        }
        return Response(['status' => 'done', 'code' => 1, 'data' => 'data'], 200);
    }

    public
    function doPurchase(Request $request)
    {
        error_log('**************doPurchase_new***************');
        error_log($request);
        error_log('**************doPurchase_new***************');

        $req = $request->getContent();
        $req = json_decode($req);
//        error_log('$req = ' . $req->services[0]->price);
//        error_log('count = ' . count($req->services));

        $id_customer = $req->customer->id_customers;
        $invoice_total_items = $req->invoiceTotalItems;
        $preferred_score_usage_in_percent = $req->preferredPercents->score;
        $preferred_wallet_usage_in_percent = $req->preferredPercents->wallet;
        $sale_user_id = Auth::user()->id_users;
        $businesse_id = Auth::user()->businesse_id;
        $sale_user_ip = $_SERVER['REMOTE_ADDR'];

        $response = array();
        $response['invoiceTotalItems'] = $req->invoiceTotalItems;

        //invoice_number
        $new_invoice_no_by_business_query = "CALL sp_get_new_invoice_number_by_business($businesse_id);";
        try {
            $new_invoice_no_by_business = DB:: select(DB::raw($new_invoice_no_by_business_query));
            $invoice_number = $new_invoice_no_by_business[0]->invoice_number;
            $response['invoice_number'] = $invoice_number;
            $response['items'] = array();

        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
            error_log('query error = ' . $ex->getMessage());
            error_log('query error code= ' . $ex->getCode());
            return Response(['status' => 'error', 'code' => $ex->getCode()], 409);
        }

        //get_offers_for_service_by_customer
        //insert Item to invoice_items
        for ($x = 0; $x < $invoice_total_items; $x++) {

            $service = $req->services[$x];
            $id_service = $service->id_services;
            $count = $service->unit;

            //offers_for_service
            $available_offers_query = "CALL sp_get_offers_for_service_by_customer($id_customer, $id_service, $count);";
            $available_offers = [];
            try {
                $available_offers = DB:: select(DB::raw($available_offers_query));
                $service->available_offers = $available_offers;

            } catch (\Illuminate\Database\QueryException $ex) {
                error_log('query error = ' . $ex->getMessage());
                error_log('query error code= ' . $ex->getCode());
                return Response(['status' => 'error', 'code' => $ex->getCode()], 409);
            }
            error_log('CHECK ' . $x);
            if (count($available_offers) > 0) {
                $id_services_x_sense_junction = $available_offers[0]->id_services_x_sense_junction;
            } else {
                $id_services_x_sense_junction = 0;
            }

            $insert_invoice_items_query = "CALL sp_set_invoice_items($id_customer,'$invoice_number', $invoice_total_items,
                              $id_service, $count,
                              $preferred_score_usage_in_percent,
                              $preferred_wallet_usage_in_percent,
                              $id_services_x_sense_junction, $sale_user_id,
                              '$sale_user_ip'); ";
            try {
                $inserted_invoice_item_data = DB:: select(DB::raw($insert_invoice_items_query));
                $service->inserted_invoice_item_data = $inserted_invoice_item_data[0];
            } catch (\Illuminate\Database\QueryException $ex) {
                error_log('query error = ' . $ex->getMessage());
                error_log('query error code= ' . $ex->getCode());
                return Response(['status' => 'error', 'code' => $ex->getCode()], 409);
            }

            array_push($response['items'], $service);
        }

        $response['Qr'] = 'data:image/png;base64,' . base64_encode(QrCode::format('png')
                ->encoding('UTF-8')->errorCorrection('M')->size(300)->color(0, 0, 0)
                ->generate($response['invoice_number']));


        return Response(['status' => 'done', 'code' => 1, 'response' => $response], 200);

    }

//****************************************************************************purchase
//****************************************************************************convertor
    public function score_convertor(Request $request)
    {
        $view = $request['v'];
        $viewInReturn = '';
        $activeView = '';

        switch ($view) {
            case 'table':
                $activeView = 'table';
                $viewInReturn = 'admin.score-convertor.score-convertor';
                break;
            case 'form':
                $activeView = 'form';
                $viewInReturn = 'admin.score-convertor.score-convertor';
                break;
        }
        return view($viewInReturn)->with('activeView', $activeView);
    }

    public function score_convertor_do_this(Request $request)
    {
        error_log('*****************************');
        error_log($request);
        error_log('*****************************');

        $do_this = $request['this'];

        error_log('score_convertor_do_this -> ' . $do_this);
        $response = array();
        $response['status'] = 'Done';
        $id_business = Auth::user()->businesse_id;
        $id_user = Auth::user()->id_users;
        $creator_user_ip = $_SERVER['REMOTE_ADDR'];
        switch ($do_this) {

            case 'add_new':

                $convertor_name = $request['convertor_name'];
                $score_cost = $request['score_cost'];
                $off_percent = $request['off_percent'];
                $off_value = $request['off_value'];
                $description = $request['description'];
                $available = $request['available'];
                $expire = $request['expire'];


                $query = "CALL sp_set_new_score_convertor (
                                            '$convertor_name' ,
                                            '$score_cost' ,
                                            '$off_percent' ,
                                            '$off_value' ,
                                            '$description' ,
                                            '$id_user'  ,
                                            '$id_business'  ,
                                            '$creator_user_ip',
                                            '$available' ,
                                            '$expire' ); ";

                try {
                    $queryResult = DB::select(DB::raw($query));
                    $response['result'] = $queryResult;
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    return Response(['status' => 'Error', 'code' => 2], 409);
                }

                $service_list = json_decode($request['service_list'], true);
                if (count($service_list) > 0) {
                    foreach ($service_list as $service) {
                        $id_score_convertor = $response['result'];
                        $query = "CALL sp_score_convertor_plans_services_junction_add  ('$id_score_convertor','$service')";
                        try {
                            $queryResult = DB:: select(DB::raw($query));
                            error_log('sp_score_convertor_plans_services_junction_add query successful');

                        } catch (\Illuminate\Database\QueryException $ex) {
                            error_log('query error = ' . $ex->getMessage());
                            error_log('query error code= ' . $ex->getCode());
                            return Response(['status' => 'error', 'code' => 2], 409);
                        }
                    }
                }


                break;
            case 'edit':

                $convertor_name = $request['convertor_name'];
                $score_cost = $request['score_cost'];
                $off_percent = $request['off_percent'];
                $off_value = $request['off_value'];
                $description = $request['description'];
                $available = $request['available'];
                $expire = $request['expire'];
                $id_score_convertor = $request['id_score_convertor'];

                $query = "CALL sp_edit_score_convertor (
                                            '$id_score_convertor' ,
                                            '$convertor_name' ,
                                            '$score_cost' ,
                                            '$off_percent' ,
                                            '$off_value' ,
                                            '$description' ,
                                            '$id_user'  ,
                                            '$id_business'  ,
                                            '$creator_user_ip',
                                            '$available' ,
                                            '$expire' ); ";

                try {
                    $queryResult = DB::statement($query);
                    $response['result'] = $queryResult;
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    return Response(['status' => 'Error', 'code' => 2], 409);
                }

                $service_list = json_decode($request['service_list'], true);
                if (count($service_list) > 0) {
                    foreach ($service_list as $service) {
                        $id_services = $service['id_services'];
                        $query = "CALL sp_score_convertor_plans_services_junction_add ('$id_score_convertor','$id_services')";
                        try {
                            $queryResult = DB:: select(DB::raw($query));
                            error_log('sp_score_convertor_plans_services_junction_add query successful');

                        } catch (\Illuminate\Database\QueryException $ex) {
                            error_log('query error = ' . $ex->getMessage());
                            error_log('query error code= ' . $ex->getCode());
                            return Response(['status' => 'error', 'code' => 2], 409);
                        }
                    }
                }

                break;
        }
        return Response($response, 200);
    }

    public function score_convertor_get_this(Request $request)
    {
//        error_log($request);
        $get_this = $request['this'];

        error_log('purchase_get_this -> ' . $get_this);
        $response = array();

        $response['status'] = 'Done';
        $id_business = Auth::user()->businesse_id;
        $id_user = Auth::user()->id_users;
        $creator_user_ip = $_SERVER['REMOTE_ADDR'];

        switch ($get_this) {

            case 'convertor_list':
                $result = DB::table('v_get_score_convertor_list')
                    ->where('id_business', '=', $id_business)->paginate(10);
                $response['dataList'] = $result;
                break;
            case 'servicesByBusiness':
                $userBusinessID = Auth::user()->businesse_id;

                $filter = ($request->filter) . '%';

                $services = DB::table('services')
                    ->where([['id_business', '=', $userBusinessID],
                        ['name', 'LIKE', '%' . $filter . '%']])
                    ->get(['id_services', 'name']);
                $response['servicesByBusiness'] = $services;
                break;
        }
        return Response($response, 200);
    }

//****************************************************************************convertor
//****************************************************************************Tools
    public
    function store(Request $request)
    {
//        error_log('image_name = ' . $request->file('image')->);
        error_log($request);
        error_log('store - ');
        $store_this = $request['this'];
        error_log($store_this);
        $response = array();

        switch ($store_this) {
            case 'business_logo':

                error_log('business_logo is Uploading ... ');
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . date('mdYHis') . uniqid() . '.' . $extension;
                    $path = $request->file('image')->storeAs('public/logo_img', $fileNameToStore);
                    error_log($path);

//            return $data['image'] = $fileNameToStore;
                    $data['image'] = $fileNameToStore;

//            $data['image'] = $path;
//            error_log($data['image']);
//            return Response(['status' => 'Done', 'data' => $data], 200);
                    return Response($fileNameToStore, 200);
                }

                abort(500, 'Could not upload image :(');
                break;
            case 'card_bg':
                error_log('card_bg is Uploading ... ');
                $userBusinessID = Auth::user()->businesse_id;
                $id_user = Auth::user()->id_users;
                $creator_user_ip = $_SERVER['REMOTE_ADDR'];
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
//                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $filename = $userBusinessID;
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . 'card_bg_' . date('mdYHis') . uniqid() . '.' . $extension;
                    error_log('$fileNameToStore =');
                    error_log($fileNameToStore);
                    $path = $request->file('image')->storeAs('card_bg', $fileNameToStore, 'public');
                    error_log('$path = ');
                    error_log($path);

//            return $data['image'] = $fileNameToStore;
                    $data['image'] = $fileNameToStore;

//            $data['image'] = $path;
//            error_log($data['image']);
//            return Response(['status' => 'Done', 'data' => $data], 200);

                    DB::table('business_card_design')->updateOrInsert(
                        ['id_businesses' => $userBusinessID],
                        ['id_businesses' => $userBusinessID, 'card_bg_address' => $fileNameToStore,
                            'creator_user_id' => $id_user, 'creator_user_ip' => $creator_user_ip]);
//

                    return Response($fileNameToStore, 200);
                }

                abort(500, 'Could not upload image :(');

                break;
        }


    }

    public
    function viewUploads()
    {
        $images = File::all();
        return view('view_uploads')->with('images', $images);
    }

    //****************************************************************************Tools
}
