import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/home/index";
import Services from "../views/services/index";
import AboutUs from "../views/aboutus/index";
import Signin from "../views/user/signin";
import Signup from "../views/user/signup";
import Verify from "../views/user/verify";
import Profile from "../views/user/profile";

Vue.use(VueRouter);

const routes = [{
        path: "/",
        name: "Home",
        component: Home,
        meta: {
            icon: "mdi-home",
            title: "Home",
            subtitle: ""
        }
    },
    {
        path: "/services",
        name: "Services",
        component: Services,
        meta: {
            icon: "mdi-home",
            title: "Services",
            subtitle: ""
        }
    },
    {
        path: "/about-us",
        name: "AboutUs",
        component: AboutUs,
        meta: {
            icon: "mdi-home",
            title: "AboutUs",
            subtitle: ""
        }
    },
    {
        path: "/signin",
        name: "Signin",
        component: Signin,
        meta: {
            icon: "mdi-home",
            title: "Signin",
            subtitle: ""
        }
    },
    {
        path: "/signup",
        name: "Signup",
        component: Signup,
        meta: {
            icon: "mdi-home",
            title: "Signup",
            subtitle: ""
        }
    },
    {
        path: "/verify",
        name: "Verify",
        component: Verify,
        meta: {
            icon: "mdi-home",
            title: "Verify",
            subtitle: ""
        }
    },
    {
        path: "/profile",
        name: "Profile",
        component: Profile,
        meta: {
            icon: "mdi-home",
            title: "Profile",
            subtitle: ""
        }
    }
];

const router = new VueRouter({
    mode: "history",
    routes
    // base: process.env.MIX_APP_URL
});

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem("user");
    const isVerified = localStorage.getItem("isUserVerfied");

    if ((to.name === "Profile" || to.name === "Verify") && !loggedIn) {
        next("/signin");
        return;
    }
    // else if (loggedIn && isVerified === "false" && to.name === "Signin") {
    //     next("/verify");
    //     return;
    // } 
    else if (loggedIn && (to.name === "Signin" || to.name === "Signup")) {
        next("/");
        return;
    }
    next();
});

export default router;