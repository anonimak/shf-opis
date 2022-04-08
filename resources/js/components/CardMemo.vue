<template>
  <div class="card bg-white rounded-0">
    <div class="card-body p-2">
      <div class="float-right" @click="$emit('clicked:Menu')">
        <i class="bx bx-dots-horizontal-rounded"></i>
      </div>
      <h6 class="card-title mb-0 text-truncate">Primary card title</h6>
      <p class="font-weight-light text-warning mb-0">
        <small>revised</small>
      </p>
      <!-- <span
        class="d-inline-block font-weight-light text-truncate"
        style="max-width: 200px"
      >
        Some quick example text to build on the card title and make up the
        bulkof the cards content.
      </span> -->
    </div>
  </div>
</template>
<style lang="scss" scoped>
</style>