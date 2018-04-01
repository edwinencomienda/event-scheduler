<template>
    <v-snackbar
    :timeout="2500"
    :top="true"
    v-model="value"
    :color="snackbarColor"
    >
    {{ snackbarText }}
    <v-btn flat dark  @click.native="snackbar = false">Close</v-btn>
    </v-snackbar>
</template>

<script>
export default {
  data () {
    return {
      snackbar: false
    }
  },
  watch: {
      snackbar () {
        this.$emit('input', this.value)
      }
  },
  props: ['value', 'snackbarColor', 'snackbarText']
}
</script>

