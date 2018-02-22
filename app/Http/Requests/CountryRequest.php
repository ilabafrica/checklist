<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Country;

class CountryRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$id = $this->ingnoreId();
		return [
            'name'   => 'required|unique:countries,name,'.$id,
            'capital'   => 'required|unique:countries,capital,'.$id,
            'code'   => 'required|unique:countries,code,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('country');
		$name = $this->input('name');
		return Country::where(compact('id', 'name'))->exists() ? $id : '';
	}

}
