<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';

class QuestionController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Question');
        $this->load->model('Answer');
        $this->load->model('User');
    }

    public function question_post()
    {
        if ($this->User->is_logged_in()) {
            $username = $this->session->username;
            $category = $this->post('category');
            $title = $this->post('title');
            $description = $this->post('description');

            // if (empty($title)) {
            //     $this->response(array('error' => 'Title is required'), 400);
            //     return;
            // }

            // $data = array(
            //     'username' => $username,
            //     'title' => $title,
            //     'category' => $category,
            //     'description' => $description
            // );

            log_message('debug', "adding to username: $username");

            $questionId = $this->Question->addQuestion($username, $category, $title, $description);

            if ($questionId) {
                $this->response(array('id' => $questionId), REST_Controller::HTTP_OK);
            } else {
                $this->response(array('error' => 'Failed to insert question'), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->load->view('includes/header.php');
            $this->load->view('login');
            $this->load->view('includes/footer.php');
        }
    }

    public function index_get()
    {
        $questionId = $this->get('id');
        $category = $this->get('category');
        if ($questionId) {
            $question = $this->Question->getQuestionsById($questionId);
            // $answers = $this->Answer->getAnswers($questionId);

            if ($question) {
                $this->load->view('includes/header.php');
                $this->load->view('question_view', array('question' => $question));
                $this->load->view('includes/footer.php');
            } else {
                $this->load->view('includes/header.php');
                $this->load->view('errors/html/error_404.php', array('heading' => 'Error', 'message' => 'Ooops! Page Not Found'));
                $this->load->view('includes/footer.php');
            }
        } elseif ($category) {
            $questions = $this->Question->getQuestionsByCategory($category);

            $this->load->view('includes/header.php');
            $this->load->view('all_questions', array('questions' => $questions, 'header' => $category));
            $this->load->view('includes/footer.php');
        } else {
            $questions = $this->Question->getQuestionsById(null);

            $this->load->view('includes/header.php');
            $this->load->view('all_questions', array('questions' => $questions, 'header' => 'All'));
            $this->load->view('includes/footer.php');
        }
    }

    public function question_patch()
    {
        if ($this->User->is_logged_in()) {
            $oldAction = $this->patch('oldAction');
            $newAction = $this->patch('newAction');
            $username = $this->session->username;
            log_message('debug', "patching to username: $username");
            $this->Question->update($username, $oldAction, $newAction);

            $actions = $this->Question->getlist($username);
            $dto = array(
                'result' => $actions
            );

            $this->set_response($dto, REST_Controller::HTTP_OK);
        } else {
            $this->load->view('login');
        }
    }

    public function ask_get()
    {
        $data = [];
        $data['isLoggedIn'] = true;

        $categories = $this->Question->getCategories();

        $this->load->view('includes/header.php', $data);
        $this->load->view('new_question', array('categories' => $categories));
        $this->load->view('includes/footer.php');
    }

    public function categories_get()
    {
        $categories = $this->Question->getCategories();

        $this->load->view('includes/header.php');
        $this->load->view('categories', array('categories' => $categories));
        $this->load->view('includes/footer.php');
    }

    public function question_delete()
    {
        if ($this->User->is_logged_in()) {
            $deleteAction = $this->delete('deleteAction');
            $username = $this->session->username;
            log_message('debug', "deleting from username: $username");
            $this->Question->remove($username, $deleteAction);

            $actions = $this->Question->getlist($username);
            $dto = array(
                'result' => $actions
            );

            $this->set_response($dto, REST_Controller::HTTP_OK);
        } else {
            $this->load->view('login');
        }
    }
}
