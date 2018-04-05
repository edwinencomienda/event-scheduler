<template>
<div style="width:100%;">
  <v-card>
    <v-card-title>
      Deans
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
        <td>{{ props.item.gender }}</td>
        <td>{{ props.item.email }}</td>
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </v-data-table>
  </v-card>


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

  <v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Add Dean User</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12>
                <v-text-field v-model="first_name" label="Firt Name" required></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-text-field v-model="last_name" label="Last Name" required></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-select
                  label="Course"
                  required
                  v-model="course_id"
                  autocomplete
                  item-text="name"
                  item-value="id"
                  :items="courses"
                ></v-select>
              </v-flex>
              <v-flex xs12>
                <v-text-field v-model="email" type="email" label="Email" required></v-text-field>
              </v-flex>
               <v-flex xs12>
                <v-text-field v-model="password" type="password" label="Passowrd" required></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" flat @click.native="register">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>



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
          { text: 'Gender', value: 'gender' },
          { text: 'Email', value: 'email' },
        ],
        items: [],
        dialog: false,
        courses: [],
        course_id: '',
        first_name: '',
        last_name: '',
        email: '',
        password: ''
      }
    },
    created () {
      this.getItems()
      this.getCourses()
    },
    methods: {
      async getItems () {
        try {
          const response = await axios.get('/api/user?role=dean')
          this.items = response.data
        } catch (error) {
          // fails
        }
      },
      async register () {
        try {
          const formData = {
            first_name: this.first_name,
            last_name: this.last_name,
            email: this.email,
            password: this.password,
            course_id: this.course_id,
            role: 'dean',
            gender: 'Male'
          }
          const response = await axios.post('/api/auth/register', formData)
          this.getItems()
          this.first_name = ''
          this.last_name = ''
          this.email = ''
          this.password = ''
          this.course_id = ''
          this.dialog = false
        } catch (error) {
          // fails
        }
      },
      async getCourses () {
        try {
          const response = await axios.get('/api/course')
          this.courses = response.data
        } catch (error) {
          // fails
        }
      }
    }
  }
</script>