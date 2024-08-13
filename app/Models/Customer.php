<?php

namespace App\Models;
use App\Consts;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
   protected $table = 'users';
   protected $guarded = [];

   public static function getsqlUser($params, $isPaginate = false)
   {
      $query = Customer::selectRaw('users.*')
         ->when(!empty($params['keyword']), function ($query) use ($params) {
            $keyword = $params['keyword'];
            return $query->where(function ($where) use ($keyword) {
               return $where->where('users.name', 'like', '%' . $keyword . '%');
            });
         })

         ->when(!empty($params['id']), function ($query) use ($params) {
            return $query->where('users.id', $params['id']);
         });
         if (!empty($params['status'])) {
         $query->where('users.status', $params['status']);
         } else {
            $query->where('users.status', "!=", Consts::STATUS_DELETE);
         };
      return $query;
   }
   public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
