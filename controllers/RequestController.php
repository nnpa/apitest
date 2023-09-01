<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Users;
use app\models\Request;
use \DateTime;

use yii\web\Response;


class RequestController extends Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action){

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    
    }
    /**
     *  get all messages with filter
     *   http://localhost/requests?request={"status":"Active","date_start":"01.8.2023","date_end":"01.10.2023"}
     *
     *  create message
     *  http://localhost/requests
     *   POST form
     *   request = {"message":"test","api_key":"key"}
     * @return type json
     */
    public function actionRequests(){
        if(isset($_POST) && !empty($_POST)){
            return $this->create();
            
        }else{

            return $this->show();
        }
    }
    /**
     * Show all requests for admin
     * @return type json
     */
    public function show(){

        if(isset($_GET["request"]) && !empty($_GET["request"])){
 
            $request = $_GET["request"];
            $request = json_decode($request);
            
            if(!$this->isJson()){
                return $this->getError("Invalid json");
            }
            
            
            if(!property_exists($request, "api_key")){
                return $this->getError("api_key dont exists");
            } 
            
            $user = Users::find()->where(["api_key" => $request->api_key])->one();
            
            if(is_null($user)){
                return $this->getError("api_key invalid");
            }
            
            if($user->is_admin == 0){
                return $this->getError("Access denied");

            }
            
            $message = Request::find();
            
            if(property_exists($request, "status")){
                if($request->status != "Active" && $request->status != "Resolved"){
                    return $this->getError("Invalid status");
                }
                $message = $message->where(["status" => $request->status]);

            }
            
            if(property_exists($request, "date_start")){
                $nums = explode(".",$request->date_start);
                if(count($nums)>3){
                    return $this->getError("Invalid date_start");
                }
                $date = DateTime::createFromFormat('d.m.Y', $request->date_start);
                
                if ($date === false){
                    return $this->getError("Invalid date_start");

                }
                
                $message = $message->andWhere([">","created_at" , $date->getTimestamp()]);
                
            }
            
            if(property_exists($request, "date_end")){
                $nums = explode(".",$request->date_end);
                if(count($nums)>3){
                    return $this->getError("Invalid date_end");
                }
                $date = DateTime::createFromFormat('d.m.Y', $request->date_end);
                
                if ($date === false){
                    return $this->getError("Invalid date_end");

                }
                
                $message = $message->andWhere(["<","created_at" , $date->getTimestamp()]);
                
            }
            
            $messages = $message->all();
            
            $responce = [];
            
            foreach($messages as $message){
                $messageArr = [];
                $messageArr["id"] = $message->id;
                $messageArr["name"] = $message->name;
                $messageArr["message"] = $message->message;
                $messageArr["created_at"] = date("d.m.Y",$message->created_at);
                $messageArr["updated_at"] = date("d.m.Y",$message->updated_at);
                $messageArr["comment"] = $message->comment;
                $messageArr["status"] = $message->status;

                $messageArr["email"] = $message->email;
                $responce[] = $messageArr;
            }
            
            
            return json_encode($responce);
            
        }
    }
    /**
     * create user message
     * @return json
     */
    public function create(){
        if(isset($_POST["request"]) && !empty($_POST["request"])){
            $request = $_POST["request"];

            $request = json_decode($request);
            if(!$this->isJson()){
                return $this->getError("Invalid json");
            }
            
            if(!property_exists($request, "message")){
                return $this->getError("message dont exists");
            } 
            
            if(!property_exists($request, "api_key")){
                return $this->getError("api_key dont exists");
            } 
            
            $user = Users::find()->where(["api_key" => $request->api_key])->one();
            
            if(is_null($user)){
                return $this->getError("api_key invalid");
            }
            
            $message = new Request();
            $message->name = $user->name;
            $message->email = $user->email;
            $message->message = $request->message;
            $message->comment = "";
            $message->created_at = time();
            $message->updated_at = time();
            $message->status    = "Active";
            $message->save(false);
            
            $responce = ["message" => "successful"];
            $responce = json_encode($responce);
            return $responce;
        }
    }
    /**
     * create error message
     * @param type $message
     * @return type json
     */
    public function getError($message){
        $responce = ["Error" => $message];
        return json_encode($responce);
    }
    /*
     * check is valid json
     * 
     * @return boolean
     */
    public function isJson() {
        return json_last_error() === JSON_ERROR_NONE;
    }
    
    /*
     * admin responce to user request
     * @var id
     * @return type json
     */
    public function actionResponce($id){
        if( $_SERVER['REQUEST_METHOD'] != "PUT"){
            exit;
        }
        
        parse_str(file_get_contents("php://input"),$_PUT);
        if(array_key_exists("request",$_PUT)){
            $request = $_PUT["request"];
            
            $request = json_decode($request);
            if(!$this->isJson()){
                return $this->getError("Invalid json");
            }
            
            if(!property_exists($request, "api_key")){
                return $this->getError("api_key dont exists");
            } 

            $user = Users::find()->where(["api_key" => $request->api_key])->one();
            
            if(is_null($user)){
                return $this->getError("api_key invalid");
            }
            
            if($user->is_admin == 0){
                return $this->getError("Access denied");

            }
            
            $message = Request::find()->where(["id" =>$id])->one();
            if(is_null($message)){
                return $this->getError("Request dont exist");

            }
            
            if(!property_exists($request, "comment")){
                return $this->getError("comment dont exists");
            } 
            $message->comment = $request->comment;
            $message->updated_at = time();
            $message->status = "Resolved";
            $message->save(false);
            
            Yii::$app->mailer->compose()
            ->setFrom('priceoil.ru@yandex.ru')
            ->setTo($user->email)
            ->setSubject('new comment at yout request')
            ->setTextBody($message->comment)
            ->setHtmlBody($message->comment)
            ->send();
            
            $responce = ["message" => "successful"];
            $responce = json_encode($responce);
            return $responce;
            
        }
    }
}


/**
 
 
 get all messages with filter
 http://localhost/requests?request={"status":"Active","date_start":"01.8.2023","date_end":"01.10.2023"}

 create message
 http://localhost/requests
 POST form
 request = {"message":"test","api_key":"key"}
  
 */