<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Simple settings placeholder so route('settings') resolves.
     */
    public function index(): View
    {
        // You can pass real settings data here later
        return view('admin.settings.index');
    }
}
