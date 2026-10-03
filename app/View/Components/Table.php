<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Table extends Component
{
    public string|null $title;
    public array $columns;
    public array $rows;
    public mixed $nativeData;
    public array|null $actions;
    public bool $isSearchable = true;

    public function __construct(array $columns, array $rows = [], string $title = null, array $actions = null, mixed $nativeData = null, bool $isSearchable = true)
    {
        $this->nativeData = $nativeData;
        $this->title = $title;
        $this->columns = $columns;
        $this->rows = $rows;
        $this->actions = $actions;
        $this->isSearchable = $isSearchable;
    }

    public function render(): View
    {
        return view('components.table');
    }
}
