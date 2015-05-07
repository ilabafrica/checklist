<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Lab;

class LabRequest extends Request {

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
            'name'   => 'required|unique:labs,name,'.$id,
            'lab_type'   => 'required:labs,lab_type_id,'.$id,
            'country'   => 'required:labs,country_id,'.$id,
            'address'   => 'required:labs,address,'.$id,
            'city'   => 'required:labs,city,'.$id,
            'postal_code'   => 'required:labs,postal_code,'.$id,
            'lab_level'   => 'required:labs,lab_level_id,'.$id,
            'lab_affiliation'   => 'required:labs,lab_affiliation_id,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('lab');
		$name = $this->input('name');
		return Lab::where(compact('id', 'name'))->exists() ? $id : '';
	}
}