<?php

namespace App\Traits;

use App\Scopes\BranchScope;

trait BranchScoped
{
    protected static function booted()
    {
        static::addGlobalScope(new BranchScope);
    }

    // Method to disable branch scope
    public static function withoutBranchScope(callable $callback)
    {
        return static::withoutGlobalScope(BranchScope::class)->$callback();
    }

    // Method to get data from all branches
    public static function allBranches()
    {
        return static::withoutGlobalScope(BranchScope::class);
    }
}