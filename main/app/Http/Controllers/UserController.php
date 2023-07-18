<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        // $recodsPerBatch = 5;
        // $limit = 10;
        // $maxId = User::orderBy('id', 'asc')->offset($limit)->limit(1)->value('id');

        // User::orderBy('id', 'asc')->whereNull('updated_at')->where('id', '<', $maxId)->chunkById($recodsPerBatch, function (Collection $users) {
        //     foreach ($users as $user) {
        //         $user->updated_at = now();
        //         $user->update();
        //     }
        // });

        $users = User::withTrashed()->whereNot('email', '=', 'hoang220201@gmail.com')
            ->withCount('posts')
            ->paginate(10);

        return view('dashboard', compact(['users']));

        
    }

    public function edit(User $user)
    {
        return view('edit-user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($user->id)]
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect(route('user.edit', $user->id))->with('status', 'profile-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Request $request): RedirectResponse
    {
        $user->delete();

        $request->session()->flash('user-deletion-status', 'User ' . '<b>' . $user->name . '</b>' . ' successfully deleted!');

        return redirect(route('dashboard'));
    }

    public function restore(User $user): RedirectResponse
    {
        $user->restore();

        return back();
    }
}
