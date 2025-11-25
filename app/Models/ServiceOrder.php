<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrder extends Model
{
    protected $fillable = [
        'customer_id',
        'customer_document',
        'manufacturer',
        'device_model',
        'device_imei',
        'problems_photos',
        'problem_description',
        'price',
        'parts_cost',
        'extra_cost_type',
        'extra_cost_value',
        'discount_type',
        'discount_value',
        'diagnostic',
        'estimated_cost',
        'final_cost',
        'status',
        'deadline',
        'notes',
        'cancellation_reason',
        'pdf_hash',
    ];

    protected $casts = [
        'problems_photos' => 'array',
        'price' => 'decimal:2',
        'parts_cost' => 'decimal:2',
        'extra_cost_value' => 'decimal:2',
        'discount_value' => 'decimal:2',
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
