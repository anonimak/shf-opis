<template>
  <b-modal
    id="modal-prevent-closing"
    ref="modal"
    :title="modalTitle"
    @show="getData"
    @hidden="resetModal"
    ok-title="Save"
    @ok="handleOk"
  >
    <form ref="form" @submit.stop.prevent="handleSubmit">
      <b-card-body>
        <b-col col lg="6" md="auto">
          <b-form-group
            id="input-group-title"
            label="Name:"
            label-for="input-title"
            :invalid-feedback="errors.name ? errors.name[0] : ''"
            :state="errors.name ? false : null"
          >
            <b-form-input
              id="input-title"
              type="text"
              name="name"
              v-model="form.name"
              placeholder="Name"
              :state="errors.name ? false : null"
              trim
            ></b-form-input>
          </b-form-group>
          <b-form-group
            id="input-group-title"
            label="Bank Name:"
            label-for="input-title"
            :invalid-feedback="errors.bank_name ? errors.bank_name[0] : ''"
            :state="errors.bank_name ? false : null"
          >
            <b-form-input
              id="input-title"
              type="text"
              name="bank_name"
              v-model="form.bank_name"
              placeholder="Bank Name"
              :state="errors.bank_name ? false : null"
              trim
            ></b-form-input>
          </b-form-group>
          <b-form-group
            id="input-group-title"
            label="Bank Account"
            label-for="input-title"
            :invalid-feedback="
              errors.bank_account ? errors.bank_account[0] : ''
            "
            :state="errors.bank_account ? false : null"
          >
            <b-form-input
              id="input-title"
              type="text"
              name="bank_account"
              v-model="form.bank_account"
              placeholder="Bank Account"
              :state="errors.bank_account ? false : null"
              trim
            ></b-form-input>
          </b-form-group>
          <b-form-group
            id="input-group-title"
            label="Amount:"
            label-for="input-title"
            :invalid-feedback="errors.amount ? errors.amount[0] : ''"
            :state="errors.amount ? false : null"
          >
            <b-form-input
              id="input-title"
              type="number"
              name="amount"
              v-model="form.amount"
              placeholder="amount"
              :state="errors.amount ? false : null"
              trim
            ></b-form-input>
          </b-form-group>
          <b-form-group
            id="input-group-title"
            label="Remark:"
            label-for="input-title"
            :invalid-feedback="errors.remark ? errors.remark[0] : ''"
            :state="errors.remark ? false : null"
          >
            <b-form-input
              id="input-title"
              type="tel"
              name="remark"
              placeholder="Remark"
              v-model="form.remark"
              :state="errors.remark ? false : null"
              trim
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-card-body>
    </form>
  </b-modal>
</template>

<script>
export default {
  props: {
    indexMemo: {
      type: Number,
      default: null,
    },
    errors: {
      type: Object,
      default: {},
    },
  },
  data() {
    return {
      form: {
        name: null,
        bank_name: null,
        bank_account: null,
        amount: null,
        remark: null,
      },
      id_form: null,
      modalTitle: "",
    };
  },
  methods: {
    getData() {
      this.modalTitle = "Add Detail Payment";
    },
    resetModal() {
      this.form = {
        name: null,
        bank_name: null,
        bank_account: null,
        amount: null,
        remark: null,
      };
      this.id_form = null;
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      this.$inertia
        .put(
          route("user.memo.statusmemo.proposepayment", this.indexMemo),
          this.form
        )
        .then(() => {
          if (Object.entries(this.errors).length === 0) {
            console.log("no error");
            this.$nextTick(() => {
              this.$bvModal.hide("modal-prevent-closing");
            });
          }
        });
    },
  },
};
</script>
