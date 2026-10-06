//======EDIT=======//

function editRecords(id) {
    let name = document.getElementById("name-"+id).innerText;
    let course = document.getElementById("course-"+id).innerText;
    let date = document.getElementById("date-"+id).innerText;
    let status = document.getElementById("status-"+id).innerText;
    let address = document.getElementById("address-"+id).innerText;
    let contact = document.getElementById("contact-"+id).innerText;



    document.getElementById("name").value = name;
    document.getElementById("course").value = course;
    document.getElementById("date").value = date;
    document.getElementById("status").value = status;
    document.getElementById("address").value = address;
    document.getElementById("contact").value = contact;

    document.getElementById("edit_enquiry_id").value = id;
    let submitBtn = document.getElementById("submitBtn");
    submitBtn.name = "update_btn";
    submitBtn.innerText = "update";
    document.getElementById("enquiryModal").style.display="block";
     
}

//==========DELETE=========//


function deleteRecords(id){
    document.getElementById("modal_enquiry_id").value = id;

    document.getElementById("deleteModal").style.display = "flex";
}

function closeDeleteModal(){
    document.getElementById("deleteModal").style.display = "none";
    document.getElementById("modal_enquiry_id").value = "";
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


// + new Enquiry//
function openEnquiryModal(){
    document.getElementById("name").value = "";
    document.getElementById("course").value = "";
    document.getElementById("date").value = "";
    document.getElementById("status").value = "";
    document.getElementById("address").value = "";
    document.getElementById("contact").value = "";

    document.getElementById("edit_enquiry_id").value = "";
    let submitBtn = document.getElementById("submitBtn");
    submitBtn.name = "save";
    submitBtn.innerText = "Save";
    document.getElementById("enquiryModal").style.display ="block";

}
function closeEnquiryModal(){
    document.getElementById("enquiryModal").style.display="none";

}

