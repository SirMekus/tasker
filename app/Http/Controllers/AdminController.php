<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function login()
    {
		$messages = [
                        'email.required'  => "The :attribute field is required to work",
                        'unique'    => ":attribute is already used."
                    ];

        $this->validate(request(), [
            'email'   => 'required|string',
            'password' => 'required|string'
        ], $messages);

        if (Auth::guard('admin')->attempt(['email' => request()->email, 'password' => request()->password])) 
		{
            $data["status"] = true;
			$data["url"] = redirect()->intended(route('activities'))->getTargetUrl();

			return response($data, 200);
        }

        abort(422,"Credentials didn't match our records.");
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
	
		$data["status"] = true;
		$data["url"] = route("admin.login");
		$data["msg"] = "logout was successful";

		return response($data);
    }

    public function getAdmins()
    {
        $admins = Admin::when(request()->id, function($query){
            $query->where('id', request()->id);
        })
        ->when(request()->search, function($query){
            $query->where('name->firstname', 'like', "%".request()->search."%")->orWhere('name->lastname', 'like', "%".request()->search."%");
        })
        ->paginate(20);

        return view('admin.admins', ["result"=>$admins]);
    }

    public function createOrUpdateView()
    {
        $this->authorizeForUser(request()->user('admin'), 'isOga', Admin::class);

        $admin = null;

        if(request()->id)
        {
            $admin = Admin::where('id', request()->id)->first();
        }

        return view('admin.create-admin', ["admin"=>$admin]);
    }

    public function createOrUpdate()
    {
        $this->authorizeForUser(request()->user('admin'), 'isOga', Admin::class);

        request()->validate([
            'firstname' => ['bail', 'required', 'string'],
            'lastname' => ['bail', 'required', 'string'],
            'email' => ['bail', 'nullable', 'email:rfc', Rule::unique((new Admin)->getTable())->ignore(request()->user('admin')->id, 'id')],
            'role' => ['bail', 'string'],
            'password' => ['bail', 'nullable', 'string', Rule::requiredIf(function () {
                return !request()->filled('id');
            })],
            'id' => 'sometimes|nullable|string|exists:App\Models\Admin',
        ]);
    
        $data = [
            'name' => [
                'firstname' => request()->firstname,
                'lastname' => request()->lastname,
            ],
            'role' => request()->role,  'email' => request()->email
        ];

        if (request()->filled('change_password') or !request()->filled('id')) 
        {
            $data['password'] = request()->password;
        }

        Admin::updateOrCreate(
            ['id' => request()->id],
            $data
        );

        $verb = request()->filled('id') ? 'updated' : 'created';

        return response("Admin was $verb successfully");
    }

    public function deactivate()
    {
        $this->authorizeForUser(request()->user('admin'), 'isOga', Admin::class);

        Admin::where('id', request()->id)->update([
            'active'=>0
        ]);

        return redirect(url()->previous());
    }

    public function reactivate()
    {
        $this->authorizeForUser(request()->user('admin'), 'isOga', Admin::class);

        Admin::where('id', request()->id)->update([
            'active'=>1
        ]);

        return redirect(url()->previous());
    }

    public function delete()
    {
        $this->authorizeForUser(request()->user('admin'), 'isOga', Admin::class);
        
        Admin::where('id', request()->id)->delete();

        return redirect(url()->previous());
    }
}
