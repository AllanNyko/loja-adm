<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'description',
        'category',
        'amount',
        'due_date',
        'paid_date',
        'status',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    /**
     * Verifica se a despesa está vencida
     */
    public function isOverdue(): bool
    {
        return $this->status === 'pending' 
            && $this->due_date 
            && $this->due_date->isPast();
    }

    /**
     * Marca a despesa como paga
     */
    public function markAsPaid(?string $paymentMethod = null, ?\DateTime $paidDate = null): void
    {
        $this->status = 'paid';
        $this->paid_date = $paidDate ?? now();
        
        if ($paymentMethod) {
            $this->payment_method = $paymentMethod;
        }
        
        $this->save();
    }

    /**
     * Retorna o nome da categoria traduzido
     */
    public function getCategoryNameAttribute(): string
    {
        return match($this->category) {
            'utilities' => 'Utilidades (Luz, Água, Gás)',
            'internet' => 'Internet/Telefone',
            'rent' => 'Aluguel',
            'supplies' => 'Insumos/Materiais',
            'equipment' => 'Equipamentos',
            'salary' => 'Salários',
            'taxes' => 'Impostos',
            'marketing' => 'Marketing/Publicidade',
            'maintenance' => 'Manutenção',
            'other' => 'Outros',
        };
    }

    /**
     * Retorna o nome do status traduzido
     */
    public function getStatusNameAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pendente',
            'paid' => 'Pago',
            'overdue' => 'Vencido',
            'cancelled' => 'Cancelado',
        };
    }

    /**
     * Retorna o nome do método de pagamento traduzido
     */
    public function getPaymentMethodNameAttribute(): string
    {
        return match($this->payment_method) {
            'cash' => 'Dinheiro',
            'debit_card' => 'Cartão de Débito',
            'credit_card' => 'Cartão de Crédito',
            'pix' => 'PIX',
            'bank_transfer' => 'Transferência Bancária',
            'other' => 'Outro',
            default => '-',
        };
    }
}
