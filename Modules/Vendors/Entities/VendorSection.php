<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Sections\Entities\Section;

class VendorSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'section_id',
    ];

    protected $table = 'vendor_section';

    /**
     * Get the vendor that owns the vendor section.
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the section that owns the vendor section.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}

