<?php
//Крассная звездочка
$red_star = '<span class="text-danger">*</span>';
function ui_input($name, $lable = "", $placeholder = "", $parent = "", $id = "", $value = "", $type = "text"){
    $ui = '';

    $block_label = '';
    $block_input = '';

    if (empty($id) && !empty($name)){
        $id = $name;
    } 
    //Label
    if (!empty($lable)){
        $block_label .= '<label for="'.$id.'" class="form-label">'.$lable.'</label>';
    } 
    //Input
    if (!empty($name)){
        $block_input .= '<input type="'.$type.'" placeholder="'.$placeholder.'" class="form-control" name="'.$name.'" id="'.$id.'" value="'.$value.'">';
    }
    
    $ui .= $block_label . $block_input;
    return $ui;
}
function ui_input_hidden($name, $val = ""){
    return '<input type="hidden" name="'.$name.'" value="'.$val.'">';
}

function ui_submit($name = null, $text = null, $class = 'btn btn-primary', $value = "", $attr = ''){
    $ui = '';
    if(!empty($name) && !empty($text)){
        $ui .= '<button type="submit" class="'.$class.'" name="'.$name.'" value="'.$value.'" id="'.$name.'" '.$attr.'>'.$text.'</button>';
    }
    return $ui;
}
function ui_button($name = null, $text = null, $class = 'btn btn-secondary', $attr = ''){
    $ui = '';
    if(!empty($name) && !empty($text)){
        $ui .= '<button type="button" class="'.$class.'" name="'.$name.'" id="'.$name.'" '.$attr.'>'.$text.'</button>';
    }
    return $ui;
}
function ui_button_a($id = null, $text = null, $href = "", $class = 'btn btn-info', $attr = ''){
    $ui = '';
    if(!empty($id) && !empty($text)){
        $ui .= '<a class="'.$class.'" id="'.$id.'" href="'.$href.'" '.$attr.'>'.$text.'</a>';
    }
    return $ui;
}
?>
