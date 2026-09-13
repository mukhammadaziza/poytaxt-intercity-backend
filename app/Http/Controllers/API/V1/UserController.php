<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\API\V1\User\ActivateUserAction;
use App\Actions\API\V1\User\CheckIfUserExistAction;
use App\Actions\API\V1\User\CreateUserAction;
use App\Actions\API\V1\User\DeactivateUserAction;
use App\Actions\API\V1\User\GetAllUsersAction;
use App\Actions\API\V1\User\GetUserAction;
use App\Actions\API\V1\User\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Users\ActivateUserRequest;
use App\Http\Requests\API\V1\Users\CheckIfUserExistRequest;
use App\Http\Requests\API\V1\Users\DeactivateUserRequest;
use App\Http\Requests\API\V1\Users\IndexUserRequest;
use App\Http\Requests\API\V1\Users\ShowUserRequest;
use App\Http\Requests\API\V1\Users\StoreUserRequest;
use App\Http\Requests\API\V1\Users\UpdateUserRequest;
use App\Http\Resources\API\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Get all users (except driver)
     * 
     * @param IndexUserRequest $indexUserRequest
     * @param GetAllUsersAction $getAllUsersAction
     * @return JsonResponse
     */
    public function index(
        IndexUserRequest $indexUserRequest,
        GetAllUsersAction $getAllUsersAction
    ): JsonResponse
    {
        $users = $getAllUsersAction->execute();

        return UserResource::collection($users)->response();
    }

    /**
     * Store user (except driver)
     * 
     * @param StoreUserRequest $storeUserRequest
     * @param CreateUserAction $createUserAction
     * @return JsonResponse
     */
    public function store(
        StoreUserRequest $storeUserRequest,
        CreateUserAction $createUserAction
    ): JsonResponse
    {
        $user = $createUserAction->execute($storeUserRequest->validated());

        return response()->json([
            'message' => 'User created successfully.',
            'data' => new UserResource($user)
        ], 201);
    }

    /**
     * Show user
     * 
     * @param ShowUserRequest $showUserRequest
     * @param GetUserAction $getUserAction
     * @param User $user
     * @return JsonResponse
     */
    public function show(
        ShowUserRequest $showUserRequest,
        GetUserAction $getUserAction,
        User $user
    ): JsonResponse
    {
        $user = $getUserAction->execute($user);

        return response()->json([
            'data' => new UserResource($user),
        ]);
    }

    /**
     * Update user
     * 
     * @param UpdateUserRequest $updateUserRequest
     * @param UpdateUserAction $updateUserAction
     * @param User $user
     * @return JsonResponse
     */
    public function update(
        UpdateUserRequest $updateUserRequest,
        UpdateUserAction $updateUserAction,
        User $user
    ): JsonResponse
    {
        
        $user = $updateUserAction->execute($updateUserRequest->validated(), $user);

        return response()->json([
            'message' => 'User updated successfully.',
            'data'    => new UserResource($user),
        ], 200);
    }

    /**
     * Deactivate user
     * 
     * @param DeactivateUserRequest $deactivateUserRequest
     * @param DeactivateUserAction $deactivateUserAction
     * @param User $user
     * @return JsonResponse
     */
    public function deactivateUser(
        DeactivateUserRequest $deactivateUserRequest,
        DeactivateUserAction $deactivateUserAction,
        User $user
    ): JsonResponse
    {
        $user = $deactivateUserAction->execute($user);   

        return response()->json([
            'message' => 'User deactivated successfully',
            'data' => new UserResource($user)
        ], 200);
    }

    /**
     * Activate user
     * 
     * @param ActivateUserRequest $activateUserRequest
     * @param ActivateUserAction $activateUserAction
     * @param User $user
     * @return JsonResponse
     */
    public function activateUser(
        ActivateUserRequest $activateUserRequest,
        ActivateUserAction $activateUserAction,
        User $user
    ): JsonResponse
    {
        $user = $activateUserAction->execute($user);

        return response()->json([
            'message' => 'User activated successfully',
            'data' => new UserResource($user)
        ], 200);
    }

    /**
     * Get user by phone number
     * @param CheckIfUserExistRequest $checkIfUserExistRequest
     * @param CheckIfUserExistAction $checkIfUserExistAction
     * @return JsonResponse
     */
    public function getUserByPhone(
        CheckIfUserExistRequest $checkIfUserExistRequest,
        CheckIfUserExistAction $checkIfUserExistAction
    ): JsonResponse
    {
        $user = $checkIfUserExistAction->execute($checkIfUserExistRequest->validated());
        
        return response()->json([
            'user' => new UserResource($user)
        ], 200);
    }
}
