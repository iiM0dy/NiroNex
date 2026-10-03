<?php

use App\Enums\TransactionStatus;
use App\Enums\UserStatus;
use Carbon\Carbon;

// use Route;

// APP FUNCTIONS
function appName()
{
	return config('app.name', env('APP_NAME', 'Laravel'));
}

function brandTheme()
{
	return config('app.brand_theme', 'nironex');
}

function isBrandTheme(string $theme): bool
{
	return brandTheme() === $theme;
}

function brandAiName(): string
{
	return appName() . ' AI';
}

function brandTagline(): string
{
	return config('app.brand_tagline', 'AI-Powered Trading. Smarter Profits.');
}

function brandText(?string $text): string
{
	if ($text === null || $text === '') {
		return '';
	}

	$brand = appName();
	$brandAi = brandAiName();

	return strtr($text, [
		'Pipix Trade' => $brand,
		'Pipix AI' => $brandAi,
		'Pipix' => $brand,
		'pipix.trade' => 'nironex.com',
		'pipix' => $brand,
		'Lira AI' => $brandAi,
		'Lira' => $brand,
		'ليرة' => $brand,
		'ليرا' => $brand,
		'lira.com' => 'nironex.com',
	]);
}

// ROUTE FUNCTIONS
function routePut($name, $args = [])
{
	return $name && \Route::has($name) ? route($name, $args) : '#';
}
function routeCurrentName()
{
	return \Route::getCurrentRoute()->getName();
}
function routeIsActive($routeName)
{
	return request()->routeIs($routeName) ? 'active' : '';
}


// BACKEND FUNCTIONS
function backendAssets($path)
{
	return asset('backend/' . $path);
}
function backendView($key)
{
	return $key;
}
function backendRoute($key)
{
	return $key;
}
function backendRoutePut($key, $args = [])
{
	return routePut(backendRoute($key), $args);
}


function getDurationLabel($duration_days): string
{
	return match ($duration_days) {
		1 => 'يومياً',
		7 => 'أسبوعياً',
		30 => 'شهرياً',
		default => $duration_days . ' أيام',
	};
}

function formatTrimmedNumber($amount, int $maxDecimals = 6, string $decimal = '.', string $thousands = ','): string
{
	$amount = is_numeric($amount) ? (float) $amount : 0.0;
	$formatted = number_format($amount, $maxDecimals, $decimal, $thousands);

	$trimmed = rtrim(rtrim($formatted, '0'), $decimal);

	return $trimmed === '' || $trimmed === '-0' ? '0' : $trimmed;
}

function formatCurrency($amount, $currency = '$', $position = 'before', int $maxDecimals = 6)
{
	$amount = is_numeric($amount) ? $amount : 0;
	$formatted = formatTrimmedNumber($amount, $maxDecimals);
	if ($position === 'after') {
		return $formatted . '' . $currency;
	}
	return $currency . '' . $formatted;
}

function formatPercent($value, int $maxDecimals = 2): string
{
	return formatTrimmedNumber($value, $maxDecimals) . '%';
}

function formatDate($date)
{
	$carbonDate = Carbon::parse($date);

	if ($carbonDate->isToday()) {
		return $carbonDate->format('h:i:s A') . ', اليوم';
	} elseif ($carbonDate->isYesterday()) {
		return $carbonDate->format('h:i:s A') . ', أمس';
	} else {
		return $carbonDate->format('h:i:s A, M d'); // Ex: 10:10:00 AM, Jul 10
	}
}

function renderStatusBadge($status): string
{
	$classMap = [
		TransactionStatus::class => [
			TransactionStatus::Pending->value => 'bg-warning text-dark',
			TransactionStatus::Accepted->value => 'bg-success',
			TransactionStatus::Rejected->value => 'bg-danger',
			TransactionStatus::Canceled->value => 'bg-secondary',
		],
		UserStatus::class => [
			UserStatus::Pending->value => 'bg-warning text-dark',
			UserStatus::Active->value => 'bg-success',
			UserStatus::Inactive->value => 'bg-secondary',
		],
	];

	$enumClass = get_class($status);
	$value = $status->value;
	$name = $status->name;

	$class = $classMap[$enumClass][$value] ?? 'bg-light text-dark';

	return '<span style="width: fit-content" class="badge ' . $class . '">' . $name . '</span>';
}
