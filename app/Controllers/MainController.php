<?php

namespace App\Controllers;

use App\Models\Task;

class MainController extends BaseController {

  public function indexAction($request){
    //var_dump($request->getMethod());
    //var_dump($request->getBody());
    //var_dump($request->getParseBody());
    //include '../views/index.php';

    return $this->renderHTML('index.twig');
  }

  public function todolistAction($request){
    $Task = Task::all();
    
    return $this->renderHTML('todolist.twig', array(
      'tasks' => $Task
    ));
  }
}