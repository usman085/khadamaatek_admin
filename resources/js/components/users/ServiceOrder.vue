<template>
  <b-tab title="Place Service Order" active>
    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="fullPage"></loading>

    <div class="tab-card">
      <div class="steps-line">
        <!-- <a-steps progress-dot :current="current">
          <a-step v-for="item in steps" :key="item.title" :title="item.title"></a-step>
        </a-steps>-->
        <div class="tab-card__steps-content departments mt-2 mb-3">
          <h2 class="tab-card__title">Different Groups</h2>
          <p class="tab-card__description">You can choose the Group as you want service</p>

          <b-row>
            <b-col md="3" sm="6" v-for="(group, i) in groups" :key="i">
              <div
                class="tab-card__box"
                :data-group_id="group.name"
                :class="{active:group.id == orderData.selectedGroup}"
                @click="getDepartmentsByGroup(group.id)"
              >{{ group.name }}</div>
            </b-col>
          </b-row>
        </div>

        <div class="tab-card__steps-content departments mt-2 mb-3" v-if="orderData.selectedGroup">
          <h2 class="tab-card__title">Different Departments</h2>
          <p class="tab-card__description">You can choose the department as you want service</p>

          <b-row>
            <b-col md="3" sm="6" v-for="(dept, i) in departments" :key="i">
              <div
                class="tab-card__box"
                :data-dept_id="dept.name"
                :class="{active:dept.id == orderData.selectedDept}"
                @click="getCategoriesByDept(dept.id)"
              >{{ dept.name }}</div>
            </b-col>
          </b-row>
        </div>

        <div class="tab-card__steps-content mt-5 mb-3" v-if="orderData.selectedDept">
          <h2 class="tab-card__title">Different Service Categories</h2>
          <p class="tab-card__description">You can choose the service category as you want service</p>

          <b-row>
            <b-col md="3" sm="6" v-for="(cat, i) in categories" :key="i">
              <div
                class="tab-card__box"
                :class="{active:cat.id == orderData.selectedCat}"
                @click="getSubCategories(cat.id)"
              >{{ cat.name }}</div>
            </b-col>
          </b-row>
        </div>

        <div class="subcategories-section" v-if="orderData.selectedCat">
          <div
            class="tab-card__steps-content mt-5 mb-3"
            v-for="(subcats, i) in subcategories"
            :key="i"
          >
            <h2 class="tab-card__title">Service Sub Categories</h2>
            <p class="tab-card__description">You can choose the sub category as you want service</p>

            <b-row>
              <b-col md="3" sm="6" v-for="(cat, ind) in subcats" :key="ind">
                <div
                  class="tab-card__box"
                  :data-cate_id="cat.id"
                  :data-index="i"
                  :class="{active:cat.id == orderData.selectedSubCats[i]}"
                  @click="getSubCategories(cat.id, 'subcat', i)"
                >{{ cat.name }}</div>
              </b-col>
            </b-row>
          </div>
        </div>

        <div
          class="tab-card__steps-content mt-5 mb-3"
          v-if="orderData.selectedCat || orderData.selectedSubCats.length > 0"
        >
          <div class="d-flex justify-content-between align-items-center">
            <div class="info">
              <h2 class="tab-card__title">Different Services</h2>
              <p class="tab-card__description">You can choose the best service as your requirement</p>
            </div>
            <div class="search d-none">
              <input type="text" class="form-control search" placeholder="search" />
            </div>
          </div>

          <b-row>
            <b-col md="3" sm="6" v-for="(service, i) in services" :key="i">
              <div
                class="tab-card__box"
                :class="{active:service.id == orderData.selectedService}"
                @click="getServiceDetails(service.id)"
              >{{ service.name }}</div>
            </b-col>
          </b-row>
        </div>

        <div class="row">
          <div class="col-xl-4 col-lg-6 col-md-6 ml-auto mr-auto">
            <button
              class="btn btn-warning btn-lg btn-block"
              @click="showModal = true"
              v-if="requirementForm"
            >
              Requirements Form
              <i class="fab fa-wpforms"></i>
            </button>
          </div>
        </div>

        <div class="tab-card__steps-content mt-5 mb-3" v-if="orderData.selectedService">
          <b-row>
            <b-col md="8">
              <div class="order-summary">
                <h2 class="tab-card__title">Order Summary</h2>

                <b-table stacked :items="service_detail" class="stack-table-left"></b-table>

                <div class="contact-info">
                  <h2 class="contact-info__title">Contact Information</h2>

                  <b-table stacked :items="contact_detail" class="stack-table-left"></b-table>
                </div>
              </div>
            </b-col>
            <b-col md="4">
              <div class="package-box pt-2">
                <b-row>
                  <b-col md="4" class="text-center">
                    <div class="package-box__thumbnail">
                      <img
                        src="../../assets/Home/GOLD Package-2x.png"
                        alt="Gold Package"
                        class="img-fluid package-box__photo"
                      />
                    </div>
                  </b-col>
                  <b-col md="8">
                    <h2 class="package-box__pkg-title" v-text="selectedServiceName"></h2>
                  </b-col>
                </b-row>

                <b-row class="mt-5">
                  <b-col cols="6">
                    <p class="package-box__total-text">Subtotal</p>
                  </b-col>
                  <b-col cols="6">
                    <p class="package-box__total-value">
                      <!-- <span>{{ selectedCurrency }}</span> -->
                      <span>{{ orderData.selectedServiceFee }}</span>
                    </p>
                  </b-col>
                </b-row>

                <b-row>
                  <b-col cols="6">
                    <p class="package-box__total-text">Tax</p>
                  </b-col>
                  <b-col cols="6">
                    <p class="package-box__total-value">0.00</p>
                  </b-col>
                </b-row>

                <p
                  class="tab-card__description"
                  style="font-size: 12px;"
                >Payment deducted from your wallet</p>

                <b-row>
                  <b-col cols="12">
                    <div class="package-box__total-box">
                      <p class="package-box__total">Total</p>
                      <p class="package-box__total-amount">
                        <span>{{ selectedCurrency }}</span>
                        <span>{{ orderData.selectedServiceFee }}</span>
                      </p>
                    </div>
                  </b-col>
                </b-row>
                <b-row>
                  <b-col cols="12">
                    <button class="btn btn-black btn-block" @click.prevent="checkout">CHECKOUT</button>
                  </b-col>
                </b-row>
              </div>
            </b-col>
          </b-row>
        </div>
      </div>
    </div>

    <b-modal
      v-model="showModal"
      :size="modal_size"
      id="template-form"
      ref="modal"
      title="Submit Details"
    >
      <div class="row">
        <div class="col-md-6" v-for="(req, index) in requirements_data" :key="index">
          <label for>{{ req.label }}</label>
          <select
            :name="getSchemaKey(req.label)"
            v-model="schema[getSchemaKey(req.label) + '_' + req.document_id]"
            @change="addNewDoc(req.document_id, getSchemaKey(req.label) + '_' + req.document_id)"
            class="form-control"
          >
            <option value selected disabled>Choose Document</option>
            <option value="new_doc">Add New</option>
            <option v-for="(opt, i) in req.data" :key="i" :value="opt.id">{{ opt.name }}</option>
          </select>
        </div>
      </div>

      <template v-slot:modal-footer>
        <div class="w-100">
          <b-button variant="warning" size="lg" class="float-right" @click="showModal=false">Close</b-button>
          <b-button
            variant="primary"
            size="lg"
            class="float-right mr-2"
            @click="showModal=false"
          >Save</b-button>
        </div>
      </template>
    </b-modal>

    <!-- Add new Document -->
    <b-modal
      v-model="showNewDocumentModal"
      :size="modal_size"
      id="template-form"
      ref="modal"
      title="New Document"
    >
      <b-row>
        <b-col md="12">
          <div class="form-group">
            <label>
              <span>Document Name</span>
            </label>
            <div class="field-wrap">
              <div class="wrapper">
                <input
                  id="doc_name"
                  type="text"
                  placeholder="Document Name"
                  required="required"
                  class="form-control"
                  v-model="newSelectedDoc_name"
                  size="lg"
                />
              </div>
            </div>
          </div>
        </b-col>
      </b-row>

      <b-row>
        <b-col md="12">
          <form action="#" class="form-container">
            <vue-form-generator :schema="newDocumentschema" :model="newTemplateModel"></vue-form-generator>
          </form>
        </b-col>
      </b-row>

      <template v-slot:modal-footer>
        <div class="w-100">
          <b-button
            variant="warning"
            size="lg"
            class="float-right"
            @click="showNewDocumentModal=false"
          >Close</b-button>
          <b-button
            variant="primary"
            size="lg"
            class="float-right mr-2"
            @click="saveNewDocument"
          >Save</b-button>
        </div>
      </template>
    </b-modal>
  </b-tab>
