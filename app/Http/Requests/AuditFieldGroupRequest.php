<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\AuditFieldGroup;

class AuditFieldGroupRequest extends Request {

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
            'name'   => 'required|unique:audit_types,name,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('auditFieldGroup');
		$name = $this->input('name');
		return AuditFieldGroup::where(compact('id', 'name'))->exists() ? $id : '';
	}

}
