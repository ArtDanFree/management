<?php

namespace App\Helpers;
use DB;
use App\Models\Payment;
use App\Models\City;
use App\Models\user_city;
use App\Models\User;
use Storage;
use Auth;


class Helper
{
  protected $cityId;
  protected $notificationId;

  public static function getCommission($data)
  {
    foreach ($data as $key => $item) {
      $data[$key]->commissionSum = ($item->money / 100) * $item->user->commission;
    }
  }



  public static function getCitiesForUnderwriter($id)
  {

    $in_string = [] ;
    //  $city = DB::table('user_cities')->select('city_id')->where('user_id',\Request::user()->id)->get();
    $city = DB::table('user_cities')->select('city_id')->where('user_id',$id)->get();
    foreach ($city as $key){
      $in_string[]  = $key->city_id ;
    }

    return $in_string;
  }

  public static function getUserByCity($city){
    $search_city = City::where('name', $city)->get();
    foreach ($search_city as $key => $value) {
      $city_id = $value->id;
    }
    $in_string = [] ;
    $t = user_city::where('city_id', $city_id)->get();
    foreach ($t as $key){
      $in_string[]  = $key->user_id ;
    }
    return $in_string;
  }

  public static function getCitiesForHistory($id)
  {

    $in_string = '' ;
    $city = user_city::with('City')->select('city_id')->where('user_id',$id)->get();
    foreach ($city as $key){
      $in_string  = $in_string.$key->City->name.'; ';
    }

    return $in_string;
  }




  public static function getAccessCity($id, $city_id){
    $cities = Helper::getCitiesForUnderwriter($id);
    $access=0;
    $s=0;
    for($i=0;$i<count($cities);$i++){
      $s++;
      if($cities[$i]==$city_id){
        $access++;
      }

    }
    return    $access++;
  }



  public static function deleteReport($request, $date, $id )
  {

    $docs = Payment::select('doc')->where('user_id', $request->id)->where('dat',$date)->get();
    foreach ($docs as $doc){
      $doc1=$doc;
    }
    $deletedRows = Payment::where('user_id', $request->id )->where('dat',$date)->delete();
    Storage::delete('public/folder/pay/' . $date . '/' .$id.'/'.$doc1->doc);
  }

  public static function saveReport($request, $dat )
  {
    $files = $request->file('file');
    $upload_folder = 'public/folder/pay/' . $dat . '/' . $request->id;
    foreach ($files as $file) {
      $filename = $file->getClientOriginalName();
      Storage::putFileAs($upload_folder, $file, $filename);
    }
    $payment = new payment;
    $payment->user_id = $request->id;
    $payment->doc = $filename;
    $payment->dat = $dat;
    $payment->save();

  }


  public static function getTicket( $data )
  {
    $dat = str_replace('.', '-', $data);//
    //квитанция для лидогенератора
    $user_id = Auth::user()->id;
    $tickets = payment::select('id', 'doc')->where('user_id', $user_id)->where('dat', $dat)->get();

    $doc = "";
    foreach ($tickets as $ticket) {
      $doc = $ticket->doc;

    }

    $document = "";
    if (!empty($doc)) {
      $document = 'storage/folder/pay/' . $dat . '/' . $user_id . '/' . $doc;
    }

    return $document;

  }


  public static function saveUnderwriterCity( $request)
  {
    $i=0;

    $arr=$request->arr;
    for($k=0;$k<(count($arr));$k++){
      if(!empty($arr[$i])){
        $city = user_city::create(['city_id' => $arr[$i],'user_id' => $request->user]);
      }
      $i++;
    }
    $city->save();

  }

  public static function deleteCity( $request)
  {
    DB::update('update leads set city_id = 1 where city_id= ?', [$request->id]);
    $delete_cities = City::where('id', $request->id);
    $delete_cities->delete();

  }

  public static function getPage($request)
  {
    $page=1;
    if(($request->page)==''){ $page=1;}else
    {$page=$request->page;}

    return $page;
  }

  public static function getCountTable($request)
  {
    $count=15;
    if(($request->count)==''){$count=15;}else {$count=$request->count;}
    return $count;
  }