</template>

<script>
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
import "vue-form-generator/dist/vfg.css";
// ant design style css
import "ant-design-vue/lib/steps/style/css"; // for css

export default {
  name: "ServiceOrder",
  components: {
    Loading,
  },
  async created() {
    const getGroups = await axios
      .get("department/get-groups")
      .then(({ data }) => {
        if (data.groups && data.groups.length > 0) {
          data.groups.forEach((elem) => {
            let obj = {
              id: elem.id,
              name: elem.name,
            };
            this.groups.push(obj);
          });
        } else {
          this.groupMsg = data.message;
        }
      })
      .catch((err) => {
        console.log(err);
      });
  },
  props:{
    order_id: null,
  },
  data() {
    return {
      showModal: false,
      showNewDocumentModal: false,
      isLoading: false,
      fullPage: true,
      modal_size: "md",
      form_col_class: "col-lg-12",
      attachment_col_class: "col-lg-12",
      old_attachments: [],

      orderData: {
        selectedGroup: false,
        selectedDept: false,
        selectedCat: false,
        selectedService: false,
        selectedSubCats: [],
        selectedServiceFee: "",
      },

      requirementForm: "",
      selectedCurrency: "SAR:",
      selectedServiceName: "",

      current: 0,
      steps: [
        {
          title: "Departments Select",
          id: 1,
        },
        {
          title: "Service Categories",
          id: 2,
        },
        {
          title: "Different Services",
          id: 3,
        },
        {
          title: "Payment & Confirm",
          id: 4,
        },
      ],

      groupMsg: "",
      groups: [],

      departmentMsg: "",
      departments: [],

      categoryMsg: "",
      categories: [],

      subcategories: [],

      serviceMsg: "",
      services: [],

      service_detail: [],
      contact_detail: [],

      requirements_data: [],
      schema_keys: [],
      templateModel: {},
      schema: {},
      // for new document
      selectedNewDocumentId: null,
      newDocumentschema: {},
      newTemplateModel: {},
      newSelectedDoc_name: null,
    };
  },
  methods: {
    getSchemaKey(name) {
      return name.toLowerCase().split(" ").join("_");
    },

    addNewDoc(document_id, selectedVal) {
      // console.log(document_id);
      let type = this.schema[selectedVal];
      if (type === "new_doc") {
        this.schema[selectedVal] = "";
        this.isLoading = true;
        const loggedIn = JSON.parse(localStorage.getItem("user"));
        if (document_id && loggedIn.user) {
          this.selectedNewDocumentId = document_id;
          this.templateModel = {};

          axios
            .get(`/documents/get/${document_id}/${loggedIn.user.id}`)
            .then((response) => {
              // console.log(response.data);
              let templateFields = JSON.parse(
                response.data.data.document.schema
              );
              templateFields.forEach((element, index) => {
                if (element.type === "upload") {
                  templateFields[index].onChanged = function (
                    model,
                    schema,
                    event
                  ) {
                    var files = event.target.files || event.dataTransfer.files;
                    if (!files.length) return;
                    model[schema.model] = files[0];
                  };
                } else if (element.inputType === "date") {
                  templateFields[index].set = function (model, val) {
                    model[this.model] = new Date(val).valueOf();
                    model[this.model + "-type"] = "date";
                  };
                }
              });

              this.newDocumentschema = {
                fields: templateFields,
              };
              this.isLoading = false;
              this.showModal = false;
              this.showNewDocumentModal = true;
            })
            .catch((err) => {
              console.log(err.response);
              this.isLoading = false;
              alert("Technical Error!");
            });
        } else {
          alert("Data missing!!!");
        }
      }
    },

    saveNewDocument() {
      let errors = this.validateNewDocTemplateData();
      const loggedIn = JSON.parse(localStorage.getItem("user"));
      let formData = new FormData();
      for (var property in this.newTemplateModel) {
        formData.append(property, this.newTemplateModel[property]);
      }
      formData.append("document_name", this.newSelectedDoc_name);
      formData.append("document_id", this.selectedNewDocumentId);
      formData.append("user_id", loggedIn.user.id);
      formData.append("user_type", "customer");
      formData.append("template", JSON.stringify(this.newTemplateModel));
      if (!errors) {
        this.isLoading = true;
        axios
          .post("document/savedata", formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then(({ data }) => {
            this.getServiceDetails(this.orderData.selectedService);
            alert(data.message);
            this.isLoading = false;
            this.showNewDocumentModal = false;
          })
          .catch((error) => {
            this.isLoading = false;
            let errors = error.response.data.errors;
            for (var property in errors) {
              this.$toasted.show(errors[property][0], {
                theme: "toasted-primary",
                icon: "fa-exclamation-triangle",
                position: "top-right",
                duration: 3000,
              });
            }
          });
      }
    },

    validateNewDocTemplateData() {
      let error = false;
      this.newDocumentschema.fields.forEach((element) => {
        if (element.required == true && !error) {
          if (!this.newTemplateModel[element.model]) {
            alert("Please fill the requirement form");
            error = true;
          }
        }
      });

      return error;
    },

    async getDepartmentsByGroup(group_id) {
      this.isLoading = true;
      this.resetData("group");
      this.orderData.selectedGroup = group_id;

      await axios
        .get(`department/getdepartmentsbygroup/${group_id}`)
        .then(({ data }) => {
          this.departments = [];
          if (data.departments && data.departments.length > 0) {
            data.departments.forEach((dept) => {
              let obj = {
                id: dept.id,
                name: dept.name,
              };
              this.departments.push(obj);
            });
          } else {
            this.departmentMsg = data.message;
          }
          this.isLoading = false;
        })
        .catch((err) => {
          this.isLoading = false;
          this.$toasted.show(err.response.data.message, {
            theme: "toasted-primary",
            icon: "fa-exclamation-triangle",
            position: "top-right",
            duration: 3000,
          });
        });
    },

    async getCategoriesByDept(dept_id) {
      this.isLoading = true;
      this.resetData("department");
      this.orderData.selectedDept = dept_id;

      await axios
        .post("department/get-categories", { department_id: dept_id })
        .then(({ data }) => {
          this.categories = [];
          if (data.categories && data.categories.length > 0) {
            data.categories.forEach((dept) => {
              let obj = {
                id: dept.id,
                name: dept.name,
              };
              this.categories.push(obj);
            });
          } else {
            this.categoryMsg = data.message;
          }
          this.isLoading = false;
        })
        .catch((err) => {
          this.isLoading = false;
          this.$toasted.show(err.response.data.message, {
            theme: "toasted-primary",
            icon: "fa-exclamation-triangle",
            position: "top-right",
            duration: 3000,
          });
        });
    },

    getSubCategories(cat_id, type, index) {
      this.isLoading = true;
      if (type != "subcat") {
        this.orderData.selectedCat = cat_id;
        this.subcategories = [];
        this.orderData.selectedSubCats = [];
        this.services = [];
        this.orderData.selectedService = "";
        this.requirementForm = "";
        this.modal_size = "md";
        this.form_col_class = "col-lg-12";
        this.attachment_col_class = "col-lg-12";
        this.old_attachments = [];
        this.templateModel = {};
      } else {
        this.orderData.selectedSubCats[index] = cat_id;
        this.orderData.selectedSubCats.splice(index + 1);
        this.subcategories.splice(index + 1);
        this.services = [];
        this.orderData.selectedService = "";
        this.requirementForm = "";
        this.modal_size = "md";
        this.form_col_class = "col-lg-12";
        this.attachment_col_class = "col-lg-12";
        this.old_attachments = [];
        this.templateModel = {};
      }

      axios
        .post("category/get-subcategories", { category_id: cat_id })
        .then(({ data }) => {
          let subCat = [];
          let showError = true;
          if (data.categories && data.categories.length > 0) {
            data.categories.forEach((categ) => {
              let obj = {
                id: categ.id,
                name: categ.name,
              };
              subCat.push(obj);
            });
            showError = false;
            this.subcategories.push(subCat);
          }
          if (data.services && data.services.length > 0) {
            data.services.forEach((service) => {
              let obj = {
                id: service.id,
                name: service.name,
              };
              this.services.push(obj);
            });
            showError = false;
          }
          if(showError){
            this.categoryMsg = data.message;
          }
          this.isLoading = false;
        })
        .catch((err) => {
          this.isLoading = false;
          this.$toasted.show(err.response.data.message, {
            theme: "toasted-primary",
            icon: "fa-exclamation-triangle",
            position: "top-right",
            duration: 3000,
          });
        });
    },

    getServiceDetails(service_id) {
      this.old_attachments = [];
      this.templateModel = {};
      this.requirements_data = [];
      this.selectedNewDocumentId = null;
      this.newDocumentschema = {};
      this.newTemplateModel = {};
      this.newSelectedDoc_name = null;
      this.requirementForm = null;
      this.schema_keys = [];

      this.isLoading = true;
      this.orderData.selectedService = service_id;
      let loggedin = JSON.parse(localStorage.getItem("user"));

      axios
        .get(`service/get-service/${service_id}/${loggedin.user.id}`)
        .then((response) => {
          let service = response.data.service;
          // let templateData = response.data.prev_template_data;
          // console.log(response.data);
          if (service) {
            this.selectedServiceName = service.name;
            this.orderData.selectedServiceFee = service.fee;
            this.requirementForm = service.formbuilder_id;
            // console.log(response.data.required_documents);
            this.requirements_data = response.data.required_documents;
            this.requirements_data.forEach((element) => {
              var key = this.getSchemaKey(element.label);
              this.schema_keys.push(key + "_" + element.document_id);
            });
            // let templateFields = service.template.schema;
            // templateFields.forEach((element, index) => {
            //   console.log(element);
            // if (element.type === "upload") {
            //   // console.log(templateFields[index]);
            //   templateFields[index].onChanged = function (
            //     model,
            //     schema,
            //     event
            //   ) {
            //     var files = event.target.files || event.dataTransfer.files;
            //     if (!files.length) return;
            //     model[schema.model] = files[0];
            //   };
            // } else if(element.inputType === 'date'){
            //   templateFields[index].set = function(model, val) {
            //     model[this.model] = new Date(val).valueOf();
            //     model[this.model + '-type'] = "date";
            //   }
            // }

            // poulate previous template data
            // if(templateData.hasOwnProperty('id')){
            //   let templateModelData = JSON.parse(templateData.dataModel);
            //   if(templateModelData.hasOwnProperty(element.model)){
            //     if (element.type === "upload") {
            //       this.form_col_class = "col-md-8";
            //       this.attachment_col_class = "col-md-4";
            //       this.modal_size = "lg";

            //       this.old_attachments.push({
            //         src: './requirements_attach/' + templateModelData[element.model],
            //         name: element.label,
            //       });

            //       this.templateModel[element.model] = templateModelData[element.model];
            //     } else {
            //       if(element.inputType === "date"){
            //         var timestamp = templateModelData[element.model].replace("dateTimeStamp-", "");
            //         this.templateModel[element.model] = new Date(parseInt(timestamp)).valueOf();
            //         this.templateModel[element.model+'-type'] = "date";
            //       } else {
            //         this.templateModel[element.model] = templateModelData[element.model];
            //       }
            //     }
            //   } else {
            //     this.templateModel[element.model] = "";
            //   }
            // } else {
            //   this.templateModel[element.model] = "";
            // }
            // });

            // this.schema = {
            //   fields: templateFields,
            // };

            this.service_detail = [
              {
                service_id: service.id,
                service: service.name,
              },
            ];

            this.contact_detail = [
              {
                name: loggedin.user.first_name + " " + loggedin.user.last_name,
                Email: loggedin.user.email,
                mobile_number: loggedin.user.phone_no,
              },
            ];
          }
          this.isLoading = false;
        })
        .catch((error) => {
          this.isLoading = false;
          this.$toasted.show(error.response.message, {
            theme: "toasted-primary",
            icon: "fa-exclamation-triangle",
            position: "top-right",
            duration: 3000,
          });
        });
    },

    checkout() {
      this.isLoading = true;
      let errors = false;
      let loggedin = JSON.parse(localStorage.getItem("user"));
      const profileComplete = localStorage.getItem("isProfileComplete");

      this.orderData.customer = loggedin.user.id;
      if (this.requirementForm) {
        errors = this.validateTemplateData();
      }
      if (profileComplete && profileComplete === "false") {
        errors = true;
        this.$toasted.show("Please Complete your profile to order!!!", {
          theme: "toasted-primary",
          icon: "fa-exclamation-triangle",
          position: "top-right",
          duration: 3500,
        });
      }
      if (!errors) {
        this.orderData.customer_requirement_data = JSON.stringify(this.schema);
        var self = this;
        axios
          .post("/customer/placeorder", this.orderData)
          .then(({ data }) => {
            // self.handleReponse(data);
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
          .catch((error) => {
            this.isLoading = false;

            let errors = error.response.data.errors;
            for (var property in errors) {
              this.$toasted.show(errors[property][0], {
                theme: "toasted-primary",
                icon: "fa-exclamation-triangle",
                position: "top-right",
                duration: 3000,
              });
            }
          });
      } else {
        this.isLoading = false;
      }
    },

    // handleReponse(response) {
    //   if (response.result == true) {
    //     if (this.requirementForm) {
    //       var formData = new FormData();
    //       for (var property in this.templateModel) {
    //         formData.append(property, this.templateModel[property]);
    //       }
    //       formData.append("order_id", response.order.id);

    //       axios
    //         .post("requirement/savedata", formData, {
    //           headers: {
    //             "Content-Type": "multipart/form-data",
    //           },
    //         })
    //         .then(({ data }) => {
    //           console.log(data);
    //         })
    //         .catch((err) => {
    //           console.log(err);
    //         });
    //     }

    //     this.$toasted.show(response.message, {
    //       theme: "toasted-primary",
    //       icon: "fa-check",
    //       position: "top-right",
    //       duration: 3000,
    //     });

    //     setTimeout(() => {
    //       location.reload();
    //     }, 1000);
    //   } else {
    //     this.$toasted.show(response.message, {
    //       theme: "toasted-primary",
    //       icon: "fa-check",
    //       position: "top-right",
    //       duration: 3000,
    //     });
    //   }
    //   this.isLoading = false;
    // },

    // onModelUpdated() {
    //   // console.log(this.templateModel);
    // },

    validateTemplateData() {
      let error = false;
      // this.schema_keys.forEach((element) => {
      //   if (!error) {
      //     if (!this.schema[element]) {
      //       alert("Please fill all the requirements or add new Document.");
      //       error = true;
      //     }
      //   }
      // });
      // this.schema.fields.forEach((element) => {
      //   if (element.required == true && !error) {
      //     if (!this.templateModel[element.model]) {
      //       alert("Please fill the requirement form");
      //       error = true;
      //     }
      //   }
      // });

      return error;
    },

    resetData(type) {
      this.orderData.selectedDept = "";
      this.orderData.selectedCat = "";
      this.categories = [];
      this.subcategories = [];
      this.orderData.selectedSubCats = [];
      this.services = [];
      this.orderData.selectedService = "";
      this.requirementForm = "";
      this.modal_size = "md";
      this.form_col_class = "col-lg-12";
      this.attachment_col_class = "col-lg-12";
      this.old_attachments = [];
      this.templateModel = {};
      this.requirements_data = [];
      this.selectedNewDocumentId = null;
      this.newDocumentschema = {};
      this.newTemplateModel = {};
      this.newSelectedDoc_name = null;
      this.requirementForm = null;
      this.schema_keys = [];
    },
  },
  mounted(){
    console.log('this.order_id',this.order_id);
  }
};
</script>

<style lang="scss">
.modal-title,
.close {
  font-size: 2rem;
}
.vue-form-generator .form-control {
  height: calc(2em + 0.95rem + 2px);
}
.field-wrap .wrapper {
  width: 100%;
}
</style>
