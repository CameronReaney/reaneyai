<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EarlyAccessSignup extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'email',
        'ip_address',
        'user_agent',
        'notified'
    ];
    
    protected $casts = [
        'notified' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Scope to get only non-notified signups
     */
    public function scopeNotNotified($query)
    {
        return $query->where('notified', false);
    }
    
    /**
     * Mark this signup as notified
     */
    public function markAsNotified()
    {
        $this->update(['notified' => true]);
    }
}
