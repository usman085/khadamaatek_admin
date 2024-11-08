<template>
  <b-tab title="My Profile">
    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="fullPage"></loading>

    <div class="tab-card">
      <h2 class="tab-card__title mb-5">My Profile</h2>
      <b-tabs>
        <b-tab title="My Profile" active>
          <b-table no-border-collapse hover :items="items" class="profile-table">
            <!-- A custom formatted column -->
            <template v-slot:cell(name)="data">
              <b>{{ data.value }}</b>
            </template>
            <template v-slot:cell(value)="data">
              <span v-if="data.value.type && data.value.type == 'email_verify'">
                <span class="badge badge-success p-2" v-if="data.value.verified">
                  <span class="fas fa-check"></span> Verified
                </span>
                <span
                  class="badge badge-danger p-2"
                  style="cursor:pointer;"
                  v-else
                  @click="verifyEmail"
                >
                  <span class="fas fa-times"></span> Verify Now
                </span>
              </span>

              <span v-html="data.value" v-else></span>
            </template>
          </b-table>
        </b-tab>
        <b-tab title="Edit Profile">
          <form action="#" class="mt-5" @submit.prevent="updateProfile">
            <b-row>
              <b-col md="6">
                <div class="form-group">
                  <label for="first_name">First Name</label>
                  <input
                    type="text"
                    class="form-control tab-card__input"
                    v-model="formData.first_name"
                    required
                  />
                </div>
              </b-col>
              <b-col md="6">
                <div class="form-group">
                  <label for="first_name">Last Name</label>
                  <input
                    type="text"
                    class="form-control tab-card__input"
                    v-model="formData.last_name"
                    required
                  />
                </div>
              </b-col>
            </b-row>

            <b-row>
              <b-col md="6">
                <div class="form-group">
                  <label for="first_name">Email</label>
                  <input type="email" class="form-control tab-card__input" v-model="formData.email" />
                </div>
              </b-col>
              <b-col md="6">
                <div class="form-group">
                  <label for="first_name">ID Number</label>
                  <input type="text" class="form-control tab-card__input" v-model="formData.cnic" />
                </div>
              </b-col>
            </b-row>

            <b-row>
              <b-col md="6">
                <div class="form-group">
                  <label for="first_name">Nationality</label>
                  <input
                    type="text"
                    class="form-control tab-card__input"
                    v-model="formData.nationality"
                  />
                </div>
              </b-col>
              <b-col md="6">
                <div class="form-group">
                  <label for="first_name">Gender</label>
                  <select name id class="form-control tab-card__input" v-model="formData.gender">
                    <option value="Male" :selected="formData.gender == 'Male'">Male</option>
                    <option value="Female" :selected="formData.gender == 'Female'">Female</option>
                    <option value="Other" :selected="formData.gender == 'Other'">Other</option>
                  </select>
                </div>
              </b-col>
            </b-row>

            <b-row>
              <b-col md="12">
                <div class="form-group">
                  <label for="first_name">Address</label>
                  <input
                    type="text"
                    class="form-control tab-card__input"
                    v-model="formData.address"
                  />
                </div>
              </b-col>
            </b-row>

            <b-row>
              <b-col md="12">
                <div class="form-group">
                  <button
                    class="btn btn-secondary btn-block tab-card__btn mt-4"
                    type="submit"
                  >Update</button>
                </div>
              </b-col>
            </b-row>
          </form>
        </b-tab>
      </b-tabs>
    </div>
  </b-tab>
</template>

<script>
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
import "vue-form-generator/dist/vfg.css";

export default {
  name: "MyProfile",
  components: {
    Loading,
  },
  data() {
    return {
      isLoading: false,
      fullPage: true,

      userData: "",
      items: [
        { name: "First Name", value: "" },
        { name: "Sur Name", value: "" },
        { name: "Email", value: "" },
        { name: "ID Number", value: "" },
        { name: "Nationality", value: "" },
        { name: "Gender", value: "" },
        { name: "Phone:", value: "" },
        { name: "Address:", value: "" },
      ],

      formData: {
        first_name: "",
        last_name: "",
        email: "",
        cnic: "",
        nationality: "",
        gender: "",
        phone_no: "",
        address: "",
      },
    };
  },
  async created() {
    const loggedIn = JSON.parse(localStorage.getItem("user"));
    if (loggedIn && loggedIn.token && loggedIn.user) {
      const getUser = await axios
        .post("/user/get-user/" + loggedIn.user.id, {
          user_type: "customer",
        })
        .then((response) => {
          let user = response.data.user;
          this.items = [
            { name: "First Name", value: user.first_name },
            { name: "Sur Name", value: user.last_name },
            { name: "Acc No.", value: user.account_no },
            { name: "Email", value: user.email },
            {
              name: "Email Verified",
              value: {
                type: "email_verify",
                verified: user.email_verified_at,
              },
            },
            { name: "ID Number", value: user.cnic },
            { name: "Nationality", value: user.nationality },
            { name: "Gender", value: user.gender },
            { name: "Phone:", value: user.phone_no },
            { name: "Address:", value: user.address },
          ];

          this.formData = {
            first_name: user.first_name,
            last_name: user.last_name,
            email: user.email,
            cnic: user.cnic,
            nationality: user.nationality,
            gender: user.gender,
            phone_no: user.phone_no,
            address: user.address,
          };
        })
        .catch((err) => {
          alert(err.response.data.message);
        });
    } else {
      alert("user not logged in!");
    }
  },
  methods: {
    verifyEmail: function () {
      this.isLoading = true;

      const loggedin = JSON.parse(localStorage.getItem("user"));
      axios
        .post(`/customer/email-verify-send/${loggedin.user.id}`, {
          user_type: "customer",
        })
        .then((response) => {
          this.isLoading = false;
          alert(response.data.message);
        })
        .catch((err) => {
          this.isLoading = false;
          alert(err.response.data.message);
        });
    },

    updateProfile: function () {
      this.isLoading = false;
      this.$store
        .dispatch("updateProfile", this.formData)
        .then(() => {
          this.isLoading = false;
          this.$router.push({ name: "Profile" });
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style>
</style>