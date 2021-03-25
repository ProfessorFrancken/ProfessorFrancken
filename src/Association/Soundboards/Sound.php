<?php

declare(strict_types=1);

namespace Francken\Association\Soundboards;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;

final class Sound extends Model
{
    use Mediable;
    use SoftDeletes;

    /**
     * @var string
     */
    public const SOUND_AUDIO_TAG = 'soundobards_sound_audio';

    /**
     * @var string
     */
    public const SOUND_IMAGE_TAG = 'soundobards_sound_image';

    protected $casts = [
        'soundboard_id' => 'int',
        'uploaded_by_member_id' => 'int',
        'audio_media_id' => 'int',
        'image_media_id' => 'int',
    ];

    /**
     * @var string
     */
    protected $table = 'association_soundboards_sounds';

    /**
     * @var string[]
     */
    protected $fillable = [
        'soundboard_id',
        'name',
        'uploaded_by_member_id',
        'audio_media_id',
        'image_media_id',
        'css_background',
        'css_foreground',
    ];

    public function soundboard() : BelongsTo
    {
        return $this->belongsTo(Soundboard::class);
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'uploaded_by_member_id');
    }

    public function audioMedia() : BelongsTo
    {
        return $this->belongsTo(Media::class, 'audio_media_id');
    }

    public function imageMedia() : BelongsTo
    {
        return $this->belongsTo(Media::class, 'image_media_id');
    }

    public function getAudioAttribute() : ?string
    {
        $audio = $this->audioMedia;

        if ($audio) {
            return $audio->getUrl();
        }

        return null;
    }

    public function getImageAttribute() : ?string
    {
        $image = $this->imageMedia;

        if ($image) {
            return $image->getUrl();
        }

        return null;
    }
}
