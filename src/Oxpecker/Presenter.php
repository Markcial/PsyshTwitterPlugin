<?php

namespace Oxpecker;

use Psy\Presenter\Presenter as BasePresenter;

class Presenter implements BasePresenter
{
    /**
     * Check whether this Presenter can present $value.
     *
     * @param mixed $value
     *
     * @return boolean
     */
    public function canPresent($value)
    {
        $item = current($value);
        return is_array($value) &&
            is_object($item) &&
            property_exists($item, 'user') &&
            property_exists($item, 'text');
    }

    /**
     * Present a reference to the value.
     *
     * @param mixed $value
     *
     * @return string
     */
    public function presentRef($value)
    {
        $text = array();
        foreach ($value as $twt) {
            $text[] = sprintf(
                '<aside>@<keyword>%s</keyword> (<const>%s</const>) :<public>%s</public> .<object>%s</object></aside>',
                $twt->user->screen_name,
                $twt->user->name,
                $twt->text,
                $twt->created_at
            );
        }

        return $text;
    }

    /**
     * Present a full representation of the value.
     *
     * Optionally pass a $depth argument to limit the depth of recursive values.
     *
     * @param mixed $value
     * @param int $depth (default: null)
     * @param int $options One of Presenter constants
     *
     * @return string
     */
    public function present($value, $depth = null, $options = 0)
    {
        return $this->presentRef($value);
    }
}
