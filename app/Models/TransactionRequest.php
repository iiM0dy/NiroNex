<?php

namespace App\Models;

use App\Enums\TransactionRequestMethod;
use App\Enums\TransactionRequestType;
use App\Enums\TransactionStatus;
use App\Http\Requests\StoreTransactionRequestRequest;
use App\Traits\HasStorageUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TransactionRequest extends Model
{
    use HasStorageUrl;
    protected $fillable = [
        'user_id',
        'type',
        'method',
        'amount',
        'image',
        'status',
        'admin_note',
        'reviewed_by',
        'transfer_data',
        'receiver_id',
        'note'
    ];

    protected $casts = [
        'type' => TransactionRequestType::class,
        'method' => TransactionRequestMethod::class,
        'status' => TransactionStatus::class,
        'amount' => 'decimal:6',
        'transfer_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function robotSetting(): HasOne
    {
        return $this->hasOne(RobotSetting::class, 'transaction_request_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function statusName(): string
    {
        return $this->status->getName();
    }


    public function getFormattedTransferData()
    {
        if (!is_null($this->transfer_data)) {
            if ($this->type === TransactionRequestType::Robot) {
                $fields = [];

                if (!empty($this->transfer_data['risk_level_label'])) {
                    $fields[] = 'المخاطرة: ' . $this->transfer_data['risk_level_label'];
                }

                if (isset($this->transfer_data['allocation_amount'])) {
                    $fields[] = 'المبلغ المخصص: ' . formatCurrency($this->transfer_data['allocation_amount']);
                }

                if (isset($this->transfer_data['wallet_percentage'])) {
                    $fields[] = 'النسبة المحسوبة من الرصيد: ' . formatPercent($this->transfer_data['wallet_percentage']);
                }

                if (isset($this->transfer_data['pep_price'])) {
                    $fields[] = 'سعر PEP: ' . formatCurrency($this->transfer_data['pep_price']);
                }

                if (isset($this->transfer_data['take_profit'])) {
                    $fields[] = 'جني الربح: ' . formatPercent($this->transfer_data['take_profit']);
                }

                if (isset($this->transfer_data['stop_loss'])) {
                    $fields[] = 'وقف الخسارة: ' . formatPercent($this->transfer_data['stop_loss']);
                }

                return implode(' | ', $fields);
            }

            $labels = StoreTransactionRequestRequest::getTransferDataLabels($this->method);
            $formatted = [];
            foreach ($labels as $key => $label) {
                $value = $this->transfer_data[$key] ?? '-';
                $formatted[$label['label']] = $label['label'] . ': ' . $value;
            }
            return implode(' | ', $formatted);
        }
        return '';
    }


}
