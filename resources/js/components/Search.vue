<template>
  <div class="items-center">
    <div class="row form-group">
      <input
        class="form-control input-round"
        autocomplete="off"
        type="search"
        name="search"
        placeholder="Search.."
        :value="value"
        @input="$emit('input', $event.target.value)"
      />
    </div>
    <!-- <button type="submit" class="btn btn-primary btn-round">Subscribe</button> -->
    <!-- <label class="label text-primary" @click="$emit('reset')">Reset</label> -->
  </div>
</template>

<script>
export default {
  props: {
    value: String,
    maxWidth: {
      type: Number,
      default: 300,
    },
  },
};
</script>
