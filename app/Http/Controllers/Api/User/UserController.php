<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepository;
use App\Storage\StorageService;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{

    use HttpResponse;
    protected $userRepository;
    protected $storageService;
    public function __construct(UserRepository $userRepository,StorageService $storageService)
    {
        $this->userRepository = $userRepository;
        $this->storageService = $storageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, int $id)
    {
        try {
            $updateUser=$this->userRepository->updateUser($request->toArray(),$id);
            return $this->success('User updated successfully',['user'=>UserResource::make($updateUser)],true,200);
        } catch (Exception $e) {
            return $this->error($e->getMessage(),[],false,500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function uploadImage(Request $request){
        try {
            $request->validate([
                'avatar_url' => 'required|mimes:jpeg,png,jpg,gif,svg',
            ]);
            $file_path=$this->storageService->store('profile_photos',$request->file('avatar_url'));
            $user=$this->userRepository->uploadImage(['avatar_url'=>$file_path]);
            return $this->success('Image uploaded successfully',['user'=>UserResource::make($user)],true,200);
        } catch (Exception $e) {
           return $this->error($e->getMessage(),[],false,500);
        }
    }

    public function getUser($id){
        try {
           $user=$this->userRepository->getUser($id);
            return $this->success('Showed Successfully',['user'=>UserResource::make($user)],true,200);
        } catch (Exception $e) {
           return $this->error($e->getMessage(),[],false,500);
        }
    }
}
