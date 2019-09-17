<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Illuminate\Database\Eloquent\Model;

/**
 * Francken\Association\Symposium\AdCount
 *
 * @property int $id
 * @property int $participant_id
 * @property int $symposium_id
 * @property string $name
 * @property int $consumed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\AdCount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\AdCount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\AdCount query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\AdCount whereConsumed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\AdCount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\AdCount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\AdCount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\AdCount whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\AdCount whereSymposiumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Symposium\AdCount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class AdCount extends Model
{
    protected $table = 'association_symposium_ad_counts';
    protected $fillable = [
        'symposium_id',
        'participant_id',
        'name',
        'consumed',
    ];
}
