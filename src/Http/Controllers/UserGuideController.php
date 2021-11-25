<?php

namespace Hridoy\LaravelUserGuide\Http\Controllers;

use App\Http\Controllers\Controller;
use Hridoy\LaravelUserGuide\Http\Requests\UserGuideRequest;
use Hridoy\LaravelUserGuide\Models\UserGuide;
use Illuminate\Support\Facades\Storage;

class UserGuideController extends Controller
{
    private $checkPermission;

    public function __construct()
    {
        $this->checkPermission = config('user_guide.user-guide-permissions.enabled');
    }

    /**
     * @throws \Exception
     */
    public function index(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $this->verifyAccess(__FUNCTION__);
        $itemsPerPage = request('per_page') ?? 50;
        $type = request('type');
        $platform = request('platform');
        $userGuides = UserGuide::query();
        validator(request()->query(), [
            'id' => 'integer|exists:user_guide_categories'
        ]);
        $id = request('id');
        if ($id) {
            $userGuides->where('user_guide_category_id', $id);
        }
        if ($type){
            $userGuides->where('type',$type);
        }
        if ($platform){
            $userGuides->where('platform',$platform);
        }
        return $userGuides->paginate($itemsPerPage);
    }

    /**
     * @throws \Exception
     */
    public function store(UserGuideRequest $request)
    {
        $this->verifyAccess(__FUNCTION__);
        $path = config('user_guide.photo.path');
        $disk = config('user_guide.photo.disk');
        $input = $request->all();
        if ($request->has('photo')) {
            $input['photo'] = Storage::disk($disk)->putFile($path, $request->file('photo'));
        }
        $userGuide = UserGuide::create($input);
        return response($userGuide);
    }

    /**
     * @throws \Exception
     */
    public function show($id)
    {
        $this->verifyAccess(__FUNCTION__);
        $userGuide = UserGuide::findOrFail($id);
        return response($userGuide);
    }

    /**
     * @throws \Exception
     */
    public function update(UserGuideRequest $request, $id)
    {
        $this->verifyAccess(__FUNCTION__);
        $userGuide = UserGuide::findOrFail($id);
        $path = config('user_guide.photo.path');
        $disk = config('user_guide.photo.disk');
        $input = $request->all();
        if ($request->has('photo')) {
            $input['photo'] = Storage::disk($disk)->putFile($path, $request->file('photo'));
        }
        $userGuide->update($input);
        return response($userGuide);
    }

    /**
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->verifyAccess(__FUNCTION__);
        $userGuide = UserGuide::findOrFail($id);
        $userGuide->delete();
        return response($userGuide);
    }

    /**
     * @throws \Exception
     */
    public function restore()
    {
        $this->verifyAccess(__FUNCTION__);
    }

    /**
     * @throws \Exception
     */
    public function forceDelete()
    {
        $this->verifyAccess(__FUNCTION__);
    }

    /**
     * @throws \Exception
     */
    private function verifyAccess($method)
    {
        if ($this->checkPermission) {
            if (!(auth()->check() && auth()->user()->can(config('user_guide.user-guide-permissions.' . $method)))) {
                throw new \Exception('This action is unauthorized', 403);
            }
        }
    }
}
