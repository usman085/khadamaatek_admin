<template>
  <b-tab title="All Documents">
    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="fullPage"></loading>
    <div class="tab-card">
      <h2 class="tab-card__title">All Documents</h2>
      <p
        class="tab-card__description mb-5"
      >You can save all your documents here that you can use for service order.</p>
      <div class="alert alert-info" v-if="respMessage">{{ respMessage }}</div>

      <b-row>
        <b-col md="6">
          <b-form-select v-model="selectedDoc" :options="options" size="lg" @change="resetForm"></b-form-select>
        </b-col>
        <b-col md="6">
          <b-btn type="primary" size="lg" @click="getDocTemplate(null)">Show Form</b-btn>
        </b-col>
      </b-row>

      <div class="old-documents mt-4" v-if="prevSavedDocuments.length > 0">
        <h2>Saved Documents</h2>
        <b-row>
          <b-col md="6" v-for="(doc, i) in prevSavedDocuments" :key="i">
            <h4
              class="document_name"
              :class="{active:doc.id == selectedSavedDoc}"
              v-text="(i+1) + ') ' + doc.name"
              @click="getDocTemplate(doc.id)"
            ></h4>
          </b-col>
        </b-row>
        <hr />
      </div>
      <div class="form-container mt-4" v-if="Object.keys(schema).length > 0">
        <h2 v-text="document_title"></h2>
        <div class="row">
          <div :class="form_col_class">
            <b-row>
              <b-col md="12">
                <fieldset>
                  <div class="form-group required field-upload">
                    <label for="cnic-copy">
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
                          v-model="selectedDoc_name"
                          size="lg"
                        />
                      </div>
                    </div>
                  </div>
                </fieldset>
              </b-col>
            </b-row>

            <b-row>
              <b-col md="12">
                <form action="#" class="form-container">
                  <vue-form-generator :schema="schema" :model="templateModel"></vue-form-generator>
                </form>
              </b-col>
            </b-row>

            <b-row>
              <b-col md="12">
                <b-button variant="primary" @click="saveDocument" class="saveBtn">Save</b-button>
              </b-col>
            </b-row>
          </div>
          <div :class="attachment_col_class">
            <a
              v-for="(attach, index) in old_attachments"
              :key="index"
              :href="attach.src"
              target="_blank"
            >
              <img :src="getImageSrc(attach.src)" :alt="attach.name" class="img-fluid" />
              <p class="text-center">{{ attach.name }}</p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </b-tab>
</template>

<script>
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
import "vue-form-generator/dist/vfg.css";

