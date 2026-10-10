<?php

declare(strict_types=1);

namespace App\Models;

use App\IdeaStatus;
use Database\Factories\IdeaFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Idea extends Model
{
    /** @use HasFactory<IdeaFactory> */
    use HasFactory;

    protected $attributes = [
        'links' => '[]',
        'status' => IdeaStatus::PENDING->value,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class)->orderBy('id');
    }

    protected function casts(): array
    {
        return [
            'links' => AsArrayObject::class,
            'status' => IdeaStatus::class,
        ];
    }

    public static function statusCounts(User $user): Collection
    {

        $counts = $user->ideas()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return collect(IdeaStatus::cases())->mapWithKeys(fn ($status) => [
            $status->value => $counts->get($status->value, 0),
        ])->put('all', $user->ideas()->count());
    }
}
