<?php
//Include non-vendor files
require '../core/About/src/Validation/Validate2.php';
require '../vendor/autoload.php';
require '../../keys.php';


//Declare Namespaces
use About\Validation;
use Mailgun\Mailgun;
//Validate Declarations
$valid = new About\Validation\Validate();

$input = filter_input_array(INPUT_POST);

$message = null;

if(!empty($input)){

    $valid->validation = [
        'first_name'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter your first name'
        ]],
        'last_name'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter your last name'
        ]],
        'email'=>[[
                'rule'=>'email',
                'message'=>'Please enter a valid email'
            ],[
                'rule'=>'notEmpty',
                'message'=>'Please enter an email'
        ]],
        'subject'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter a subject'
        ]],
        'message'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please add a message'
        ]],
    ];

    $valid->check($input);

    if(empty($valid->errors) && !empty($input)){
        $message = "<div class=\"success\">Your form has been submitted!</div>";
         #00ff000;\">Your form has been submitted!</div>";

        # Instantiate the client.
        $mgClient = new Mailgun('$mailgunkey');
        $domain = "sandbox9f9689058863482484e42d257e2d5e28.mailgun.org";

        # Make the call to the client.
        $result = $mgClient->sendMessage("$domain",
              array('from'    => "{$input['first_name']} {$input['last_name']} <{$input['email']}>",
                    'to'      => 'julietta Hensgen <juliettaurdiales@yahoo.com>',
                    'subject' => $input['subject'],
                    'text'    => $input['subject']
                ));


    var_dump($result);
    }else{
            $message = "<div style=\"color: #ff0000;\">Please correct the errors</div>";
    }
}
