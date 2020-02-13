<template>
  <div class="card-summary">
    <div class="container">
      <template v-if="loading">
        <div class="text-center">
          <div class="lds-dual-ring"></div>
        </div>
      </template>
      <template v-else>
        <h3 style="color: white">RD${{parseFloat(data[summary] ? data[summary] : 0 ).formatMoney(2)}}</h3>
        <p style="color: white;float: right">{{data.quantity ? data.quantity : 0}} {{subtitle}}</p>
      </template>
    </div>
  </div>
</template>
<script>
  export default {
    name:'summary-invoices',
    props:['summary', 'subtitle'],
    data()
    {
      return{
        data:null,
        loading:false
      }
    },
    methods:{
      fetchData()
      {
        this.loading = true;
        axios.get('/clients/summary',{
          params:{
            summary:this.summary
          }
        })
        .then((response) => {
          if(response.data.length !== 0)
          {
            this.data = response.data[0];
          }
          console.log(response.data)
        })
        .catch((err) => {
          console.log(err)
        })
        .finally(() => {
          this.loading = false;
        })
      }
    },
    computed:{
    },
    created() {
      this.fetchData();
    }
  }
</script>
<style>
  .card-summary{
    background:linear-gradient(to right, #1488cc, #2b32b2);
    height: 60px;
    width: 300px;
    box-shadow: 0 1px 2px rgba(0,0,0,.05);
    border-radius: 10px 10px 10px 10px;
  }

  .lds-dual-ring {
    display: inline-block;
    width: 10px;
    height: 10px;
  }

  .lds-dual-ring:after {
    content: " ";
    display: block;
    width: 30px;
    height: 30px;
    margin: 4px;
    border-radius: 50%;
    border: 6px solid #fff;
    border-color: #fff transparent #fff transparent;
    animation: lds-dual-ring 1.2s linear infinite;
  }
  @keyframes lds-dual-ring {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
</style>