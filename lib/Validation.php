<?php
class Validation {
    private $_errors = [],
            $_isValid = false;

    public function check($formData = [], $formFields = []) {
        $this->_isValid = false;
        foreach($formFields as $field => $rules) {
            foreach($rules as $rule_name => $rule_value) {
                $field_name = $formFields[$field]['name'];
                $preg_match_msg = (isset($formFields[$field]['preg_match_msg'])) ? $formFields[$field]['preg_match_msg'] : null;
                $values = $formData[$field];
                if($rule_name !== 'required' && !empty($values)) {
                    switch($rule_name) {
                        case 'min':
                            if(strlen($values) < $rule_value) {
                                $this->setErrors($field, "{$field_name} Must Be Minimum {$rule_value} Characters");
                            }
                            break;

                        case 'max':
                            if(strlen($values) > $rule_value) {
                                $this->setErrors($field, "{$field_name} Must Be Maximum {$rule_value} Characters");
                            }
                            break;

                        case 'preg_match':
                            if(!preg_match($rule_value, $values)) {
                                $this->setErrors($field, "{$preg_match_msg}");
                            }
                            break;

                        default:
                            break;

                    }
                } else {
                    if($rule_name === 'required' && empty($values)) {
                        $this->setErrors($field, "{$field_name} Must Not Be Empty");
                    }
                }
            }
        }

        if( empty($this->_errors) ) {
            $this->_isValid = true;
        }

        return $this;
    }

    public function checkValidation($userInputs = []) {
        $userValidation = $this->check($userInputs, [
            "name" => [
                "name" => "Name",
                "required" => true,
                "min" => 4,
                "max" => 20,
                "preg_match_msg" => "Only Letter's And Alphabes, Space Are Allowed in Name",
                "preg_match" => "/^[a-zA-Z ]+$/"
            ],
            
            "roll" => [
                "name" => "Roll",
                "required" => true,
                "min" => 1,
                "max" => 3,
                "preg_match_msg" => "Only Numbers Are Allowed in Roll",
                "preg_match" => "/^[0-9]+$/"
            ],
            
            "address" => [
                "name" => "Address",
                "required" => true,
                "min" => 10,
                "max" => 32,
                "preg_match_msg" => "Only Alphabes, Numbers, Commas, Hyphens Are Allowed in Address",
                "preg_match" => "/^[a-zA-Z0-9-, ]+$/"
            ]
        ]);

        return $userValidation;
    }

    public function setErrors($err_key, $err_value) {
        $this->_errors[$err_key] = $err_value;
    }

    public function getErrors() {
        return $this->_errors;
    }

    public function isValid() {
        return $this->_isValid;
    }

}

?>