<?php

namespace App\Http\Controllers\Docs;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class DocsController extends Controller
{
    public function index(): View
    {
        return view('docs.show', [
            'markdown' => file_get_contents(docs_path() . '/setup-docker.md')
        ]);
    }
}
