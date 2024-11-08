
function get_drawer_links(type) {
    if(type==="admin"){
        return AdminLinks
    }
    else if (type==="student"){
        return StudentLinks
    }
    else if (type==="teacher"){
        return TutorLinks
    }

}

const AdminLinks = [
    {
        icon: "mdi-poll-box",
        text: "Dashboard",
        exact: true,
        to: {
            name: "APDashBoard"
        }
    },
    {
        icon: "mdi-school",
        text: "Students",
        exact: false,
        to: {
            name: "APStudents"
        }
    },
    {
        icon: "mdi-teach",
        text: "Tutors",
        exact: false,
        to: {
            name: "Tutors"
        }
    },
    {
        icon: "mdi-account-group",
        text: "Classes",
        exact: false,
        to: {
            name: "Classes"
        }
    },
    {
        icon: "fas fa-file-word",
        text: "CatchUp",
        exact: false,
        to: {
            name: "CatchUps"
        }
    },
    {
        icon: "fas fa-file-word",
        text: "Work",
        exact: false,
        to: {
            name: "Works"
        }
    },
    {
        icon: "mdi-account-cash-outline",
        text: "Accounts",
        exact: false,
        to: {
            name: "Accounts"
        }
    },
    {
        icon: "mdi-cog",
        text: "Settings",
        exact: false,
        to: {
            name: "Settings"
        }
    },
    // Tutor Modules
]

const StudentLinks = [
    {
        icon: "mdi-school",
        text: "Student",
        exact: false,
        to: {
            name: "StudentProfile"
        }
    },
    {
        icon: "mdi-teach",
        text: "Classes",
        exact: false,
        to: {
            name: "StudentClasses"
        }
    },
    {
        icon: "fas fa-file-word",
        text: "Work",
        exact: false,
        to: {
            name: "StudentWork"
        }
    },
    {
        icon: "fas fa-file-word",
        text: "Catch up",
        exact: false,
        to: {
            name: "StudentCatchUp"
        }
    },
    {
        icon: "mdi-account-cash-outline",
        text: "Accounts",
        exact: false,
        to: {
            name: "StudentAccounts"
        }
    },
]

const TutorLinks=[
    {
        icon: "fas fa-user",
        text: "Tutor",
        exact: false,
        to: {
            name: "TutorProfile"
        }
    },
    {
        icon: "mdi-teach",
        text: "Classes",
        exact: false,
        to: {
            name: "TutorClasses"
        }
    },
    {
        icon: "mdi-account-cash-outline",
        text: "Accounts",
        exact: false,
        to: {
            name: "TutorAccounts"
        }
    }
]

export default get_drawer_links