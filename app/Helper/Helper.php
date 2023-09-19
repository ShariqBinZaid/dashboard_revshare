<?php

namespace App\Helper;

use App\Models\Role;
use App\Models\RolePermission;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Willywes\AgoraSDK\RtcTokenBuilder;
use Cache;

/***************************
Go to config/app 
set aliases aliases_name' =>location (App\Helper\Helper::class)
 ********************************/
class Helper
{
  public static function permission($name)
  {

    $roles = DB::table('user_roles')->select('role_id')->where('user_id', Auth::id())->get();
    $roleArray = [];
    if ($roles->count() > 0) {
      foreach ($roles as $key => $role) {
        $roleArray[] = $role->role_id;
      }
    }
    if (!empty($roles)) {
      $getPerm = DB::table('permissions As p')
        ->select('p.permission_name')
        ->leftJoin('role_permissions As rp', 'p.id', '=', 'rp.permission_id')
        ->where('p.permission_name', $name)->whereIn('rp.role_id', $roleArray)
        ->get();
      if ($getPerm->count() > 0) {
        return true;
      }
      return false;
    }
    return false;
  }

  static function  getSvgIcon($path, $class = "")
  {
    $rootPath = "www/site/"; // project path

    $full_path =  $path;

    // if (!file_exists($full_path)) {
    //   return "<!--SVG file not found: $path-->\n";
    // }

    $cls = array("svg-icon");

    if (!empty($class)) {
      $cls = array_merge($cls, explode(" ", $class));
    }

    $svg_content = file_get_contents($full_path);

    // $output = "<!--begin::Svg Icon | path: $path-->\n";
    $output = "<span class=\"" . implode(" ", $cls) . "\">" . $svg_content . "</span>";
    // $output .= "\n<!--end::Svg Icon-->";

    return $output;
  }
}