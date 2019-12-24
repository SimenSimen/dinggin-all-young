<?php

class Shop extends MY_Controller
{
	public function __construct()
	{
        parent::__construct();
        
        $this->load->model('shop_model');

        $this->data['web_config'] = $this->get_web_config($this->session->userdata('session_domain'));
		$this->data['style_config'] = $this->get_style_config($this->session->userdata('session_domain'));
    }

    public function list_page()
    {
        $this->load->view('store/index');
    }

    public function index()
    {
        $this->apiResponse($this->shop_model->index());
    }

    public function create()
    {
        $this->load->view('store/create');
    }

    public function store()
    {
        if (in_array('', $_POST)) {
            $this->apiResponse(['status' => 1, 'message' => 'Unprocessable Entity'], 422);
        }
        
        $result = $this->shop_model->create($_POST);

        if ($result) {
            $this->apiResponse(['status' => 0]);
        }

        $this->apiResponse(['status' => 1, 'message' => 'Internal Server Error'], 500);
    }

    public function edit($id)
    {
        $store = $this->shop_model->find($id);
        $this->load->view('store/edit', $store);
    }

    public function update($id)
    {
        if (in_array('', $_POST)) {
            $this->apiResponse(['status' => 1, 'message' => 'Unprocessable Entity'], 422);
        }
        
        $this->shop_model->update($id, $_POST);
        $this->apiResponse(['status' => 0]);
    }

    public function destroy($id)
    {
        $result = $this->shop_model->delete($id);
        
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
