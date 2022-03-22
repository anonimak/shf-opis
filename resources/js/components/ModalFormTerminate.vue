<template>
  <b-modal
    id="modal-terminate"
    ref="modal"
    :title="title"
    @show="resetModal"
    @hidden="actionHideModal"
    @ok="handleOk"
  >
    <form ref="form" @submit.stop.prevent="handleSubmit">
      <p>{{ caption }}</p>
      <b-form-group label-for="name-input">
        <label for="terminate-datepicker">Choose a date</label>
        <b-form-datepicker
          id="terminate-datepicker"
          :date-format-options="{
            year: 'numeric',
            month: 'numeric',
            day: 'numeric',
          }"
          locale="id"
          v-model="terminate_date"
          class="mb-2"
        ></b-form-datepicker>
      </b-form-group>
    </form>
    <template #modal-footer="{ ok, hide }">
      <b-button size="sm" variant="secondary" @click="hide('forget')">
        Cancel
      </b-button>
      <b-button size="sm" variant="danger" @click="ok()"> TERMINATE </b-button>
    </template>
  </b-modal>
</template>
<script>
export default {
  props: ["title", "caption", "idItemClicked"],
  data() {
    return {
      useMessage: false,
      terminate_date: "",
    };
  },
  methods: {
    actionHideModal() {
      this.$emit("handleHidden", true);
      this.resetModal();
    },
    resetModal() {
      this.terminate_date = "";
      this.useMessage = false;
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      this.$emit("handleOk", {
        id: this.idItemClicked,
        terminated_at: this.terminate_date,
      });
      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide("modal-prevent-closing");
      });
    },
  },
};
</script>
