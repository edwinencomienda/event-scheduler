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
        <td>{{ props.item.date }}</td>
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </v-data-table>
  </v-card>
</div>
</template>

<script>
  export default {
    data () {
      return {
        search: '',
        headers: [
          { text: 'Name', value: 'name' },
          { text: 'Date', value: 'date' },
        ],
        items: []
      }
    },
    created () {
      this.getItems()
    },
    methods: {
      async getItems () {
        try {
          const response = await axios.get('/api/activity')
          this.items = response.data
        } catch (error) {
          // fails
        }
      }
    }
  }
</script>