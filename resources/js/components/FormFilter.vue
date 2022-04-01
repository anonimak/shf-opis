<template>
  <b-col md="auto">
    <div>
      <b-button
        variant="outline-primary"
        size="sm"
        :class="visible ? 'mb-2' : 'collapsed mb-3'"
        :aria-expanded="visible ? 'true' : 'false'"
        aria-controls="collapse-filter"
        @click="visible = !visible"
      >
        Filter By Branch
        <i class="fa fa-search-plus" aria-hidden="true"></i>
      </b-button>
    </div>
    <b-collapse id="collapse-filter" v-model="visible" class="mt-2 mb-2">
      <b-card>
        <b-form-group label="" v-slot="{ ariaDescribedby }">
          <b-form-checkbox
            v-for="option in dataBranch"
            v-model="selectedBranch"
            :key="option.id"
            :value="option.id"
            :aria-describedby="ariaDescribedby"
            @change="changeChecked"
            name="flavour-3a"
          >
            {{ option.branch_name }}
          </b-form-checkbox>
        </b-form-group>
      </b-card>
    </b-collapse>
  </b-col>
</template>
<script>
export default {
  props: ["dataBranch","value"],
  data() {
    return {
      visible: true,
      selectedBranch: null,
    };
  },
  mounted() {
    this.selectedBranch = this.value;
  },
  methods: {
    changeChecked: function () {
      this.$emit("change", this.selectedBranch);
    },
  },
};
</script>
