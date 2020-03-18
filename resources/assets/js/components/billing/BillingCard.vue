<template>
  <div class="container">
    <div class="card">
      <div class="loader" v-if="loading"></div>
      <create-invoice v-if="createForm" @createFormStatus="createFormStatus" :data-edit="dataEdit" :loading="loading" @loading="loadingStatus"/>
      <view-invoices v-else @loading="loadingStatus" @createFormStatus="createFormStatus" @dataEdit="searchDataEdit"/>
    </div>
  </div>
</template>
<script>
  import createInvoice from "./createInvoice";
  import viewInvoices from "./viewInvoices";
  export default {
    name:'billing-card',
    components:{createInvoice, viewInvoices},
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
        axios.get('/invoice/find',{
          params:{
            invoice_id:id
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
      searchDataEstimate(id)
      {
        this.loadingStatus(true);
        axios.get('/estimate/find',{
          params:{
            estimate_id:id
          }
        })
            .then((response) => {
              this.dataEdit = this.DataFormat(response['data']);
              this.createForm = true;
            })
            .catch( (error) => {
              console.log(error);
            })
            .finally(() => {
              this.loadingStatus(false);
            });
      },
      DataFormat(data)
      {
        let data_edit = {
          invoice_date : data.estimatedate,
          due_date: data.duedate,
          client_id:data.client_id,
          address:data.address,
          invoice_number:data.estimatenumber,
          email:data.email,
          invoice_details:data.estimate_details,
          note: data.note,
          action:'create'
        };

        return data_edit;
      },
      loadingStatus(val)
      {
        this.loading = val
      },
      createFormStatus(val)
      {
        this.createForm = val;
        if (!val)
        {
          this.dataEdit = null
        }
      },
      getUrlVars()
      {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
          hash = hashes[i].split('=');
          vars.push(hash[0]);
          vars[hash[0]] = hash[1];
        }
        return vars;
      },
      clientToInvoice()
      {
        this.createForm = true;
      }
    },
    computed:{
    },
    created() {
      if(this.getUrlVars(window.location.href)['convertToInvoice'])
      {
       this.searchDataEstimate(this.getUrlVars(window.location.href)['convertToInvoice'])
      }

      if(this.getUrlVars(window.location.href)['client'])
      {
       this.clientToInvoice(this.getUrlVars(window.location.href)['client'])
      }
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