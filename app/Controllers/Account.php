<?php

namespace App\Controllers;

use CodeIgniter\Shield\Models\UserModel;

/**
 * Logged-in-only account actions ported from application/controllers/auth.php's
 * change_password()/change_email()/unregister(). Shield doesn't ship
 * controllers for these (it only covers login/register/magic-link), so this
 * talks to Shield's UserModel + Passwords service directly.
 *
 * change_email() here changes the address immediately after password
 * verification, rather than the old confirmation-link flow (Tank Auth's
 * set_new_email()/activate_new_email()) -- Shield doesn't provide the
 * underlying token mechanism that relied on, and rebuilding it was out of
 * scope for a personal single-user app. See app/Views/email/change_email-html.php.
 */
class Account extends BaseController
{
    public function changePassword()
    {
        $errors = [];

        if ($this->request->getMethod() === 'post') {
            $oldPassword         = $this->request->getPost('old_password');
            $newPassword         = $this->request->getPost('new_password');
            $confirmNewPassword  = $this->request->getPost('confirm_new_password');

            $user     = auth()->user();
            $identity = $user->getEmailIdentity();

            if (! service('passwords')->verify((string) $oldPassword, $identity->secret2)) {
                $errors['old_password'] = 'Incorrect password.';
            } elseif ($newPassword !== $confirmNewPassword) {
                $errors['confirm_new_password'] = "Passwords don't match.";
            } else {
                $user->password = $newPassword;

                if (model(UserModel::class)->save($user)) {
                    return redirect()->to('auth/change_password')->with('message', 'Your password has been changed.');
                }

                $errors = model(UserModel::class)->errors();
            }
        }

        return view('auth/change_password_form', ['errors' => $errors]);
    }

    public function changeEmail()
    {
        $errors = [];

        if ($this->request->getMethod() === 'post') {
            $password = $this->request->getPost('password');
            $newEmail = $this->request->getPost('email');

            $user     = auth()->user();
            $identity = $user->getEmailIdentity();

            if (! service('passwords')->verify((string) $password, $identity->secret2)) {
                $errors['password'] = 'Incorrect password.';
            } else {
                $user->email = $newEmail;

                if (model(UserModel::class)->save($user)) {
                    return redirect()->to('auth/change_email')->with('message', 'Your email address has been changed.');
                }

                $errors = model(UserModel::class)->errors();
            }
        }

        return view('auth/change_email_form', ['errors' => $errors]);
    }

    public function unregister()
    {
        $errors = [];

        if ($this->request->getMethod() === 'post') {
            $password = $this->request->getPost('password');

            $user     = auth()->user();
            $identity = $user->getEmailIdentity();

            if (! service('passwords')->verify((string) $password, $identity->secret2)) {
                $errors['password'] = 'Incorrect password.';
            } else {
                model(UserModel::class)->delete($user->id);
                auth()->logout();

                return redirect()->to('welcome')->with('message', 'Your account has been deleted.');
            }
        }

        return view('auth/unregister_form', ['errors' => $errors]);
    }
}
