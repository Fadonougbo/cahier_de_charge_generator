<?php 

namespace App;

use Valitron\Validator;

class Validation
{

    public $validator;
    public $data;
    public array $errorTab=[];

    public function __construct(array $data)
    {
        $this->validator=new Validator($data);
        $this->data=$data;

    }

    public function verifyRules(array $ruleList):array
    {


        
        if(isset($ruleList["required"]))
        {
            $champNameList=[];
            
            if($ruleList["required"]==="*") 
            {
                 foreach(array_keys($this->data) as $el)
                  {
                      array_push($champNameList,$el);
                  }

                            
            }else
            {
                $champNameList=$ruleList["required"];
            }
            
            $this->validator->rules([

                "required"=> $champNameList

            ]);

            
        }


        if(isset($ruleList["lengthMin"]))
        {   

            $this->validator->rules(
            [
                    "lengthMin"=>$ruleList["lengthMin"]
                    
             ]);

        }

        if(isset($ruleList["dateFormat"]))
        {
            $this->validator->rules(
            [
                "dateFormat"=>$ruleList["dateFormat"]

            ]);
        }

        if(isset($ruleList["emailVerify"]))
        {
            $this->validator->rules(
            [
                "email"=>$ruleList["emailVerify"]

            ]);
        }

        if(isset($ruleList["url"]))
        {
            $this->validator->rules(
            [
                "url"=>$ruleList["url"]

            ]);
        }
         if(isset($ruleList["integer"]))
        {
            $this->validator->rules(
            [
                "integer"=>$ruleList["integer"]

            ]);
        }

          if(isset($ruleList["min"]))
        {
            $this->validator->rules(
            [
                "min"=>$ruleList["min"]

            ]);
        }

        if(isset($ruleList["radioVerify"]))
        {
            foreach($ruleList["radioVerify"] as $el)
            {
                if(!empty($_POST)&&empty($_POST[$el]))
                {

                    $this->errorTab[$el]="Veillez selectionné une option";
                    
                }
            }
        }

        if(isset($ruleList["checkBoxVerify"]))
        {
            foreach($ruleList["checkBoxVerify"] as $el)
            {
                if(!empty($_POST)&&empty($_POST[$el]))
                {

                    $this->errorTab[$el]="Veillez selectionné une option";
                    
                }
            }
        }

return (!$this->validator->validate()||!empty($this->errorTab)) || (!$this->validator->validate()&&!empty($this->errorTab)) ?[$this->validator->errors(),$this->errorTab]:[[],[]];
    }

}

 ?>