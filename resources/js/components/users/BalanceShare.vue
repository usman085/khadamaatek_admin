<template>
<div>
    <b-modal id="modal-1" title="Confirmation" ok-title="Send" @ok="balanceShare">
        <b-table stacked :items="items" :busy="isBusy" outlined>
            <template #table-busy>
                <div class="text-center text-danger my-2">
                <b-spinner class="align-middle"></b-spinner>
                <strong>Loading...</strong>
                </div>
            </template>
        </b-table>
        <div>
            <p style="text-align: center;">Please confirm information before proceeding.</p>
        </div>
    </b-modal>
  <b-tab title="Balance Share">
    <div class="tab-card">
      <h2 class="tab-card__title">Balance Share</h2>
      <p
        class="tab-card__description mb-5"
      >You can access and modify your personal details (name, address, telephone number, etc) in order to facilitate your future purchases.</p>


      <b-form action="#">
        <b-row>
          <b-col md="6">
            <div class="form-group">
              <label class="tab-card__label" for="account_num">To Account Number *</label>
              <input
                type="text"
                class="form-control tab-card__input"
                id="account_num"
                name="account_num"
                v-model="formData.phone_no"
              />
            </div>
          </b-col>
          <b-col md="6">
            <div class="form-group">
              <label class="tab-card__label" for="amount">Amount *</label>
              <input
                type="text"
                class="form-control tab-card__input"
                id="amount"
                name="amount"
                v-model="formData.amount"
              />
            </div>
          </b-col>
        </b-row>

        <b-row>
          <b-col md="12">
            <div class="form-group">
              <button class="btn btn-secondary btn-block tab-card__btn mt-4" disabled @click="getUserDetials" type="button" v-if="processing">
                  <b-spinner class="align-middle"></b-spinner>
              </button>
              <button class="btn btn-secondary btn-block tab-card__btn mt-4" @click="getUserDetials" type="button" v-else>
                  Process
              </button>
            </div>
          </b-col>
        </b-row>
            <div class="alert alert-info" v-if="respMessage">{{ respMessage }}</div>
      </b-form>
    </div>
  </b-tab>
</div>
</template>

<script>
export default {
  name: "BalanceShare",
  data() {
    return {
      processing: false,
      isBusy: false,
      items: [
            {
                Name: "Test",
                Email: 'test@test.com',
                Phone: '+92340000000',
                "Account #": "923",
                Amout: '10.00'
            }
      ],
      respMessage: "",
      formData: {
        phone_no: "",
        amount: "",
      },
    };
  },
  methods: {
    getUserDetials() {
        if(this.formData.phone_no.length <= 0) {
            this.respMessage = "Please enter user account #";
            return false;
        }
        if(this.formData.amount.length <= 0) {
            this.respMessage = "Please enter amount to be transfer!";
            return false;
        }
        this.processing = true;
        axios
          .post("user/get-user/"+this.formData.phone_no, { user_type: "customer"})
          .then((r) => {
              let user = r.data.user;
            this.processing = false;

            this.items = [{
                Name: user.first_name+" "+user.last_name,
                Email: user.email,
                Phone: user.phone_no,
                "Account #": user.account_no,
                Amout: this.formData.amount
            }];
            this.respMessage = "";
            this.$bvModal.show('modal-1');
          })
          .catch((err) => {
            this.processing = false;
            this.$bvModal.hide('modal-1');
            this.respMessage = err.response.data.message;
            this.$toasted.show(this.respMessage, {
                theme: "toasted-primary",
                icon: "fa-exclamation-triangle",
                position: "top-right",
                duration: 3000,
              });
          });
    },
    balanceShare() {
        this.$bvModal.hide('modal-1');
        this.respMessage = "Amount successfully transferred";
    //   let errors = false;
    //   const profileComplete = localStorage.getItem("isProfileComplete");
    //   let loggedin = JSON.parse(localStorage.getItem("user"));

    //   if (profileComplete && profileComplete === "false") {
    //     errors = true;
    //     this.$toasted.show("Please Complete your profile to order!!!", {
    //       theme: "toasted-primary",
    //       icon: "fa-exclamation-triangle",
    //       position: "top-right",
    //       duration: 3500,
    //     });
    //   }

        this.formData.etype = "balanceShare";
        axios
          .post("/user/fundtransfer", this.formData)
          .then((r) => {
            let data = r.data;
            this.respMessage = data.message;
            // form reset
            for (var property in this.formData) {
              this.formData[property] = "";
            }
          })
          .catch((err) => {
            this.respMessage = err.response.data.message;
          });

    },
  },
};
</script>
<style>
</style>
