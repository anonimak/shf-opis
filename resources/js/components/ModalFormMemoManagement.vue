<template>
  <b-modal
    id="modal-edit-memo"
    ref="modal"
    :title="title"
    @shown="getData"
    @hidden="resetModal"
    @ok="handleOk"
    no-close-on-backdrop
  >
    <b-overlay
      :show="isModalformbusy"
      opacity="0.6"
      spinner-small
      spinner-variant="primary"
    >
      <b-form ref="form" @submit.prevent="handleSubmit">
        <b-form-group
          id="input-group-title"
          label="Takeover Memo:"
          label-for="input-title"
        >
          <v-select
            label="employee_name"
            placeholder="-- Edit Takeover Memo --"
            :get-option-label="getOptionLabel"
            :options="dataPositions"
            v-model="form.id_employee2"
            :reduce="(position) => position.id_employee"
          ></v-select>
        </b-form-group>
        <b-form-group
          id="input-group-title2"
          label="Confirmer Payment:"
          label-for="input-title"
        >
          <v-select
            label="employee_name2"
            placeholder="-- Edit Confirmer Payment --"
            :get-option-label="getOptionLabel"
            :options="dataPositions"
            v-model="form.id_confirmed_payment"
            :reduce="(position) => position.id_employee"
          >
          </v-select>
        </b-form-group>
        <b-form-group
          id="input-group-title3"
          label="Type Memo:"
          label-for="input-title"
        >
          <v-select
            label="name"
            placeholder="-- Edit Type Memo --"
            :options="dataTypeMemo"
            v-model="form.id_type_memo"
            :reduce="(type_memo) => type_memo.id"
            @input="onChangeTypememo"
          >
            <template v-slot:option="option">
              {{ option.name }}
              <span
                v-if="!option.id_department"
                class="font-weight-bold font-italic"
              >
                (General Memo)</span
              >
            </template>
          </v-select>
        </b-form-group>
      </b-form>
    </b-overlay>
  </b-modal>
</template>
<script>
export default {
  props: [
    "title",
    "indexMemo",
    "idTakeover",
    "idEmployee",
    "idTypeMemo",
    "idConfirmerPayment",
    "__update",
  ],
  data() {
    return {
      form: {
        id_employee2: null,
        id_type_memo: null,
        id_confirmed_payment: null,
      },
      url_positions: "super.api.employee.positions",
      url_typememo: "super.api.memo.type_memo",
      dataPositions: [],
      dataTypeMemo: [],
      isModalformbusy: false,
    };
  },
  methods: {
    getData() {
      Promise.all([this.getDataPositions(), this.getDataTypeMemo()]).then(
        (results) => {
          this.dataPositions = results[0].data;
          this.dataTypeMemo = results[1].data;
          this.form.id_type_memo = this.idTypeMemo;

          let itemTypeMemo = _.find(this.dataTypeMemo, typeMemo => typeMemo.id == this.idTypeMemo);
          this.form.id_employee2 = (this.idTakeover)? this.idTakeover : itemTypeMemo.id_overtake_memo;
          this.form.id_confirmed_payment = (this.idConfirmerPayment) ? this.idConfirmerPayment : itemTypeMemo.id_confirmed_payment_by;
        }
      );
    },
    onChangeTypememo() {
      let itemTypeMemo = _.find(this.dataTypeMemo, typeMemo => typeMemo.id == this.form.id_type_memo);
      this.form.id_employee2 = (itemTypeMemo && itemTypeMemo.id_overtake_memo) ? itemTypeMemo.id_overtake_memo : null;

      this.form.id_confirmed_payment = (itemTypeMemo && itemTypeMemo.id_confirmed_payment_by) ? itemTypeMemo.id_confirmed_payment_by : null;
    },
    getOptionLabel(option) {
      let firstname = option.employee ? option.employee.firstname : "";
      let lastname = option.employee ? option.employee.lastname : "";

      return option.position.position_name + " - " + firstname + " " + lastname;
    },
    getDataPositions: async function () {
      return axios.get(route(this.url_positions)); //TODO: add count
    },
    getDataTypeMemo: async function () {
      return axios.get(route(this.url_typememo, this.indexMemo)); //TODO: add count
    },
    actionHideModal() {
      this.$emit("handleHidden", true);
      this.resetModal();
    },
    resetModal() {
      this.dataPositions = [];
      this.dataTypeMemo = [];
      this.form = {
        id_employee2: null,
        id_type_memo: null,
        id_confirmed_payment: null,
      };
      this.idItemClicked = null;
      this.modalTitle = "";
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      this.isModalformbusy = true;
      this.$inertia
        .put(route(this.__update, this.indexMemo), this.form)
        .then(() => {
          this.resetModal();
          this.isModalformbusy = false;
          this.$nextTick(() => {
            this.$bvModal.hide("modal-edit-memo");
          });
        });
    },
  },
};
</script>
