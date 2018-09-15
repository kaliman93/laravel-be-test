<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $casts = [
        'birth_date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }
    public function scopeWithLastInteractionType($query)
    {
        $subQuery = \DB::table('interactions')->
            select('type')->
            whereRaw('customer_id = customers.id')->
            latest()->
            limit(1);

        return $query->select('customers.*')->selectSub($subQuery, 'last_interaction_type');
    }
}

