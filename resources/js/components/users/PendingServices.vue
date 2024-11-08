<template>
  <b-tab title="Pending Services" title-link-class="subtabs">
    <b-modal
      v-model="modalShow"
      modal-class="messageModal"
      title="Notifications"
      no-close-on-esc
      no-close-on-backdrop
    >
      <div class="row">
        <div class="col-lg-12">
          <div class="chat-box">
            <div v-for="(item, index) in messageSection" :key="index">
              <div v-html="item"></div>
            </div>
          </div>
          <div class="input-group">
            <input
              class="form-control"
              type="text"
              id="message"
              placeholder="Type Note Here..."
              v-model="messageNote"
            />
            <div class="input-group-append">
              <a
                class="input-group-text bg-primary text-white"
                id="sendMessage"
                title="Send Message"
                @click.prevent="sendMessage"
              >
                <i class="fas fa-paper-plane"></i>
              </a>
            </div>
          </div>
        </div>
      </div>

      <template v-slot:modal-footer="{ ok, cancel }">
        <b-button size="lg" variant="danger" @click="cancel()">Cancel</b-button>
      </template>
    </b-modal>
    <div class="tab-card">
      <h2 class="tab-card__title mb-5">Pending Services</h2>

      <p class="alert alert-info" v-if="errorMessage">{{ errorMessage }}</p>
      <b-table hover :items="pendingServices" class="tab-card__table">
        <template v-slot:head(message)="scope">
          <span></span>
        </template>
        <template v-slot:head(action)="scope">
          <span></span>
        </template>

        <template v-slot:cell(order_no)="data">
          <b class="secondary-color">{{ data.item.order_no }}</b>
        </template>

        <template v-slot:cell(status)="data">
          <span class="text-capitalize">{{ data.item.status }}</span>
        </template>

        <template v-slot:cell(message)="data">
          <button
            class="btn btn-warning"
            style="font-size: 14px;"
            data-target="#messagesModal"
            data-toggle="modal"
            @click="fetchMessages(data.item.action)"
          >
            <i class="fas fa-bell"></i>
            <span class="badge badge-pill badge-danger">{{ data.item.message }}</span>
          </button>
        </template>

        <template v-slot:cell(action)="data">
          <div class="row">
            <div class="col-6">
              <button
                class="btn btn-danger"
                style="font-size: 14px;"
                @click.prevent="cancelOrder(data.item.action)"
              >Cancel</button>
            </div>
            <div class="col-6">
              <button
                class="btn btn-info"
                style="font-size: 14px;"
                @click.prevent="editOrder(data.item.action)"
              >Edit</button>
            </div>
          </div>
        </template>
      </b-table>
    </div>
  </b-tab>
</template>

