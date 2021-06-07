<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Command_list;
use App\Category_cmd;
use App\Cmd_auto;
use App\Command;
use App\Computer;
use App\Operationpc;
use App\User_role;
use App\User;
use App\Agent;
use Carbon\Carbon;
use DateTime;

class HomeController extends Controller
{
    public function index()
    {
        $cmd_auto = Cmd_auto::all();
        $category_cmd = Category_cmd::all()->sortBy('id');
        $operationpc = Operationpc::where('status', '!=', 0)->get();

        foreach($category_cmd as $cc) {
            $cc->command_list = Command_list::where('category_fk', $cc->category_name)->get();
        }

        // dd($category_cmd);

        return view('home', [
                'category_cmd' => $category_cmd,
                'cmd_auto' => $cmd_auto,
                'operationpc' => $operationpc
            ]
        );
    }

    public function download() {
        $path = public_path('files/systems/excel/question.xlsx');
        return response()->download($path);
    }

    public function folder() {
        return view('folder');
    }

    public function users() {
        $users = User::all();
        foreach($users as $u) {
            $u->role_name = User_role::where('user_id', $u->roles)->first();
        }
        return view('users', compact('users'));
    }

    public function createOperation(Request $request) {
        $validation = $request->validate([
            'ops_name' => 'required|unique:operationpc',
            'description' => 'required'
        ]);

        if ($validation) {
            $create = Operationpc::create([
                'ops_name' => $request->get('ops_name'),
                'description' => $request->get('description'),
                'etat_ops' => 1
            ]);

            return response()->json([
                'data' => $create
            ]);
        }

        return response()->json();
    }
    public function createCmd(Request $request) {
        $validation = $request->validate([
            'pc' => 'required_without:chca',
            'cmm' => 'required',
            'cord'=> 'required_if:chca,on|integer',
            'cop'=> 'required_if:chca,on'
        ]);
        if ($validation) {
            $arr=explode(",",$request->get('pc'));
            $cm=$request->get('cmm');
            $arr1=array_filter($request->input(),function ($key) {
                return strstr($key,"param_") !=false;
            }, ARRAY_FILTER_USE_KEY);
            if(count($arr1)>0){$cm.="|".implode('|',$arr1);}

            if(array_key_exists("chca",$request->input())){
                $create = Cmd_auto::create([
                    'cmd_auto' => $cm,
                    'operationpc_cmd_fk' => $request->get('cop'),
                    'ordre' => $request->get('cord'),
                ]);    
            }else{ 
                foreach($arr as $pc){
                $create = Command::create([
                    'pc' => $pc,
                    'cmd' => $cm,
                    'ok' => 0,
                ]);
                }
            }
            return response()->json();
        }

        return response()->json();
    }
    public function getOperation($id, int $min) {
        $operation = Operationpc::find($id);
        $computers = Computer::where('ops_linked', $operation->ops_name)->get();
        $agents = Agent::where('operationpc_fk', $operation->ops_name)->get();

        foreach ($computers as $c) {
            $command = Command::where('pc', $c->pc)->where('cmd', '!online')->orderBy('id', 'DESC')->first();

            if ($command) {

                if($command->result != null) {
                    $ex = explode(' ', $command->result);

                    $date1 = $ex[0][26] . $ex[0][28] . $ex[0][30] . $ex[0][32] . '-' . $ex[0][14] . $ex[0][16] . '-' . $ex[0][20] . $ex[0][22];
                    $date2 = $ex[1][1] . $ex[1][3] . ':' . $ex[1][7] . $ex[1][9] . ':' . $ex[1][13] . $ex[1][15];
                    $date = $date1 . ' ' .$date2;

                    $d1 = new DateTime($date);
                    $d2 = new DateTime(Carbon::now()->toDateTimeString());
                    $diff = $d1->diff($d2);

                    if ($diff->y == 0 && $diff->m == 0 && $diff->days == 0 && $diff->h <= 1 && $diff->i <= $min) {
                        $c->online = true;
                    } else {
                        $c->online = false;
                    }

                } else {
                    $c->online = false;
                }

            } else {
                $c->online = false;
            }
        }

        return response()->json([
            'data' => $operation,
            'pc' => $computers,
            'agent' => $agents
        ]);
    }

    public function editOperation(Request $request) {
        $validation = $request->validate([
            'ops_name' => 'required',
            'description' => 'required'
        ]);

        if ($validation) {
            $create = Operationpc::find($request->get('id'));
            $create->update([
                'ops_name' => $request->get('ops_name'),
                'description' => $request->get('description')
            ]);

            return response()->json([
                'data' => $create
            ]);
        }

        return response()->json();
    }

    public function deleteOperation(Request $request) {
        $operation = Operationpc::find($request->get('id'));
        $operation->update([
            'status' => 0
        ]);

        return response()->json();
    }

    public function getPcResult($id) {

        $command = Command::where('pc', $id)->get();

        return response()->json([
            'data' => $command
        ]);
    }

}
