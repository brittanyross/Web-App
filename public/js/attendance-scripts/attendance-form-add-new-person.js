/*
  File to add person to the table of people
 */

var newPersonInfoMatrix = [];

function jsValidateTable() {
    var firstName, middleInitial, lastName, race, age, numChildren, zip;

    //grab person's information from fields
    firstName = document.getElementById("new-person-first").value;
    middleInitial = document.getElementById("new-person-middle").value;
    lastName = document.getElementById("new-person-last").value;
    race = document.getElementById("race-select").value;
    age = document.getElementById("age-input").value;
    numChildren = document.getElementById("num-children-input").value;
    zip = document.getElementById("zip-input").value;

    //javascript validation (will do php validation later, too)
    var valid = true;
    var errorMessage = null;

    //string (if failed) or bool(true if succeeded)
    var validateResult = validateFields(firstName, middleInitial, lastName, race, age, numChildren, zip);
    //failed validation?
    if(validateResult !== true){
        valid = false;
        errorMessage = validateResult;
    }

    //success or failure message
    var insertAlertHere = document.getElementById("alert-box");

    while(insertAlertHere.hasChildNodes()) { //remove all children
        insertAlertHere.removeChild(insertAlertHere.lastChild);
    }
    insertAlertHere.appendChild(createMessage(valid, errorMessage));

    return valid;

}

function createRow(firstName, middleInitial, lastName, age, zip, numChildren, editLink) {
    var tr = document.createElement("tr");


    var tabCheckBox = document.createElement("td");
    tabCheckBox.innerHTML = "<label class=\"custom-control custom-checkbox\">\n" +
        "<input type=\"checkbox\" class=\"custom-control-input\" checked>\n" +
        "<span class=\"custom-control-indicator\"></span>\n" +
        "</label>"

    var tabFullName = document.createElement("td");
    tabFullName.innerHTML = firstName + " " + middleInitial + " " + lastName;

    var tabAge = document.createElement("td");
    tabAge.innerHTML = age;

    var tabZip = document.createElement("td");
    tabZip.innerHTML = zip;

    var tabNumChildren = document.createElement("td");
    tabNumChildren.innerHTML = numChildren;

    var tabEdit = document.createElement("td");
    tabEdit.innerHTML = "<a href=\"" + editLink + "\">Edit</a>";

    tr.appendChild(tabCheckBox);
    tr.appendChild(tabFullName);
    tr.appendChild(tabAge);
    tr.appendChild(tabZip);
    tr.appendChild(tabNumChildren);
    tr.appendChild(tabEdit);

    return tr;
}

function createMessage(success, errorMessage) {
    var div = document.createElement("div");
    div.setAttribute("role", "alert");

    if(success){
        div.setAttribute("class", "alert alert-success");
        div.innerHTML = "<strong>Success! </strong>Person added to list."
    } else {
        div.setAttribute("class", "alert alert-warning");
        div.innerHTML = "<strong>Oops! </strong>" + errorMessage;
    }

    return div;
}

function validateFields(first, middle, last, race, age, numChildren, zip){
    if(!validateName(first)){
        return "First name may only contain letters. Spaces, numbers, and other characters are not allowed.";
    }
    if(!validateMiddle(middle)){
        return "Middle initial may only contain one letter."
    }
    if(!validateName(last)){
        return "Last name may only contain letters. Spaces, numbers, and other characters are not allowed.";
    }
    if(!validateRace(race)){
        return "Please select a race from the drop-down."
    }
    if(!validateAge(age)){
        return "Please enter a valid age."
    }
    if(!validateNumChildren(numChildren)){
        return "Please enter a valid number of children"
    }
    if(!validateZip(zip)){
        return "Please enter a valid number zip";
    }
    //success
    return true;
}

//first or last name
function validateName(name) {
    //returns true if matched, validates for a-z and A-Z
    return (/^[A-Za-z]+$/.test(name));
}

function validateMiddle(middle) {
    //returns true if matched, validates for a-z and A-Z max one character
    return (/^[A-Za-z]$/.test(middle));
}

function validateRace(race) {
    //returns true if not the default option
    return(race !== "Select Race...");
}

function validateAge(age) {
    //returns true if age in valid range 18-100
    return((age >= 18) && (age <= 100));
}

function validateNumChildren(num) {
    //returns true if a valid number of children
    return((num >= 0) && (num <= 25))
}

function validateZip(zip) {
    //validate zip code (from stackoverflow)
    return (/(^\d{5}$)|(^\d{5}-\d{4}$)/.test(zip));
}

function appendNewPerson(first, middle, last, race, age, numChildren, zip){
    var newRow = [first, middle, last, race, age, numChildren, zip];
    newPersonInfoMatrix.push(newRow);
}