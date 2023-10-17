<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $categories = [];

        if ($this->resource->count() > 0) {
            foreach ($this->resource as $category) {
                // dd($btl->getCategorys);
                // $noofChild = Card::where($card->id)->count();
                $picture = $category->image != null ? asset('storage/' . $category->image) : '/assets/media/avatars/blank.png';
                $userAvatar = '<div class="d-flex align-items-center">
                            <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="' . $picture . '"
                                         style=" object-fit: cover;"/>
                            </div>
                            <a href="' . route('user.admin.view', $category->id) . '" target="_blank" >
                                <div class="text-gray-800 text-hover-primary mb-1 ms-5 cursor-pointer">
                                    ' . $category->first_name . ' ' . $category->last_name . '
                                    <div class="fw-semibold text-muted">' . $category->email . '</div>
                                </div>
                                </a>
                            <!--end::Details-->
                        </div>';

                $actions = '<div class="dropdown">
                              <button class="btn btn-active-dark btn-sm dropdown-toggle" type="button" id="actionsMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="actionsMenu">';

                // if (Helper::permission('Users.view')) {
                // $actions .= '<li>
                //                     <a class="dropdown-item"  target="_blank" href="' . route('user.admin.view', $card->id) . '">View</a>
                //                 </li>';
                $actions .= '<li>
                                    <a class="dropdown-item create_new_off_canvas_modal edit_blog"  data-id="' . $category->id . '" href="javascript:void(0);" >Edit</a>
                                </li>';
                // $actions .= $btl->is_active == 1 ? '<li>
                //                     <a   href="javascript:void(0);" class="dropdown-item userStatus" data-active=0  data-id="' . $btl->id . '"  >Deactive</a>
                //                 </li>' : '<li>
                //                     <a   href="javascript:void(0);" class="dropdown-item userStatus" data-active=1   data-id="' . $btl->id . '"  >Active</a>
                //                 </li>';
                // }
                // if (Helper::permission('Users.delete')) {
                $actions .= '<li>
                                    <a class="dropdown-item delete_record" data-id="' . $category->id . '" href="javascript:void(0);">Delete</a>
                                </li>';
                // }
                $actions .= '  </ul>
                            </div>';
                $status = $category->is_active == 1 ? '<div class="badge badge-light-success fw-bold">Active</div>' : '<div class="badge badge-light-danger fw-bold">Disabled</div>';
                $creator = '';
                $categories[] = [
                    'image' => $userAvatar,
                    'title' => $category->title,
                    'actions' => $actions
                ];
            }
        }

        return [
            'draw' => 1,
            'recordsTotal' => count($categories),
            'recordsFiltered' => count($categories),
            'data' => $categories
        ];
    }
}
