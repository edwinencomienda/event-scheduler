<template>
<div style="width:100%;">
  <v-card>
    <v-card-title>
      Activities
      <v-spacer></v-spacer>
      <v-text-field
        append-icon="search"
        label="Search"
        single-line
        hide-details
        v-model="search"
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="items"
      :search="search"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.name }}</td>
        <td>{{ props.item.date_from }}</td>
        <td>{{ props.item.date_to }}</td>
        <td>{{ props.item.description }}</td>
        <td style="width:162px;">
            <v-btn @click="showForm('edit', props.item)" flat icon color="primary">
              <v-icon>create</v-icon>
            </v-btn>
            <v-btn  @click="showDeleteModal(props.item)" flat icon dark color="red">
              <v-icon>delete</v-icon>
            </v-btn>
        </td>
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </v-data-table>
  </v-card>


   <v-dialog v-model="deleteModal" max-width="290">
      <v-card>
        <v-card-title class="headline">Are you sure to delete?</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" flat="flat" @click.native="deleteModal = false">Disagree</v-btn>
          <v-btn color="primary" flat="flat" @click.native="deleteRecord">Agree</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

<v-dialog v-model="dialog" persistent max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">{{ mode === 'add' ? 'Create' : 'Update' }} Activity</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
                <v-flex xs12>
                  <v-text-field
                  label="Event Name"
                  v-model="eventName"
                  required
                  ></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-menu
                        ref="dateFromMenu"
                        lazy
                        :close-on-content-click="false"
                        v-model="dateFromMenu"
                        transition="scale-transition"
                        offset-y
                        full-width
                        :nudge-right="40"
                        min-width="290px"
                        :return-value.sync="dateFrom"
                    >
                        <v-text-field
                        slot="activator"
                        label="Date From"
                        v-model="dateFrom"
                        prepend-icon="event"
                        readonly
                        ></v-text-field>
                        <v-date-picker v-model="dateFrom" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="dateFromMenu = false">Cancel</v-btn>
                        <v-btn flat color="primary" @click="$refs.dateFromMenu.save(dateFrom)">OK</v-btn>
                        </v-date-picker>
                    </v-menu>
              </v-flex>
                <v-flex xs12>
                  <v-menu
                        ref="dateToMenu"
                        lazy
                        :close-on-content-click="false"
                        v-model="dateToMenu"
                        transition="scale-transition"
                        offset-y
                        full-width
                        :nudge-right="40"
                        min-width="290px"
                        :return-value.sync="dateTo"
                    >
                        <v-text-field
                        slot="activator"
                        label="Date To"
                        v-model="dateTo"
                        prepend-icon="event"
                        readonly
                        ></v-text-field>
                        <v-date-picker v-model="dateTo" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="dateToMenu = false">Cancel</v-btn>
                        <v-btn flat color="primary" @click="$refs.dateToMenu.save(dateTo)">OK</v-btn>
                        </v-date-picker>
                    </v-menu>
              </v-flex>
              <v-flex xs12>
                  <v-text-field
                    v-model="description"
                    name="input-1"
                    label="Description"
                    :multi-line="true"
                    id="testing"
                  ></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" flat @click="submitForm">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


    <v-fab-transition>
      <v-btn
        @click="showForm('add')"
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


</div>
</template>

<script>
  export default {
    data () {
      return {
        search: '',
        headers: [
          { text: 'Name', value: 'name' },
          { text: 'Date From', value: 'date_from' },
          { text: 'Date To', value: 'date_to' },
          { text: 'Description', value: 'description' },
          { text: '', value: '' },
        ],
        items: [],
        dialog: false,
        dateFrom: '',
        dateFromMenu: false,
        dateTo: '',
        dateToMenu: false,
        eventName: '',
        snackbar: false,
        snackbarText: '',
        snackbarColor: '',
        description: '',
        deleteItem: '',
        deleteModal: false,
        mode: 'add',
        activityId: ''
      }
    },
    created () {
      this.getItems()
    },
    methods: {
      showForm (mode, data = '') {
         if (mode === 'edit') {
           this.mode = mode
           this.eventName = data.name
           this.dateFrom = data.date_from
           this.dateTo = data.date_to
           this.description = data.description
           this.activityId = data.id
           this.dialog = true
         } else {
           this.mode = 'add'
           this.resetForm()
           this.dialog = true
         }
      },
      submitForm () {
        if (this.mode === 'add') {
          this.createActivity()
        } else {
          this.updateActivity()
        }
      },
      showDeleteModal (item) {
        this.deleteItem = item
        this.deleteModal = true
      },
      async deleteRecord () {
        try {
          const response = await axios.delete('/api/activity/' + this.deleteItem.id)
          this.getItems()
          this.snackbarText = 'Activity Successfully Deleted.'
          this.snackbarColor = 'success'
          this.snackbar = true
          this.deleteModal = false
        } catch (error) {
          // fails
        }
      },
      async getItems () {
        try {
          const response = await axios.get('/api/activity?upcoming=true')
          this.items = response.data
        } catch (error) {
          // fails
        }
      },
      async createActivity () {
        try {
          let formData = {
            name: this.eventName,
            date_from: this.dateFrom,
            date_to: this.dateTo,
            course_id: '',
            description: this.description
          }
          const response = await axios.post('/api/activity', formData)
          this.dialog = false
          this.snackbarText = 'Activity Successfully Created.'
          this.snackbarColor = 'success'
          this.snackbar = true
          this.getItems()
          this.resetForm()
        } catch (error) {
          this.snackbarText = 'Something went wrong.'
          this.snackbarColor = 'error'
          this.snackbar = true
        }
      },
      async updateActivity () {
        try {
          let formData = {
            id: this.activityId,
            name: this.eventName,
            date_from: this.dateFrom,
            date_to: this.dateTo,
            course_id: '',
            description: this.description,
            _method: 'put'
          }
          const response = await axios.post('/api/activity/' + this.activityId, formData)
          this.dialog = false
          this.snackbarText = 'Activity Successfully Updated.'
          this.snackbarColor = 'success'
          this.snackbar = true
          this.resetForm()
          this.getItems()
        } catch (error) {
          this.snackbarText = 'Something went wrong.'
          this.snackbarColor = 'error'
          this.snackbar = true
        }
      },
      resetForm () {
        this.eventName = ''
        this.dateFrom = ''
        this.dateTo = ''
        this.description = ''
        this.activityId = ''
      }
    }
  }
</script>