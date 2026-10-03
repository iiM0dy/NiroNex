<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function footerDefaults(): array
    {
        return [
            'site_description' => appName() . ' تقدم تجربة منظمة لإدارة الحسابات والخطط والمتابعة داخل واجهة عربية احترافية تركّز على الوضوح وسهولة الاستخدام.',
            'support_email' => env('SUPPORT_EMAIL', ''),
            'instagram_url' => '',
            'telegram_url' => '',
            'copyright_text' => '© ' . now()->year . ' ' . appName() . ' — جميع الحقوق محفوظة',
        ];
    }

    public static function footer(): array
    {
        $defaults = static::footerDefaults();

        if (! static::storageIsReady()) {
            return $defaults;
        }

        $stored = Cache::rememberForever(static::footerCacheKey(), function () use ($defaults) {
            return static::query()
                ->whereIn('key', array_keys($defaults))
                ->pluck('value', 'key')
                ->all();
        });

        foreach ($stored as $key => $value) {
            if ($value === '' && ! in_array($key, static::footerOptionalKeys(), true)) {
                unset($stored[$key]);
            }
        }

        return array_merge($defaults, $stored);
    }

    public static function updateFooter(array $values): void
    {
        foreach (array_keys(static::footerDefaults()) as $key) {
            static::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $values[$key] ?? '']
            );
        }

        Cache::forget(static::footerCacheKey());
    }

    protected static function footerCacheKey(): string
    {
        return 'settings.footer';
    }

    protected static function footerOptionalKeys(): array
    {
        return [
            'support_email',
            'instagram_url',
            'telegram_url',
        ];
    }

    protected static function storageIsReady(): bool
    {
        try {
            return Schema::hasTable((new static())->getTable());
        } catch (\Throwable $exception) {
            return false;
        }
    }
}
