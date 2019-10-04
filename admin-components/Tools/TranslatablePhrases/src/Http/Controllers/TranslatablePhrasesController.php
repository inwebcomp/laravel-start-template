<?php

namespace InWeb\Admin\TranslatablePhrases\Http\Controllers;

use Illuminate\Routing\Controller;
use InWeb\Admin\App\Actions\Action;
use TranslationsParser;

class TranslatablePhrasesController extends Controller
{
    public function index($locale = null)
    {
        $phrases = [];

        $locales = $showLocales = config('translations-parser.locales');

        if ($locale)
            $showLocales = [$locale];

        foreach ($showLocales as $locale) {
            $parsed = TranslationsParser::getParsed($locale);

            foreach ($parsed as $original => $phrase) {
                $phrases[$original][$locale] = $phrase;
            }
        }

        return compact('phrases', 'locales');
    }

    public function parse()
    {
        \Artisan::call('translations:parse');

        return Action::message(__('Phrases successfully parsed'));
    }

    public function save()
    {
        $request = request()->input();

        $locale = $request['locale'];
        $original = $request['original'];
        $phrase = $request['phrase'];

        if ($locale == '' or $original == '')
            return false;

        TranslationsParser::translate($locale, $original, $phrase);

        return Action::message(__('Translation saved'));
    }
}
