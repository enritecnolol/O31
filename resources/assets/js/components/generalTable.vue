<template>
  <div :class="responsive ? 'table-responsive' : ''">
    <table
      class="table table-sm"
      :class="[hover ? 'table-hover' : '', bordered ? 'table-bordered':'', striped ? 'table-striped' : '']"
    >
      <thead :class="[headerLight ? 'thead-light' : '']">
        <slot name="table-header" />
      </thead>
      <tbody style="height: 10px !important; overflow: scroll; ">
        <slot name="table-body" />
      </tbody>
      <slot name="table-footer" />
    </table>
    <hr>
    <slot name="bottom-down"/>
    <pagination
      v-if="paginate"
      align="right"
      :data="paginate"
      :limit="1"
      :show-disabled="true"
      @pagination-change-page="changePage"
    />
  </div>
</template>
<script>
window.Vue = require("vue");
Vue.component("pagination", require("laravel-vue-pagination"));
export default {
  props: {
    pagination: {
      type: Boolean,
      default: false
    },
    paginate: {
      type: Object
    },
    hover: {
      type: Boolean,
      default: false
    },
    bordered: {
      type: Boolean,
      default: false
    },
    striped: {
      type: Boolean,
      default: false
    },
    headerLight: {
      type: Boolean,
      default: false
    },
    responsive: {
      type: Boolean,
      default: true
    }
  },
  components: {},
  data() {
    return {};
  },
  methods: {
    changePage(page) {
      this.$emit("pageChange", page);
    }
  }
};
</script>
<style>
.table-responsive {
  height: 450px;
  overflow: auto;
}
thead tr:nth-child(1) th {
  background: white;
  position: sticky;
  top: 0;
  z-index: 10;
}
</style>
