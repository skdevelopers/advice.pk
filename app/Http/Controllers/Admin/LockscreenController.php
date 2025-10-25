<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LockscreenController extends Controller
{
    /**
     * Display the lockscreen placeholder page.
     */
    public function index(): View
    {
        return view('admin.lockscreen.index');
    }
}
