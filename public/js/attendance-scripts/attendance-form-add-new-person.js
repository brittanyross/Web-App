/*
  File to add person to the table of people
 */

function addPersonToTable() {
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

    //success or failure message
    var insertAlertHere = document.getElementById("alert-box");

    while(insertAlertHere.hasChildNodes()) { //remove all children
        insertAlertHere.removeChild(insertAlertHere.lastChild);
    }
    insertAlertHere.appendChild(createMessage(valid, errorMessage));



    //add to table
    var table = document.getElementById("class-list");
    table.appendChild(createRow(firstName,middleInitial,lastName,age,zip,numChildren, "#"))

    //clear the fields
    document.getElementById("new-person-first").value = '';
    document.getElementById("new-person-middle").value = '';
    document.getElementById("new-person-last").value = '';
    document.getElementById("race-select").value = 0;
    document.getElementById("age-input").value = '';
    document.getElementById("num-children-input").value = '';
    document.getElementById("zip-input").value = '';
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
        div.innerHTML = "<strong>Success!</strong> Person added to list."
    } else {
        div.setAttribute("class", "alert alert-warning");
        div.innerHTML = "<strong>Oops!</strong>" + errorMessage;
    }

    return div;
}

function validateFields(){

}