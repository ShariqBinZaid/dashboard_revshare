<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Helper\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $modules = [];
        if ($this->resource->count() > 0) {
            foreach ($this->resource as $module) {
                $perms = '<span>';
                if ($module->permission->count() > 0) {
                    foreach ($module->permission as $kp => $perm) {
                        $color = 'badge-light-primary';
                        if ($kp == 1) {
                            $color = 'badge-light-danger';
                        }
                        if ($kp == 2) {
                            $color = 'badge-light-success';
                        }
                        if ($kp == 3) {
                            $color = 'badge-light-info';
                        }
                        if ($kp == 4) {
                            $color = 'badge-light-warning';
                        }

                        $perms .= ' <a href="#" class="badge ' . $color . ' fs-7 m-1 text-capitalize">' .
                            str_replace(['.', '_'], [' ', ' '], $perm->permission_name) . '</a>';
                    }
                }
                $perms .= '</span>';
                $actions = '<div class="dropdown">';
                // if (Helper::permission('Modules.update') || Helper::permission('Modules.delete')) {
                $actions .= '<button class="btn btn-active-dark btn-sm dropdown-toggle" type="button" id="actionsMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="actionsMenu">';

                // if (Helper::permission('Modules.update')) {
                $actions .= ' <li>
                                    <a class="dropdown-item create_new_off_canvas_modal edit_module"  data-id="' . $module->id . '" href="javascript:void(0);" >Edit</a>
                                </li>';
                // }
                // if (Helper::permission('Modules.delete')) {
                $actions .= '<li>
                 <a class="dropdown-item delete_record" data-id="' . $module->id . '" href="javascript:void(0);">Delete</a>
                                </li>';
                // }
                $actions .= '  </ul>';
                // }
                $actions .= '</div>';



                $modules[] = [
                    'module' =>  $module->name,
                    'permission' => $perms,
                    'createdAt' => Carbon::createFromFormat('Y-m-d H:i:s', $module->created_at)->format('d M, Y h:i A'),
                    'actions' => $actions
                ];
            }
        }
        return [
            'draw' => 1,
            'recordsTotal' => count($modules),
            'recordsFiltered' => count($modules),
            'data' => $modules
        ];
    }
}
