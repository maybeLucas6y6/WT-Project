<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    private $key = 'this-should-not-be-hardcoded';

    public function __construct($action, $params)
    {
        $model = new UserModel();
        $view = new AuthView();

        parent::__construct($action, $params, $model, $view);
    }

    public function render()
    {
        if ($this->action === 'register') {
            $this->view->setTemplate('register');
            $this->view->render('TODO');

            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
            $email = $_POST['email'] ?? null;
            $phoneNumber = $_POST['phoneNumber'] ?? null;

            if (!$username || !$password || !$email || !$phoneNumber) {
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // TODO:
                return;
            }
            if (!preg_match('/^\+?[0-9]{10,15}$/', $phoneNumber)) {
                // TODO:
                return;
            }

            try {
                $this->model->register($username, $password, $email, $phoneNumber);
                jumpTo('/auth/login');
            } catch (UserAlreadyExistsException $e) {
                // TODO:
            } catch (Exception $e) {
                // TODO:
            }
            return;
        } elseif ($this->action === 'login') {
            $this->view->setTemplate('login');
            $this->view->render('TODO');

            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;

            if (!$username || !$password) {
                return;
            }

            $user = $this->model->getUserByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                $token = $this->generateToken($user['id']);

                setcookie('auth_token', $token, [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'httponly' => true,
                    'secure' => isset($_SERVER['HTTPS']),
                    'samesite' => 'Lax'
                ]);

                jumpTo('/home');
            } else {
                $this->view->setTemplate('error');
                $this->view->assign('error', 'Invalid action specified.');
                return;
            }
        } elseif ($this->action === 'logout') {
            setcookie('auth_token', '', [
                'expires' => time() - 3600,
                'path' => '/',
                'httponly' => true,
                'secure' => isset($_SERVER['HTTPS']),
                'samesite' => 'Lax'
            ]);

            jumpTo('/auth/login');
            return;
        }
    }

    private function generateToken($userId): string
    {
        $payload = [
            'iss' => 'http://rem.com',
            'iat' => time(),
            'exp' => time() + (60 * 60), // 1 hour
            'user_id' => $userId,
        ];

        return JWT::encode($payload, $this->key, 'HS256');
    }

    public function verifyToken($token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            return (array) $decoded;
        } catch (Exception $e) {
            return null;
        }
    }

    public function getCurrentUser(): ?array
    {
        $token = $_COOKIE['auth_token'] ?? null;

        if (!$token) {
            return null;
        }

        $payload = $this->verifyToken($token);
        if (!$payload || $payload['exp'] < time()) {
            return null;
        }

        return $this->model->getUserById($payload['user_id']);
    }
}
