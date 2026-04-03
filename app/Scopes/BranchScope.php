<?php 

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BranchScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Check if we're in admin mode and have selected branch
        if (session()->has('admin_selected_branch')) {
            $builder->where('branch_id', session()->get('admin_selected_branch'));
        }
        // Check if we're on branch subdomain
        elseif (session()->has('branch_id')) {
            $builder->where('branch_id', session()->get('branch_id'));
        }
        
        
    }
}