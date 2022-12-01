<?php 

namespace App;


class Form 
{

    public $errorTab;
    public $is_placeholder;

    public function __construct(array $errorTab,bool $is_placeholder=null)
    {
        $this->errorTab=$errorTab;
        $this->is_placeholder=$is_placeholder;


    }

 public function inp(array $valueArray)
 {
 	$type=$valueArray['type'];
 	$champName=$valueArray["champName"];
 	$label=$valueArray["label"];
    /*placeholder ou value*/
 	$value=isset($_POST["$champName"])?htmlentities($_POST["$champName"]):htmlentities($valueArray["value"]);
    $placeholder=!empty($this->is_placeholder)&&$this->is_placeholder&&!isset($_POST["$champName"])?true:false;

    $errorMessage="";
    /*les champs*/
    $textarea=null;
    $input=null;



    if($placeholder)
    {

         $textarea="<textarea name='$champName' cols='30' rows='10' placeholder=$value ></textarea>";
         $input="<input type='$type' name='$champName' placeholder='$value'>";

    }else
    {
         $textarea="<textarea name='$champName' cols='30' rows='10'>$value</textarea>";
         $input="<input type='$type' name='$champName' value='$value'>";
    }

    
    if(!empty($this->errorTab) && isset($this->errorTab[$champName]  ) && !empty($_POST) )
    {
        
        $tab=$this->errorTab[$champName];
        $errorMessageTab=[];
        foreach($tab as $el)
        {
            $errorMessageTab[]="<span>{$el}</span>";
        }
        $errorMessage=implode(",",$errorMessageTab);
    }

    

 	if($type==="textarea")
 	{


 		return <<<HTML
    <div class="textAreaContainner" >
     	<label for="">$label</label>
     	<section>
     		{$textarea}
            {$errorMessage}
     	</section>
 	</div>

HTML;
 	}


 	return <<<HTML
    <div class="inputContainner" >
     	<label for="">$label</label>
     	<section>
             {$input}
            {$errorMessage}
     	</section>
    </div>
 	

HTML;
 }

 public function select(array $valueArray)
 {
    $champName=$valueArray["champName"];
    $optList=$valueArray["optList"];
    $currentOptList=$valueArray["currentOptList"];
    $multipleSelect=isset($valueArray["multipleSelect"])&&$valueArray["multipleSelect"]===false?"":"multiple";
    $optionBalise="";
    $error=!empty($valueArray["error"])?$valueArray["error"]:null;

    foreach ($optList as $key => $el) 
    {
        /*$isSelected=in_array($el,$currentOptList)?"selected":null;*/
        $isSelected=null;
        if( (($key+1)===1 && empty($currentOptList)) || (!empty($currentOptList)&&in_array($el,$currentOptList)) || (($key+1)===1 && empty($_POST["$champName"])) )
          {
            $isSelected="selected";
          }
        $optionBalise.= <<<HTML
                 <option value='$el' $isSelected>$el</option>
        HTML;
        
       
       /*$optionBalise.="<option value='$el' $isSelected>$el</option>";*/
    };
    return <<<HTML
                <div class="selectContainner">
                   <p>{$error}</p> 
                  <select name="{$champName}[]" id="" $multipleSelect>$optionBalise</select>
                </div>
    HTML;
 }

 public function radio(array $valueArray)
 {
    $x="";
    foreach ($valueArray["valueList"] as $key => $value) 
    {   
        $k=$key+1;
        $checked=null;
        if( ( ($k)===1 && empty($valueArray["multipleChecked"]) ) || (!empty($valueArray["multipleChecked"])&&$value===$valueArray["multipleChecked"])   )
          {
            $checked="checked";
          }

        $v=!in_array($value,$valueArray["valueList"])?$value:$value;

      $x.=<<<HTML
        <div class="radioContainner">
             <label for="{$valueArray['name']}{$k}">
                <input value="$v" type=radio name="{$valueArray['name']}" id="{$valueArray['name']}{$k}" $checked>$v
            </label>
       </div>
HTML;
    }

    return $x;

 }

} 

 ?>