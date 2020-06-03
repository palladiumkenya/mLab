<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Result;
use App\Partner;
use App\Facility;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Http\Controllers\SenderController;

class UshauriController extends Controller
{
    public function index()
    {
        $partners = Partner::all();
        

        $data = array(
            'partners' => $partners,
        );
        return view('data.clients_filter')->with($data);
    }

    public function getResults(Request $request)
    {
        $mfl = $request->mfl_code;
        $ccc = $request->ccc_number;

        if ($ccc) {
            $results = Result::where('client_id', $ccc)->get();
            if (!$results->isEmpty()) {
                return response()->json(['message' => 'success', 'results' => $results], 200);
            } else {
                return response()->json(['message' => 'No results for the given MFL code were found'], 200);
            }
        } elseif ($mfl) {
            $results = Result::where('mfl_code', $mfl)->get();
            if (!$results->isEmpty()) {
                return response()->json(['message' => 'success', 'results' => $results], 200);
            } else {
                return response()->json(['message' => 'No results for the given MFL code were found'], 200);
            }
        } else {
            return response()->json(['message' => 'You did not specify any search parameters. Please include either CCC_NUMBER or MFL CODE in the request'], 400);
        }
    }

    public function notifyClients()
    {
        $results = Result::whereDate('created_at', Carbon::today())->where('client_notified', false)->where('mfl_code', 12345)->limit(10)->get();

        foreach ($results as $result) {
            if ($result->result_type == 1) {
                $type = "Viral Load";
            } else {
                $type = "EID";
            }
            $facility = Facility::where('code', $result->mfl_code)->first();
            $client = new Client();

            $res = $client->request('POST', 'http://localhost:5000/api/mlab/check/consent', [
                        'form_params' => [
                            'mfl_code' => $result->mfl_code,
                            'ccc_number' => $result->client_id
                        ]
                    ]);

            if ($res->getStatusCode() == 200) { // 200 OK
                $data = json_decode($res->getBody()->getContents());
                if ($data->smsenable == 'Yes') {
                    $date = date('Y-m-d H:i:s', time());
                    $msg = 'Hello '. $data->f_name. ', your '. $type.' results are ready. Kindly visit '. $facility->name . ' to get the results.';
                  
                    $sender = new SenderController;
                    if ($sender->send($data->phone_no, $msg)) {
                        $result->client_notified = true;
                        $result->save();
                    }
                }
            }
        }
    }

    public function getClients(Request $request)
    {
        $mfl = $request->code;
        $page = $request->page ?? 1;
        
        $client = new Client();

        $res = $client->request('POST', 'http://localhost:5000/api/mlab/list/clients', [
                    'form_params' => [
                        'mfl_code' => $mfl,
                        'page' => $page
                    ]
                ]);

        if ($res->getStatusCode() == 200) { // 200 OK
            $data = json_decode($res->getBody()->getContents());
           
            $data->mfl_code = $mfl;
            return view('client.clients')->with('data', $data);
        } else {
            return redirect()->back();
        }
    }

    public function getOneClient(Request $request)
    {
        $ccc_number = $request->ccc_number;
        
        $client = new Client();

        $res = $client->request('POST', 'http://localhost:5000/api/mlab/get/one/client', [
                    'form_params' => [
                        'ccc_number' => $ccc_number
                    ]
                ]);

        if ($res->getStatusCode() == 200) { // 200 OK
            $data = json_decode($res->getBody()->getContents());
           
            $data->mfl_code = $data->clients[0]->mfl_code;
            
            return view('client.clients')->with('data', $data);
        } else {
            return redirect()->back();
        }
    }

    public function getClientResults(Request $request)
    {
        $ccc_number = $request->ccc_number;
        $results = Result::where('client_id', $ccc_number)->get();

        return $results;
    }
}
