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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            $data['error'] = true;
            $data['title'] = 'Search Error';
            $data['text'] = 'Search term should exist and be at least 2 characters long.';
            $this->view->render('search/search', $data);
            return;            
        }
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
            $data['text'] = 'Search term must be at least 2 characters long.';
        }
        else if (strlen($searchTerm) > 100)
        {
            $data['error'] = true;
            $data['title'] = 'Search Error';
            $data['text'] = 'Search term cannot be longer than 100 characters.';
        }
        else
        {
            $searchModel = new Search;
            $data['users'] = $searchModel->searchUsers($searchTerm);
            $data['topics'] = $searchModel->searchTopics($searchTerm);
            $data['suggestions'] = $searchModel->searchSuggestions($searchTerm);
            $searchResultCount = count($data['users']) + count($data['topics']) + count($data['suggestions']);
            $data['title'] = 'Found ' . $searchResultCount . ' results.';
            $data['text'] = 'Search results:';
        }
        $this->view->render('search/search', $data);           
    }
 
}