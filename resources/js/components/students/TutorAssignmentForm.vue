<template>
  <v-dialog @click:outside="$emit('closeDialog',true)" v-model="dialog" max-width="600px">
    <v-card>
      <v-toolbar flat elevation="1">
        <v-spacer></v-spacer>
        <v-toolbar-title class="primary--text">Discount Offers</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-card-text>
        <div class="tutor-assign-grid-header mt-4">
          <div class="pr-2 flex-grow-1">
            <span class="py-1">Name</span>
            <v-text-field full-width value="Kei Nagae" solo></v-text-field>
          </div>
          <div class="pr-2">
            <span class="py-1">Class</span>
            <v-select v-model="selected_class" :items="classes" solo></v-select>
          </div>
          <span style="width: 50px"></span>
        </div>

        <div style="max-height: 400px" class="scrolled tutor-assign-grid">
          <template v-for="(assigned,i) in assigned_tutor_subjects">
            <div class="pr-2" v-bind:key="i">
              <span class="py-1">Subject</span>
              <v-select v-model="assigned_tutor_subjects[i].subject" :items="subjects" solo></v-select>
            </div>
            <div class="pr-2" v-bind:key="'A'+ i">
              <span class="py-1">Tutor</span>
              <v-select
                v-model="assigned_tutor_subjects[i].teacher"
                :items="teachers"
                id="tutor-assign-select"
                solo
              >
                <template slot="selection" slot-scope="data">
                  <span>{{data.item.info.name}}</span>
                  <!-- <v-btn>{{data.item.info.name}}</v-btn> -->
                </template>

                <template slot="item" slot-scope="data">
                  <span class="tutor-option">
                    <div class="tutor-option__info">
                      <span class="tutor-option__name">{{data.item.info.name}}</span>
                      <span class="tutor-option__time">{{ data.item.info.avail_time }}</span>
                      <span class="tutor-option__days">{{ data.item.info.avail_days }}</span>
                    </div>

                    <div class="tutor-option__rating">{{ data.item.info.rating }}</div>
                  </span>
                </template>
              </v-select>
            </div>
            <v-btn
              class="grid-align-center"
              v-bind:key="'B'+ i"
              @click="assigned_tutor_subjects.push({subject: null, teacher: null })"
              v-if="i==0"
              fab
              color="primary"
              small
            >
              <v-icon>mdi-plus</v-icon>
            </v-btn>
            <v-btn
              class="grid-align-center"
              v-bind:key="'C'+ i"
              @click="assigned_tutor_subjects.splice(i,1)"
              v-else
              fab
              color="error"
              small
            >
              <v-icon>mdi-minus</v-icon>
            </v-btn>
          </template>
        </div>
      </v-card-text>
      <v-card-actions>
        <v-btn>Cancel</v-btn>
        <v-spacer></v-spacer>
        <v-btn color="primary">Assigned</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "TutorAssignmentForm",
  props: {
    dialog: false
  },
  data() {
    return {
      classes: [
        {
          text: "O Level",
          value: "olvel"
        },
        {
          text: "A Level",
          value: "Alvel"
        }
      ],
      selected_class: {
        text: "O Level",
        value: "olvel"
      },
      teachers: [
        {
          info: {
            name: "Kelzen Kack",
            avail_time: "11:00 AM to 01:00PM",
            avail_days: "Mon, Wed, Fri",
            rating: 5
          },
          value: 1
        },
        {
          info: {
            name: "Tysen keak",
            avail_time: "11:00 AM to 01:00PM",
            avail_days: "Mon, Wed, Fri",
            rating: 5
          },
          value: 2
        },
        {
          info: {
            name: "Kruklin",
            avail_time: "11:00 AM to 01:00PM",
            avail_days: "Mon, Wed, Fri",
            rating: 5
          },
          value: 3
        },
        {
          info: {
            name: "Trck zen",
            avail_time: "11:00 AM to 01:00PM",
            avail_days: "Mon, Wed, Fri",
            rating: 5
          },
          value: 4
        }
      ],
      subjects: [
        {
          text: "Dummy a",
          value: 0
        },
        {
          text: "Dummy b",
          value: 2
        },
        {
          text: "Dummy c",
          value: 3
        },
        {
          text: "Dummy d",
          value: 4
        },
        {
          text: "Dummy e",
          value: 5
        }
      ],
      assigned_tutor_subjects: [
        {
          subject: null,
          teacher: null
        },
        {
          subject: null,
          teacher: null
        }
      ]
    };
  }
};
</script>

<style lang="scss">
.tutor-assign-grid-header {
  display: grid;
  grid-template-columns: 1fr 1fr fit-content(50px);
}
.grid-align-center {
  align-self: center;
}
.tutor-assign-grid {
  display: grid;
  grid-template-columns: 1fr 1fr fit-content(50px);
}

.v-list-item {
  & .tutor-option {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;

    &__info {
      display: flex;
      flex-direction: column;
    }

    &__name {
      font: 600 13px/20px Segoe UI;
      color: #172b4d;
    }

    &__time,
    &__days {
      font: 500 10px/16px Segoe UI;
      color: #0e0edff7;
    }

    &__days {
      color: #172b4db3;
    }

    &__rating {
      background: #f2a711;
      border-radius: 5px;
      padding: 2px 5px;
      color: #fff;
      font: 600 9px/12px Segoe UI;
    }
  }
}
</style>