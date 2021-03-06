<?php

namespace App;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Eloquence\Eloquence;

class Patient extends Model
{
	use Eloquence;
	use FormAccessible;
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $fillable = [
		'name1',
		'name2',
		'user_id',
		'surname1',
		'surname2',
		'married_name',
		'gender',
		'civil',
		'birth',
		'patient_code',
		'document_type',
		'document',
		'status',
		'name_relation',
		'kinship',
		'phone1',
		'phone2',
		'email',
		'address',
		'city_town',
	];

    public function consultations()
    {
        return $this->hasMany('App\Consultation');
    }

}
