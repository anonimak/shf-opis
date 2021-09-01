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
                <b-form-checkbox
                    id="checkbox-1"
                    v-model="useMessage"
                    name="checkbox-1"
                    :value="true"
                    :unchecked-value="false"
                >
                    With message
                </b-form-checkbox>
                <b-form-textarea
                    v-if="useMessage"
                    id="textarea"
                    v-model="message"
                    placeholder="Enter message..."
                    rows="3"
                    max-rows="6"
                ></b-form-textarea>
            </b-form-group>
        </form>
    </b-modal>
</template>
<script>
export default {
    props: ["title", "caption", "variant", "idItemClicked"],
    data() {
        return {
            useMessage: false,
            message: ""
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
        handleOk(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        handleSubmit() {
            this.$emit("handleOk", {
                message: this.message,
                id: this.idItemClicked,
                variant: this.variant
            });
            // Hide the modal manually
            this.$nextTick(() => {
                this.$bvModal.hide("modal-prevent-closing");
            });
        }
    }
};
</script>
