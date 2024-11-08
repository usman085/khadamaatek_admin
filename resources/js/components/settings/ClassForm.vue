<template>
  <v-card>
    <v-form>
      <v-container>
        <fieldset>
          <v-row>
            <v-col cols="12" sm="6" md="6">
              <label class="custom-label">Class Name</label>
              <v-text-field v-model="selectedClass" label="Class" placeholder="Class" solo></v-text-field>
            </v-col>

            <v-col cols="12" sm="6" md="6">
              <label class="custom-label">Subjects</label>
              <v-select
                v-model="selectSubject"
                :items="subjects"
                label="Choose Subject"
                placeholder="Choose Subject"
                solo
                multiple
              ></v-select>
            </v-col>

            <v-col cols="12" sm="6" md="6">
              <label class="custom-label">Total Fare</label>
              <v-text-field
                v-model="fare"
                hint="Charges based on the per hour session"
                persistent-hint
                label="Fare"
                placeholder="Fare"
                solo
              ></v-text-field>
            </v-col>

            <v-col cols="12">
              <v-btn color="#6A158E" dark>Save</v-btn>
            </v-col>
          </v-row>
        </fieldset>
      </v-container>
    </v-form>
  </v-card>
</template>

<script>
export default {
  name: "ClassForm",
  data() {
    return {
      selectedClass: "",
      fare: "",
      selectSubject: "",
      subjects: ["English", "Math", "Science", "Physics", "Chemistry"]
    };
  }
};
</script>

<style lang="scss" scoped>
fieldset {
  border: 0;
  &:not(:last-of-type) {
    border-bottom: 1px dashed #8898aa80;
    margin-bottom: 20px;
  }

  & legend {
    font: Bold 20px/25px Lato;
    color: #172b4d;
  }

  & label {
    font: Bold 15px/40px Lato;
    color: #172b4d;
  }
}
</style>