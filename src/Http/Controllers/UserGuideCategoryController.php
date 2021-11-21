<?php

namespace Hridoy\LaravelUserGuide\Http\Controllers;

use App\Http\Controllers\Controller;
use Hridoy\LaravelUserGuide\Http\Requests\UserGuideCategoryRequest;
use Hridoy\LaravelUserGuide\Models\UserGuideCategory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;

class UserGuideCategoryController extends Controller
{
    private $checkPermission;

    public function __construct()
    {
        $this->checkPermission = config('user_guide.user-guide-category-permissions.enabled');
    }

    /**
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->verifyAccess(__FUNCTION__);
        $itemsPerPage = request('per_page') ?? 50;
        return UserGuideCategory::paginate($itemsPerPage);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(UserGuideCategoryRequest $request)
    {
        $this->verifyAccess(__FUNCTION__);
        $path = config('user_guide.photo.path');
        $disk = config('user_guide.photo.disk');
        $input = $request->all();
        if ($request->has('photo')) {
            $input['photo'] = Storage::disk($disk)->putFile($path, $request->file('photo'));
        }
        $userGuideCategory = UserGuideCategory::create($input);
        return response($userGuideCategory);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $userGuideCategory = UserGuideCategory::findOrFail($id);
        $this->verifyAccess(__FUNCTION__);
        return response($userGuideCategory->load('userGuides'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UserGuideCategoryRequest $request, $id)
    {
        $this->verifyAccess(__FUNCTION__);
        $userGuideCategory = UserGuideCategory::findOrFail($id);
        $path = config('user_guide.photo.path');
        $disk = config('user_guide.photo.disk');
        $input = $request->all();
        if ($request->has('photo')) {
            $input['photo'] = Storage::disk($disk)->putFile($path, $request->file('photo'));
        }
        $userGuideCategory->update($input);
        return response($userGuideCategory);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $this->verifyAccess(__FUNCTION__);
        $userGuideCategory = UserGuideCategory::findOrFail($id);
        $userGuideCategory->delete();
        return response($userGuideCategory);
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
        if ($this->checkPermission) {
            $this->authorize(config('user_guide.user-guide-category-permissions.' . $methodName));
        }
    }
}
