<template>
  <v-card>
    <v-data-table
      :page.sync="page"
      @page-count="pageCount = $event"
      :items="students"
      :headers="headers"
      hide-default-footer
    >
      <template v-slot:item.name="{ item }">
        <v-btn text color="primary">
          <router-link
            class="profile-link"
            active-class="active"
            :exact="true"
            :to="{name: 'StudentProfile'}"
          >{{item.name}}</router-link>
        </v-btn>
      </template>
      <template v-slot:item.assessment="{ item }">
        <v-btn text color="#5E5EEA">{{item.assessment}}</v-btn>
      </template>
      <template v-slot:item.action="{ item }">
        <v-btn elevation="1" fab small>
          <v-icon dark>mdi-plus</v-icon>
        </v-btn>
      </template>
    </v-data-table>
    <div class="pa-2 d-flex justify-end">
      <span class="pa-2">
        Total Enquiries
        <span
          :style="{'color':this.$vuetify.theme.themes.light.primary}"
        >{{students.length+1}}</span>
      </span>
      <v-spacer></v-spacer>
      <v-pagination circle v-model="page" :length="pageCount"></v-pagination>
    </div>
  </v-card>
</template>

<script>
export default {
  name: "EnquiryTable",
  data() {
    return {
      page: 1,
      pageCount: 3,
      itemsPerPage: 10,
      headers: [
        { text: "SRNO", sortable: true, value: "srno" },
        { text: "Name", value: "name", sortable: true },
        { text: "Father Name", value: "father_name", sortable: true },
        { text: "Phone Number", value: "phone_number", sortable: true },
        { text: "Class", value: "class", sortable: true },
        { text: "Assessment", value: "assessment", sortable: true },
        { text: "Enquiry At", value: "enquiry_at", sortable: true },
        { text: "Action", value: "action", sortable: true }
      ],
      students: [
        {
          srno: 1,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 1
        },
        {
          srno: 2,
          name: "Kylen",
          father_name: "Niklon",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 2
        },
        {
          srno: 3,
          name: "Hikron",
          father_name: "Nilkon",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 3
        },
        {
          srno: 4,
          name: "Zenstr",
          father_name: "Istrek",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 4
        },
        {
          srno: 5,
          name: "Frestrak",
          father_name: "Sarcel",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 5
        },
        {
          srno: 6,
          name: "Toka",
          father_name: "Kirishama",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 6
        },
        {
          srno: 7,
          name: "Hide",
          father_name: "Youshi",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 7
        },
        {
          srno: 8,
          name: "Silsan",
          father_name: "Mendlas",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 8
        },
        {
          srno: 9,
          name: "Treslon",
          father_name: "Chilron",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 10,
          name: "zerfolen",
          father_name: "skline",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        },
        {
          srno: 11,
          name: "Kei",
          father_name: "Nagae",
          phone_number: "+92323-45656565y",
          class: "A Level",
          assessment: "Open",
          enquiry_at: "06/05/2020",
          action: null,
          stdid: 10
        }
      ]
    };
  }
};
</script>

<style scoped>
</style>