  public static function takeOn($role_id)
  {
    $result = 0;
    if($role_id==2){
      $result++;
    }
    return $result;
  }


  public static function getLastLeads($leads)
  {
    $result="";
    foreach ($leads as $lead) {
      $result = $lead->created_at;
      break;
    }


    return $result;
  }

  public static function getAccessType($type, $ltype)
  {
    if($type == $ltype || $type==2){
      return 1;
    }
    else 0;
  }

  public static function getUnclaimedLead()
  {
      $result = [];
      $cities = user_city::get();
      foreach ($cities as $key) {
      if (in_array($key->city_id, $result) == false){
          $result[] = $key->city_id;
        }
      }
      return $result;
  }

  public static function getUpdateData($request, $users){

    $request_arr = [];
    $request_arr = array(
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'surname' => $request->surname,
      'organization' => $request->organization,
      'credit_card_number' => $request->credit_card_number,
      'personal_acc' => $request->personal_acc,
      'correspondent_acc' => $request->correspondent_acc,
      'bic_bank' => $request->bic_bank,
      'name_bank' => $request->name_bank,
      'cities' => $request->cities,
      'telegram' => $request->telegram,

    );

    $users_arr = array(
      'first_name' => $users->first_name,
      'last_name' => $users->last_name,
      'surname' => $users->surname,
      'organization' => $users->organization,
      'credit_card_number' => $users->credit_card_number,
      'personal_acc' => $users->personal_acc,
      'correspondent_acc' => $users->correspondent_acc,
      'bic_bank' => $users->bic_bank,
      'name_bank' => $users->name_bank,
      'cities' => $users->cities,
      'telegram' => $users->telegram,
    );
    $diff = array_diff( $users_arr,$request_arr);
    $diff['user_id'] = $users->id;
    $diff['editor_id'] = $users->id;
    return $diff;

  }

  public static function getTimeZone($user_tz){
  $tz = 'Europe/Moscow';
  switch ($user_tz) {

    case '11':
    $tz = 'Pacific/Midway';
    break;
    case '10':
    $tz = 'US/Hawaii';
    break;
    case '9':
    $tz = 'US/Alaska';
    break;
    case '8':
    $tz = 'America/Tijuana';
    break;
    case '7':
    $tz = 'US/Arizona';
    break;
    case '6':
    $tz = 'America/Monterrey';
    break;
    case '5':
    $tz = 'America/Lima';
    break;
    case '4':
    $tz = 'America/La_Paz';
    break;
    case '3.5':
    $tz = 'Canada/Newfoundland';
    break;
    case '3':
    $tz = 'America/Argentina/Salta';
    break;
    case '2':
    $tz = 'America/Sao_Paulo';
    break;
    case '1':
    $tz = 'Atlantic/Cape_Verde';
    break;
    case '0':
    $tz = 'Europe/Dublin';
    break;
    case '-1':
    $tz = 'Europe/Vienna';
    break;
    case '-2':
    $tz = 'Europe/Sofia';
    break;
    case '-3':
    $tz = 'Europe/Moscow';
    break;
    case '-4':
    $tz = 'Europe/Ulyanovsk';
    break;
    case '-5':
    $tz = 'Asia/Yekaterinburg';
    break;
    case '-6':
    $tz = 'Asia/Omsk';
    break;
    case '-7':
    $tz = 'Asia/Krasnoyarsk';
    break;
    case '-8':
    $tz = 'Asia/Irkutsk';
    break;
    case '-9':
    $tz = 'Asia/Yakutsk';
    break;
    case '-10':
    $tz = 'Asia/Vladivostok';
    break;
    case '-11':
    $tz = 'Asia/Magadan';
    break;
    case '-12':
    $tz = 'Asia/Kamchatka';
    break;
    case '-13':
    $tz = 'Pacific/Samoa';
    break;
    case '-13.75':
    $tz = 'Pacific/Chatham';
    break;
    case '-14':
    $tz = 'NZ-CHAT';
    break;

    default:

    break;
      }
      return $tz;
}


}
