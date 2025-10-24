<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $eventbriteIdentity = $user->identities()->where('provider', 'eventbrite')->first();

        return view('admin.profile', compact('user', 'eventbriteIdentity'));
    }
}
