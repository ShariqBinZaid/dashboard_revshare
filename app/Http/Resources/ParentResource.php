<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Helper\Helper;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $users = [];
        if ($this->resource->count() > 0) {
            foreach ($this->resource as $user) {

                $picture = $user->display_picture != null ? asset('storage/' . $user->display_picture) : '/assets/media/avatars/blank.png';
                $userAvatar = '<div class="d-flex align-items-center">
                            <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="' . $picture . '"
                                         style=" object-fit: cover;"/>
                            </div><a href="' . route('user.admin.view', $user->id) . '" target="_blank" >
                            <div class="text-gray-800 text-hover-primary mb-1 ms-5 cursor-pointer">
                                ' . $user->first_name . ' ' . $user->last_name . '
                                <div class="fw-semibold text-muted">' . $user->email . '</div>
                            </div></a>
                            <!--end::Details-->
                        </div>';

                $actions = '<div class="dropdown">
                              <button class="btn btn-active-dark btn-sm dropdown-toggle" type="button" id="actionsMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="actionsMenu">';

                // if (Helper::permission('Users.view')) {
                    $actions .= '<li>
                                    <a class="dropdown-item"  target="_blank" href="' . route('user.admin.view', $user->id) . '">View</a>
                                </li>';
                // }
                // if (Helper::permission('Users.delete')) {
                    $actions .= '<li>
                                    <a class="dropdown-item delete_record" data-id="' . $user->id . '" href="javascript:void(0);">Delete</a>
                                </li>';
                // }
                $actions .= '  </ul>
                            </div>';
                $status = $user->is_active == 1 ? '<div class="badge badge-light-success fw-bold">Active</div>' : '<div class="badge badge-light-danger fw-bold">Disabled</div>';
                $creator = '';
                $users[] = [
                    'user' => $userAvatar,
                    'status' => $status,
                    'createdBy' => $creator,
                    'createdAt' => Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d M, Y h:i A'),
                    'actions' => $actions
                ];
            }
        }

        return [
            'draw' => 1,
            'recordsTotal' => count($users),
            'recordsFiltered' => count($users),
            'data' => $users
        ];
    }
}
