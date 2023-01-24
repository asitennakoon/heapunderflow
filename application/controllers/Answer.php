<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';

class Answer extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AnswerModel');
        $this->load->model('UserModel');
    }

    public function answer_post()
    {
        $questionId = $this->post('questionId');
        $username = $this->session->username;
        $description = $this->post('description');
        $answerId = $this->AnswerModel->addAnswer($questionId, $username, $description);

        $answer = $this->AnswerModel->getAnswerById($answerId);

        if ($answer) {
            $this->response($answer, REST_Controller::HTTP_OK);
        } else {
            $this->response('Error: Failed to insert question', REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function answers_get()
    {
        $questionId = $this->get('questionId');
        $answers = $this->AnswerModel->getAnswers($questionId);

        if ($answers) {
            $this->response($answers, REST_Controller::HTTP_OK);
        } else {
            $this->response('Error: Failed to get answers', REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function answer_patch()
    {
        $answerId = $this->patch('id');
        $username = $this->session->username;
        $description = $this->patch('description');
        $this->AnswerModel->update($answerId, $username, $description);

        $answer = $this->AnswerModel->getAnswerById($answerId);

        if ($answer) {
            $this->response($answer, REST_Controller::HTTP_OK);
        } else {
            $this->response('Error: Failed to update answer', REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function answer_delete($id)
    {
        $username = $this->session->username;
        $this->AnswerModel->remove($username, $id);

        $this->set_response(null, REST_Controller::HTTP_NO_CONTENT);
    }

    public function upvote_post()
    {
        $answerId = $this->post('answerId');
        $this->AnswerModel->upvote($answerId);

        $answer = $this->AnswerModel->getAnswerById($answerId);
        $this->response($answer, REST_Controller::HTTP_OK);
    }

    public function downvote_post()
    {
        $answerId = $this->post('answerId');
        $this->AnswerModel->downvote($answerId);

        $answer = $this->AnswerModel->getAnswerById($answerId);
        $this->response($answer, REST_Controller::HTTP_OK);
    }
}
