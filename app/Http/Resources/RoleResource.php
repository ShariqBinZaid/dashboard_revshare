<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
        // dd($this->resource[0]->user);
        if ($this->resource->count() > 0) {
            foreach ($this->resource[0]->user as $user) {
                $picture = $user->display_picture != null ? asset('storage/' . $user->display_picture) : '/assets/media/avatars/blank.png';
                $userAvatar = '<div class="d-flex align-items-center">
                            <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="' . $picture . '"
                                         style=" object-fit: cover;"/>
                            </div>
                            <div class="text-gray-800 text-hover-primary mb-1 ms-5">
                                ' . $user->first_name . ' ' . $user->last_name . '
                                <div class="fw-semibold text-muted">' . $user->email . '</div>
                            </div>
                            <!--end::Details-->
                        </div>';

                $actions = '
                            <div class="dropdown">
                              <button class="btn btn-active-dark btn-sm dropdown-toggle" type="button" id="actionsMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="actionsMenu">

                                <li>
                                    <a class="dropdown-item"  target="_blank"  href="' . route('user.admin.view', $user->id) . '">View</a>
                                </li>
                                <li>
                                    <a class="dropdown-item delete_record" data-id="' . $user->id . '" href="javascript:void(0);">Delete</a>
                                </li>
                              </ul>
                            </div>
                ';
                $status = $user->is_active == 1 ? '<div class="badge badge-light-primary fw-bold">Active</div>' : '<div class="badge badge-light-warning fw-bold">Disabled</div>';
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
