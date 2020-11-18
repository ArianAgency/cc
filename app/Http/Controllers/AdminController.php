<?php

namespace App\Http\Controllers;

use App\Business;
use App\Customer;
use App\Service;
use App\User;
use App\X_sens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        $value = $request['value'];
        $result = '';

        try {

            switch ($action) {

                case 'is_active':
                    DB::table('businesses')
                        ->where('id_businesses', $business_id)
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
        error_log($business_id);
        error_log($result);

        return Response(['action' => $action, 'business_id' => $business_id, 'value' => $value], 200);
    }

    public function business_type(Request $request)
    {
        $type = $request['type'];
        $businesses = '';

        switch ($type) {
            case 'index':
                $page = $request['page'];
                $businesses = Business::paginate(10);
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

        switch ($get_this) {
            case 'availableCardPreNumber':
//                $availableCardPreNumber = 5000;
                $availableCardPreNumber = DB::table('businesses')->latest('card_pre_number')->first();
                $availableCardPreNumber = ($availableCardPreNumber->card_pre_number) + 1;
                error_log('$availableCardPreNumber  = ');
                error_log($availableCardPreNumber);
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
        error_log('$foundation_date = ' . $request->foundation_date);
        error_log('company_name = ' . $request->company_name);

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
        $have_social = $request->have_social;
        $company_size = $request->company_size;
        $parent_id = $request->parent_id;
        $bank_account = $request->bank_account;
        $card_pre_number = $request->card_pre_number;
        $registration_origin = $request->registration_origin;
        $website = $request->website;
        $finding_way = $request->finding_way;
        $have_hashtag = $request->have_hashtag;
        $password = password_hash($request->password, PASSWORD_DEFAULT);
//        error_log('password_hash  = ' . $password);


        if (strlen($have_social) == 0) {
            $have_social = "1";
        }
        if (strlen($parent_id) == 0) {
            $parent_id = "0";
        }
        if (strlen($registration_origin) == 0) {
            $registration_origin = "1";
        }
        if (strlen($logo_address) == 0) {
            $logo_address = "NULL";
        }
        error_log('$logo_address => ');


        $query = "CALL sp_register_new_business  ($is_it_new_registration,'$brand_name', '$company_name', '$company_type', '$foundation_date', '$register_code', '$national_code',
        '$financial_code', '$company_field', '$address', '$phone', '$support_phone', '$mobile',
        '$email', '$work_time', '$logo_address', '$have_social', '$company_size', '$parent_id',
        '$bank_account', '$card_pre_number', '$registration_origin', '$website', '$finding_way','$have_hashtag', '$password')";

        error_log('sp_register_new_business -> $query = ' . $query);

        try {
            $queryResult = DB:: select(DB::raw($query));
            error_log('implode = ' . implode(',', $queryResult));
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
        }
        error_log('End of user_get_this - ' . $get_this);
        error_log('$availableCardNumber = ' . $availableCardNumber);
        return Response(['status' => 'Done', 'availableCardNumber' => $availableCardNumber, 'user' => $userDetail,'roles'=>$roles, 'businessesIndex' => $businessesIndex], 200);
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

//****************************************************************************User
//****************************************************************************Customer
    public function customer()
    {
        return view('admin.customers.customers-index');
    }

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
                $page = $request['page'];
                $customers = Customer::paginate(10);
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
        $availableCardPreNumber = '';
        error_log($get_this);

        $response = array();
        $response['status'] = 'Done';

        switch ($get_this) {
            case 'availableCardNumber':
                $lastCardNumber = DB::table('customers')->where('card_number', 'like', '90%')
                    ->orderBy('created_at', 'desc')->get('card_number');
                error_log('$lastCardNumber = ' . $lastCardNumber);
                error_log('count($lastCardNumber) = ' . count($lastCardNumber));
                if (count($lastCardNumber) > 0) {
                    $availableCardNumber = $lastCardNumber[0]->card_number + 1;
                } else {
                    $availableCardNumber = '9009000000000001';
                }
                $response['availableCardNumber'] = $availableCardNumber;
                break;
            case 'getAllDetail':
                $id_customers = $request['id_customers'];
                $customerDetail = DB::table('customers')->where('id_customers', '=', $id_customers);
                $response['customerDetail'] = $customerDetail;
                break;
        }

//        return Response(['status' => 'Done', 'availableCardNumber' => $availableCardNumber], 200);
        return Response($response, 200);
    }

    public function customer_new(Request $request)
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
        $finding_way = $request->finding_way;
        $job = $request->job;
        $card_number = $request->card_number;
        $bank_account = $request->bank_account;
        $wallet = $request->wallet;
        $score = $request->score;
        $password = $request->password;

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

//****************************************************************************Customer
//****************************************************************************Product / Service
    public function services()
    {
        return view('admin.services.services-index');
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

    public function service_type(Request $request)
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
        }


//        return Response(['status' => 'Done', 'availableCardNumber' => $availableCardNumber], 200);
        return Response($response, 200);
    }

    public function service_new(Request $request)
    {
        error_log('*******************************');
        error_log('request = ' . $request);
        error_log('*******************************');

//        error_log('image = ' . $request['image']);
//        error_log('brand_name = ' . $request->brand_name);
//        error_log('company_name = ' . $request->company_name);

        $is_it_new_registration = $request->is_it_new_registration;
        $id_services = $request->id_services;
        $id_business = $request->id_business;
        $name = $request->name;
        $sync_code = $request->sync_code;
        $description = $request->description;
        $price = $request->price;
        $price = $price;
        $is_edited = $request->is_edited;
        $expire_at = $request->expire_at;
        $updated_at = $request->updated_at;
        $is_active = $request->is_active;

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
            return Response(['status' => 'done', 'code' => 1, 'data' => $queryResult], 200);
        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
            error_log('query error = ' . $ex->getMessage());
            error_log('query error code= ' . $ex->getCode());
            return Response(['status' => 'error', 'code' => 2], 409);
        }
    }

    public function services_load_type(Request $request)
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
//****************************************************************************Product / Service
//****************************************************************************X Sens
    public function xsenses()
    {
        return view('admin.xsenses.xsenses-index');
    }

    public function xsensAction(Request $request)
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

    public function xsens_type(Request $request)
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

    public function xsens_get_this(Request $request)
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

    public function xsens_new(Request $request)
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
                            '$creator_user_id', '$business_id', '$creator_user_ip')";
        } else if ($is_it_new_registration == 'false') {
            $id_x_senses = $request->id_x_senses;
            $sp_name = 'sp_update_x_sense';
            $query = "CALL sp_update_x_sense ('$id_x_senses','$x_sens_name_fa', '$x_sens_name_en', '$first_chord_id', '$mid_chord_id', $last_chord_id, '$off_chord',
                            '$creator_user_id', '$business_id', '$creator_user_ip')";
        }

        error_log($sp_name . ' -> $query = ' . $query);

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

    public function xsens_load_type(Request $request)
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
    public function services_xsense()
    {
        return view('admin.services-xsense.services-xsense-index');
    }

    public function services_xsenseAction(Request $request)
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

    public function services_xsense_type(Request $request)
    {

        $type = $request['type'];
        $services_xsense = '';
        error_log('services_xsense_type = ' . $type);
        $id_business = Auth::user()->businesse_id;


        switch ($type) {
            case 'index':
                $page = $request['page'];
                $services_xsense = DB::table('v_get_SerXsen_table_data')->where('id_business', '=', $id_business)->paginate(10);
                break;
            case 'all':
                $services_xsense = X_sens::all();
                $services_xsense = array('current_page' => 0, 'data' => $services_xsense);
                break;
        }

        return Response(['status' => 'Done', 'data' => $services_xsense], 200);
    }

    public function services_xsense_get_this(Request $request)
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

    public function services_xsense_new(Request $request)
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
            $queryResult = DB:: select(DB::raw($query));
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
    public function purchase()
    {
        return view('admin.financial.purchase');
    }

    public function purchase_get_this(Request $request)
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
                    $services = DB::table('v_get_services_list')->where('id_business', '=', $id_business)->get();
                }

                $response['services'] = $services;
                break;
        }
