<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Role;
use Hash;
use Input;
use Session;
use Carbon\Carbon;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all users
		$users = User::withTrashed()->get();
		return view('user.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Return new user form
		return view('user.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(UserRequest $request)
	{
		$user = new User;
		$user->name = $request->name;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->address = $request->address;
        if($request->default_password)
        	$user->password = Hash::make(User::DEFAULT_PASSWORD);
        else
        	$user->password = Hash::make($request->password);
        if(Input::hasFile('photo'))
        	$user->image = $this->imageModifier($request, $request->all()['photo']);
        $user->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', 'User created successfully.')->with('active_user', $user ->id);
	}

	//New user's self registration

	public function registerSave(UserRequest $request)
	{
		$user = new User;
		$user->name = $request->name;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->address = $request->address;
        $user->deleted_at =Carbon::now(); // by default a newly registered user's is deactivated. The admin should accept the new user's role then activate it.

        if($request->default_password)
        	$user->password = Hash::make(User::DEFAULT_PASSWORD);
        else
        	$user->password = Hash::make($request->password);
        if(Input::hasFile('photo'))
        	$user->image = $this->imageModifier($request, $request->all()['photo']);

        //users assigns themselves a role but the account is inactive until admin approves.
        $role = Role::find($request->user_role);        
        try
        {
	        $user->save();
			$user->detachRole($role);
			$user->attachRole($role);
		}catch(Exception $e){
			dd($e);
		}
        return redirect()->to('/')->with('message', 'Registration successful. Kindly contact the Admin to activate your account.')->with('active_user', $user ->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//	Get user
		$user = User::find($id);
		return view('user.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//	Get user
		$user = User::find($id);
		return view('user.edit', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UserRequest $request, $id)
	{
		//	Get user
		$user = User::find($id);
		$user->name = $request->name;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->username = $request->username;
        if($request->default_password)
        	$user->password = Hash::make(User::DEFAULT_PASSWORD);
        else
        	$user->password = Hash::make($request->password);
        if(Input::hasFile('photo'))
        	$user->image = $this->imageModifier($request, $request->all()['photo']);
        $user->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', 'User updated successfully.')->with('active_user', $user ->id);
	}

	/**
	 * Disable a user from using the system.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function delete($id)
	{
		$user= User::find($id);
		$user->delete();
		return redirect('user')->with('message', 'User deleted successfully.');
	}

	//Enable a user to use the system
	public function enable($id)
	{
		$user= User::withTrashed()->find($id);
		$user->deleted_at = null;
		$user->save();
		return redirect('user')->with('message', 'User enabled successfully.');
	}

	//Reset a user's password to default
	public function reset_password($id)
	{
		$user= User::withTrashed()->find($id);
        $user->password = Hash::make(User::DEFAULT_PASSWORD);
		$user->save();
		return redirect('user')->with('message', 'Password Reset successfully.');
	}

	public function destroy($id)
	{
		//
	}
	/**
     * Change the image name, move it to img/profile, and return its new name
     *
     * @param $request
     * @param $data
     * @return string
     */
    private function imageModifier($request, $image)
    {
        if(empty($image)){
            $filename = 'default.png';
        }else{
            $ext = $request->file('photo')->getClientOriginalExtension();
            $filename = uniqid() . "." . $ext;
            $request->file('photo')->move('img/profiles/', $filename);
        }
        return $filename;
    }
}
