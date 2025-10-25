<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * Simple admin chat page (stub).
     */
    public function index(): View
    {
        // If you don't have auth yet, this keeps the page accessible.
        // Later you can add middleware('auth') to the route.
        return view('admin.chat.index');
    }
}
