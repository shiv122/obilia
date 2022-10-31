<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $options;
    public $multiple;
    public $tags;
    public $class;
    public $attrs;
    public $required;
    public $additionalOptionText;
    public $label;
    public $optionValue;
    public $array;
    public $id;
    public $placeholder;
    public $withoutScript;
    public function __construct(
        string $name,
        array|object $options = [],
        bool $multiple = false,
        int $tags = 0,
        string $class = "",
        $attrs = "",
        bool $required = true,
        array $additionalOptionText = [],
        string|bool $label = false,
        string $optionValue = null,
        bool $array = false,
        $id = null,
        string $placeholder = null,
        bool $withoutScript = false
    ) {
        $this->name = $name;
        $this->options = $options;
        $this->multiple = $multiple;
        $this->tags = $tags;
        $this->class = $class;
        $this->attrs = $attrs;
        $this->required = $required;
        $this->additionalOptionText = $additionalOptionText;
        $this->label = $label;
        $this->optionValue = $optionValue;
        $this->array = $array;
        $this->id = $id;
        $this->placeholder = $placeholder;
        $this->withoutScript = $withoutScript;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select');
    }
}
