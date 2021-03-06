<?php

namespace App;
use Illuminate\Support\Carbon;
use DB;
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
    public function scopeOrderByField($query, $field, $order)
    {
        switch ($field) {
            case 'name': 
                $query->orderByName($order);
                break;
            case 'company': 
                $query->orderByCompany($order);
                break;
            case 'birthday': 
                $query->orderBybirthday($order);
                break;
            case 'last_interaction': 
                $query->orderByLastInteractionDate($order);
                break;

        }
    }
    public function scopeOrderByCompany($query, $order){
        if (strtolower($order) == 'asc') {
            $query->orderByAsc(Company::select('name')->whereRaw('customers.company_id = companies.id'));
        } else {
            $query->orderByDesc(Company::select('name')->whereRaw('customers.company_id = companies.id'));
        }
    }
     public function scopeOrderByBirthday($query, $order){
        $query->orderby(DB::raw('MONTH(birth_date)'), $order)->orderby(DB::raw('DAYOFMONTH(birth_date)'), $order);
    }
    public function scopeOrderByName($query, $order){
        $query->orderBy('last_name', $order)->orderBy('first_name', $order);
    }
    public function scopeOrderByLastInteractionDate($query, $order){
        if (strtolower($order) == 'asc') {
            $query->orderByDesc(Interaction::select('created_at')->whereRaw('customers.id = interactions.customer_id')->latest());
        } else {
            $query->orderByAsc(Interaction::select('created_at')->whereRaw('customers.id = interactions.customer_id')->latest());
        }
    }
    public function scopeSearch($query, $search){
            foreach (explode(' ', $search) as $term) {
                 $query->where(function ($query) use ($term) {
                    $query->where('first_name', 'like', '%' . $term . '%')
                    ->orWhere('last_name', 'like', '%' . $term . '%')
                    ->orWhereHas('company', function ($query) use ($term) {
                        $query->where('name', 'like', '%' . $term . '%');
                    });                   
                });
            };
    }
    public function scopeWhereBirthdayThisWeek($query){
        $start = Carbon::now()->startOfWeek()->format('md');
        $end = Carbon::now()->endOfWeek()->format('md');
         return $query->whereNotNull('birth_date')->whereBetween(\DB::raw("date_format(birth_date, '%m%d')"),array($start,$end));
    }
    public function scopeWhereFilters($query, array $filters){
        $filters = collect($filters);
        $query->when($filters->get('search'), function ($query, $search) {
            $query->search($search);
        })->when($filters->get('filter') === 'birthday_this_week', function ($query, $filter) {
            $query->whereBirthdayThisWeek();
        });
    }
    public function scopeVisibleTo($query, User $user){
        if ($user->is_admin) {
            return $query;
        }
         return $query->where('sales_rep_id', $user->id);
    }
}