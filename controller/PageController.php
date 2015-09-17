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
        if(isset($_SESSION['Login'])){
            $this->lv->render($_SESSION['Login'], $this->v, $this->dtv);
        }
        else{
            $this->lv->render(false, $this->v, $this->dtv);
        }
    }
}
