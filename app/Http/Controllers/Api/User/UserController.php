<?php

namespace App\Http\Controllers\Api\User;

use Exception;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Models\MentorProfile;
use App\Models\LearnerProfile;
use App\Storage\StorageService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Validator;

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

    // upgrade user role to learner or mentor
    // Upgrade user to Learner or Mentor
    public function upgrade(Request $request)
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Validate the upgrade request (only upgrade once to learner or mentor)
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:learner,mentor', // Only allow learner or mentor role
            'learner_profile' => 'nullable|array', // Learner profile details, if upgrading to learner
            'mentor_profile' => 'nullable|array', // Mentor profile details, if upgrading to mentor
            'learner_profile.age' => 'required_if:role,learner|integer|min:5',
            'learner_profile.school_grade' => 'required_if:role,learner|string',
            'mentor_profile.bio' => 'required_if:role,mentor|string',
            'mentor_profile.experience' => 'required_if:role,mentor|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Set the user role
        $user->role = $request->role;
        $user->save();

        // Create Learner or Mentor profile based on the role
        if ($request->role == 'learner') {
            // Create Learner profile
            $learnerProfile = LearnerProfile::create([
                'user_id' => $user->id,
                'age' => $request->learner_profile['age'],
                'school_grade' => $request->learner_profile['school_grade'],
                'guardian_contact' => $request->learner_profile['guardian_contact'] ?? null,
                'learning_goals' => $request->learner_profile['learning_goals'] ?? null,
                'special_needs' => $request->learner_profile['special_needs'] ?? null,
                'location' => $request->learner_profile['location'] ?? null,
            ]);
        }

        if ($request->role == 'mentor') {
            // Create Mentor profile
            $mentorProfile = MentorProfile::create([
                'user_id' => $user->id,
                'bio' => $request->mentor_profile['bio'],
                'experience' => $request->mentor_profile['experience'],
                'availability' => json_encode($request->mentor_profile['availability']), // Assuming availability is an array of available times
            ]);
        }

        return response()->json([
            'message' => 'User upgraded successfully to ' . $request->role,
            'user' => $user,
        ]);
    }
}
