<?php

namespace Admin\Fields\FeaturesField;

use InWeb\Admin\App\Fields\Textarea;

class Features extends Textarea
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'features-field';

    public function sections($withTitle = false)
    {
        return $this->withMeta([
            'sections' => true,
            'withSectionsTitle' => $withTitle
        ]);
    }
}
