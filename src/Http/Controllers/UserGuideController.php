<?php

namespace Hridoy\LaravelUserGuide\Http\Controllers;

use App\Http\Controllers\Controller;
use Hridoy\LaravelUserGuide\Http\Requests\UserGuideCategoryRequest;
use Hridoy\LaravelUserGuide\Http\Requests\UserGuideRequest;
use Hridoy\LaravelUserGuide\Models\UserGuide;
use Hridoy\LaravelUserGuide\Models\UserGuideCategory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;

class UserGuideController extends Controller
{
    private $checkPermission=false;

    public function __construct()
    {
        $this->checkPermission = config('user_guide.user-guide-permissions.enabled');
        $this->authorizeResource(UserGuide::class);
    }

    /**
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->verifyAccess(__FUNCTION__);
        $itemsPerPage = request('per_page') ?? 50;
        $userGuides = UserGuide::query();
        validator(request()->query(), [
            'id' => 'integer|exists:user_guide_categories'
        ]);
        $id = request('id');
        if ($id) {
            $userGuides->where('user_guide_category_id', $id);
        }
        return $userGuides->paginate($itemsPerPage);
    }

    /**
     * @throws AuthorizationException
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
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $this->verifyAccess(__FUNCTION__);
        $userGuide = UserGuide::findOrFail($id);
        return response($userGuide);
    }

    /**
     * @throws AuthorizationException
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
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $this->verifyAccess(__FUNCTION__);
        $userGuide = UserGuide::findOrFail($id);
        $userGuide->delete();
        return response($userGuide);
    }

    /**
     * @throws AuthorizationException
     */
    public function restore()
    {
        $this->verifyAccess(__FUNCTION__);
    }

    /**
     * @throws AuthorizationException
     */
    public function forceDelete()
    {
        $this->verifyAccess(__FUNCTION__);
    }

    /**
     * @throws AuthorizationException
     */
    private function verifyAccess($methodName)
    {
//        if ($this->checkPermission) {
//            $this->authorize(config('user_guide.user-guide-permissions.' . $methodName));
//        }
    }
}
