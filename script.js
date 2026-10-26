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

document.addEventListener("DOMContentLoaded", function () {
    const data = window.dashboardData;

    if (!data || typeof Chart === "undefined") {
        console.error("Dashboard data or Chart.js is missing.");
        return;
    }

    // Common colors and chart styling
    const purple = "#7028b8";
    const purpleLight = "rgba(112, 40, 184, 0.12)";
    const orange = "#ff795e";
    const gridColor = "#eeeaf3";
    const textColor = "#9995a5";

    Chart.defaults.font.family = "Arial, sans-serif";
    Chart.defaults.font.size = 11;
    Chart.defaults.color = textColor;

    // Shared chart options
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            intersect: false,
            mode: "index"
        },
        plugins: {
            legend: {
                display: true,
                position: "bottom",
                labels: {
                    usePointStyle: true,
                    pointStyle: "circle",
                    boxWidth: 7,
                    boxHeight: 7,
                    padding: 14,
                    color: "#8c8798"
                }
            },
            tooltip: {
                backgroundColor: "#29213b",
                titleColor: "#ffffff",
                bodyColor: "#ffffff",
                padding: 12,
                cornerRadius: 8,
                displayColors: true
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                },
                border: {
                    display: false
                },
                ticks: {
                    color: textColor,
                    maxRotation: 35,
                    minRotation: 0
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: gridColor,
                    drawTicks: false
                },
                border: {
                    display: false,
                    dash: [4, 4]
                },
                ticks: {
                    padding: 8,
                    precision: 0
                }
            }
        }
    };

    // ==============================
    // 1. FEES PER COURSE
    // Smooth purple line with a soft fill
    // ==============================
    const feeCanvas = document.getElementById("feeChart");

    if (feeCanvas) {
        const ctx = feeCanvas.getContext("2d");
        const gradient = ctx.createLinearGradient(0, 0, 0, 260);

        gradient.addColorStop(0, "rgba(112, 40, 184, 0.24)");
        gradient.addColorStop(1, "rgba(112, 40, 184, 0.00)");

        new Chart(feeCanvas, {
            type: "line",
            data: {
                labels: data.feename,
                datasets: [{
                    label: "Course fees",
                    data: data.feevalue,
                    borderColor: purple,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.42,
                    borderWidth: 3,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: orange,
                    pointHoverBorderColor: "#ffffff",
                    pointHoverBorderWidth: 2
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    x: {
                        ...commonOptions.scales.x,
                        ticks: {
                            ...commonOptions.scales.x.ticks,
                            autoSkip: true,
                            maxTicksLimit: 8
                        }
                    },
                    y: {
                        ...commonOptions.scales.y,
                        beginAtZero: true,
                        ticks: {
                            ...commonOptions.scales.y.ticks,
                            callback: value =>
                                Number(value).toLocaleString()
                        }
                    }
                }
            }
        });
    }

    // ==============================
    // 2. ENQUIRIES PER COURSE
    // Smooth orange line with purple points
    // ==============================
    const enquiryCanvas = document.getElementById("enquiryChart");

    if (enquiryCanvas) {
        new Chart(enquiryCanvas, {
            type: "line",
            data: {
                labels: data.course_name,
                datasets: [{
                    label: "Enquiries",
                    data: data.enquirycount,
                    borderColor: orange,
                    backgroundColor: "rgba(255, 121, 94, 0.12)",
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 3,
                    pointBackgroundColor: purple,
                    pointBorderColor: "#ffffff",
                    pointBorderWidth: 1.5,
                    pointHoverRadius: 6
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    x: {
                        ...commonOptions.scales.x,
                        ticks: {
                            ...commonOptions.scales.x.ticks,
                            autoSkip: true,
                            maxTicksLimit: 8
                        }
                    }
                }
            }
        });
    }

    // ==============================
    // 3. ENQUIRIES OVER TIME
    // Rounded purple and orange bars
    // ==============================
    const timeCanvas = document.getElementById("timeChart");

    if (timeCanvas) {
        new Chart(timeCanvas, {
            type: "bar",
            data: {
                labels: data.enquiryDates,
                datasets: [{
                    label: "Months",
                    data: data.enquiryTotals,

                    // Alternate colors like the reference design
                    backgroundColor: data.enquiryTotals.map(
                        (_, index) =>
                            index % 2 === 0 ? purple : orange
                    ),

                    hoverBackgroundColor: data.enquiryTotals.map(
                        (_, index) =>
                            index % 2 === 0 ? "#8d50cf" : "#ce7312"
                    ),

                    borderRadius: {
                        topLeft: 5,
                        topRight: 5,
                        bottomLeft: 0,
                        bottomRight: 0
                    },
                    borderSkipped: "bottom",
                    maxBarThickness: 24,
                    categoryPercentage: 0.78,
                    barPercentage: 0.85
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    x: {
                        ...commonOptions.scales.x,
                        ticks: {
                            ...commonOptions.scales.x.ticks,
                            maxRotation: 0
                        }
                    }
                }
            }
        });
    }
});


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
                window.location.href = "stats.php";
            }, 3300);

        } else {
            message.textContent = "Invalid username or password! ❌";
            message.style.color = "red";
        }
    }