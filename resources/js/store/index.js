import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

window.axios = axios;

window.axios.defaults.baseURL = process.env.MIX_APP_URL + "/api";
window.axios.defaults.backEndBaseURL = process.env.MIX_APP_URL;

export default new Vuex.Store({
    state: {
        user: null
    },
    mutations: {
        setUserData(state, userData) {
            state.user = userData;
            localStorage.setItem("isUserVerfied", false);
            if (userData.user.verified == "true") {
                localStorage.setItem("isUserVerfied", true);
            }
            localStorage.setItem("user", JSON.stringify(userData));

            if (
                (userData.user.first_name === "Temp" &&
                    userData.user.last_name === "User") ||
                (!userData.user.first_name && !userData.user.last_name)
            ) {
                localStorage.setItem("isProfileComplete", false);
            } else {
                localStorage.setItem("isProfileComplete", true);
            }
            if (userData.token) {
                axios.defaults.headers.common.Authorization = `Bearer ${userData.token}`;
            }
        },

        setUserToVerified() {
            localStorage.setItem("isUserVerfied", true);
        },

        clearUserData() {
            localStorage.clear();
            // localStorage.removeItem("user");
            // location.reload();
        }
    },
    actions: {
        login({ commit }, credentials) {
            return axios
                .post("customer/login", credentials)
                .then(({ data }) => {
                    commit("setUserData", data);
                });
        },

        register({ commit }, credentials) {
            return axios
                .post("/customer/registration", credentials)
                .then(({ data }) => {
                    commit("setUserData", data);
                });
        },

        verify({ commit }, credentials) {
            const userData = JSON.parse(localStorage.getItem("user"));
            credentials.userData = userData.user;

            return axios
                .post("/customer/verify", credentials)
                .then(({ data }) => {
                    alert("Profile verified successfully!");
                    // commit("setUserData", data);
                    commit("clearUserData");
                });
        },

        updateProfile({ commit }, userData) {
            const loggedin = JSON.parse(localStorage.getItem("user"));
            userData.user = loggedin.user;

            return axios
                .post("/customer/update-profile", userData)
                .then(({ data }) => {
                    alert("Profile Updated Successfully!");
                    commit("setUserData", data);
                    location.reload();
                });
        },

        logout({ commit }) {
            commit("clearUserData");
            // return axios
            //     .post("/customer/logout", credentials)
            //     .then(() => {
            // });
        }
    },
    getters: {
        isLogged: state => !!state.user
    }
    // modules: {},
    // strict: process.env.DEV
});