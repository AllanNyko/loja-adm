<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrder extends Model
{
    protected $fillable = [
        'customer_id',
        'device_model',
        'device_imei',
        'problem_description',
        'diagnostic',
        'estimated_cost',
        'final_cost',
        'status',
        'deadline',
        'notes',
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'final_cost' => 'decimal:2',
        'deadline' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Aguardando Aprovação',
            'approved' => 'Aprovada',
            'in_progress' => 'Em Execução',
            'completed' => 'Concluída',
            'cancelled' => 'Cancelada',
            default => 'Desconhecido',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'info',
            'in_progress' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
