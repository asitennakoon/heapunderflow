<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel');
		$this->load->model('QuestionModel');
	}

	public function index()
	{
		if ($this->UserModel->is_logged_in()) {
			$questions = $this->QuestionModel->getTrendingQuestions();
			$header = ($questions == false) ? 'Trending questions from this week would be displayed here' : 'This Week\'s Trending';

			$this->load->view('includes/header.php', array('isLoggedIn' => true));
			$this->load->view('all_questions', array('questions' => $questions, 'header' => $header));
			$this->load->view('includes/footer.php');
		} else {
			$this->load->view('includes/header.php');
			$this->load->view('home');
			$this->load->view('includes/footer.php');
		}
	}
}
