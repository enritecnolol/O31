<template>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="float-left">
          <h3>Lista de Factura</h3>
        </div>
        <div class="float-right">
          <button class="btn btn-sm btn-primary" @click="createFormStatus">Crear Factura</button>
        </div>
      </div>
      <div class="col-md-12">
        <hr>
      </div>
      <div class="col-md-12" style="margin-bottom: 15px">
        <div class="row" style="margin-bottom: 15px;margin-top: 5px">
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
            <label>Codigo de factura:</label>
            <input type="text" class="form-control form-control-sm" v-model="filter.codeEstimate" placeholder="#00000">
          </div>
          <div class="col-md-3" style="margin-top: 10px">
            <label for="status">Estado:</label>
            <select id="status" class="form-control form-control-sm" v-model="filter.status">
              <option value="ALL"> Todas </option>
              <option value="COMPLETADO"> Completado </option>
              <option value="DEUDA"> Deuda </option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-12" style="margin-top: 15px">
        <table-invoice
            :pagination="true"
            :paginate="tableData"
            @pageChange="getInvoice">
          <template slot="table-header">
            <th>No. factura</th>
            <th>Fecha de factura</th>
            <th>Cliente</th>
            <th style="text-align: right">Total</th>
            <th>Estado</th>
            <th>Estado pagado</th>
            <th style="text-align: right">Balance pendiente</th>
            <th />
          </template>
          <template slot="table-body">
            <tr v-if="dataSize === 0">
              <th colspan="6" style="font-size: 20px;text-align: center">
                No hemos encontrado resultado ....
              </th>
            </tr>
            <tr v-for="(item, index) in tableData.data">
              <th>#{{item.id}}</th>
              <td>{{moment(item.date).format('DD-MM-YYYY')}}</td>
              <td>{{toShowClient(item.client)}}</td>
              <td style="text-align: right">{{parseFloat(item.total_facture).formatMoney(2)}}</td>
              <td><span :style="{
                color:spanColor(item.status).color,
                background:spanColor(item.status).background
              }" style="font-size: 13px;padding: 5px 10px;">{{item.status}}</span></td>
              <td><span :style="{
                color:spanBackgroundColor(item.paid_status).color,
                background:spanBackgroundColor(item.paid_status).background
              }" style="font-size: 13px;padding: 5px 10px;">{{item.paid_status}}</span></td>
              <td style="text-align: right">{{parseFloat(item.open_balance).formatMoney(2)}}</td>
              <td>
                <div class="dropdown">
                  <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bars" />
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" @click="dataEdit(item.id, item.paid_status)">Editar</a>
                    <a class="dropdown-item" href="#" @click="toPayment(item.id, item.paid_status)">Recibo de pago</a>
<!--                    <a class="dropdown-item" href="#">Eliminar</a>-->
                  </div>
                </div>
              </td>
            </tr>
          </template>
        </table-invoice>
      </div>
    </div>
  </div>
</template>
<script>
  import tableInvoice from "./tableInvoice";
  import Datepicker from 'vuejs-datepicker';
  export default {
    components:{tableInvoice, Datepicker},
    data()
    {
      return {
        tableData:{},
        clientsData:null,
        filter:{
          customer:'',
          from:'',
          to:'',
          codeInvoice:'',
          status:'ALL'
        }
      }
    },
    methods:{
      toPayment(id, status)
      {
        window.location.href = '/client/details?client='+id;
      },
      dataEdit(id, status)
      {
        if(status === 'PAGADO' || status === 'PAGADO PARCIALMENTE')
        {
          toastr.warning("Las Facturas pagadas no pueden ser modificadas");
          return;
        }
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
      getInvoice(page)
      {
        this.loading(true);
        let url = page ? '/invoices/list?page='+page : '/invoices/list';
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
      ResendEstimate(invoice_id)
      {
        axios.get('/invoices/resend', {
          params:{
            invoice_id:invoice_id
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
          let found = this.clientsData.find(e => e.id === parseInt(id));
          if(found){
            return found.nombre;
          }
        }
        return "no found"
      },
      spanColor(status)
      {
        if(status === 'COMPLETADO')
        {
          return {color:'#354930', background:'#d5eed0'};
        }
        else if(status === 'DEUDA')
        {
          return {color:'#6c432e', background:'#f8edcb'};
        }
        else{
          return {color:'#1e576c', background:'#c9e3ec'};
        }
      },
      spanBackgroundColor(status)
      {
        if(status === 'PAGADO')
        {
          return {color:'#354930', background:'#d5eed0'};
        }
        else if(status === 'NO PAGADO')
        {
          return {color:'#6c432e', background:'#f8edcb'};
        }
        else{
          return {color:'#1e576c', background:'#c9e3ec'};
        }
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
          this.getInvoice(1);
        },
        deep: true
      }
    },
    created(){
      this.getInvoice();
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