<template>
  <div style="width:100%;">
      <v-card>
          <v-card-title>Settings</v-card-title>
           <v-container>
             <v-layout row wrap>
                <v-flex xs12>
                    <v-form v-model="valid">
                      <!-- <v-text-field
                        label="File"
                        type="file"
                        required
                        @change="onFileChange"
                      ></v-text-field> -->
                      <!-- <upload-file v-model="file"></upload-file> -->
                      <input type="file" class="" @change="onFileChange"> <br><br>
                      <v-btn :loading="uploading" :disabled="uploading"  @click="submit" color="primary">Import</v-btn>
                      <small v-show="uploading">This may take a few minutes</small>
                    </v-form>
                    <v-snackbar
                      :timeout="2500"
                      :top="true"
                      v-model="snackbar"
                      :color="snackbarColor"
                    >
                      {{ snackbarText }}
                      <v-btn flat dark  @click.native="snackbar = false">Close</v-btn>
                    </v-snackbar>
                </v-flex>
              </v-layout>
           </v-container>
      </v-card>
  </div>
</template>

<script>
import UploadFile from '../../components/UploadFile'

export default {
  data () {
    return {
       valid: true,
       file: '',
       uploading: false,
       snackbar: false,
       snackbarText: '',
       snackbarColor: ''
    }
  },
  components: {
    'upload-file': UploadFile
  },
  methods: {
    async submit () {
      try {
        const formData = new FormData
        formData.set('file', this.file)
        this.uploading = true
        const response = await axios.post('/api/file/import/students', formData)
        this.uploading = false
        this.snackbarText = 'Import Successful'
        this.snackbarColor = 'success'
        this.snackbar = true
      } catch (error) {
        this.uploading = false
        this.snackbarText = 'Import Failed'
        this.snackbarColor = 'error'
        this.snackbar = true
      }
    },
    onFileChange (e) {
      this.file = e.target.files[0]
      console.log(e)
    }
  }
}
</script>
