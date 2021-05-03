<template>
  <ol class="breadcrumb">
    <li
      class="breadcrumb-item"
      v-for="item in items"
      :key="item.title"
      :class="{ active: item.active }"
    >
      <inertia-link
        v-if="!item.active"
        :href="item.param ? route(item.href, item.param) : route(item.href)"
      >
        <i v-if="item.icon" class="fas" :class="item.icon"></i>
        {{ item.title }}
      </inertia-link>
      <span v-else>
        <i v-if="item.icon" class="fas" :class="item.icon"></i>
        {{ item.title }}
      </span>
    </li>
  </ol>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
    },
  },
};
</script>
