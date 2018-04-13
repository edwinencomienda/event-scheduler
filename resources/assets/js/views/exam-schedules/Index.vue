<template>
<div style="width:100%;">
  <v-card>
    <v-card-title>
      Exam Schedules
      <v-spacer></v-spacer>
      <v-text-field
        append-icon="search"
        label="Search"
        single-line
        hide-details
        v-model="search"
      ></v-text-field>
      <a :href="baseUrl + '/api/file/download/exam-schedules'">
      <v-btn flat icon color="primary">
              <v-icon>print</v-icon>
      </v-btn>
      </a>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="items"
      :search="search"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.subject && props.item.subject.code }}</td>
        <td>{{ props.item.subject.description }}</td>
        <td>{{ props.item.date }}</td>
        <td>{{ props.item.time_start }}</td>
        <td>{{ props.item.time_end }}</td>
        <td>{{ props.item.section && props.item.section.code }}</td>
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </v-data-table>
  </v-card>

<v-dialog v-model="dialog" persistent max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Exam Schedule</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12>
                <v-select
                  label="Subject"
                  required
                  v-model="subjectId"
                  autocomplete
                  item-text="code"
                  item-value="id"
                  :items="subjects"
                ></v-select>
              </v-flex>
              <v-flex xs12>
                  <v-menu
                        ref="dateMenu"
                        lazy
                        :close-on-content-click="false"
                        v-model="menu"
                        transition="scale-transition"
                        offset-y
                        full-width
                        :nudge-right="40"
                        min-width="290px"
                        :return-value.sync="date"
                    >
                        <v-text-field
                        slot="activator"
                        label="Exam Date"
                        v-model="date"
                        prepend-icon="event"
                        readonly
                        ></v-text-field>
                        <v-date-picker v-model="date" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                        <v-btn flat color="primary" @click="$refs.dateMenu.save(date)">OK</v-btn>
                        </v-date-picker>
                    </v-menu>
              </v-flex>
              <v-flex xs6>
                    <v-menu
                        ref="timeStartMenu"
                        lazy
                        :close-on-content-click="false"
                        v-model="timeStartMenu"
                        transition="scale-transition"
                        offset-y
                        full-width
                        :nudge-right="40"
                        max-width="290px"
                        min-width="290px"
                        :return-value.sync="timeStart"
                    >
                        <v-text-field
                        slot="activator"
                        label="Time Start"
                        v-model="timeStart"
                        prepend-icon="access_time"
                        readonly
                        ></v-text-field>
                        <v-time-picker v-model="timeStart" @change="$refs.timeStartMenu.save(timeStart)"></v-time-picker>
                    </v-menu>
              </v-flex>
              <v-flex xs6>
                    <v-menu
                        ref="timeEndMenu"
                        lazy
                        :close-on-content-click="false"
                        v-model="timeEndMenu"
                        transition="scale-transition"
                        offset-y
                        full-width
                        :nudge-right="40"
                        max-width="290px"
                        min-width="290px"
                        :return-value.sync="timeEnd"
                    >
                        <v-text-field
                        slot="activator"
                        label="Time End"
                        v-model="timeEnd"
                        prepend-icon="access_time"
                        readonly
                        ></v-text-field>
                        <v-time-picker v-model="timeEnd" @change="$refs.timeEndMenu.save(timeEnd)"></v-time-picker>
                    </v-menu>
              </v-flex>
              <v-flex xs12>
                <v-select
                  label="Room"
                  required
                  v-model="roomId"
                  autocomplete
                  item-text="name"
                  item-value="id"
                  :items="rooms"
                ></v-select>
              </v-flex>
              <v-flex xs12>
                <v-select
                  label="Section"
                  required
                  v-model="sectionId"
                  autocomplete
                  item-text="code"
                  item-value="id"
                  :items="sections"
                ></v-select>
              </v-flex>
              <v-flex xs12>
                <v-select
                  label="Proctor"
                  required
                  v-model="proctorId"
                  autocomplete
                  item-text="name"
                  item-value="id"
                  :items="users"
                ></v-select>
              </v-flex>
            </v-layout>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" flat @click="createSchedule">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


      <v-fab-transition>
      <v-btn
        @click="dialog = true"
        color="primary"
        dark
        fab
        fixed
        bottom
        right
      >
        <v-icon>add</v-icon>
        <v-icon>close</v-icon>
      </v-btn>
    </v-fab-transition>


    <v-snackbar
    :timeout="3000"
    :top="true"
    v-model="snackbar"
    :color="snackbarColor"
    >
    {{ snackbarText }}
    <v-btn flat dark  @click.native="snackbar = false">Close</v-btn>
    </v-snackbar>

</snack-bar-alert>

</div>
</template>

<script>
  export default {
    data () {
      return {
        search: '',
        headers: [
          { text: 'Subject Code', value: 'subject.code' },
          { text: 'Subject Description', value: 'subject.description' },
          { text: 'Date', value: 'date' },
          { text: 'Time Start', value: 'time_start' },
          { text: 'Time End', value: 'time_end' },
          { text: 'Section', value: 'section.code' }
        ],
        items: [],
        dialog: false,
        users: [],
        subjects: [],
        rooms: [],
        sections: [],
        date: null,
        menu: false,
        time: null,
        timeStartMenu: false,
        timeEndMenu: false,
        timeStart: null,
        timeEnd: null,
        subjectId: '',
        proctorId: '',
        roomId: '',
        snackbar: false,
        snackbarColor: '',
        snackbarText: '',
        sectionId: '',
        baseUrl: document.head.querySelector('meta[name="base-url"]').content
      }
    },
    created () {
      this.getItems()
      this.getSubjects ()
      this.getUsers()
      this.getRooms()
      this.getSections()
    },
    methods: {
      async getItems () {
        try {
          const response = await axios.get('/api/exam-schedule')
          this.items = response.data
        } catch (error) {
          // fails
        }
      },
      async getSubjects () {
        try {
          const response = await axios.get('/api/subject')
          this.subjects = response.data
        } catch (error) {
          // fails
        }
      },
      async getUsers () {
        try {
          const response = await axios.get('/api/user?role=instructor')
          this.users = response.data
        } catch (error) {
          // fails
        }
      },
      async getRooms () {
        try {
          const response = await axios.get('/api/room')
          this.rooms = response.data
        } catch (error) {
          // fails
        }
      },
      async getSections () {
        try {
          const response = await axios.get('/api/section')
          this.sections = response.data
        } catch (error) {
          // fails
        }
      },
      async createSchedule () {
        try {
          const formData  = {
            subject_id: this.subjectId,
            proctor_id: this.proctorId,
            time_start: this.timeStart,
            time_end: this.timeEnd,
            date: this.date,
            room_id: this.roomId,
            section_id: this.subjectId
          }
          const response = await axios.post('/api/exam-schedule', formData)
          this.subjectId = ''
          this.proctorId = ''
          this.timeStart = null
          this.timeEnd = null
          this.date = ''
          this.roomId = ''
          this.subjectId = ''
          this.dialog = false
          this.snackbarText = 'Exam Schedule Successfully Created.'
          this.snackbarColor = 'success'
          this.snackbar = true
          this.getItems()
        } catch (error) {
          this.snackbarText = 'Something went wrong.'
          this.snackbarColor = 'error'
          this.snackbar = true
        }
      }
    }
  }
</script>