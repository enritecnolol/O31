<template>
  <div>
    <div class="loader" v-if="loading"></div>
    <div class="table-responsive" style="height: 500px;overflow-y: auto">
      <table class="table table-sm">
        <thead>
          <template v-if="nfcleng2">
            <tr>
              <th
                scope="col"
                :colspan="headers.length"
                class="text-center"
              >{{tnfc(ncfs[index].tipo_nfc)}}</th>
            </tr>
          </template>
          <tr>
            <template v-for="(header, key) in headers">
              <th scope="col" class="text-center" :key="key">{{header}}</th>
            </template>
          </tr>
        </thead>
        <tbody>
          <template v-if="headers.length == 0">
            <tr>
              <td colspan="3">
                <div class="text-center">
                  <i class="fa fa-exclamation-triangle"></i> Por Favor aplicar un filtro
                </div>
              </td>
            </tr>
          </template>
          <template v-if="data.length == 0 && headers.length > 0">
            <tr>
              <td colspan="3">
                <div class="text-center">
                  <i class="fa fa-exclamation-triangle"></i> No se ha encontrado datos
                </div>
              </td>
            </tr>
          </template>

          <template v-if="nfcleng">
            <template v-for="(item, key) in data">
              <tr :key="key">
                <td>
                  <div class="text-left">{{item.slug}} | {{item.tipo}}</div>
                </td>
                <td>
                  <div class="text-center">{{item.cantidad}}</div>
                </td>
                <td>
                  <div class="text-right">${{parseFloat(item.total).toFixed(2)}}</div>
                </td>
              </tr>
            </template>
          </template>

          <template v-else>
            <template v-for="(item, key) in data">
              <tr :key="key">
                <template v-for="(tdteam, property, index) in item">
                  <td v-if="property != 'monto_normal'" :key="index">
                    <div class="text-center">{{tdteam}}</div>
                  </td>
                </template>
                <td v-if="seleccionado == 'Ventas'">
                  <u style="color:blue;cursor:pointer;" @click="openDetalle(item)">Ver detalle</u>
                </td>
              </tr>
            </template>
          </template>
        </tbody>
      </table>
      <br />
    </div>
    <div class="row">
      <div class="col-md-12" v-if="seleccionado == 'Productos' && headers.length != 0">
        <div class="text-center">
          <b>Total vendido:</b>
          {{ cantidadProductos() }} -
          <b>Monto total:</b>
          ${{ formatMoney(montoTotalProducto()) }}
        </div>
      </div>
      <div class="col-md-12">
        <div class="pull-right">
          <button
            type="button"
            class="btn btn-success"
            v-if="data.length > 0 && (seleccionado == 'Productos' || seleccionado == 'Ventas')"
            @click="openTab"
          >
            <i class="fas fa-print"></i> Imprimir
          </button>
          <button
            type="button"
            class="btn btn-success"
            @click="JSONToCSVConvertor(data,'Reporte de '+seleccionado, true)"
            v-if="data.length > 0"
          >
            <i class="fas fa-file-excel"></i> Export
          </button>
        </div>
      </div>
    </div>
    <br />
    <detallefature :factureselect="factureselect" :details="details" :setting="setting"></detallefature>
  </div>
