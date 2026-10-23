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
            backgroundColor: 'rgb(79, 76, 167)',
            pointBackgroundColor: '#de1414',
            pointBorderColor: '#e2e5e7',
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
                    text: 'Course Cost',
                    color: '#ffffff'
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
                '#0d0abc',
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
                    text: 'Number of Enquiries',
                    color: '#ffffff'
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

//Enquiries per day//
const dates = dashboardData.enquiryDates || [];
const totals = dashboardData.enquiryTotals || [];

const timeCanvas = document.getElementById("timeChart");

if (timeCanvas) {
    const monthLabels = [
        "January", "February", "March", "April",
        "May", "June", "July", "August",
        "September", "October", "November", "December"
    ];

    
    const monthlyTotals = Array(12).fill(0);

    dates.forEach((date, index) => {
        let monthIndex = -1;

        if (/^\d{4}-\d{2}/.test(date)) {
            monthIndex = parseInt(date.substring(5, 7), 10) - 1;
        } else {
            monthIndex = monthLabels.findIndex(
                month => month.toLowerCase() === date.toLowerCase()
            );
        }

        if (monthIndex >= 0 && monthIndex < 12) {
            monthlyTotals[monthIndex] += Number(totals[index] || 0);
        }
    });

    new Chart(timeCanvas, {
        type: "bar",

        data: {
            labels: monthLabels,

            datasets: [{
                label: "Enquiries",
                data: monthlyTotals,
                backgroundColor: "#0b588c",
                borderColor: "#36a2eb",
                borderWidth: 1,
                borderRadius: 5
            }]
        },

        options: {
            indexAxis: "x",
            responsive: true,
            maintainAspectRatio: false,

            layout: {
                padding: {
                    top: 15,
                    right: 15,
                    bottom: 5,
                    left: 5
                }
            },

            plugins: {
                legend: {
                    display: false
                },

                tooltip: {
                    callbacks: {
                        label: context =>
                            "Enquiries: " + context.parsed.y
                    }
                },
                    datalabels: {
                display: true,
                color: "#ffffff",
                anchor: "end",
                align: "top",
                offset: 4,
                font: {
                    weight: "bold",
                    size: 12
                },
                formatter: function(value) {
                    return value;
                }
            }
               
            },

            scales: {
                x: {
                    ticks: {
                        color: "#ffffff",
                        autoSkip: false,
                        maxRotation: 0,
                        minRotation: 0
                    },

                    title: {
                        display: true,
                        text: "Months",
                        color: "#ffffff"
                    },

                    grid: {
                        display: false
                    }
                },

                y: {
                    beginAtZero: true,
                    grace: "10%",

                    ticks: {
                        precision: 0,
                        color: "#ffffff"
                    },

                    title: {
                        display: true,
                        text: "Number of Enquiries",
                        color: "#ffffff"
                    }
                }
            }
        }
    });
}



//search x button//
document.querySelectorAll('input[name="search"]').forEach(function (searchInput) {
    searchInput.addEventListener("search", function () {
        if (this.value.trim() === "") {
            window.location.href = window.location.pathname;
        }
    });
});
//login//
function login(event) {
        event.preventDefault();

        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        const message = document.getElementById("message");

        if (
            (username === "user1" && password === "pass123") ||
            (username === "user2" && password === "pass456")
        ) {
            message.textContent = "Welcome, " + username + "! 🎉";
            message.style.color = "green";

            setTimeout(function () {
                window.location.href = "stat.php";
            }, 3300);

        } else {
            message.textContent = "Invalid username or password! ❌";
            message.style.color = "red";
        }
    }