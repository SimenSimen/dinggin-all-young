<?php

class Store extends MY_Controller
{
	public function __construct()
	{
        parent::__construct();
        
        $this->load->model('store_model');

        $this->data['web_config'] = $this->get_web_config($this->session->userdata('session_domain'));
		$this->data['style_config'] = $this->get_style_config($this->session->userdata('session_domain'));
    }

    public function list_page()
    {
        $this->load->view('store/index');
    }

    public function index()
    {
        $this->apiResponse($this->store_model->index());
    }

    public function create()
    {
        // $this->load->view('store/create');
    }

    public function store()
    {

    }

    public function edit($id)
    {

    }

    public function update($id)
    {
        
    }

    public function destroy($id)
    {
        $result = $this->store_model->delete($id);
        
        if ($result) {
            $this->apiResponse(['status' => 0]);
        }

        $this->apiResponse(['status' => 1, 'message' => 'Not found'], 404);
    }

    protected function apiResponse(array $data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}