//        return Response(['status' => 'Done', 'availableCardNumber' => $availableCardNumber], 200);
        return Response($response, 200);
    }

    public function doPurchase(Request $request)
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
        $sale_user_ip = $_SERVER['REMOTE_ADDR'];

        for ($x = 0; $x <= $req->invoiceTotalItems; $x++) {

            $id_service = $req->services[$x]->id_services;
            $count = $req->services[$x]->unit;

            $query = "CALL sp_do_buy_process('$id_customer', '$id_service','$count',
                                   '$invoice_total_items', '$preferred_score_usage_in_percent',
                                  '$preferred_wallet_usage_in_percent',
                                  '$sale_user_id', '$sale_user_ip')";

            try {
                $queryResult = DB:: select(DB::raw($query));
                return Response(['status' => 'done', 'code' => 1, 'data' => 'data'], 200);
            } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                error_log('query error = ' . $ex->getMessage());
                error_log('query error code= ' . $ex->getCode());
                return Response(['status' => 'error', 'code' => 2], 409);
            }

        }

    }


//****************************************************************************purchase
//****************************************************************************Tools
    public function store(Request $request)
    {
//        error_log('image_name = ' . $request->file('image')->);
        error_log($request);

        error_log('File is Uploading ... ');
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
    }

    public function viewUploads()
    {
        $images = File::all();
        return view('view_uploads')->with('images', $images);
    }

    //****************************************************************************Tools
}
