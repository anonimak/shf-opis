<template>
  <div>
    <li
      v-for="item in items"
      :key="item.id"
      class="nav-item"
      :class="checkStatusRoutes(item) == true? 'active':''"
    >
      <div v-if="isArrayRoutes(item) == true">
        <a
          :class="checkStatusRoutes(item) == true? '':'collapsed'"
          class="nav-link"
          href="#"
          data-toggle="collapse"
          :data-target="'#'+item.title+'Page'"
          aria-expanded="false"
          :aria-controls="item.title+'Page'"
        >
          <i :class="item.icon"></i>
          <span>{{item.title}}</span>
        </a>
        <div
          v-if="isArrayRoutes(item) == true"
          :id="item.title+'Page'"
          :class="checkStatusRoutes(item) == true? 'show':''"
          class="collapse"
          aria-labelledby="headingPage"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Custom Utilities:</h6> -->
            <inertia-link
              v-for="itemChild in item.child"
              :key="itemChild.link"
              :class="isRoute(itemChild.link)? 'collapse-item active': 'collapse-item'"
              :href="route(itemChild.link)"
            >{{ itemChild.title }}</inertia-link>
          </div>
        </div>
      </div>
      <inertia-link v-else class="nav-link" :href="route(item.link)">
        <i :class="item.icon"></i>
        <span>{{item.title}}</span>
      </inertia-link>
    </li>
  </div>
</template>
<script>
export default {
  props: {
    items: Array,
  },
  methods: {
    isArrayRoutes(data) {
      if (typeof data.child !== "undefined" && Array.isArray(data.child)) {
        return true;
      }
      return false;
    },
    checkStatusRoutes(data) {
      if (typeof data.child !== "undefined" && Array.isArray(data.child)) {
        for (let index = 0; index < data.child.length; index++) {
          if (this.isRoute(data.child[index].link)) {
            return true;
          }
          // console.log("ada");
        }

        return false;
      } else {
        if (this.isRoute(data.link)) {
          return true;
        }
      }
    },
  },
};
</script>