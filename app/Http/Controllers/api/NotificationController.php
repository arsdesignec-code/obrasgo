<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
   public function notificationlist(Request $request)
   {
      if($request->user_id == ""){
         return response()->json(["status"=>0,"message"=>trans('messages.enter_user_id')],200);
      }
      $checkuser = User::where('id',$request->user_id)->where('is_available',1)->first();
      if(empty($checkuser)){
         return response()->json(["status"=>0,"message"=>trans('messages.invalid_user')],200);
      }
      $notificationdata = Notification::with('usersname')
                  ->join('bookings','notification.booking_id','bookings.booking_id')
                  ->select('notification.id','notification.user_id','bookings.booking_id','notification.is_read','notification.booking_status','notification.canceled_by',
                     DB::raw('DATE(notification.created_at) AS date'),
                     DB::raw("CONCAT('".asset('storage/app/public/service')."/', bookings.service_image) AS image_url"))
                  ->where('notification.user_id',$request->user_id)
                  ->orderByDesc('notification.id')
                  ->paginate(10);
      return response()->json(['status'=>1,'message'=>trans('messages.success'),'notificationdata'=>$notificationdata],200);
   }
   public function unread(Request $request)
   {
      if($request->user_id == ""){
         return response()->json(["status"=>0,"message"=>trans('messages.enter_user_id')],200);
      }
      if($request->notification_id == ""){
         return response()->json(["status"=>0,"message"=>trans('messages.enter_notification_id')],200);
      }
      $checknoti = Notification::where('id',$request->notification_id)->where('user_id',$request->user_id)->where('is_read',2)->first();
      if(!empty($checknoti)){
         $update = Notification::where('id',$request->notification_id)->update(['is_read'=>1]);
         if($update){
            return response()->json(['status'=>1,'message'=>trans('messages.success')],200);
         }else{
            return response()->json(['status'=>1,'message'=>trans('messages.wrong')],200);
         }
      }else{
         return response()->json(['status'=>1,'message'=>trans('messages.not_available')],200);
      }
   }
}