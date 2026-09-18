//======EDIT=======//

function editRecords(id) {

    let name = document.getElementById("name-"+id).innerText;

    let Course = document.getElementById("course-"+id).innerText;

    let date = document.getElementById("date-"+id).innerText;

    let Status = document.getElementById("status-"+id).innerText;

    let Contact = document.getElementById("Contact-"+id).innerText;

    window.location.href = "New Enquiry.html?id=" + id + 
     "&name="+ 
    encodeURIComponent(name) + 
    "&course="+ 
    encodeURIComponent(Course)+
    "&date="+ 
    encodeURIComponent(date) +
    "&status=" + 
    encodeURIComponent(Status) +
    "&contact=" + 
    encodeURIComponent(Contact) ;   
}

//==========DELETE=========//
function deleteRecords(id){
    let answer = confirm("Are you Sure Want to delete this Records?");
    
    if(!answer){

        return;
    }

    let row = document.getElementById("record-"+ id);

    if(row){

        row.remove();
    }

    alert("Data deleted  successfully");

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

