<template>
  <b-button
    :title="title"
    :class="{ active: isActive ? isActive() : null }"
    @click="action"
    @mousedown="onMouseDown"
    variant="light"
    :disabled="isDisabled"
  >
    <i :class="`ri-${icon}`"></i>
  </b-button>
</template>

<script>
export default {
  props: {
    icon: {
      type: String,
      required: true,
    },

    title: {
      type: String,
      required: true,
    },

    action: {
      type: Function,
      required: true,
    },

    isActive: {
      type: Function,
      default: null,
    },
    isDisabled: {
      type: Function,
      default: null,
    },
  },
  methods: {
    onMouseDown: function (e) {
      e.preventDefault();
      this.$emit("onMouseDown", true);
    },
  },
};
</script>
