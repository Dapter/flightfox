<?php

class Controller 
{
    /**
     * @var type 
     */
    private $model;
    
    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
        return $this->model->getAll();
    }
    
    public function add()
    {
        return $this->model->addItem($_POST);
    }
    
    public function setCompleted($priority)
    {
        return $this->model->setCompleted($priority);
    }
}
