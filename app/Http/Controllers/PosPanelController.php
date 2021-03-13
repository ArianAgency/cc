<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use stdClass;

class PosPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('pos.home');
    }

    public function pos_get_this(Request $request)
    {
        error_log('pos_get_this - ');
        $get_this = $request['this'];
        $id_customer = $request->query('id_customers');
        $id_service = $request->query('id_services');
        $count = $request->query('count');

        error_log('$get_this = ' . $get_this);
//        error_log('$id_customer = ');
//        error_log($id_customer);
//        error_log('$id_service = ');
//        error_log($id_service);
//        error_log('$count = ');
//        error_log($count);
        $businesse_id = Auth::user()->businesse_id;
        $response = array();
        $dataList = array();

        switch ($get_this) {
            case 'discounts':
                //offers_for_service
                $available_offers_query = "CALL sp_get_offers_for_service_by_customer($id_customer, $id_service, $count);";
                $available_offers = [];
                try {
                    $available_offers = DB:: select(DB::raw($available_offers_query));
                    foreach ($available_offers as $value) {
                        array_push($dataList, (object)[
                            'name' => $value->name,
                            'off_percent' => $value->off_percent,
                            'off_value' => 0,
                            'exp' => $value->services_x_sense_exp,
                            'type' => 'services_x_sense_junction',
                            'type_id' => $value->id_services_x_sense_junction
                        ]);
                    }
                    error_log($available_offers_query);
                    error_log('sp_get_offers_for_service_by_customer was SUCCESSFUL');
//                    $response['dataList'] = $available_offers;
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    return Response(['status' => 'error', 'code' => $ex->getCode()], 409);
                }

                //active score converts
                $active_score_convert_query = "CALL sp_get_active_customer_score_convert_list($id_customer,$businesse_id, $id_service);";
                $active_score_convert = [];
                try {
                    $active_score_convert = DB:: select(DB::raw($active_score_convert_query));
//                    $response['active_score_convert'] = $active_score_convert;
                    foreach ($active_score_convert as $value) {
                        array_push($dataList, (object)[
                            'name' => $value->name,
                            'off_percent' => $value->off_percent,
                            'off_value' => $value->off_value,
                            'exp' => $value->exp,
                            'type' => 'score_convertor_plans_customers_junction',
                            'type_id' => $value->id_score_convertor_plans_customers_junction
                        ]);
                    }
                    error_log($active_score_convert_query);
                    error_log('sp_get_active_customer_score_convert_list was SUCCESSFUL');
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    return Response(['status' => 'error', 'code' => $ex->getCode()], 409);
                }
                $response = $dataList;
                break;
            case 'serviceCategories':
                $query = "CALL sp_get_all_categories_of_business_and_branches($businesse_id);";
                try {
                    $business_and_its_parent_categories = DB::select(DB::raw($query));
                    $response['dataList'] = $business_and_its_parent_categories;
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    return Response(['status' => 'error', 'code' => $ex->getCode()], 409);
                }

                break;
        }
        return Response(['status' => 'Done', 'response' => $response], 200);
    }

    public
    function doPurchase(Request $request)
    {
        error_log('************** POS doPurchase ***************');
        error_log($request);
        error_log('************** POS doPurchase ***************');

        $req = $request->getContent();
        $req = json_decode($req, false);

        $id_customer = $req->customer->id_customers;
        $invoice_total_items = $req->invoiceTotalItems;

        $sale_user_id = Auth::user()->id_users;
        $businesse_id = Auth::user()->businesse_id;
        $sale_user_ip = $_SERVER['REMOTE_ADDR'];


        $response = array();
        $response['invoiceTotalItems'] = $req->invoiceTotalItems;
        $response['items'] = array();

        //invoice_number
        $new_invoice_no_by_business_query = "CALL sp_get_new_invoice_number_by_business($businesse_id);";
        try {
            $new_invoice_no_by_business = DB:: select(DB::raw($new_invoice_no_by_business_query));
            $invoice_number = $new_invoice_no_by_business[0]->invoice_number;
            $response['invoice_number'] = $invoice_number;
            error_log($invoice_number);
        } catch (\Illuminate\Database\QueryException $ex) {
            error_log('query error = ' . $ex->getMessage());
            error_log('query error code= ' . $ex->getCode());
            return Response(['status' => 'error', 'code' => $ex->getCode()], 409);
        }

        //get_offers_for_service_by_customer
        //insert Item to invoice_items
//        for ($x = 0; $x < $invoice_total_items; $x++) {
        foreach ($req->services as $service) {
//            $service = $req->services[$x];
//            $service = $req->services[0];
            $id_service = $service->id_services;
            $count = $service->count;

            error_log('$id_service = ');
            error_log($id_service);

            //discount id and type
            $type_id = $service->type_id;
            $type = $service->type;

            $insert_invoice_items_query = "CALL sp_pos_set_invoice_items(
                             '$id_customer',
                             '$invoice_number',
                              $invoice_total_items,
                              $id_service, $count,
                              '0',
                              '$type_id',
                              '$type',
                              '$sale_user_id',
                              '$sale_user_ip'); ";

            error_log('$insert_invoice_items_query for $id_service = ' . $id_service);
//            error_log($insert_invoice_items_query);
            try {
                $inserted_invoice_item_data = DB:: select(DB::raw($insert_invoice_items_query));
                $service->inserted_invoice_item_data = $inserted_invoice_item_data[0];
            } catch (\Illuminate\Database\QueryException $ex) {
                error_log('query error = ' . $ex->getMessage());
                error_log('query error code= ' . $ex->getCode());
                return Response(['status' => 'error', 'code' => $ex->getCode()], 409);
            }
            array_push($response['items'], $service);
//            $response['items'] = $service;
        }

        $response['Qr'] = 'data:image/png;base64,' . base64_encode(QrCode::format('png')
                ->encoding('UTF-8')->errorCorrection('M')->size(300)->color(0, 0, 0)
                ->generate($response['invoice_number']));


        return Response(['status' => 'done', 'code' => 1, 'response' => $response], 200);

    }

}
