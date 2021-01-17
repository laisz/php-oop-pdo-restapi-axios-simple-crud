
// Custom Scripts for Navigatin....

// // ============================================( MAIN CODE START )============================================

// // ===================================( CODE For Read Data )==================================================

/*
| =============================================================================
| --------------- One Important Thing to Remember -------------
| 
| Before Using/Creating REST-API PHP PDO Crud with Ajax-JQuery Modal, We
| Created PHP PDO Crud with Ajax-JQuery Modal, which was withot REST-API
| There in out JS Code in custom_script.js FILE we could use JSON.parse()
| Method to Conver the JSON to JavaScript Object to parse JSON String
| which Returned From Back-END, But Here inth REST-API You Can't Use
| JSON.parse() Method to Convert JSON to JS Object, It's Bcoz We're Using 
| header() METHOD in the Action FILE in PHP Back-END there, & It's Generate
| Pure JSON, Instead of JSON-String, So, It's Already an JS-OBJECT So,
| So, You Don't Need to Convert it to JS Object. & You Can't Use JSON.parse()
| =============================================================================
*/


$(document).ready(function() {
    
    // const URL = "https://jsonplaceholder.typicode.com/users";
    const URL = "http://localhost:3000/users";

    let creatingTR = (data, parentElement) => {
        let tr = document.createElement("tr");

        let tdId = document.createElement("td");
        tdId.textContent = data.id;
        tr.appendChild(tdId);

        let tdName = document.createElement("td");
        tdName.textContent = data.name;
        tr.appendChild(tdName);

        let tdRoll = document.createElement("td");
        tdRoll.textContent = data.roll;
        tr.appendChild(tdRoll);

        let tdAddress = document.createElement("td");
        tdAddress.textContent = data.address;
        tr.appendChild(tdAddress);

        let tdAction = document.createElement("td");
        
        let btnDetails = document.createElement("button");
        btnDetails.className = "btn bg-primary text-white showDetails"
        btnDetails.textContent = "Details";
        btnDetails.addEventListener("click", e => {
            // console.log("Details");
            // console.log(data);
            showDetails(e, data.id);

        });
        tdAction.appendChild(btnDetails);
        
        let btnEdit = document.createElement("button");
        btnEdit.className = "btn bg-primary text-white ml-1 editBtn"
        btnEdit.textContent = "Edit";
        
        // // Edit Data HERE....
        btnEdit.addEventListener("click", e => {
            e.preventDefault();
            const editModal = $("#EditDataModal");
            editModal.modal("toggle");

            let divInsideInput = document.querySelectorAll(`form#editformID > .form-group > div`);
            for(let val of divInsideInput) {
                val.innerText = '';
            }

            editName = document.querySelector("form#editformID > div.form-group > #u_name");
            editRoll = document.querySelector("form#editformID > div.form-group > #u_roll");
            editAddress = document.querySelector("form#editformID > div.form-group > #u_address");

            editName.value = data.name;
            editRoll.value = data.roll;
            editAddress.value = data.address;
            
            // // Update Data HERE....
            let updateBtn = document.querySelector("form#editformID > div.form-group > #updateData");
            updateBtn.addEventListener("click", e => {
                e.preventDefault();
                let userInputs = {
                    id: data.id,
                    name: editName.value,
                    roll: editRoll.value,
                    address: editAddress.value,
                    update: "Update"
                };

                let userValidation = checkValidation(userInputs);   // Checking Validation...
                if(userValidation.passed()) {
                    console.log("Validation Successful");
                    axios({
                        method: "PUT",
                        url: `http://localhost/crud/pdo_oop_prepare_restapi_for_axios/lib/update_data.php`,
                        data: userInputs
                    })
                    .then(resp => {
                        // tdName.textContent = resp.data.name;
                        // tdRoll.textContent = resp.data.roll;
                        // tdAddress.textContent = resp.data.address;

                        // console.log(resp);
                        // console.log(resp.data);

                        loadTableSL();

                        // After Form Submission, getting the Form-Field Blank
                        editName.value = "";
                        editRoll.value = "";
                        editAddress.value = "";
                        
                        // Then Hiding the Modal Out....
                        editModal.modal("toggle");
                        
                        if(resp.data.status == true) {
                            Swal.fire({
                                title: resp.data.message,
                                icon: 'success',
                                type: "success"
                            });
                        } else {
                            Swal.fire({
                                title: resp.data.message,
                                icon: 'error',
                                type: "error"
                            });
                        }
                    })
                    .catch(err => console.log(err));
                } else {
                    let errs = userValidation.getErrors();
                    getValidationErrors(errs, "form#editformID");
                }
            });

        });
        tdAction.appendChild(btnEdit);
        
        let btnDelete = document.createElement("button");
        btnDelete.className = "btn bg-danger text-white ml-1 deleteBtn"
        btnDelete.textContent = "Delete";
        btnDelete.addEventListener("click", e => {
            // console.log("Delete");
            // console.log(data);
            deleteData(e, parentElement, tr, data.id);
        });
        tdAction.appendChild(btnDelete);
        tr.appendChild(tdAction);
        parentElement.appendChild(tr);
    };

    // Function For Read Data...
    const loadTableSL = () => {
        //const sendData = JSON.stringify({readall : "YES"});   // For the POST type Method
        const readURL = "http://localhost/crud/pdo_oop_prepare_restapi_for_axios/lib/read_data.php"
        axios({
            method: "POST",
            url: readURL,
            data: {readall : "YES"}
        })
        .then(resp => {
            // console.log(resp.data.length);
            // console.log(tds(resp.data[0]));
            // console.log(tds(resp.data[2]));
            
            const parentTarget = document.querySelector(".card-body > .table-data");
            if(resp.data.length < 1) {
                parentTarget.innerHTML = `<h1 class="text-danger">No Records Found !!</h1>`
            } else {
                parentTarget.innerHTML = `<div class='table-responsive'>
                                        <table id="mytable" class='table table-striped table-hover table-bordered'>
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Roll</th>
                                                    <th>Address</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody"></tbody>
                                        </table>
                                    </div>`;
            
                // console.log(parentTarget);

                const tbody = document.querySelector("table#mytable > tbody#tbody");
                resp.data.forEach(data => {
                    creatingTR(data, tbody);
                });

                $("table").DataTable({
                    order: [0, 'desc']
                });
            }
        })
        .catch(err => console.log(err));
    }

    loadTableSL();

 // // ===================================( CODE For CREATE Data )========================================  

    let createData = () => {
        const createBtn = document.querySelector("form#createFormId > div.form-group > #createData");
        const showCreateDataForm = document.querySelector("button#showCreateDataForm");
        const CreateModal = $("#CreateDataModal");
        showCreateDataForm.addEventListener("click", e => {
            e.preventDefault();
            CreateModal.modal("toggle");
            // Using these Block of Code.. We're Removing the Validation Message Set During Validation
            let divInsideInput = document.querySelectorAll(`form#createFormId > .form-group > div`);
            for(let val of divInsideInput) {
                val.innerText = '';
            }

            const createName = document.querySelector("form#createFormId > div.form-group > #name");
            const createRoll = document.querySelector("form#createFormId > div.form-group > #roll");
            const createAddress = document.querySelector("form#createFormId > div.form-group > #address");

            createName.value = "";
            createRoll.value = "";
            createAddress.value = "";

            createBtn.addEventListener("click", e => {
                e.preventDefault();
                let userInputs = {
                    name: createName.value,
                    roll: createRoll.value,
                    address: createAddress.value,
                    create: "Create"
                };
                let userValidation = checkValidation(userInputs);    // Checking Validation...
                if(userValidation.passed()) {
                    console.log("Validation Successful");
                    // So, Here We'll Write the Code to Create Data to the Database
                    axios({
                        method: "POST",
                        url: `http://localhost/crud/pdo_oop_prepare_restapi_for_axios/lib/insert_data.php`,
                        data: userInputs
                    })
                    .then(resp => {
                        console.log(resp.data);
                        
                        loadTableSL();  // Load Table Here Again, After Crating New Data..

                        // let tbody = document.querySelector("table#mytable > tbody#tbody");
                        // creatingTR(resp.data, tbody);

                        // After Form Submission, getting the Form-Field Blank
                        createName.value = "";
                        createRoll.value = "";
                        createAddress.value = "";

                        // Then Hiding the Modal ...
                        CreateModal.modal("toggle");

                        // SuccessFul Alert !!
                        Swal.fire(
                            "Data Created Successfully",
                            "Thank You !!",
                            'success'
                        );
                    })
                    .catch(err => console.log(err));
                } else {
                    let errs = userValidation.getErrors();
                    getValidationErrors(errs, "form#createFormId");
                }
                // console.log("end");
            });
        });
    } 

    createData();

// // ===================================( CODE For Validation After Submit Data )=================================

    let checkValidation = userInputs => {
        let namePattern = /^[a-zA-Z ]+$/i
        let rollPattern = /^[0-9]+$/i
        let addressPattern = /^[a-zA-Z0-9-, ]+$/i
        let formFields = {
            name : {
                name : "Name",
                required : true,
                min : 4,
                max : 20,
                regx_msg : "Only Letter's And Alphabets Are Allowed in Name",
                regx_match : namePattern
            },

            roll : {
                name : "Roll",
                required : true,
                min : 1,
                max : 3,
                regx_msg : "Only Number's Are Allowed in Roll",
                regx_match : rollPattern
            },

            address : {
                name : "Address",
                required : true,
                min : 10,
                max : 32,
                regx_msg : "Only Number's And Alphabes, Commas, Hyphen, Spaces Are Allowed in Address",
                regx_match : addressPattern
            }
        };
        let v = new Validation();
        let userValidation = v.check(userInputs, formFields);
        return userValidation;
    }

    let getValidationErrors = (errs, writeFormId) => {
        const writeForm = document.querySelector(`${writeFormId}`);
        const writeFormParent = writeForm.parentElement;
        let formEmpty = writeFormParent.querySelector("div.form_empty");
        for(props in errs) {
            console.log(errs[props]);
        }

        for(let props in errs) { // let {name, roll, address, valid} = errs  // This way will be tested later
            if(props == "name") {
                document.querySelector(`${writeFormId} > div.form-group > div.name_validity`).innerHTML = errs[props];
            } else if(props == "roll") {
                document.querySelector(`${writeFormId} > div.form-group > div.roll_validity`).innerHTML = errs[props];
            } else if(props == "address") {
                document.querySelector(`${writeFormId} > div.form-group > div.address_validity`).innerHTML = errs[props];
            } else {
                formEmpty.innerHTML = errs[props];
            }
        }
    }


// // ===================================( CODE For DELETE Data )==============================================


// Code For Delete Data...
const deleteData = (e, parentElement, tr, delId) => {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4CA750',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            axios({
                url: `http://localhost/crud/pdo_oop_prepare_restapi_for_axios/lib/delete_data.php`,
                method: 'DELETE',
                data: {
                    uid: delId,
                    del: "Delete"
                }
            }).then(resp => {
                if(resp.data.status == true) {
                    parentElement.removeChild(tr);
                    Swal.fire({
                        title: resp.data.message,
                        icon: 'success',
                        type: "success"
                    });
                } else {
                    Swal.fire({
                        title: resp.data.message,
                        icon: 'error',
                        type: "error"
                    });
                }
            }).catch(err => console.log(err));
        }
    });
}


// // ---------------------------------------( Show Details Data )--------------------------------------------

    // Code For Show Details Data...
    function showDetails(e, showId) {
        e.preventDefault();
        // let sendData = JSON.stringify({uid : user_id, page_name : page, one : "ONE"});
        axios({
            url: `http://localhost/crud/pdo_oop_prepare_restapi_for_axios/lib/read_one.php`,
            method: 'POST',
            data: {
                uid: showId,
                one: "ONE"
            }
        })
        .then(resp => {
            const u_data = resp.data[0];
            if(u_data.status == false) {
                Swal.fire({
                    title: "No Data Found !!",
                    icon: 'error',
                    type: "error"
                });
            } else {
                Swal.fire({
                    title: `<strong>User Info : ID ( ${u_data.id} )</strong>`,
                    icon: 'info',
                    type: 'info',
                    html: `<b>Name: </b>${u_data.name}<br>
                    <b>Roll: </b>${u_data.roll}<br>
                    <b>Address: </b>${u_data.address}<br>`,
                    showCancelButton: true
                });
            }
        })
        .catch(err => console.log(err));
    }


});



