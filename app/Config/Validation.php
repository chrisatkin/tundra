<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    /**
     * Overrides Shield's default login rules (which validate an `email`
     * field) since Tank Auth logged in by username only
     * (application/config/tank_auth.php: login_by_username = TRUE,
     * login_by_email = FALSE). Read by CodeIgniter\Shield\Validation\
     * ValidationRules::getLoginRules() via setting('Validation.login').
     */
    public array $login = [
        'username' => [
            'label' => 'Auth.username',
            'rules' => ['required'],
        ],
        'password' => [
            'label' => 'Auth.password',
            'rules' => ['required'],
        ],
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
}
