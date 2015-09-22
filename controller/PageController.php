<?php
/**
 * Created by PhpStorm.
 * User: Jesper
 * Date: 2015-09-17
 * Time: 19:11
 */

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/DatabaseModel.php');

class PageController{

    private $databaseModel;
    private $v;
    private $dtv;
    private $lv;

    public function __construct(){
        //CREATE OBJECTS OF THE VIEWS
        $this->databaseModel = new DatabaseModel();
        $this->v = new LoginView($this->databaseModel);
        $this->dtv = new DateTimeView();
        $this->lv = new LayoutView();
    }


    public function start(){
        $this->initiateSession();
        $this->lv->render($this->v, $this->dtv);
    }

    /* Start a session if there isn't one allready */
    public function initiateSession(){
        if(!isset($_SESSION['Login'])){
            $_SESSION['Login'] = false;
        }
    }
}
