<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchShowcaseItem extends Model
{
    const SECTION_PARTNERS = 'partners';
    const SECTION_FEATURED_CLIENTS = 'featured_clients';

    const PAGE_HOME = 'home';
    const PAGE_ABOUT = 'about';
    const PAGE_BOTH = 'both';

    protected $table = 'branch_showcase_items';

    protected $fillable = [
        'branch_id',
        'section',
        'page',
        'title',
        'image',
        'link',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public static function sections()
    {
        return [
            self::SECTION_PARTNERS => trans('admin/main.partner_slides'),
            self::SECTION_FEATURED_CLIENTS => trans('admin/main.client_slides'),
        ];
    }

    public static function pages()
    {
        return [
            self::PAGE_BOTH => trans('admin/main.home_and_about_pages'),
            self::PAGE_HOME => trans('admin/main.home_page_only'),
            self::PAGE_ABOUT => trans('admin/main.about_page_only'),
        ];
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeVisibleFor($query, $branchId, $section, $page)
    {
        return $query->where('branch_id', $branchId)
            ->where('section', $section)
            ->where('status', 1)
            ->where(function ($query) use ($page) {
                $query->where('page', self::PAGE_BOTH)->orWhere('page', $page);
            })
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc');
    }
}
