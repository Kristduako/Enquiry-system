//======EDIT=======//

function editRecords(id) {
    let name = document.getElementById("name-"+ id).innerText;
    let course = document.getElementById("course-"+ id).innerText;
    let date = document.getElementById("date-"+ id).innerText;
    let address = document.getElementById("address-"+ id).innerText;
    let contact = document.getElementById("contact-"+ id).innerText;



    document.getElementById("name").value = name;
    document.getElementById("course").value = course;
    document.getElementById("date").value = date;
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
    let Contact = params.get("contact");

    if(!name){

        return;
    }
    document.getElementById("name").value =name;

    document.getElementById("course").value = course;
    
    document.getElementById("date").value = date;

    document.getElementById("Contact").value = Contact;


}


// + new Enquiry//
function openEnquiryModal(){
    document.getElementById("name").value = "";
    document.getElementById("course").value = "";
    document.getElementById("date").value = "";
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

// + new course//
function opencourse_EnquiryModal(){
    document.getElementById("course_name").value = "";
    document.getElementById("duration").value = "";
    document.getElementById("cost").value = "";
    
    document.getElementById("course_enquirymodal").style.display ="flex";

}

function closecourse_EnquiryModal(){
    document.getElementById("course_enquirymodal").style.display="none";
 
}


//Delete pop up//

function deletecourse(id){
    document.getElementById("course_id").value = id;
    document.getElementById("deletecourse").style.display = "flex";
}

function closedeletecourse(){
    document.getElementById("deletecourse").style.display = "none";
    document.getElementById("course_id").value = "id";
}

//Edit course//
function editcourse(id) {
    let name = document.getElementById("course_name-"+ id).innerText;
    let course = document.getElementById("duration-"+ id).innerText;
    let date = document.getElementById("cost-"+ id).innerText;
    
    document.getElementById("course_name").value = name;
    document.getElementById("duration").value = course;
    document.getElementById("cost").value = date;

    document.getElementById("edit_course_id").value = id;
    let submitBtn = document.getElementById("submitBtn");
    submitBtn.name = "update_btn";
    submitBtn.innerText = "update";
    document.getElementById("course_enquirymodal").style.display="flex";
}




// Graph //
const dashboardData = window.dashboardData;
Chart.register(ChartDataLabels);

new Chart(document.getElementById('feeChart'), {
    type: 'line',

    data: {
        labels: dashboardData.feename,

        datasets: [{
            label: 'Course Fees',
            data: dashboardData.feevalue,

            borderColor: '#1685ee',
            backgroundColor: 'rgba(22, 134, 238, 0.84)',
            pointBackgroundColor: '#f47742',
            pointBorderColor: '#1685ee',
            pointRadius: 5,
            pointHoverRadius: 8,
            borderWidth: 3,
            tension: 0.3,
            fill: true
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                display: true,
                position: 'top'
            },

            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Course Fees: ' +
                            Number(context.parsed.y).toLocaleString();
                    }
                }
            },

            datalabels: {
                display: true,
                color: '#e7dfdf',
                align: 'top',
                font: {
                    weight: 'bold',
                    size: 11
                },
                formatter: function(value) {
                    return Number(value).toLocaleString();
                }
            }
        },

        scales: {
            y: {
                beginAtZero: true,

                title: {
                    display: true,
                    text: 'Course Cost'
                }
            },

                        x: {
                ticks: {
                    color: '#ffffff'
                },
                title: {
                    display: true,
                    text: 'Course Name',
                    color: '#ffffff'
                }
            }
        }
    }
});

new Chart(document.getElementById('enquiryChart'), {
    type: 'bar',

    data: {
        labels: dashboardData.course_name,
        datasets: [{
            label: 'Number of Enquiries',
            data: dashboardData.enquirycount,

            backgroundColor: [
                '#FF6384',
                '#36A3EB',
                '#de131d',
                '#d1db09',
                '#9966FF',
                '#c4a4de',
                '#35b55b',
                '#bf3de7'
            ],

            borderRadius: 5
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                display: false
            },

            datalabels: {
                display: true,
                color: '#fffdfd',
                anchor: 'end',
                align: 'top',
                font: {
                    weight: 'bold',
                    size: 12
                }
            }
        },

        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                },
                title: {
                    display: true,
                    text: 'Number of Enquiries'
                }
            },

                    x: {
                ticks: {
                    color: '#ffffff'
                },
                title: {
                    display: true,
                    text: 'Courses',
                    color: '#ffffff'
                }
            }
        }
    }
});