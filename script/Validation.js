class Validation {
    errors = {};
    isValid = false;

    check = (userInputs = {}, formFields = {}) => {
        this.isValid = false;
        // console.log(userInputs);
        // console.log(formFields);
        for(let field in formFields) {
            let rules = formFields[field];
            for(let rule_name in rules) {
                let rule_value = rules[rule_name];
                let field_name = formFields[field].name;
                let regx_msg = (formFields[field].regx_msg) ? formFields[field].regx_msg : null;
                let values = userInputs[field];
                if(rule_name !== 'required' && values != "") {
                    switch(rule_name) {
                        case 'min':
                            if(values.length < rule_value) {
                                this.setErrors(field, `${field_name} Must Be Minimum ${rule_value} Characters`);
                            }
                            break;

                        case 'max':
                            if(values.length > rule_value) {
                                this.setErrors(field, `${field_name} Must Be Maximum ${rule_value} Characters`);
                            }
                            break;

                        case 'regx_match':
                            let regex = new RegExp(rule_value)
                            if(!regex.test(values)) {	
                                this.setErrors(field, `${regx_msg}`);
                            }
                            break;

                        // case 'matches':
                        // 	if(values != $formData[rule_value]) {
                        // 		$this.setErrors(field, "{field_name} doesn't Matched");
                        // 	}
                        // 	break;

                        // case 'validate':
                        // 	if(!filter_var(values, rule_value)) {
                        // 		$this.setErrors(field, "{field_name} Not Valid !!");
                        // 	}
                        // 	break;

                        // case 'unique':
                        // 	try{
                        // 		$checkExistance = $this->db->getWhere(rule_value, [field, "=", values]);
                        // 		if($checkExistance->rowsCanCount()) {
                        // 			$this.setErrors(field, "{field_name} Already Exists!!");
                        // 		}
                        // 		break;
                        // 	} catch (\PDOException $exp) {
                        // 		die("Not Found");
                        // 	}

                        default:
                            break;

                    }
                } else {
                    if(rule_name === 'required' && values == "") {
                        this.setErrors(field, `${field_name} Must Not Be Empty`);
                    }
                }
            }
        }


        if(Object.keys(this.errors).length < 1) {
            this.isValid = true;
        }

        return this;
    }

    setErrors = (err_key, err_value) => {
        this.errors[err_key] = err_value;
    }

    getErrors() {
        return this.errors;
    }

    passed() {
        return this.isValid;
    }
}