export default {
  name: "Documents",
  components: {
    Loading,
  },
  data() {
    return {
      form_col_class: "col-md-12",
      attachment_col_class: "col-md-12",
      old_attachments: [],
      document_title: "New Document",
      selectedSavedDoc: "",
      isLoading: false,
      fullPage: true,
      respMessage: "",
      prevSavedDocuments: [],
      selectedDoc: null,
      selectedDoc_name: null,
      options: [{ value: null, text: "Please select a Document" }],
      templateModel: {},
      schema: {},

      formData: {
        to_account_id: "",
        to_account_num: "",
        amount: "",
      },
    };
  },
  async created() {
    const loggedIn = JSON.parse(localStorage.getItem("user"));
    if (loggedIn && loggedIn.token && loggedIn.user) {
      this.isLoading = true;
      const getUser = await axios
        .get("/documents/get-all")
        .then((response) => {
          // console.log(response);
          let docs = response.data.data;
          if (docs.length > 0) {
            docs.forEach((element) => {
              this.options.push({
                value: element.id,
                text: element.name,
              });
            });
          }
          this.isLoading = false;
        })
        .catch((err) => {
          alert(err.response.data.message);
          this.isLoading = false;
        });
    } else {
      alert("user not logged in!");
    }
  },
  methods: {
    onModelUpdated() {
      // console.log(this.templateModel);
    },

    triggerChange(){
      let old_name = this.selectedDoc_name;
      this.selectedDoc_name = old_name + " ";
      this.selectedDoc_name = old_name;
    },

    resetForm() {
      this.prevSavedDocuments = [];
      this.selectedDoc_name = null;
      this.templateModel = {};
      this.schema = {};
    },

    getImageSrc(path){
      var fileExt = path.split('.').pop().toLowerCase();
      if(fileExt == 'jpg' || fileExt == 'jpeg' || fileExt == 'png' || fileExt == 'gif' || fileExt == 'bmp' ) {
        return path;
      } else{
        return "./images/file.png";
      }
    },

    getDocumentDetail(savedDocId) {
      let self = this;
      this.selectedSavedDoc = savedDocId;
      if (this.selectedSavedDoc) {
        axios
          .get(`/customer/document-detail/${this.selectedSavedDoc}`)
          .then(({ data }) => {
            let templateModelData = JSON.parse(data.document.dataModel);
            this.selectedDoc_name = data.document.name;
            const formSchema = self.schema.fields;
            //
            formSchema.forEach((element) => {
              if (templateModelData.hasOwnProperty(element.model)) {
                if (element.type === "upload") {
                  this.form_col_class = "col-md-8";
                  this.attachment_col_class = "col-md-4";
                  this.old_attachments.push({
                    src:
                      "./customer_documents/" +
                      templateModelData[element.model],
                    name: element.label,
                  });
                  this.templateModel[element.model] =
                    templateModelData[element.model];
                } else {
                  if (element.inputType === "date") {
                    var timestamp = templateModelData[element.model].replace(
                      "dateTimeStamp-",
                      ""
                    );
                    this.templateModel[element.model] = new Date(
                      parseInt(timestamp)
                    ).valueOf();
                    this.templateModel[element.model + "-type"] = "date";
                  } else {
                    this.templateModel[element.model] =
                      templateModelData[element.model];
                  }
                }
              } else {
                this.templateModel[element.model] = "";
              }
            });
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

    saveDocument() {
      let errors = this.validateTemplateData();
      // trigger change due to update value issue in vue form generator
      this.triggerChange();
      const loggedIn = JSON.parse(localStorage.getItem("user"));
      let formData = new FormData();
      for (var property in this.templateModel) {
        formData.append(property, this.templateModel[property]);
      }
      formData.append("document_name", this.selectedDoc_name);
      formData.append("document_id", this.selectedDoc);
      formData.append("user_id", loggedIn.user.id);
      formData.append("user_type", "customer");
      formData.append("template", JSON.stringify(this.templateModel));
      if(this.selectedSavedDoc){
        formData.append("selectedSavedDoc", this.selectedSavedDoc);
      }
      if (!errors) {
        this.isLoading = true;
        axios
          .post("document/savedata", formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then(({ data }) => {
            alert(data.message);
            this.isLoading = false;
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
      }
    },

    validateTemplateData() {
      let error = false;
      this.schema.fields.forEach((element) => {
        if (element.required == true && !error) {
          if (!this.templateModel[element.model]) {
            alert("Please fill the requirement form");
            error = true;
          }
        }
      });

      return error;
    },

    getDocTemplate(customerdoc_id = null) {
      const loggedIn = JSON.parse(localStorage.getItem("user"));
      if (this.selectedDoc && loggedIn.user) {
        this.isLoading = true;
        this.templateModel = {};
        this.form_col_class = "col-md-12";
        this.attachment_col_class = "col-md-12";
        this.old_attachments = [];
        let url = `/documents/get/${this.selectedDoc}/${loggedIn.user.id}`;
        if (customerdoc_id) {
          url += `/${customerdoc_id}`;
        }
        axios
          .get(url)
          .then((response) => {
            // console.log(response.data);
            this.prevSavedDocuments = [];
            this.prevSavedDocuments = response.data.data.oldDocs;
            let templateFields = JSON.parse(response.data.data.document.schema);
            const customer_document = response.data.data.customer_document;
            let templateModelData = null;
            if (customer_document) {
              templateModelData = JSON.parse(customer_document.dataModel);
              this.document_title = "Update Document";
              this.selectedDoc_name = customer_document.name;
            } else {
              this.document_title = "New Document";
              this.selectedDoc_name = "";
            }

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

              //
              if (
                templateModelData &&
                templateModelData.hasOwnProperty(element.model)
              ) {
                if (element.type === "upload") {
                  this.form_col_class = "col-md-8";
                  this.attachment_col_class = "col-md-4";
                  this.old_attachments.push({
                    src:
                      "./customer_documents/" +
                      templateModelData[element.model],
                    name: element.label,
                  });
                  this.templateModel[element.model] =
                    templateModelData[element.model];
                } else {
                  if (element.inputType === "date") {
                    var timestamp = templateModelData[element.model].replace(
                      "dateTimeStamp-",
                      ""
                    );
                    this.templateModel[element.model] = new Date(
                      parseInt(timestamp)
                    ).valueOf();
                    this.templateModel[element.model + "-type"] = "date";
                  } else {
                    this.templateModel[element.model] =
                      templateModelData[element.model];
                  }
                }
              } else {
                this.templateModel[element.model] = "";
              }
            });

            this.schema = {
              fields: templateFields,
            };
            this.selectedSavedDoc = customerdoc_id;
            this.isLoading = false;
          })
          .catch((err) => {
            console.log(err.response);
            alert(err.response.data.message);
            this.isLoading = false;
          });
      } else {
        alert("First Select a Document!!");
      }
    },
  },
};
</script>
<style lang="scss">
.btn {
  font-size: 14px;
}
.custom-select.custom-select-lg {
  font-size: 14px;
}

.form-control {
  height: calc(2em + 0.95rem + 2px);
  font-size: 14px;
}
.saveBtn {
  font-size: 1.4rem;
  padding: 8px 10%;
  border-radius: 5px;
}
.document_name {
  cursor: pointer;
  &.active,
  &:hover {
    color: #ce9718;
  }
}
</style>