<?php


namespace Modules\Vendors\Entities\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Accounts\Entities\Verification;
use Modules\Products\Entities\Product;
use Modules\Sections\Entities\Section;

trait VendorRelations
{

    /**
     * Get the Vendor's verification.
     */
    public function verification(): MorphOne
    {
        return $this->morphOne(Verification::class, 'parentable');
    }

    /**
     * Get the sections that belong to the vendor.
     */
    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class, 'vendor_section', 'vendor_id', 'section_id')
            ->withTimestamps();
    }

    /**
     * Get the products that belong to the vendor.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

}