</template>
<script>
import detallefature from "./modal/DetalleFactura";
export default {
  name: "multi_table",
  components: { detallefature },
  props: [
    "data",
    "headers",
    "ncfs",
    "index",
    "ncf",
    "seleccionado",
    "date",
    "categories",
    "products"
  ],
  data() {
    return {
      loading: false,
      name: "",
      print: "",
      details: [],
      factureselect: {},
      setting: {}
    };
  },
  methods: {
    settings() {
      axios
        .post("/configuracion/sale")
        .then(response => {
          for (var key in response["data"]) {
            this.setting = response["data"][key];
            return;
          }
        })
        .catch(error => {});
    },
    JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
      console.log(JSONData);
      var arrData =
        typeof JSONData != "object" ? JSON.parse(JSONData) : JSONData;

      var CSV = "";
      //Set Report title in first row or line

      CSV += ReportTitle + "\r\n\n";

      //This condition will generate the Label/Header
      if (ShowLabel) {
        var row = "";

        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {
          //Now convert each value to string and comma-seprated
          row += index + ",";
        }

        row = row.slice(0, -1);

        //append Label row with line break
        CSV += row + "\r\n";
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
        CSV += row + "\r\n";
      }

      if (CSV == "") {
        alert("Invalid data");
        return;
      }

      //Generate a file name
      var fileName = "Reporte";
      //this will remove the blank-spaces from the title and replace it with an underscore
      fileName += ReportTitle.replace(/ /g, "_");

      //Initialize file format you want csv or xls
      var uri = "data:text/csv;charset=utf-8," + escape(CSV);

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
    tnfc(nfc) {
      if (nfc == "01") {
        this.print = "01 | Credito Fiscal";
      }
      if (nfc == "02") {
        this.print = "02 | Facturas de Consumo";
      }
      if (nfc == "03") {
        this.print = "03 | Notas de Debito";
      }
      if (nfc == "04") {
        this.print = "04 | Notas de Credito";
      }
      if (nfc == "11") {
        this.print = "11 | Provedores Informales";
      }
      if (nfc == "12") {
        this.print = "12 | Registro Unico de Ingresos";
      }
      if (nfc == "13") {
        this.print = "13 | Registro de Gastos Menores";
      }
      if (nfc == "14") {
        this.print = "14 | Regímenes Especiales de Tributación";
      }
      if (nfc == "15") {
        this.print = "15 | Comprobantes Gubernamentales";
      }
      return this.print;
    },
    nombrecliente(id) {
      if (id !== "General") {
        var nombre = "";
        axios
          .post("/cliente/buscar/nombre", {
            id: id
          })
          .then(response => {
            for (var key in response.data) {
              if (id == response.data[key].id) {
                this.name = response.data[key].nombre;
              }
            }
          })
          .catch(error => {
            console.log(error);
          });
        return this.name;
      }
      return id;
    },
    montoTotalProducto() {
      var monto = 0;
      for (var index in this.data) {
        monto += parseFloat(this.data[index].monto_normal);
      }
      return parseFloat(monto).toFixed(2);
    },
    cantidadProductos() {
      var total = 0;
      for (var index in this.data) {
        total = total + parseInt(this.data[index].cantidad_producto);
      }
      return total;
    },
    formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
      try {
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(
          (amount = Math.abs(Number(amount) || 0).toFixed(decimalCount))
        ).toString();
        let j = i.length > 3 ? i.length % 3 : 0;

        return (
          negativeSign +
          (j ? i.substr(0, j) + thousands : "") +
          i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) +
          (decimalCount
            ? decimal +
              Math.abs(amount - i)
                .toFixed(decimalCount)
                .slice(2)
            : "")
        );
      } catch (e) {
        console.log(e);
      }
    },
    openTab() {
      if(this.seleccionado === "Ventas")
      {
        window.open(
        window.location.origin +
          "/print/ventas?date=" +
          JSON.stringify(this.date) +
          "&seleccionado=Ventas"
          );
      }
      window.open(
        window.location.origin +
          "/print?date=" +
          JSON.stringify(this.date) +
          "&products=" +
          JSON.stringify(this.products) +
          "&seleccionado=Productos" +
          "&categories=" +
          JSON.stringify(this.categories) +
          "&totales=" +
          JSON.stringify([
            "",
            "",
            "",
            this.cantidadProductos(),
            "$" + this.formatMoney(this.montoTotalProducto())
          ])
      );
    },
    toPrint(id) {
      window.open("/invoice/print?invoice_id=" + id, "_blank");
    },
    openDetalle(facture) {
      if (facture.type_sale === "personalizado") {
        this.toPrint(facture.id);
        return;
      }
      this.factureselect = facture;
      this.loading = true;
      axios
        .get("/return/facture/detalle", {
          params: {
            facture: facture.id
          }
        })
        .then(response => {
          this.factureselect = response.data.facture;
          this.details = response.data.detalle;
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          console.log(facture);
          this.loading = false;
          $("#detallefactura").modal("show");
        });
    }
  },
  computed: {
    nfcleng() {
      var count = 0;
      for (var key in this.ncfs) {
        count++;
      }
      if (count == 0 && this.ncf == undefined) {
        return true;
      } else {
        return false;
      }
    },
    nfcleng2() {
      var count = 0;
      for (var key in this.ncfs) {
        count++;
      }
      if (count > 0) {
        return true;
      } else {
        return false;
      }
    }
  },
  created() {
    this.settings();
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
  background: url("../../../../public/loading2.gif") 50% 50% no-repeat
    rgb(249, 249, 249);
  opacity: 0.8;
}
</style>