<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface

class Workshop extends Model implements Revisionable{

    protected $table = 'workshops';
    use RevisionableTrait;

    protected $revisionable = [
        'name',
        'description',
    ];

    public static function idByName($name)
    {
        try
        {
            $workshop = Workshop::where('name', $name)->orderBy('name', 'asc')->firstOrFail();
            return $workshop->id;
        }
        catch (ModelNotFoundException $e)
        {
            Log::error("The Workshop type ` $name ` does not exist:  ". $e->getMessage());
            //TODO: send email?
            return null;
        }
    }
}

