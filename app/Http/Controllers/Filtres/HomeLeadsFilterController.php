<?php

namespace App\Http\Controllers\Filtres;

use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeLeadsFilterController extends Controller
{
    protected $builder;
    protected $request;

    public function __construct($builder, $request)
    {
        $this->builder = $builder;
        $this->request = $request;
        $this->builder->orderByDesc('created_at');

    }

    public function apply()
    {
        foreach ($this->filters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function leads($value)
    {
        switch ($value) {
            case 'unclaimed':
                return $this->builder->doesntHave('city.underwriter');
                break;
            case 'free':
                return $this->builder->where('lead_status', 1);
                break;
            case 'my':
                return $this->builder->where('underwriter_id', \Auth::id());
                break;
            case 'bad-quality':
                return $this->builder->where('lead_status', 4);
                break;
        }
    }

    public function from($value)
    {
        return $this->builder->where('created_at', '>=', $value);
    }

    public function to($value)
    {
        return $this->builder->where('created_at', '<=', $value);
    }

    public function filters()
    {
        return $this->request->all();
    }
}
