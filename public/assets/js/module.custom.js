$(document).ready(function(){
    const temp = $('#items_templates');
    const place = $('#module_place');

    create_templates()
});

class Input{
    constructor(parms){

        return
    }
}

let test = {
    element : "input",
    attr : {
        type : "text",
        id : null,
        name : null,
        class : [
            "form-control",
        ],
    }
};



function create_templates(){
    let items = {
        text_field : { 
            el: "input",
            type: "text",
            id : null,
            name : null,
            class: "form-control",
            attr : null
        },
        number_field : { 
            el: "input",
            type: "number",
            id : null,
            name : null,
            class: "form-control",
            attr : null
        },
        long_field : { 
            el: "textarea",
            type: "text",
            id : null,
            name : null,
            class: "form-control",
            attr : null
        },
        label : { 
            el: "label",
            id : null,
            name : null,
            class: "form-label",
            attr : {
                for: null,
            }
        },
        checkbox_field : { 
            el: "input",
            type: "checkbox",
            value : "1",
            id : null,
            name : null,
            class: "form-checkbox",
            attr : null
        },
    }
    
}