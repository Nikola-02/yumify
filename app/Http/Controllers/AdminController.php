<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Rating;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;


class AdminController extends OsnovniController
{
    public function index(){
        $message = "";
        try {
            $logData = File::get(public_path('assets/log/user_actions.log'));

            $logLines = explode("\n", $logData);

            $logLines = array_filter($logLines, 'trim');

            $logFile = storage_path('logs/laravel.log');
            $logContents = file_get_contents($logFile);

            $logs = explode("\n", $logContents);

            return view('pages.admin.index', ['log_lines'=>$logLines, 'error_logs'=>$logs]);

        }catch (\Exception $ex){
            $message = $ex->getMessage();
        }
    }

    public function show($table_name){
        if(in_array($table_name, $this->table_names)){

            return view('pages.admin.show', $this->data_for_table($table_name));
        }else{
            return redirect()->route('admin_home');
        }
    }

}
