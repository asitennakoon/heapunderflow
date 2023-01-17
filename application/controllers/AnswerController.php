<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';

class AnswerController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Answer');
        $this->load->model('User');
    }

    public function answer_post()
    {
        if ($this->User->is_logged_in()) {
            $questionId = $this->post('questionId');
            $username = $this->session->username;
            $description = $this->post('description');
            $answerId = $this->Answer->addAnswer($questionId, $username, $description);

            $answer = $this->Answer->getAnswerById($answerId);

            if ($answer) {
                $this->response($answer, REST_Controller::HTTP_OK);
            } else {
                $this->response('Error: Failed to insert question', REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $this->load->view('includes/header.php');
            $this->load->view('login');
            $this->load->view('includes/footer.php');
        }
    }

    public function answers_get()
    {
        $questionId = $this->get('questionId');
        $answers = $this->Answer->getAnswers($questionId);

        if ($answers) {
            $this->response($answers, REST_Controller::HTTP_OK);
        } else {
            $this->response('Error: Failed to get answers', REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function upvote_post()
    {
        $answerId = $this->post('answerId');
        $this->Answer->upvote($answerId);

        $answer = $this->Answer->getAnswerById($answerId);
        $this->response($answer, REST_Controller::HTTP_OK);
    }

    public function downvote_post()
    {
        $answerId = $this->post('answerId');
        $this->Answer->downvote($answerId);

        $answer = $this->Answer->getAnswerById($answerId);
        $this->response($answer, REST_Controller::HTTP_OK);
    }

    public function answer_get()
    {
        $questionId = $this->get('id');
        if ($questionId) {
            $question = $this->Question->getQuestionsById($questionId);
            $this->load->view('includes/header.php');
            $this->load->view('question_view', array('question' => $question));
            $this->load->view('includes/footer.php');
        } else {
            $questions = $this->Question->getQuestionsById(null);
            $this->load->view('includes/header.php');
            $this->load->view('all_questions', array('questions' => $questions, 'header' => 'All'));
            $this->load->view('includes/footer.php');
        }
    }

    public function answer_patch()
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

    public function answer_delete()
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
