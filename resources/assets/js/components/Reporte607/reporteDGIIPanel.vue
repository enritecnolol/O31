<template>
  <div class="container">
    <div class="card" style="min-height: 500px">
      <div class="loader" v-if="loading"></div>
      <div class="card-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h3>Formato de Envio de Ventas de Bienes y Servicios </h3>
              <hr>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Periodo</label>
                <date-picker @date_select="date_select" :reset="reset"/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="MontoMaximoConsumo">Monto maximo de consumo</label>
                <input type="number" min="0" class="form-control form-control-sm" id="MontoMaximoConsumo" placeholder="" v-model="MaxAmount">
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="tiponcf">Tipo ncf</label>
                <select id="tiponcf" class="form-control form-control-sm" v-model="tiponfc">
                  <option value="01">01 | Credito Fiscal</option>
                  <option value="02">02 | Facturas de Consumo</option>
                  <option value="03">03 | Notas de Debito</option>
                  <option value="04">04 | Notas de Credito</option>
                  <option value="11">11 | Provedores Informales</option>
                  <option value="12">12 | Registro Unico de Ingresos</option>
                  <option value="13">13 | Registro de Gastos Menores</option>
                  <option value="14">14 | Regímenes Especiales de Tributación</option>
                  <option value="15">15 | Comprobantes Gubernamentales</option>
                </select>
              </div>
            </div>
            <div class="col-md-5">
              <button class="btn btn-sm btn-primary" style="margin-top: 31px;" @click="getData"> <i class="fas fa-file" /> Generar Archivo</button>
            </div>
            <div class="col-md-12">
              <br>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <select id="size" class="form-control form-control-sm" v-model="tableSize">
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                  <option value="all">Todos</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">RNC/Cédula o Pasaporte</th>
                    <th scope="col">Tipo Identificación</th>
                    <th scope="col">Número Comprobante Fiscal</th>
                    <th scope="col">Número Comprobante Fiscal Modificado</th>
                    <th scope="col">Tipo de Ingreso</th>
                    <th scope="col">Fecha Comprobante</th>
                    <th scope="col">Fecha de Retención</th>
                    <th scope="col">Monto Facturado</th>
                    <th scope="col">ITBIS Facturado</th>
                    <th scope="col">ITBIS Retenido por Terceros</th>
                    <th scope="col">ITBIS Percibido</th>
                    <th scope="col">Retención Renta por Terceros</th>
                    <th scope="col">ISR Percibido</th>
                    <th scope="col">Impuesto Selectivo al Consumo</th>
                    <th scope="col">Otros Impuestos/Tasas</th>
                    <th scope="col">Monto Propina Legal</th>
                    <th scope="col">Efectivo</th>
                    <th scope="col">Cheque/ Transferencia/ Depósito</th>
                    <th scope="col">Tarjeta Débito/Crédito</th>
                    <th scope="col">Venta a Crédito</th>
                    <th scope="col">Bonos o Certificados de Regalo</th>
                    <th scope="col">Permuta</th>
                    <th scope="col">Otras Formas de Ventas</th>
                  </tr>
                  </thead>
                  <tbody>
                  <template v-for="(item, index) in data.data">
                    <template v-if="item.ncfdevolucion">
                      <tr :key="index">
                        <td>{{index+1}}</td>
                        <td>{{item.rnc_nfc}}</td>
                        <td>1</td>
                        <td>{{ item.nfc }}</td>
                        <td></td>
                        <td>01</td>
                        <td>{{item.date}}</td>
                        <td></td>
                        <td style="text-align: right">{{parseFloat(item.total_facture).formatMoney(2)}}</td>
                        <td style="text-align: right">{{item.itbis}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right">{{parseFloat(item.leycamarero).formatMoney(2)}}</td>
                        <td style="text-align: right">{{parseFloat(item.Monto_efectivo).formatMoney(2)}}</td>
                        <td style="text-align: right">0</td>
                        <td style="text-align: right">{{parseFloat(item.Monto_tarjeta).formatMoney(2)}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </template>
                    <tr :key="index">
                      <td>{{index+1}}</td>
                      <td>{{item.rnc_nfc}}</td>
                      <td>1</td>
                      <td>{{ item.ncfdevolucion ? item.ncfdevolucion: item.nfc }}</td>
                      <td>{{ item.ncfdevolucion ?  item.nfc : item.ncfdevolucion }}</td>
                      <td>01</td>
                      <td>{{item.date}}</td>
                      <td></td>
                      <td style="text-align: right">{{parseFloat(item.total_facture).formatMoney(2)}}</td>
                      <td style="text-align: right">{{item.itbis}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td style="text-align: right">{{parseFloat(item.leycamarero).formatMoney(2)}}</td>
                      <td style="text-align: right">{{parseFloat(item.Monto_efectivo).formatMoney(2)}}</td>
                      <td style="text-align: right">0</td>
                      <td style="text-align: right">{{parseFloat(item.Monto_tarjeta).formatMoney(2)}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </template>
                  </tbody>
                </table>
              </div>
              <pagination
                  align="right"
                  :data="data"
                  :limit="1"
                  :show-disabled="true"
                  @pagination-change-page="changePage"/>
            </div>
            <div class="col-md-12" style="margin-top: 15px">
              <button class="btn btn-sm btn-success"
                      v-if="dataFormat.length !== 0"
                      @click="JSONToCSVConvertor(dataFormat,'Formato de Envio de Ventas de Bienes y Servicios\n RNC:'+RNC+'\n Periodo: '+ moment(date).format('YYYYMM'), true)">
                <i class="fas fa-file-excel"></i> Exportar Excel</button>
              <button class="btn btn-sm btn-dark"
                      v-if="dataFormat.length !== 0"
                      @click="download('Formato607', textDataFormat)">
                <i class="fas fa-file-excel"></i> Exportar TXT</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  window.Vue = require('vue');
  Vue.component('pagination', require('laravel-vue-pagination'));
  import datePicker from "./datePicker";
  export default {
    components:{
      datePicker
    },
    name:'reporte-dgii-panel',
    data(){
      return{
        loading:false,
        date:'',
        reset:false,
        MaxAmount:0,
        data:{},
        text:'',
        RNC:'',
        tiponfc:'',
        tableSize:'10'
      }
    },
    methods:{
      config()
      {
        axios.post('/configuracion/sale')
            .then( (response) => {
              if(response.data[0])
              {
                this.RNC = response.data[0].rnc
              }
            })
            .catch(function (error) {
            });
      },
      changeTableSize()
      {
        this.getData(1);
      },
      changePage(page)
      {
        this.getData(page)
      },
      JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel)
      {
        console.log(JSONData)
        var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

        var CSV = '';
        //Set Report title in first row or line

        CSV += ReportTitle + '\r\n\n';

        //This condition will generate the Label/Header
        if (ShowLabel) {
          var row = "";

          //This loop will extract the label from 1st index of on array
          for (var index in arrData[0]) {

            //Now convert each value to string and comma-seprated
            row += index + ',';
          }

          row = row.slice(0, -1);

          //append Label row with line break
          CSV += row + '\r\n';
        }

        //1st loop is to extract each row
        for (var i = 0; i < arrData.length; i++) {
          var row = "";

          //2nd loop will extract each column and convert it in string comma-seprated
          for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
          }

          row.slice(0, row.length - 1);

          //add a line break after each row
          CSV += row + '\r\n';
        }

        if (CSV == '') {
          alert("Invalid data");
          return;
        }

        //Generate a file name
        var fileName = "Reporte";
        //this will remove the blank-spaces from the title and replace it with an underscore
        fileName += ReportTitle.replace(/ /g,"_");

        //Initialize file format you want csv or xls
        var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

        // Now the little tricky part.
        // you can use either>> window.open(uri);
        // but this will not work in some browsers
        // or you will not get the correct file extension

        //this trick will generate a temp <a /> tag
        var link = document.createElement("a");
        link.setAttribute("target", "_blank");
        link.href = uri;

        //set the visibility hidden so it will not effect on your web-layout
        link.style = "visibility:hidden";
        link.download = fileName + ".csv";

        //this part will append the anchor tag and remove it after automatic click
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      },
      date_select(i)
      {
        this.date = i.date;
      },
      getData(page)
      {
        if(!this.RNC)
        {
          toastr.warning("Coloque RNC");
          return;
        }
        this.loading = true;
        axios.get('/report/607',{
          params:{
            page:page,
            size:this.tableSize === 'all' ? this.data.total : this.tableSize,
            date:this.date,
            MaxAmount:this.MaxAmount,
            tiponfc:this.tiponfc
          }
        })
            .then((response) => {
              this.data = response.data;
            })
            .catch( (error) => {
              console.log(error);
            })
            .finally(() => {
              this.loading = false;
            });
      },
      download(filename, text) {
        var element = document.createElement('a');
        element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        element.setAttribute('download', filename);
        element.setAttribute("target", "_blank");

        element.style.display = 'none';
        document.body.appendChild(element);

        element.click();

        document.body.removeChild(element);
      }
    },
    watch:{
      tableSize()
      {
        this.changeTableSize();
      }
    },
    computed:{
      textDataFormat()
      {
        var text = "";
        for(var index in this.data.data)
        {
          var build =  String(this.data.data[index].rnc_nfc ? this.data.data[index].rnc_nfc : '') + "|" +
          String(1) + "|" +
          String(this.data.data[index].ncfdevolucion ? this.data.data[index].ncfdevolucion: this.data.data[index].nfc) + "|" +
          String(this.data.data[index].ncfdevolucion ?  this.data.data[index].nfc : this.data.data[index].ncfdevolucion ? this.data.data[index].ncfdevolucion : '')+ "|" +
                  "01" + "|" +
                  String(moment(this.data.data[index].date).format('YYYYMMDD')) + "|" +
                  "" + "|" +
                  String(this.data.data[index].brute) + "|" +
                  String(this.data.data[index].itbis) + "|" +
                  '0.00' + "|" +
                  '0.00' + "|" +
                  '0.00' + "|" +
                  '0.00' + "|" +
                  '0.00' + "|" +
                  '0.00' + "|" +
                  String(this.data.data[index].leycamarero) + "|" +
                  String(this.data.data[index].Monto_efectivo) + "|" +
                  String(0) + "|" +
                  String(this.data.data[index].Monto_tarjeta) + "|" +
                  '0.00' + "|" +
                  '0.00' + "|" +
                  '0.00' + "|" +
                  '0.00' + "\n";

          if(this.data.data[index].ncfdevolucion)
          {

            text += build;
            build =  String(this.data.data[index].rnc_nfc ? this.data.data[index].rnc_nfc : '') + "|" +
                    String(1) + "|" +
                    String(this.data.data[index].nfc) + "|" +
                    ""+ "|" +
                    "01" + "|" +
                    String(moment(this.data.data[index].date).format('YYYYMMDD')) + "|" +
                    "" + "|" +
                    String(this.data.data[index].brute) + "|" +
                    String(this.data.data[index].itbis) + "|" +
                    '0.00' + "|" +
                    '0.00' + "|" +
                    '0.00' + "|" +
                    '0.00' + "|" +
                    '0.00' + "|" +
                    '0.00' + "|" +
                    String(this.data.data[index].leycamarero) + "|" +
                    String(this.data.data[index].Monto_efectivo) + "|" +
                    String(0) + "|" +
                    String(this.data.data[index].Monto_tarjeta) + "|" +
                    '0.00' + "|" +
                    '0.00' + "|" +
                    '0.00' + "|" +
                    '0.00' + "\n";
          }
          text += build;

        }
        return text;
      },
      dataFormat()
      {
        let array = [];
        for(var index in this.data.data)
        {
          array.push({
            'RNC/Cédula o Pasaporte' : this.data.data[index].rnc_nfc ? this.data.data[index].rnc_nfc : '',
            'Tipo Identificación' : 1,
            'Número Comprobante Fiscal': this.data.data[index].ncfdevolucion ? this.data.data[index].ncfdevolucion: this.data.data[index].nfc ,
            'Número Comprobante Fiscal Modificado': this.data.data[index].ncfdevolucion ?  this.data.data[index].nfc : this.data.data[index].ncfdevolucion ? this.data.data[index].ncfdevolucion : '',
            'Tipo de Ingreso': '01',
            'Fecha Comprobante': moment(this.data.data[index].date).format('YYYYMMDD'),
            'Fecha de Retención': '',
            'Monto Facturado': this.data.data[index].brute,
            'ITBIS Facturado': this.data.data[index].itbis,
            'ITBIS Retenido por Terceros': '0.00',
            'ITBIS Percibido': '0.00',
            'Retención Renta por Terceros': '0.00',
            'ISR Percibido': '0.00',
            'Impuesto Selectivo al Consumo': '0.00',
            'Otros Impuestos/Tasas': '0.00',
            'Monto Propina Legal': this.data.data[index].leycamarero,
            'Efectivo': this.data.data[index].Monto_efectivo,
            'Cheque/ Transferencia/ Depósito': 0,
            'Tarjeta Débito/Crédito': this.data.data[index].Monto_tarjeta,
            'Venta a Crédito': '0.00',
            'Bonos o Certificados de Regalo': '0.00',
            'Permuta': '0.00',
            'Otras Formas de Ventas': '0.00',
          });
          if(this.data.data[index].ncfdevolucion){
            array.push({
              'RNC/Cédula o Pasaporte' : this.data.data[index].rnc_nfc ? this.data.data[index].rnc_nfc : '',
              'Tipo Identificación' : 1,
              'Número Comprobante Fiscal': this.data.data[index].nfc ,
              'Número Comprobante Fiscal Modificado': '',
              'Tipo de Ingreso': '01',
              'Fecha Comprobante': moment(this.data.data[index].date).format('YYYYMMDD'),
              'Fecha de Retención': '',
              'Monto Facturado': this.data.data[index].brute,
              'ITBIS Facturado': this.data.data[index].itbis,
              'ITBIS Retenido por Terceros': '0.00',
              'ITBIS Percibido': '0.00',
              'Retención Renta por Terceros': '0.00',
              'ISR Percibido': '0.00',
              'Impuesto Selectivo al Consumo': '0.00',
              'Otros Impuestos/Tasas': '0.00',
              'Monto Propina Legal': this.data.data[index].leycamarero,
              'Efectivo': this.data.data[index].Monto_efectivo,
              'Cheque/ Transferencia/ Depósito': 0,
              'Tarjeta Débito/Crédito': this.data.data[index].Monto_tarjeta,
              'Venta a Crédito': '0.00',
              'Bonos o Certificados de Regalo': '0.00',
              'Permuta': '0.00',
              'Otras Formas de Ventas': '0.00',
            });
          }
        }
        return array;
      }
    },
    created() {
      this.config()
    }
  }
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
