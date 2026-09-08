<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\API\V1\User\CheckIfUserExistAction;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Users\CheckIfUserExistRequest;
use App\Http\Resources\API\V1\UserResource;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return UserResource::collection($users);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Log::info($request->all());
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required',
            'car_model_id' => ['nullable'],
            'plate_number' => ['nullable'],
            'production_year' => ['nullable'],
            ]);
        // Log::info($validated['role']);
            
        // dd($request->all());  // ← logs to storage/logs/laravel.log
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password']
        ]);

        $user->assignRole($validated['role']);

        if ($validated['role'] === 'Driver') {
            Car::create([
                'driver_id' => $user->id,
                'car_model_id' => $validated['car_model_id'],
                'plate_number' => $validated['plate_number'],
                'production_year' => $validated['production_year'],
            ]);
        }

        return response()->json([
            'message' => 'User created successfully.',
            'user' => $user,
        ], 201);

    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id, // ignore current user's email
            'password' => 'nullable|string',
            'role'     => 'nullable',
        ]);

        // only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']); // remove it so current password stays
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully.',
            'user'    => $user,
        ], 200);
    }

    public function deactivateUser(User $user)
    {
        $user->update([
            'status' => UserStatus::NonActive->value
        ]);
        
        // writing to driver_logs table when driver is deactivated but when regular dispatcher deactivated where it is gong to be written and how can I know that it is driver deactivated or regular disatcher if he has both roles

        return response()->json([
            'message' => 'User deactivated successfully'
        ], 200);
    }

    public function activateUser(User $user)
    {
        $user->update([
            'status' => UserStatus::Active->value
        ]);
        
        return response()->json([
            'message' => 'User activated successfully'
        ], 200);
    }

    public function blockUserByDate(Request $request, User $user)
    {
        $validated = $request->validate([
            'comment' => ['required'],
            'blocked_until' => ['required']
        ]);

        $user->update([
            'status' => UserStatus::Blocked->value
        ]);
        
        return response()->json([
            'message' => 'User blocked successfully'
        ], 200);
    }

    public function unblockUser(User $user)
    {
        $user->update([
            'status' => UserStatus::Active->value
        ]);
        
        return response()->json([
            'message' => 'User unblocked successfully'
        ], 200);
    }

    public function checkIfUserExist(
        CheckIfUserExistRequest $checkIfUserExistRequest,
        CheckIfUserExistAction $checkIfUserExistAction
    )
    {
        $user = $checkIfUserExistAction->execute($checkIfUserExistRequest->validated());
        
        return response()->json([
            'user' => $user
        ], 200);
    }
}
