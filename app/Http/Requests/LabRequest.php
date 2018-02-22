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
		// $id = $this->ingnoreId();
		$id = $this->route('lab');

		return [
            'name'   => 'required|unique:labs,name,'.$id,
            'lab_number'   => 'required|numeric|unique:labs,lab_number,'.$id,
            'lab_type'   => 'required:labs,lab_type_id,'.$id,
            'county_id'   => 'required:labs,county_id,'.$id,
            'address'   => 'required:labs,address,'.$id,
            'postal_address'   => 'required:labs,postal_address,'.$id,
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
