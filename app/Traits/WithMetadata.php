<?php

namespace App\Traits;

use App\Models\Metadata;

/**
 * Trait WithMetadata
 * @property  Metadata metadata
 * @mixin \App\Models\Entity
 * @package App\Traits
 */
trait WithMetadata
{
    public function metadata()
    {
        return $this->hasOne(Metadata::class, 'object_id')->where('model', get_class($this));
    }

    /**
     * @param $attributes
     * @return mixed
     */
    public function setMetadata($attributes)
    {
        if (! ($metadata = $this->metadata)) {
            $metadata = new Metadata();

            $metadata->fill($attributes);
            $metadata->model = get_class($this);
            $metadata->associateWith($this);
        } else {
            $metadata->fill($attributes);
        }

        return $metadata->save();
    }
}