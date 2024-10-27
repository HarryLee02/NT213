<?php namespace App\Controller;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;
use App\Lib\Dao;

class Home extends BaseController
{
    private $twig;
    public function __construct()
    {
        // composer require twig/twig
        $loader = new FilesystemLoader('./../app/Views');
        $this->twig = new Environment($loader);
        $this->twig->addGlobal('session', $_SESSION);
    }

    public function indexAction()
    { 
        $data = ['title' => 'Home Page'];
        echo $this->twig->render('index.twig', $data);
    }

    public function loginAction()
    {
        $data = ['title' => 'Login Page'];
        echo $this->twig->render('login.twig', $data);
    }

    public function signupAction()
    {
        $data = ['title' => 'Signup Page'];
        echo $this->twig->render('signup.twig', $data);
    }

    public function profile()
    {
        if (!$_SESSION['user']) {
            // Render error page
            $data = ['title' => 'Who are you?', 'content' => 'You are not logged in . Please login.'];
            echo $this->twig->render('./errors/unauthenticated.twig', $data);
            return;
        }
        $data = ['title' => 'Profile Page', 'User' => $_SESSION['user']];
        echo $this->twig->render('profile.twig', $data);
    }

    public function post()
    {
        if (!$_SESSION['user']) {
            // Render error page
            $data = ['title' => 'Unauthenticated', 'content' => 'You are not authenticated to view this page. Please login.'];
            echo $this->twig->render('./errors/unauthenticated.twig', $data);
            return;
        }

        $data = ['title' => 'User Info Page', 'User' => $_SESSION['user']];
        echo $this->twig->render('posts.twig', $data);
    }

    public function postSearch()
    {
        if (!$_SESSION['user']) {
            // Render error page
            $data = ['title' => 'Unauthenticated', 'content' => 'You are not authenticated to view this page. Please login.'];
            echo $this->twig->render('./errors/unauthenticated.twig', $data);
            return;
        }
        extract($_POST);
        $keyword = $_POST['keyword'];

        $d = new dao();
        $result = $d->searchPost($keyword);

        echo $this->twig->render('posts.twig', ['keyword'=>$keyword,'results'=>$result]);
    }

    public function registerAction()
    {
        extract($_POST);
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $d = new dao();
        
        try{
            $d->insertUser($email, $username, $password);
            $_SESSION['message'] = 'register_success';
            header('Location: /login');
        } catch (\Exception $e) {
            $_SESSION['message'] = 'register_error';
            header('Location: /signup');
        }
        
    }

    public function signinAction()
    {
        extract($_POST);
        $email = $_POST['email'];
        $password = $_POST['password'];

        $d = new dao();
        
        $result = $d->searchUser($email, $password);

        if ($result) {
            $_SESSION['user'] = $result['username'];
            $_SESSION['message'] = 'login_success';
            header('Location: /');
        } else {
            $_SESSION['message'] = 'login_error';
            header('Location: /login');
        }
    }

    public function logoutAction()
    {
        // Destroy the session and redirect to login page
        session_destroy();
        header('Location: /');
    }

    public function notFound()
    {
        http_response_code(404);
        // Destroy the session and redirect to login page
        echo "404 Not Found";
    }
}