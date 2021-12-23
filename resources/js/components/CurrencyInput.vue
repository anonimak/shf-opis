<template>
  <b-form-input
    type="text"
    v-model="displayValue"
    placeholder="ex: 1000000"
    @blur="isInputActive = false"
    @focus="isInputActive = true"
    :state="errors ? false : null"
    trim
    required
  >
  </b-form-input>
</template>

<script>
export default {
  props: ["value", "errors"],
  data() {
    return {
      isInputActive: false,
    };
  },
  computed: {
    displayValue: {
      get: function () {
        if (this.isInputActive) {
          // Cursor is inside the input field. unformat display value for user
          return this.value.toString();
        } else {
          // User is not modifying now. Format display value for user interface
          //   return (
          //     "Rp " +
          //     this.value.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,")
          //   );
          return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 2
          }).format(this.value);
        }
      },
      set: function (modifiedValue) {
        // Recalculate value after ignoring "$" and "," in user input
        let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ""));
        // Ensure that it is not NaN
        if (isNaN(newValue)) {
          newValue = 0;
        }
        // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
        // $emit the event so that parent component gets it
        this.$emit("input", newValue);
      },
    },
  },
};
</script>

