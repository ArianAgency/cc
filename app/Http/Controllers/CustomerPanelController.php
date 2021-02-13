<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CustomerPanelController extends Controller
{
    public function index()
    {
        return view('customer.login');
    }

    public function registration()
    {
        return view('registration');
    }

    public function postLogin(Request $request): \Illuminate\Http\RedirectResponse
    {
//        error_log($request);
//        error_log('email = ');
//        error_log($request['email']);
//        error_log('password = ');
//        error_log($request['password']);


        request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

//        error_log('********************');
        $credentials = $request->only('email', 'password');
        if (Auth::guard('customers')->attempt($credentials)) {
            error_log(' Customer Authentication passed...');
//            return redirect()->intended(route('customer-dashboard'));
            return redirect()->route('customer-dashboard');
        }
         return redirect()->route('customer-login')->withSuccess('Oppes! You have entered invalid credentials');
    }

    public function postRegistration(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();

        $check = $this->create($data);

        return Redirect::to("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }

    public function dashboard()
    {
        error_log('//////////////////////////////////////');
        if (Auth::guard('customers')->check()) {
            return view('customer.main.home');
        }
        return Redirect::to("customer-panel/login")->withSuccess('Opps! You do not have access');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function logout()
    {
        Session::flush();
        Auth::guard('customers')->logout();
        return redirect()->route('customer-login');
//        session()->flash('message', 'Invalid credentials');
//        return redirect()->back();
    }

    public function customer_get_this(Request $request)
    {
//        error_log($request);
        $get_this = $request['this'];

        error_log('purchase_get_this -> ' . $get_this);
        $response = array();
        $response['status'] = 'Done';

        $id_business = Auth::guard('customers')->user()->registration_origin;
        $id_customer = Auth::guard('customers')->user()->id_customers;
        switch ($get_this) {


            case 'history':
                error_log('$id_business = ');
                $page = $request['page'];
                $id_business = Auth::guard('customers')->user()->registration_origin;

                error_log($id_business);
                try {
                    $historyList = DB::table('v_get_invoice_history')
                        ->where('id_business', '=', $id_business)
                        ->paginate(10);
                } catch (QueryException   $e) {
                    error_log($e->getMessage());
                }

                $response['dataList'] = $historyList;
                break;
            case 'invoiceItems':
                $invoice_no = $request['invoice_no'];
                $id_business = Auth::guard('customers')->user()->registration_origin;
                $invoiceItems = [];

                try {
                    $invoiceItems = DB::table('v_getInvoiceItems')
                        ->where('invoice_no', '=', $invoice_no)->get();

                } catch (QueryException   $e) {
                    error_log($e->getMessage());
                }
                $response['items'] = $invoiceItems;
                break;
            case 'discounts':

                $id_customer = Auth::guard('customers')->user()->id_customers;
                $id_business = Auth::guard('customers')->user()->registration_origin;

                $query = "CALL sp_customer_discount_offers('$id_customer','$id_business')";

                error_log('sp_customer_discount_offers -> $query = ' . $query);
                try {
                    $queryResult = DB::select($query);
                    $response['dataList'] = $queryResult;
                    error_log('query sp_customer_discount_offers successfull');
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    return Response(['status' => 'error', 'code' => 2], 409);
                }

                break;
            case 'other_discounts':

                $id_customer = Auth::guard('customers')->user()->id_customers;
                $id_business = Auth::guard('customers')->user()->registration_origin;

                $query = "CALL sp_customer_discount_offers_from_other_businesses('$id_customer','$id_business')";

                error_log('sp_customer_discount_offers_from_other_businesses -> $query = ' . $query);
                try {
                    $queryResult = DB::select($query);
                    $response['dataList'] = $queryResult;
                    error_log('query sp_customer_discount_offers_from_other_businesses successfull');
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    return Response(['status' => 'error', 'code' => 2], 409);
                }

                break;
            case 'score_converts':
                $score_convertors = array();

                try {
                    $score_convertors = DB::select(DB::raw
                    ("CALL sp_get_customer_score_convertor_list('$id_customer','$id_business')"));

                } catch (QueryException   $e) {
                    error_log($e->getMessage());
                }
                $response['dataList'] = $score_convertors;
                break;
        }
//        return Response(['status' => 'Done', 'availableCardNumber' => $availableCardNumber], 200);
        return Response($response, 200);
    }

    public function purchase_do_this(Request $request)
    {
        error_log($request);
        $do_this = $request['this'];

        error_log('purchase_do_this -> ' . $do_this);
        $response = array();
        $response['status'] = 'Done';
        $id_business = Auth::guard('customers')->user()->registration_origin;
        $id_customers = Auth::guard('customers')->user()->id_customers;

        switch ($do_this) {
            case 'delete':
                $invoice_no = $request['invoice_no'];
                $id_business = Auth::guard('customers')->user()->registration_origin;

                try {


                } catch (QueryException   $e) {
                    error_log($e->getMessage());
                }
                $response['delete'] = 'Done';
                break;
            case 'disable':
                error_log('**************************');
                break;
            case 'convertScore':
                $id_score_convertor = $request['id'];
                error_log('$id_score_convertor = ' . $id_score_convertor);


                $query = "CALL sp_customer_score_convert  ('$id_score_convertor','$id_customers')";
                error_log('sp_customer_score_convert -> $query = ' . $query);
                try {
                    $result = DB::select(DB::raw($query));
                    $response['result'] = $result;
                    error_log('query sp_customer_score_convert successfull');
                } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    return Response(['status' => 'error', 'code' => 2], 409);
                }

                $response['action'] = 'convertScore';
                break;

        }
        return Response($response, 200);
    }

    public function show_customer_v_view(Request $request)
    {
        $view = $request['v'];
        $viewInReturn = '';

        error_log("show_" . $view . "_view");

        switch ($view) {
            case 'profile':
                $viewInReturn = 'customer.main.customer-profile';
                break;
            case 'shop-history':
                $viewInReturn = 'customer.main.customer-shop-history';
                break;
            case 'discounts':
                $viewInReturn = 'customer.main.customer-discounts';
                break;
            case 'other-discounts':
                $viewInReturn = 'customer.main.customer-other-discounts';
                break;
            case 'score-converts':
                $viewInReturn = 'customer.main.customer-score-convertor';
                break;

        }
        return view($viewInReturn);
    }

    public function do_action(Request $request)
    {
        error_log('*******************************');
        error_log('request = ' . $request);
        error_log('*******************************');
        $type = $request['type'];

        error_log($type);
        switch ($type) {
            case 'complete-registration-form':
                $is_it_new_registration = 'false';
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
                $id_customers = Auth::guard('customers')
                    ->user()->id_customers;

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

                $query = "CALL sp_update_customer  ('$id_customers',
                                    '$name', '$family',
                                    '$father_name','$national_code' ,
                                    '$mobile' , '$phone',
                                    '$email','$birthday', '$marriage_status',
                                    $wedding_anniversary, '$education' , '$field' ,
                                    '$address','$website',
                                    '$job','$customer_ip')";
                error_log('sp_update_customer -> $query = ' . $query);
                try {
                    DB::select(DB::raw($query));
                    error_log('query sp_update_customer successfull');
                } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    return Response(['status' => 'error', 'code' => 2], 409);
                }
                $id_customer = $request->id_customer;


                error_log('$id_customer = ');
                error_log($id_customer);

                break;
        }
        return Response(['status' => 'done', 'code' => 1, 'data' => 1], 200);
    }
}
