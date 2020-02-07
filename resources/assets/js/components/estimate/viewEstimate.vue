<template>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="float-left">
          <h3>Lista de cotización</h3>
        </div>
        <div class="float-right">
          <button class="btn btn-sm btn-primary" @click="createFormStatus">Crear cotización</button>
        </div>
      </div>
      <div class="col-md-12" style="box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);border-radius: 10px 10px 10px 10px;margin-top: 15px;margin-bottom: 15px">
        <div class="row" style="margin-bottom: 15px;margin-top: 15px">
          <div class="col-md-3">
            <label>Cliente:</label>
            <v-select v-model="filter.customer" :options="clientsListForSelect"/>
          </div>
          <div class="col-md-3">
            <label>Desde:</label>
            <datepicker v-model="filter.from" class="form-control form-control-sm" :format="'yyyy-MM-dd'" name="from" />
          </div>
          <div class="col-md-3">
            <label>Hasta:</label>
            <datepicker v-model="filter.to" class="form-control form-control-sm" :format="'yyyy-MM-dd'" name="to" />
          </div>
          <div class="col-md-3">
            <label>Codigo cotización:</label>
            <input type="text" class="form-control form-control-sm" v-model="filter.codeEstimate" placeholder="#00000">
          </div>
        </div>
      </div>
      <div class="col-md-12" style="margin-top: 15px">
        <table-estimate
            :pagination="true"
            :paginate="tableData"
            @pageChange="getEstimate">
          <template slot="table-header">
            <th>No. cotización</th>
            <th style="text-align: center">Fecha cotización</th>
            <th style="text-align: center">Fecha de vencimiento</th>
            <th style="text-align: center">Cliente</th>
            <th style="text-align: right">Total</th>
            <th style="text-align: center">Confirmación</th>
            <th />
          </template>
          <template slot="table-body">
            <tr v-if="dataSize === 0">
              <th colspan="7" style="font-size: 20px;text-align: center">
                No hemos encontrado resultado ....
              </th>
            </tr>
            <tr v-for="(item, index) in tableData.data">
              <th>{{item.estimatenumber}}</th>
              <td style="text-align: center">{{moment(item.estimatedate).format('DD-MM-YYYY')}}</td>
              <td style="text-align: center">{{moment(item.duedate).format('DD-MM-YYYY')}}</td>
              <td style="text-align: center">{{toShowClient(item.client_id)}}</td>
              <td style="text-align: right">{{parseFloat(item.total).formatMoney(2)}}</td>
              <td style="text-align: center"><i style="font-size: 20px" :class="item.confirmation ? 'fas fa-check-circle green' : 'fas fa-ban red'" /></td>
              <td>
                <div class="dropdown">
                  <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bars" />
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" @click="dataEdit(item.id)">Editar</a>
                    <a class="dropdown-item" href="#" @click="ChangeToInvoice(item.id)">Convertir en Factura</a>
                    <a class="dropdown-item" href="#">Eliminar</a>
                  </div>
                </div>
              </td>
            </tr>
          </template>
        </table-estimate>
      </div>
    </div>
  </div>
</template>
<script>
  import tableEstimate from "./table-estimate";
  import Datepicker from 'vuejs-datepicker';
  export default {
    components:{tableEstimate, Datepicker},
    data()
    {
      return {
        tableData:{},
        clientsData:null,
        filter:{
          customer:'',
          from:'',
          to:'',
          codeEstimate:''
        }
      }
    },
    methods:{
      ChangeToInvoice(id)
      {
        window.location.href = 'billing?convertToInvoice='+id;
      },
      dataEdit(id)
      {
        this.$emit('dataEdit', id);
      },
      createFormStatus()
      {
        this.$emit('createFormStatus', true);
      },
      loading(val)
      {
        this.$emit('loading', val);
      },
      getEstimate(page)
      {
        this.loading(true);
        let url = page ? '/estimate/list?page='+page : '/estimate/list';
        axios.get(url, {
          params:{
            filters:this.filter
          }
        })
            .then((response) => {
              this.tableData = response['data'];
            })
            .catch( (error) => {
              console.log(error);
            })
            .finally(() => {
              this.loading(false);
            });
      },
      ClientsDate()
      {
        axios.post('/clientes/datos/tabla2')
            .then((response) => {
              this.clientsData = response['data'];
            })
            .catch( (error) => {
              console.log(error);
            });
      },
      ResendEstimate(estimate_id)
      {
        axios.get('/estimate/resend', {
          params:{
            estimate_id:estimate_id
          }
        })
            .then((response) => {
              toastr.success("Reenviado con exito");
            })
            .catch( (error) => {
              console.log(error);
            });
      },
      toShowClient(id)
      {
        if(this.clientsData)
        {
          let found = this.clientsData.find(e => e.id === id);
          if(found){
            return found.nombre;
          }
        }
        return "no found"
      }
    },
    computed:{
      clientsListForSelect()
      {
        let array = [];
        for (var index in this.clientsData)
        {
          array.push({
            label:this.clientsData[index].nombre,
            code:this.clientsData[index].id
          })
        }
        return array;
      },
      dataSize()
      {
        let count = 0;
        for (var index in this.tableData.data)
        {
          count++
        }
        return count;
      }
    },
    watch:{
      filter: {
        handler(val, oldVal){
          this.getEstimate(1);
        },
        deep: true
      }
    },
    created(){
      this.getEstimate();
      this.ClientsDate()
    }
  }
</script>
<style>
  .green {
    color: green;
  }

  .red{
    color: red;
  }
</style>