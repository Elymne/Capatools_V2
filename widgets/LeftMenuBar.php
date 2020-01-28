<?php
namespace app\widgets;
use yii\helpers\FileHelper;
use Yii;
/**
 * Cette classe permet de générer le menu utilisateur
 */
class LeftMenuBar extends \yii\bootstrap\Widget
{
    /**
     * Paramètre contenant l'ensemble des menus donnée par l'utilisateur    
     */
    public $Menus;

    public $title;

    public $logo;

    public function init()
    {
        parent::init();

    }
    public function getControllers()
    {


        $path = Yii::$app->getControllerPath();

        $data = array();


        $files = FileHelper::findFiles($path, array("fileTypes" => array("php")));


        foreach ($files as $file)
        {
            include_once $file;
 
            $filename = basename($file, '.php');

            if (($pos = strpos($filename, 'Controller')) > 0)
             {

                $class_name = $controllers[] = substr($filename, 0, $pos);

                if($class_name != 'Dashboard')
                {
                    $class_name = 'app\controllers\\'.$class_name.'Controller';
                    array_unshift( $data, $class_name);
                }

            }
        }
            
    return $data;

    }
    public function run()
    {
        $Ctrls =  $this->getControllers();
        $ActionsCtrl = array();

        foreach($Ctrls as &$ctrl)
        {
            $Action = $ctrl::GetActionUser(Yii::$app->user);
           
            array_unshift( $ActionsCtrl, $Action);

        }
        asort($ActionsCtrl);   
        $stringSubmenu="";
        foreach ($ActionsCtrl as &$Action)
        {
          $stringSubmenu = $stringSubmenu. SubMenuBar::widget(['titleSub'=> $Action['Name'], 'Submenulist'=> $Action['items']]);
      
        }
        
       // SubMenuBar::widget(['titleSub'=>'toto', 'Submenulist'=> $Action[1]['items']]);


        $string = 
        '<ul id="sidenav-left" class="sidenav sidenav-fixed">
        <li><a href="'.Yii::$app->homeUrl.'" class="logo-container">'.Yii::$app->name.'<i class="material-icons left"><img src="'.Yii::$app->homeUrl.'images/logo.png"/></i></a></li>
        <li class="no-padding">
      '.$stringSubmenu.'  
        </li>
        </ul>



      <div id="dropdown1" class="dropdown-content notifications">
        <div class="notifications-title">notifications</div>
        <div class="card">
          <div class="card-content"><span class="card-title">Joe Smith made a purchase</span>
            <p>Content</p>
          </div>
          <div class="card-action"><a href="#!">view</a><a href="#!">dismiss</a></div>
        </div>
        <div class="card">
          <div class="card-content"><span class="card-title">Daily Traffic Update</span>
            <p>Content</p>
          </div>
          <div class="card-action"><a href="#!">view</a><a href="#!">dismiss</a></div>
        </div>
        <div class="card">
          <div class="card-content"><span class="card-title">New User Joined</span>
            <p>Content</p>
          </div>
          <div class="card-action"><a href="#!">view</a><a href="#!">dismiss</a></div>
        </div>
      </div>';
       
      return $string;
    }

}