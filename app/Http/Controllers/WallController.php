<?php

namespace App\Http\Controllers;

use App\Models\Wall;
use App\Models\Walllike;
use Illuminate\Http\Request;

class WallController extends Controller
{
    public function getAll(){

        $array = ['error' => '', 'list' => []];
        
        $walls = Wall::all();
        $user = auth()->user();
        
        foreach($walls as $wallKey => $wallValue){
            
            $wallValue[$wallKey]['like'] = 0;
            $wallValue[$wallKey]['liked'] = false;

            $likes = Walllike::where('id_wall', $wallValue['id'])->count();
            $wallValue[$wallKey]['like'] = $likes;
            $meLikes = Walllike::where('id_wall', $wallValue['id'])->where('id_user', $user['id'])->count();
            if($meLikes > 0){
                $wallValue[$wallKey]['liked'] = true;
            }

        }

        $array['list'] = $walls;
        return $array;
    }
    public function like($id){

        $array = ['error' => ''];
        $user = auth()->user();
        $meLikes = Walllike::where('id_wall', $wallValue['id'])->where('id_user', $user['id'])->count();

        if($meLikes > 0){
            Walllike::where('id_wall', $id)->where('id_user', $user['id'])->delete();
            $array['likes'] = false;
        }else{
           
            $newLike = new Walllike();
           $newLike->id_wall = $id;
           $newLike->id_user = $user['id'];
           $newLike->save();

            $array['likes'] = true;
        }
        $array['likes'] = Walllike::where('id_wall', $id)->count();
        return $array;
    }
}
