<?php



namespace App\Http\Controllers\addons\included;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function getorder()
    {
        $todayorders = Booking::whereDate('created_at', Carbon::today())->where('is_notification', '=', '1')->where('provider_id', Auth::user()->id)->count();
        return json_encode($todayorders);
    }
}
