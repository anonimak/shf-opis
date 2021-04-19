<template>
  <div class="col-12">
        <b-card>
            <b-form @submit="onSubmit">
            <b-form-group
                id="input-group-caption"
                label="Caption slider:"
                label-for="input-caption"
            >
                <b-form-input
                id="input-caption"
                type="text"
                required
                placeholder="Masukan caption"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-text"
                label="Text slider:"
                label-for="input-text"
            >
                <b-form-textarea
                id="input-text"
                placeholder="Masukan text deskripsi..."
                rows="3"
                max-rows="6"
                ></b-form-textarea>
            </b-form-group>


            <b-form-group
                id="input-group-text"
                label="Pilih Gambar slider:"
                label-for="input-1"
                >
            <b-form-file
                v-model="file1"
                :state="Boolean(file1)"
                placeholder="Masukan Gambar slider..."
            ></b-form-file>
            
            </b-form-group>
            <b-form-group label="Apakah akan di tampilkan ?">
                <b-form-radio name="some-radios" v-model="selected" value="1" >Ya</b-form-radio>
                <b-form-radio name="some-radios" v-model="selected" value="0">Tidak</b-form-radio>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
            </b-form>    
        </b-card>
    </div>
                       
</template>

<script>
export default {
    data(){
        return{
            file1: null,
            selected: '1',
        }
    },

    methods: {
        onSubmit(evt) {
        evt.preventDefault()
        alert(JSON.stringify(this.form))
      },
        onReset(evt) {
          evt.preventDefault()
          // Reset our form values
          this.form.email = ''
          this.form.name = ''
          this.form.food = null
          this.form.checked = []
          // Trick to reset/clear native browser form validation state
          this.show = false
          this.$nextTick(() => {
            this.show = true
          })
      }
    },
}
</script>

<style>

</style>