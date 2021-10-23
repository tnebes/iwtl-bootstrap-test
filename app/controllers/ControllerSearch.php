<?php declare(strict_types = 1);

class ControllerSearch extends Controller
{
    public function __construct()
    {
       parent::__construct();
       $this->model = $this->getModel('Search');
    }

    public function search()
    {
        $data = [
            'title' => '',
            'text' => '',
            'users' => [],
            'topics' => [],
            'suggestions' => [],
            'error' => false
        ];
        $searchTerm = trim($_POST['search']);
        // TODO: these should be outside of this method
        if (empty($searchTerm))
        {
            $data['error'] = true;
            $data['title'] = 'Search Error';
            $data['text'] = 'Search term should exist and be at least 2 characters long.';
        }
        else if (strlen($searchTerm) < 2)
        {
            $data['error'] = true;
            $data['title'] = 'Search Error';
            $data['text'] = 'Search term be at least 2 characters long.';
        }
        else if (strlen($searchTerm) > 100)
        {
            $data['error'] = true;
            $data['title'] = 'Search Error';
            $data['text'] = 'Search term cannot be longer than 100 characters.';
        }
        else
        {
            
        }
        $this->view->render('search/search', $data);           
    }
 
}