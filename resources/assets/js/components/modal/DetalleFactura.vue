<template>
  <div
    class="modal fade"
    id="detallefactura"
    tabindex="-1"
    data-backdrop="static"
    data-keyboard="false"
    role="dialog"
    aria-labelledby="exampleModalLongTitle"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Factura</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="myPrintArea" style="color: #000;margin: 0 auto;display: inline;">
            <div class="row">
              <div class="col-12">
                <div style="width: 400px;text-align: center;">
                  <img :src="'imagenes/'+setting.img" width="100" alt />
                </div>
                <h3 style="color: #000;width: 400px;text-align: center;">{{ setting.nombreempresa }}</h3>
                <p style="width: 400px;text-align: center;">
                  {{ setting.pais }}, {{ setting.ciudad }}, {{ setting.direccion }}
                  <br />
                  {{ setting.telefono }}
                </p>
              </div>
              <div class="col-12">
                <div
                  class="form-group text-left"
                  style="margin: 0"
                  v-if="setting.generacomprobante=='si'"
                >
                  <label style="margin-left: 120px;">
                    <strong>{{factureselect.tiponfc === '02' ? 'Factura contado' : 'Factura de credito'}}</strong>
                  </label>
                </div>
                <div class="form-group text-left" style="margin: 0">
                  <label>
                    <strong>No. Factura:</strong>
                  </label>
                  <label>{{ factureselect.id }}</label>
                </div>
                <div class="form-group text-left" style="margin: 0">
                  <label>
                    <strong>Fecha:</strong>
                  </label>
                  <label>{{factureselect.created_at}}</label>
                </div>
                <template v-if="setting.generacomprobante=='si' && factureselect.rnc_nfc">
                  <!-- <div class="form-group text-left" style="margin: 0">
                    <label>
                      <strong>Fecha vencimiento NCF:</strong>
                    </label>
                    <label>{{rncDueDate}}</label>
                  </div>-->
                  <div class="form-group text-left" style="margin: 0">
                    <label>
                      <strong>Razon Social:</strong>
                    </label>
                    <label>{{factureselect.razon_nfc}}</label>
                  </div>
                  <div class="form-group text-left" v-if="factureselect.tipo_nfc" style="margin: 0">
                    <label>
                      <strong>RNC:</strong>
                    </label>
                    <label>{{factureselect.rnc_nfc}}</label>
                  </div>
                  <div class="form-group text-left" v-if="factureselect.tipo_nfc" style="margin: 0">
                    <label>
                      <strong>Telefono:</strong>
                    </label>
                    <label>{{factureselect.telefono_nfc}}</label>
                  </div>
                </template>
              </div>
              <hr />
              <div class="col-12">
                <div style="margin-bottom: 5px;clear:both;">
                  <table style="width: 400px;">
                    <thead
                      style="border-bottom: 1px solid black;border-top: 1px solid black;font-weight: bold;text-align: left;"
                    >
                      <tr>
                        <td style="font-weight: bold;color: #000;">Producto</td>
                        <td style="font-weight: bold;color: #000;text-align: center;">Cantidad</td>
                        <td style="font-weight: bold;color: #000;" align="right">Total</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, key) in details" :key="key">
                        <td style="font-size: 14px;color: #000;" width="50%">
                          <label>{{item.name_product.toUpperCase()}}</label>
                        </td>
                        <td
                          style="font-size: 14px;text-align: center;color: #000;"
                          width="20%"
                        >{{item.quanlity}}</td>
                        <td
                          style="font-size: 14px;color: #000;"
                          width="30%"
                          align="right"
                        >{{format2(parseFloat(item.price), '') }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-12">
                <div style="border-top:1px solid #000; padding-top:10px;"></div>
              </div>
              <div class="col-12" style="margin-top: 10px">
                <div style="margin-bottom: 5px;clear:both;">
                  <table style="width: 40%">
                    <tbody>
                      <tr>
                        <td
                          style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;"
                        >Bruto:</td>
                        <td
                          style="font-size: 14px;width: 50px;text-align: right;color: #000;"
                        >{{ format2(parseFloat(factureselect.brute), '') }}</td>
                      </tr>
                      <tr v-if="parseFloat(factureselect.desc) !== 0">
                        <td
                          style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;"
                        >Descuento:</td>
                        <td
                          style="font-size: 14px;width: 50px;text-align: right;color: #000;"
                        >{{ format2(parseFloat(factureselect.desc), '') }}</td>
                      </tr>
                      <tr>
                        <td
                          style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;"
                        >Itbis:</td>
                        <td
                          style="font-size: 14px;width: 50px;text-align: right;color: #000;"
                        >{{ format2(parseFloat(factureselect.itbis), '') }}</td>
                      </tr>
                      <tr v-if="setting.leycamarero == 'si'">
                        <td
                          style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;"
                        >10% ley:</td>
                        <td
                          style="font-size: 14px;width: 50px;text-align: right;color: #000;"
                        >{{ format2(parseFloat(factureselect.leycamarero), '') }}</td>
                      </tr>
                      <tr>
                        <td
                          style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;"
                        >Neto:</td>
                        <td
                          style="font-size: 14px;width: 50px;text-align: right;color: #000;"
                        >{{ format2(parseFloat(factureselect.total_facture), '') }}</td>
                      </tr>
                      <tr>
                        <td
                          style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;"
                        >-----</td>
                        <td style="font-size: 14px;width: 50px;text-align: right;color: #000;">-----</td>
                      </tr>
                      <tr>
                        <td
                          style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;"
                        >Efectivo:</td>
                        <td
                          style="font-size: 14px;width: 50px;text-align: right;color: #000;"
                        >{{ format2(parseFloat(factureselect.Monto_efectivo), '') }}</td>
                      </tr>
                      <tr>
                        <td
                          style="font-size: 14px;width: 70px;font-weight: bold;color: #000;text-align: right;"
                        >Devuelta:</td>
                        <td style="font-size: 14px;width: 50px;text-align: right;color: #000;">
                          <b>{{ format2(factureselect.returns, '') }}</b>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-12">
                <div style="border-top:1px solid #000; padding-top:10px;">
                  <div
                    class
                    style="padding:5px;width:85%;margin:0 auto;border-radius:3px;margin-top:20px;font-weight: bold;color: #000;"
                  >GRACIAS POR PREFERIRNOS</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
          <button
            type="button"
            class="btn btn-primary btn-sm"
            id="imprimir"
            v-print="'#myPrintArea'"
          >Imprimir</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import Print from "vue-print-nb";

Vue.use(Print);
export default {
  props: ["factureselect", "details", "setting"],
  data() {
    return {};
  },
  methods: {
    format2(n, currency) {
      n = parseFloat(n);
      return currency + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
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
    }
  },
  created() {}
};
</script>

<style scoped>
</style>