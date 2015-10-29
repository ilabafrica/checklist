<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Hash;
use Input;
use Session;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all users
		$users = User::all();
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
        $user->dob = $request->dob;
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
        $user->dob = $request->dob;
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
	 * Remove the specified resource from storage.
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
	public function destroy($id)
	{
		//
	}
	/**
     * Change the image name, move it to images/profile, and return its new name
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
            $request->file('photo')->move('images/profiles/', $filename);
        }
        return $filename;
    }
}
