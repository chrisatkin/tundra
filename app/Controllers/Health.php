<?php

namespace App\Controllers;

use Config\Database;

/**
 * Kubernetes liveness/readiness probe endpoints. Unauthenticated by design
 * (see app/Config/Routes.php) -- kubelet can't log in.
 */
class Health extends BaseController
{
    public function live()
    {
        return $this->response->setStatusCode(200)->setBody('OK');
    }

    public function ready()
    {
        try {
            db_connect((new Database())->defaultGroup)->query('SELECT 1');
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(503)->setBody('DB unreachable');
        }

        return $this->response->setStatusCode(200)->setBody('OK');
    }
}
