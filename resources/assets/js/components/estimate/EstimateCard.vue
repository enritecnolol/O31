<template>
  <div class="container">
    <div class="card">
      <div class="loader" v-if="loading"></div>
      <create-estimate v-if="createForm" @loading="loadingStatus" @createFormStatus="createFormStatus" :data-edit="dataEdit"/>
      <view-estimate v-else @loading="loadingStatus" @createFormStatus="createFormStatus" @dataEdit="searchDataEdit"/>
    </div>
  </div>
</template>
<script>
  import createEstimate from "./createEstimate";
  import viewEstimate from "./viewEstimate";
  export default {
    name:'estimate-card',
    components:{createEstimate, viewEstimate},
    data(){
      return {
        loading:false,
        createForm:false,
        dataEdit:null
      }
    },
    methods:{
      searchDataEdit(id)
      {
        this.loadingStatus(true);
        axios.get('/estimate/find',{
          params:{
            estimate_id:id
          }
        })
            .then((response) => {
              this.dataEdit = response['data'];
              this.createForm = true;
            })
            .catch( (error) => {
              console.log(error);
            })
            .finally(() => {
              this.loadingStatus(false);
            });
      },
      loadingStatus(val)
      {
        this.loading = val
      },
      createFormStatus(val)
      {
        this.createForm = val
      }
    },
    computed:{
    },
    created() {
    }
  }
</script>
<style>
  .createCustomer:hover{
    color: #0e3bbb !important;
  }
  input[type=number] {
    text-align:right;
  }

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