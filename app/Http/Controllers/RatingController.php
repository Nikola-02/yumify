<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends OsnovniController
{
    public function destroy(Rating $rating, Request $request){
        try {
            $rating->delete();

            $this->log_action_for_user('Restaurant rating deleted.');

            return response()->json($this->data_for_table('ratings'));
        }catch(\Exception $ex){
            return response()->json($ex->getMessage());
        }
    }
}
