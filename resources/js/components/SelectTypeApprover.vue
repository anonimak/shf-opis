<template>
  <div>
    <b-form-select
      :disabled="disabled"
      v-model="selectapprover.type_approver"
      @change="changeSelected"
      class="mb-3"
    >
      <b-form-select-option value="approver">Approver</b-form-select-option>
      <b-form-select-option value="acknowledge"
        >Acknowledge</b-form-select-option
      >
    </b-form-select>
  </div>
</template>
<script>
export default {
  props: {
    disabled: {
      type: Boolean,
      default: false,
    },
    approver: Object,
  },
  data() {
    return {
      selectedItem: null,
      selectapprover: {},
    };
  },
  mounted() {
    this.selectapprover = { ...this.approver };
  },
  methods: {
    changeSelected: function () {
      this.$emit("changeSelected", this.selectapprover);
    },
  },
};
</script>