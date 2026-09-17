<?php

namespace App\Controllers;

class Welcome extends BaseController
{
    public function index(): string
    {
        return view('welcome/index');
    }

    /**
     * Placeholder page linked from the marketing site -- intentionally not
     * wired to the real registration flow at auth/register. This mirrors
     * the old application/controllers/welcome.php::register() exactly: a
     * permanent "coming soon" stub, kept separate from Auth::register() on
     * purpose.
     */
    public function register(): string
    {
        return view('welcome/register');
    }
}
