<?php
namespace App\Repositories\User;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
use DB;

class UserRepository implements UserRepositoryInterface
{
    public function getUser()
    {
        $getUserListWithLastMsg = DB::table('users as u')
                                    ->select('u.id','u.name',DB::raw('COUNT(mc.read_status) as total_unread'))
                                    ->leftJoin('messages as m',function($join){
                                        $join->on('m.sender_id','=','u.id');
                                    })
                                    ->leftJoin('message_contents as mc',function($join){
                                        $join->on('mc.message_id','=','m.id');
                                        $join->where('mc.read_status','=','no');
                                    })
                                    ->where('u.id','!=',auth()->user()->id)
                                    ->groupBy('u.id')
                                    ->get();
        return $getUserListWithLastMsg;
    }

    public function getUserDetailById($userId){
        return User::select('id','name')->where('id',$userId)->first();
    }
}
