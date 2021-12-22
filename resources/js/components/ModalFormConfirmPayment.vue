<template>
  <b-modal
    id="modal-prevent-closing"
    ref="modal"
    :title="title"
    @show="resetModal"
    @hidden="actionHideModal"
    @ok="handleOk"
  >
    <form ref="form" @submit.stop.prevent="handleSubmit">
      <p>{{ caption }}</p>
      <b-form-group label-for="name-input">
        <!-- <b-form-textarea
          v-if="useMessage"
          id="textarea"
          v-model="message"
          placeholder="Enter message..."
          rows="3"
          max-rows="6"
          class="mb-2"
        ></b-form-textarea>
        <b-form-checkbox
          id="checkbox-1"
          v-model="useMessage"
          name="checkbox-1"
          :value="true"
          @change="onChangeCheckMessage"
          :unchecked-value="false"
        >
          With message
        </b-form-checkbox> -->
      </b-form-group>
    </form>
  </b-modal>
</template>
<script>
export default {
  props: ["title", "caption", "idConfirmedPayment", "idItemClicked"],
  data() {
    return {
      useMessage: false,
      message: "",
    };
  },
  methods: {
    actionHideModal() {
      this.$emit("handleHidden", true);
      this.resetModal();
    },
    resetModal() {
      this.message = "";
      this.useMessage = false;
    },
    onChangeCheckMessage(checked) {
      if (!checked) this.message = "";
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
        idConfirmedPayment: this.idConfirmedPayment,
      });
      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide("modal-prevent-closing");
      });
    },
  },
};
</script>
