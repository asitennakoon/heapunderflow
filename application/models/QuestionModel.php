<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QuestionModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function addQuestion($username, $category, $title, $description)
    {
        $this->db->set('questionCount', 'questionCount + 1', FALSE);
        $this->db->where('name', $category);
        $this->db->update('category');

        $this->db->insert(
            'question',
            array(
                'username' => $username,
                'category' => $category,
                'title' => $title,
                'description' => $description
            )
        );

        return $this->db->insert_id();
    }

    function getQuestionsById($questionId)
    {
        if ($questionId) {
            $this->db->where('id', $questionId);
            $query = $this->db->get('question');
            if ($query->num_rows() != 1) {
                return false;
            } else {
                return $query->row();
            }
        } else {
            $this->db->order_by('upvoteCount', 'DESC');
            $query = $this->db->get('question');
            if ($query->num_rows() == 0) {
                return false;
            }
            $questions = array();
            foreach ($query->result() as $row) {
                $questions[] = $row;
            }
            return $questions;
        }
    }

    function getQuestionsByCategory($category)
    {
        $this->db->order_by('upvoteCount', 'DESC');
        $this->db->where('category', $category);
        $query = $this->db->get('question');
        if ($query->num_rows() == 0) {
            return false;
        }
        $questions = array();
        foreach ($query->result() as $row) {
            $questions[] = $row;
        }
        return $questions;
    }

    function getCategories()
    {
        $query = $this->db->get('category');
        if ($query->num_rows() == 0) {
            return false;
        }
        $categories = array();
        foreach ($query->result() as $row) {
            $categories[] = $row;
        }
        return $categories;
    }

    function update($username, $oldAction, $newAction)
    {
        $this->db->where(array('username' => $username, 'id' => $oldAction));
        $this->db->update('todo', array('action' => $newAction));
    }

    function remove($username, $deleteAction)
    {
        $this->db->delete('todo', array('username' => $username, 'id' => $deleteAction));
    }
}