<script>
export default {
  name: "PendingServices",
  async created() {
    const loggedin = JSON.parse(localStorage.getItem("user"));
    const getPendingOrders = await axios
      .post("customer/get-orders?filter=1", { id: loggedin.user.id })
      .then(({ data }) => {
        if (data.orders && data.orders.length > 0) {
          data.orders.forEach((row) => {
            let obj = {
              order_no: row.order_no,
              // service_id: row.service.id,
              department: row.department.name,
              service_category: row.category.name,
              service_name: row.service.name,
              status: row.status.name,
              price: row.agreed_fee,
              message: row.unread_msg,
              action: row.id,
            };
            this.pendingServices.push(obj);
          });
        } else {
          this.errorMessage = data.message;
        }
      })
      .catch((err) => {
        console.log(err);
      });
  },
  data() {
    return {
      errorMessage: "",
      messageSection: [],
      pendingServices: [],
      currentOrder: "",
      modalShow: false,
      messageNote: "",
    };
  },
  methods: {
    cancelOrder(order_id) {
      if (!confirm("Are you sure to cancel this service?")) {
        return;
      }
      let loggedin = JSON.parse(localStorage.getItem("user"));
      axios
        .get(`/order/cancel-order/${order_id}`)
        .then(({ data }) => {
          this.$toasted.show(data.message, {
            theme: "toasted-primary",
            icon: "fa-check",
            position: "top-right",
            duration: 3000,
          });
          setTimeout(() => {
            location.reload();
          }, 1000);
        })
        .catch((err) => {
          this.$toasted.show(err.reponse.message, {
            theme: "toasted-primary",
            icon: "fa-exclamation-triangle",
            position: "top-right",
            duration: 3000,
          });
        });
    },
    editOrder(order_id) {
      console.log('order_id',order_id);
      this.$emit('editOrder',order_id);
    },

    sendMessage() {
      const loggedin = JSON.parse(localStorage.getItem("user"));
      axios
        .post("/order/send-message", {
          order_id: this.currentOrder,
          message: this.messageNote,
          user_id: loggedin.user.id,
        })
        .then(({ data }) => {
          this.$toasted.show(data.message, {
            theme: "toasted-primary",
            icon: "fa-check",
            position: "top-right",
            duration: 3000,
          });
          this.messageNote = "";
          this.modalShow = false;
        })
        .catch((err) => {
          this.$toasted.show(err.response.data.message, {
            theme: "toasted-primary",
            icon: "fa-exclamation-triangle",
            position: "top-right",
            duration: 3000,
          });
        });
    },

    fetchMessages(order_id) {
          const loggedin = JSON.parse(localStorage.getItem("user"));
      this.currentOrder = order_id;
      axios
        .get(`/order/fetch-messages/${this.currentOrder}`)
        .then(({ data }) => {
          
          this.messageSection = [];
          let html = "";
          if (data.message) {
            data.message.forEach((element) => {
              let add_date = new Date(element.created_at);
              add_date = element.sent_at;
              // add_date.getFullYear() +
              // "-" +
              // (add_date.getMonth() + 1) +
              // "-" +
              // add_date.getDate() +
              // " " +
              // add_date.getHours() +
              // ":" +
              // add_date.getMinutes() +
              // ":" +
              console.log(element)
              // add_date.getSeconds();
              if(element.user_id!=loggedin.user.id ){
    
              html += '<div class="message-box">';
              html += `<div class="user-info">`;
              html += `<span class="msg-time">${add_date}</span>`;
           if (element.user_type == "App\\Customer") {
                html += `<span class="user-name">${element.first_name}</span>`;
              } else {
                html += `<span class="user-name">${element.name}</span>`;
              }
           
              html += `</div>`;
              html += `<span class="msg-text-other">${element.message}</span>`;
              html += "</div>";
              }
              else{

                  html += '<div class="message-box">';
              html += `<div class="user-info">`;
              if (element.user_type == "App\\Customer") {
                html += `<span class="user-name">${element.first_name}</span>`;
              } else {
                html += `<span class="user-name">${element.name}</span>`;
              }
              html += `<span class="msg-time">${add_date}</span>`;
              html += `</div>`;
              html += `<span class="msg-text">${element.message}</span>`;
              html += "</div>";

              
              }
        
            });
            this.messageSection.push(html);
            this.modalShow = true;
            this.messageNote = "";
            // setTimeout(() => {
            //   $(".chat-box").scrollTop($(".chat-box")[0].scrollHeight);
            // }, 300);
          }
        })
        .catch((err) => {
          console.log(err);
        });
      // $(".chat-box").html("");
      // $("#sendMessage").data("order_id", order_id);
      // let html = "";
      // data.forEach((element) => {
      //   let add_date = new Date(element.created_at);
      //   add_date =
      //     add_date.getFullYear() +
      //     "-" +
      //     (add_date.getMonth() + 1) +
      //     "-" +
      //     add_date.getDate() +
      //     " " +
      //     add_date.getHours() +
      //     ":" +
      //     add_date.getMinutes() +
      //     ":" +
      //     add_date.getSeconds();

      //   html += '<div class="message-box">';
      //   html += `<div class="user-info">`;
      //   if (element.user_type == "App\\Customer") {
      //     html += `<span class="user-name">${element.first_name}</span>`;
      //   } else {
      //     html += `<span class="user-name">${element.name}</span>`;
      //   }
      //   html += `<span class="msg-time">${add_date}</span>`;
      //   html += `</div>`;
      //   html += `<span class="msg-text">${element.message}</span>`;
      //   html += "</div>";
      // });
      // $(".chat-box").html(html);
      // $(".showMessageModal").trigger("click");
      // setTimeout(() => {
      //   $(".chat-box").scrollTop($(".chat-box")[0].scrollHeight);
      // }, 300);
    },
  },
};
</script>



<style lang="scss">
.messageModal {
  & #message {
    font-size: 14px;
  }

  & #sendMessage {
    padding-left: 10px;
    padding-right: 10px;
  }
}
.chat-box {
  min-height: 200px;
  max-height: 350px;
  border: 1px solid #ddd;
  border-bottom: none;
  position: relative;
  overflow-y: auto;
  padding: 5px 15px;
}

.message-box {
  display: flex;
  padding:7px;
  // border-bottom: 1px solid #ddd;
  flex-direction: column;
}

.user-name {
  font-weight: 600;
}

.msg-time {
  font-size: 10px;
  color: #ccc;
}

.msg-text {
  font-size: 12px;
}
.msg-text-other {
    display: flex;
    justify-content: flex-end;
}
.user-info {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
}

.badge.badge-pill {
  top: -8px;
  right: 4px;
}

.btnShowMessages {
  padding-left: 6px;
  padding-right: 6px;
}
</style>