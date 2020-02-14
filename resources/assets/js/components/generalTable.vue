<template>
  <div class="">
    <table class="table table-sm" :class="[hover ? 'table-hover' : '', bordered ? 'table-bordered':'']">
      <thead>
        <slot name="table-header" />
      </thead>
      <tbody style="height: 10px !important; overflow: scroll; ">
      <slot name="table-body" />
      </tbody>
    </table>
    <pagination
        v-if="paginate"
        align="right"
        :data="paginate"
        :limit="1"
        :show-disabled="true"
        @pagination-change-page="changePage"/>
  </div>
</template>
<script>
  window.Vue = require('vue');
  Vue.component('pagination', require('laravel-vue-pagination'));
  export default {
    props:{
      pagination:{
        type: Boolean,
        default: false,
      },
      paginate: {
        type:Object
      },
      hover:{
        type:Boolean,
        default: false
      },
      bordered:{
        type:Boolean,
        default: false
      }
    },
    components:{

    },
    data(){
      return {

      }
    },
    methods:{
      changePage(page) {
        this.$emit("pageChange", page);
      },
    }
  }
</script>
<style>

</style>