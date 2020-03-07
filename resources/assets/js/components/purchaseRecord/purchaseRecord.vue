<template>
  <card-panel style="margin-top:-50px;">
    <template slot="body">
      <div class="loader" v-if="loading"></div>
      <div class="card-body">
        <div class="container-fluid">
          <view-purchase v-if="!formCreatePurchase" @formStatus="formStatus" @loadingStatus="loadingStatus" @editPurchase="editPurchase"/>
          <create-purchase v-else @formStatus="formStatus"  @loadingStatus="loadingStatus" :editData="editData" @cleanEditData="cleanEditData"/>
        </div>
      </div>
    </template>
  </card-panel>
</template>

<script>
  import cardPanel from "../cardPanel";
  import viewPurchase from "./viewPurchase";
  import createPurchase from "./createPurchase";
  export default {
    name: "purchase-record",
    components: {
      cardPanel,
      viewPurchase,
      createPurchase
    },
    data() {
      return {
        formCreatePurchase: false,
        loading: false,
        editData:null
      };
    },
    methods: {
      cleanEditData()
      {
        this.editData = null;
      },
      editPurchase(item)
      {
        this.loadingStatus(true)
        axios.get('/purchase/fetch', {
          params:{
            id:item.id
          }
        }).then((response) => {
          this.formStatus(true);
          this.editData = response.data
        }).catch((err) => {
          console.log(err)
        }).finally(()=> {
          this.loadingStatus(false)
        })
      },
      formStatus(status) {
        this.formCreatePurchase = status;
      },
      loadingStatus(val)
      {
        this.loading = val
      },
    },
    computed: {
    },
    created() {
    }
  };
</script>

<style>
  .loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url("../../../../../public/loading2.gif") 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
  }
</style>