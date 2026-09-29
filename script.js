//======EDIT=======//

function editRecords(id) {
    let name = document.getElementById("name-"+id).innerText;
    let course = document.getElementById("course-"+id).innerText;
    let date = document.getElementById("date-"+id).innerText;
    let status = document.getElementById("status-"+id).innerText;
    let contact = document.getElementById("Contact-"+id).innerText;


    document.getElementById("name").value = name;
    document.getElementById("course").value = course;
    document.getElementById("date").value = date;
    document.getElementById("status").value = status;
    document.getElementById("Contact").value = contact;

    document.getElementById("enquiryModal").style.display="block";
     
}

//==========DELETE=========//
let deleteId = null;

function deleteRecords(id){
    deleteId = id;

    document.getElementById("deleteModal").style.display = "flex";
}

function confirmDelete(){
    let row = document.getElementById("record-" + deleteId);

    if(row){
        row.remove();
        alert("Data deleted successfully");
    }

    document.getElementById("deleteModal").style.display = "none";
    deleteId = null;
}

function closeDeleteModal(){
    document.getElementById("deleteModal").style.display = "none";
    deleteId = null;
}


function loadEditData(){
    let params= new URLSearchParams(window.location.search);

    let name = params.get("name");
    let course = params.get("course");
    let date = params.get("date");
    let status = params.get("status");
    let Contact = params.get("contact");

    if(!name){

        return;
    }
    document.getElementById("name").value =name;

    document.getElementById("course").value = course;
    
    document.getElementById("date").value = date;
    
    document.getElementById("status").value = status;

    document.getElementById("Contact").value = Contact;


}
document.addEventListener(
    "DOMContentLoaded",
    function(){

        loadEditData();
    }
)

// + new Enquiry//
function openEnquiryModal(){
    document.getElementById("name").value = "";
    document.getElementById("course").value = "";
    document.getElementById("date").value = "";
    document.getElementById("status").value = "";
    document.getElementById("Contact").value = "";

    document.getElementById("enquiryModal").style.display ="block";

}
function closeEnquiryModal(){
    document.getElementById("enquiryModal").style.display="none";

}
function saveEnquiry(){
    alert("Enquiry Saved");
    closeEnquiryModal();
}


