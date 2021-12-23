<template>
  <div>
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
        <b-form-group
          id="input-group-title"
          label="Branch:"
          label-for="input-title"
          :invalid-feedback="errors.id_branch ? errors.id_branch[0] : ''"
          :state="errors.id_branch ? false : null"
        >
          <v-select
            label="branch_name"
            placeholder="-- Select Branch --"
            :options="dataBranch"
            v-model="form.id_branch"
            :reduce="(branch) => branch.id"
            :required="!form.id_branch"
          ></v-select>
        </b-form-group>
        <b-form-group
          id="input-group-title"
          label="Position:"
          label-for="input-title"
          :invalid-feedback="errors.id_position ? errors.id_position[0] : ''"
          :state="errors.id_position ? false : null"
        >
          <v-select
            label="position_name"
            placeholder="-- Select Position --"
            :options="dataPosition"
            v-model="form.id_position"
            :reduce="(position) => position.id"
            :required="!form.id_position"
          ></v-select>
        </b-form-group>
        <b-form-group
          id="input-group-title"
          label="Start Date:"
          label-for="input-title"
          :invalid-feedback="errors.year_started ? errors.year_started[0] : ''"
          :state="errors.year_started ? false : null"
        >
          <b-form-datepicker
            id="yearstarted-datepicker"
            v-model="form.year_started"
            placeholder="Start Date"
            :date-format-options="{
              year: 'numeric',
              month: 'numeric',
              day: 'numeric',
            }"
            locale="id"
            :state="errors.year_started ? false : null"
            class="mb-2"
          ></b-form-datepicker>
        </b-form-group>
        <b-form-group
          id="input-group-title"
          label="End Date:"
          label-for="input-title"
          :invalid-feedback="
            errors.year_finished ? errors.year_finished[0] : ''
          "
          :state="errors.year_finished ? false : null"
        >
          <b-form-datepicker
            id="yearfinished-datepicker"
            :disabled="checkboxdatenow"
            v-model="form.year_finished"
            placeholder="End Date"
            :date-format-options="{
              year: 'numeric',
              month: 'numeric',
              day: 'numeric',
            }"
            locale="id"
            :state="errors.year_finished ? false : null"
            class="mb-2"
          ></b-form-datepicker>
        </b-form-group>
        <b-form-checkbox
          id="checkbox-1"
          v-model="checkboxdatenow"
          name="checkbox-1"
          :value="true"
          :unchecked-value="false"
          class="mb-2"
        >
          Until now
        </b-form-checkbox>
      </form>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: {
    dataBranch: {
      type: Array,
      default: [],
    },
    dataPosition: {
      type: Array,
      default: [],
    },
    errors: {
      type: Object,
      default: {},
    },
    indexEmpHistory: {
      type: Number,
      default: null,
    },
  },
  watch: {
    checkboxdatenow: function (val) {
      if (val) {
        this.form.year_finished = null;
      } else {
        if (this.id_form)
          [(this.form.year_finished = this.bckup_year_finished)];
      }
    },
  },
  data() {
    return {
      form: {
        id_branch: null,
        id_position: null,
        year_started: null,
        year_finished: null,
      },
      bckup_year_finished: null,
      checkboxdatenow: true,
      id_form: null,
      modalTitle: "",
    };
  },
  methods: {
    getData() {
      if (this.indexEmpHistory !== null) {
        this.modalTitle = "Edit History";
        const employeedetail_item =
          this.$page.employee_detail[this.indexEmpHistory];
        if (employeedetail_item.year_finished) {
          this.checkboxdatenow = false;
        }
        this.id_form = employeedetail_item.id;
        this.bckup_year_finished = employeedetail_item.year_finished;

        this.form = Object.assign({}, this.form, {
          id_branch: employeedetail_item.id_branch,
          id_position: employeedetail_item.id_position,
          year_started: employeedetail_item.year_started,
          year_finished: employeedetail_item.year_finished,
        });
      } else {
        this.modalTitle = "Add New History";
      }
    },
    resetModal() {
      this.form = {
        id_branch: null,
        id_position: null,
        year_started: null,
        year_finished: null,
      };
      this.id_form = null;
      this.checkboxdatenow = true;
      this.bckup_year_finished = null;
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      if (this.id_form) {
        this.$inertia
          .put(
            route("admin.employee.history.update", [
              this.$page.employee.id,
              this.id_form,
            ]),
            this.form
          )
          .then(() => {
            if (Object.entries(this.errors).length === 0) {
              this.$nextTick(() => {
                this.$bvModal.hide("modal-prevent-closing");
              });
            }
          });
      } else {
        this.$inertia
          .post(
            route("admin.employee.history.store", this.$page.employee.id),
            this.form
          )
          .then(() => {
            if (Object.entries(this.errors).length === 0) {
              this.$nextTick(() => {
                this.$bvModal.hide("modal-prevent-closing");
              });
            }
          });
      }
      // this.$emit('')
      // Hide the modal manually
    },
  },
};
</script>