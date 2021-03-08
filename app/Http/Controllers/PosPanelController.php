<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                            'exp' => $value->services_x_sense_exp
                        ]);

                    }
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
                        $object = new stdClass();
                        array_push($dataList, (object)[
                            'name' => $value->name,
                            'off_percent' => $value->off_percent,
                            'off_value' => $value->off_value,
                            'exp' => $value->exp
                        ]);
                    }
                } catch (\Illuminate\Database\QueryException $ex) {
                    error_log('query error = ' . $ex->getMessage());
                    error_log('query error code= ' . $ex->getCode());
                    return Response(['status' => 'error', 'code' => $ex->getCode()], 409);
                }
                break;
        }
//        array_push($response, $dataList);
        $response['dataList'] = $dataList;
        return Response(['status' => 'Done', 'response' => $response], 200);
    }
}
