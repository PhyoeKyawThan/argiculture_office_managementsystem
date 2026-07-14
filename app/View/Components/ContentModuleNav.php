<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class ContentModuleNav extends Component
{
    public $categories;

    public function __construct()
    {
        $this->categories = Category::with('children')->whereNull('parent_id')->get();
    }

    public function render()
    {
        return view('components.content-module-nav');
    }
}