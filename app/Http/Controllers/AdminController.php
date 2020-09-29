<?php

namespace App\Http\Controllers;

use App\Business;
use App\Customer;
use App\User;
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
//        error_log('brand_name = ' . $request->brand_name);
//        error_log('company_name = ' . $request->company_name);

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
        $mobile_verified_at = $request->mobile_verified_at;
        $email = $request->email;
        $email_verified_at = $request->email_verified_at;
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

        if (strlen($mobile_verified_at) == 0) {
            $mobile_verified_at = "NULL";
        }
        if (strlen($email_verified_at) == 0) {
            $email_verified_at = "NULL";
        }
        if (strlen($have_social) == 0) {
            $have_social = "1";
        }
        if (strlen($parent_id) == 0) {
            $parent_id = "0";
        }


        $query = "call sp_register_new_business  ('$brand_name', '$company_name', '$company_type', '$foundation_date', '$register_code', '$national_code',
        '$financial_code', '$company_field', '$address', '$phone', '$support_phone', '$mobile', $mobile_verified_at,
        '$email', $email_verified_at, '$work_time', '$logo_address', '$have_social', '$company_size', '$parent_id',
        '$bank_account', '$card_pre_number', '$registration_origin', '$website', '$finding_way','$have_hashtag', '$password')";


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
        $availableCardPreNumber = '';
        error_log('$get_this = ' . $get_this);

        switch ($get_this) {
            case 'availableCardNumber':
                $businessID = '';
                if ($request['businessID'] == 0) {
                    $businessID = '90';
                }
                $lastCardNumber = DB::table('users')->where('card_number', 'like', $request['businessID'] . '%')
                    ->orderBy('created_at', 'desc')->get('card_number');

                error_log('$lastCardNumber = ' . $lastCardNumber);
                error_log('count($lastCardNumber) = ' . count($lastCardNumber));
                if (count($lastCardNumber) > 0) {
                    $availableCardNumber = $lastCardNumber[0]->card_number + 1;
                } else {
                    $availableCardNumber = '9009000000000001';
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
                $roles = DB::table('roles')->where('id_roles', '>', 1)->get();
                break;
        }
        error_log('End of user_get_this -');
        return Response(['status' => 'Done', 'roles' => $roles, 'availableCardNumber' => $availableCardNumber], 200);
    }

    public function user_new(Request $request)
    {
        error_log('*******************************');
        error_log('request = ' . $request);
        error_log('*******************************');

//        error_log('image = ' . $request['image']);
//        error_log('brand_name = ' . $request->brand_name);
//        error_log('company_name = ' . $request->company_name);

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
        $password = password_hash($request->password, PASSWORD_DEFAULT);

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
            $role_id = 5;
        }


        $query = "CALL sp_register_new_users  ('$name', '$family', '$father_name', '$national_code', '$gender', '$mobile', '$phone', '$email',
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

                break;
        }

        return Response(['status' => 'Done', 'availableCardNumber' => $availableCardNumber], 200);
    }

    public function customer_new(Request $request)
    {
        error_log('*******************************');
        error_log('request = ' . $request);
        error_log('*******************************');

//        error_log('image = ' . $request['image']);
//        error_log('brand_name = ' . $request->brand_name);
//        error_log('company_name = ' . $request->company_name);

        $name = $request->name;
        $family = $request->family;
        $father_name = $request->father_name;
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
        $password = password_hash($request->password, PASSWORD_DEFAULT);

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

        $query = "CALL sp_register_new_customer  (true,'$name', '$family', '$father_name', '$gender', '$mobile', '$phone', '$email',
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
