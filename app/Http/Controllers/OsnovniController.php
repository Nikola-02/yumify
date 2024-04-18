<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Rating;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;


class OsnovniController extends Controller
{
    public $table_names;
    public function __construct()
    {
        $tableNames = DB::select('SHOW TABLES');

        $tables = array_map('current', $tableNames);

        $except_names = ['benefit_restaurant', 'failed_jobs', 'migrations', 'orders', 'order_lines', 'password_reset_tokens', 'personal_access_tokens', 'prices', 'restaurant_type'];

        $this->table_names = array_diff($tables, $except_names);

        View::share('table_names', $this->table_names);
    }

    public function data_for_table($table_name){
        //Poslata tabela postoji
        $table_data = [];
        $column_names = [];
        switch ($table_name) {
            case 'meals':
                $meals = Meal::with('restaurant', 'type')->get();
                foreach ($meals as $meal) {
                    $table_data[] = [
                        'id'=>$meal->id,
                        'name'=>$meal->name,
                        'description'=>$meal->description,
                        'image'=>$meal->image,
                        'restaurant'=>$meal->restaurant->name,
                        'type'=>$meal->type->name,
                        'price'=>$meal->trigger_price,
                        'created_at'=>$meal->created_at,
                        'updated_at'=>$meal->updated_at,
                    ];
                }
                $column_names = ['name', 'description', 'image', 'restaurant', 'type', 'price', 'created_at', 'updated_at'];
                break;
            case 'users':
                $users = User::with('role')->get();
                foreach ($users as $user) {
                    $table_data[] = [
                        'id'=>$user->id,
                        'username'=>$user->username,
                        'email'=>$user->email,
                        'order_location'=>$user->order_location,
                        'role'=>$user->role->name,
                        'created_at'=>$user->created_at,
                        'updated_at'=>$user->updated_at,
                    ];
                }
                $column_names = ['username', 'email', 'order_location', 'role', 'created_at', 'updated_at'];
                break;
            case 'ratings':
                $ratings = Rating::with('restaurant', 'user')->get();
                foreach ($ratings as $rating) {
                    $table_data[] = [
                        'id'=>$rating->id,
                        'restaurant'=>$rating->restaurant->name,
                        'user'=>$rating->user->username,
                        'stars'=>$rating->stars,
                        'comment'=>$rating->comment,
                        'created_at'=>$rating->created_at,
                        'updated_at'=>$rating->updated_at,
                    ];
                }
                $column_names = ['restaurant', 'user', 'stars', 'comment', 'created_at', 'updated_at'];
                break;
            case 'restaurants':
                $restaurants = Restaurant::with('types', 'benefits')->get();
                foreach ($restaurants as $r) {
                    $table_data[] = [
                        'id'=>$r->id,
                        'name'=>$r->name,
                        'description'=>$r->description,
                        'location'=>$r->location,
                        'work_hours'=>substr($r->open_in,0, 5). ' - ' .substr($r->close_in,0, 5),
                        'image'=>$r->image,
                        'types'=>implode(", ", $r->types->pluck('name')->ToArray()),
                        'benefits'=>implode(", ", $r->benefits->pluck('name')->ToArray()),
                        'created_at'=>$r->created_at,
                    ];
                }
                $column_names = ['name', 'description', 'location', 'work_hours', 'image', 'types', 'benefits', 'created_at'];
                break;
            default:
                $table_data = DB::table($table_name)->get();
                $column_names = Schema::getColumnListing($table_name);
        }

        return ['table_name'=>$table_name, 'column_names'=>$column_names, 'table_data'=>$table_data];
    }

    public function log_action_for_user($action_name){
        try {
            if(session('user')){
                $username = session()->get('user')->username;
                $date = date('Y-m-d H:i:s');

                $logData = "{$username},{$action_name},{$date}\n";

                $logPath = public_path('assets/log');

                if(!File::isDirectory($logPath)){
                    File::makeDirectory($logPath, 0777, true, true);
                }

                File::append($logPath . '/user_actions.log', $logData);
            }
        }catch (\Exception $ex){
            $message = $ex->getMessage();
        }


    }

}
