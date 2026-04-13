<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class EmployeeDocument extends Model {
    
    protected $fillable = [
        'employee_id', 
        'document_type', 
        'file_path', 
        'file_name'
    ];

    /**
     * Relationship: A document belongs to an employee.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Accessor: Get the full URL for the document.
     * Usage: $document->download_url
     */
    public function getDownloadUrlAttribute(): string
    {
        return asset(Storage::url($this->file_path));
    }

    /**
     * Helper: Get a human-readable file size.
     */
    public function getFileSizeAttribute()
    {
        if (Storage::disk('public')->exists($this->file_path)) {
            $bytes = Storage::disk('public')->size($this->file_path);
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return '0 KB';
    }
}