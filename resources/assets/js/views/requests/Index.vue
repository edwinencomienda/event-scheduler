<template>
<div style="width:100%;">
  <v-card>
    <v-card-title>
      Requests
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
      :expand="true"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.name }}</td>
        <td>{{ props.item.email }}</td>
        <td>{{ props.item.course && props.item.course.name }}</td>
        <td>{{ props.item.year_level }}</td>
        <td>{{ props.item.role }}</td>
        <td>Pending</td>
        <td>
          <v-menu offset-y>
            <v-icon slot="activator">more_vert</v-icon>
            <v-list>
              <v-list-tile @click="approveRequest(props.item.id)">
                <v-list-tile-title>Approve Request</v-list-tile-title>
              </v-list-tile>
            </v-list>
          </v-menu>
        </td>
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </v-data-table>
  </v-card>

    <v-snackbar
    :timeout="2500"
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
          {
            text: 'Name',
            align: 'left',
            sortable: false,
            value: 'name'
          },
          { text: 'Email', value: 'email' },
          { text: 'Course', value: 'course' },
          { text: 'Year Level', value: 'year_level' },
          { text: 'Role', value: 'role' },
          { text: 'Account Status', value: 'active' },
          { sortable: false }
        ],
        items: [],
        snackbarText: '',
        snackbarColor: '',
        snackbar: false
      }
    },
    created () {
      this.getItems()
    },
    methods: {
      async getItems () {
        try {
          const response = await axios.get('/api/user?inactive=true')
          this.items = response.data
        } catch (error) {
          // fails
        }
      },
      async approveRequest (user_id) {
        try {
          const response = await axios.post('/api/admin/approve/user-request', { user_id })
          this.snackbarText = 'Request Successfully Approved.'
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