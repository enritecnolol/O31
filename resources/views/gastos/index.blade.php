@extends('main.app')
@section('tittle','SofiaRD | Gastos')

@section('titulo')
    <h3 style="color: white"><i class="fas fa-arrow-circle-right"></i> Entrada de Comprobante</h3>
@endsection

@section('aside')
    @include('caja.siderbar')
@endsection

@section('content')
    <div class="container" style="margin-top: -40px">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h1>Entrada de Comprobante</h1>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr style="background: #00aced">
                            </div>
                            <div class="col-md-12">
                                <div class="container">
                                    <div class="row justify-content-center align-items-center">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="TNCF" class=" form-control-label"><u>Tipo NCF </u><span style="color: red">*</span></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select class="form-control form-control-sm" v-model="ncf" id="TNCF">
                                                            <option selected value="">Selecionar</option>
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

                                                <template v-if="ncf != '02'">
                                                    <div class="row form-group">
                                                        <div class="col-sm-4">
                                                            <label for="rnc_rnc" class=" form-control-label"><u>RNC.</u><span style="color: red">*</span></label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" id="rnc_rnc" v-model="rnc_nfc" placeholder="" maxlength=""  @keypress.enter="buscar_rnc" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-sm-4">
                                                            <label for="razon_social" class=" form-control-label"><u>Razon Social</u><span style="color: red">*</span></label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" id="razon_social" v-model="razon_nfc" placeholder="" maxlength=""  class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-sm-4">
                                                            <label for="tel" class=" form-control-label"><u>Telefono</u><span style="color: red">*</span></label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" id="tel" v-model="telefono_nfc" placeholder="" maxlength="15"  class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </template>
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="tipoF" class=" form-control-label"><a href="#" data-toggle="modal" data-target="#modaltipof"><u>Tipo Factura</u></a> <span style="color: red">*</span></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select class="form-control form-control-sm" v-model="tfactura" id="tipoF">
                                                            <option value="">--Seleccionar--</option>
                                                            <template v-for="item in datostipofacturatabla">
                                                                <option :value="item.id">@{{ item.nombre }}</option>
                                                            </template>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="suplidor" class=" form-control-label">Suplidor <span style="color: red">*</span></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select name="" class="form-control form-control-sm" v-model="suplidor" id="suplidor">
                                                            <option value="">--Seleccionar--</option>
                                                            <template v-for="item in datosprovedorestabla">
                                                                <option :value="item.id">@{{ item.nombre }}</option>
                                                            </template>
                                                        </select>
                                                    </div>
                                                </div>
                                                {{--<div class="row form-group">--}}
                                                {{--<div class="col-sm-4">--}}
                                                {{--<label for="emisorRNC" class=" form-control-label">Emisor RNC </label>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-sm-6">--}}
                                                {{--<input type="text" maxlength="15"  v-model="emisorRNC" :disabled="suplidor == ''" id="emisorRNC" placeholder=""  class="form-control form-control-sm">--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="row form-group">--}}
                                                {{--<div class="col-sm-4">--}}
                                                {{--<label for="Emisiorfacture" class=" form-control-label">Emisor Factura </label>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-sm-6">--}}
                                                {{--<input type="text" id="Emisiorfacture" placeholder="" :disabled="suplidor == ''" v-model="emisorfactura" maxlength="15"  class="form-control form-control-sm">--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="facturaref" class=" form-control-label">Factura/Ref. <span style="color: red">*</span></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="facturaref" v-model="factura_ref" placeholder="" maxlength="15"  class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="fecha" class=" form-control-label">Fecha <span style="color: red">*</span></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="date" id="fecha" placeholder="" v-model="fecha" class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="NCFno" class=" form-control-label">NCF No. </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="NCFno" placeholder="" v-model="ncfno" maxlength="30"  class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="Tipogasto" class=" form-control-label">Tipo Gasto <span style="color: red">*</span></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select class="form-control form-control-sm" v-model="tipogasto" id="Tipogasto">
                                                            <option value="">--Seleccionar--</option>
                                                            <option value="gasto personal">Gastos de Personal</option>
                                                            <option value="gasto trabajo">Gastos por trabajos, suministros y servicios</option>
                                                            <option value="arrendamiento">Arrendamientos</option>
                                                            <option value="gasto activos fijo">Gastos de activos fijos</option>
                                                            <option value="representacion">Gastos de representacion</option>
                                                            <option value="deduciones admitidas">Otras deduciones admitidas</option>
                                                            <option value="gastos financieros">Gastos Financieros</option>
                                                            <option value="presentacion">Gastos de presentacion</option>
                                                            <option value="deduciones admitidas">Otras deduciones admitidas</option>
                                                            <option value="financieros">Gastos financieros</option>
                                                            <option value="extraordinarios">Gastos Extraordinarios</option>
                                                            <option value="compra y costo">Compras y costos</option>
                                                            <option value="activo">Activos</option>
                                                            <option value="seguro">Seguros</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="condicones" class=" form-control-label">Condiciones <span style="color: red">*</span></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="number" id="condicones" placeholder="" v-model="condiciones" min="0" max="30" class="form-control form-control-sm">
                                                    </div>
                                                    <h5 style="padding: 5px">Dias</h5>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="Concepto" class=" form-control-label">Concepto </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <textarea class="form-control" maxlength="100" v-model="concepto" id="Concepto"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="formapago" class=" form-control-label">Forma Pago <span style="color: red">*</span></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select class="form-control form-control-sm" v-model="formapago" id="formapago">
                                                            <option value="">--Selecciona--</option>
                                                            <option value="efectivo">01. Efectivo</option>
                                                            <option value="cheques">02. Cheques/Transferencias</option>
                                                            <option value="tarjeta">03. Tarjeta credito/debito</option>
                                                            <option value="compracredito">04. Compras a credito</option>
                                                            <option value="permuta">05. Permuta</option>
                                                            <option value="notacretido">06. Nota de credito</option>
                                                            <option value="mixto">07. Mixto</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="subtotal" class=" form-control-label">Sub Total <span style="color: red">*</span></label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" id="subtotal" placeholder="" v-model="subtotal" class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="descuento" class=" form-control-label">Descuento <span style="color: red">*</span></label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" id="descuento" placeholder="" v-model="descuento" class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="itbispagado" class=" form-control-label">Itbis Pagado <span style="color: red">*</span></label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" id="itbispagado" placeholder="" v-model="itbispagado"  class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="flete" class=" form-control-label">Flete <span style="color: red">*</span></label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" id="flete" placeholder="" v-model="flete"  class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-4">
                                                        <label for="total" class=" form-control-label">Neto Total</label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" id="total" placeholder="" disabled v-model="totalneto" class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr style="background: #00aced">
                            </div>
                            <div class="col-md-12">
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" @click="nuevocomprobante"><i class="fas fa-save"></i> Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modal.modalNCF')
    @include('modal.modaltipoF')
@endsection

@section('scriptp')
    <script>
        new Vue({
            el: '#Vue',
            data(){
                return {
                    nombrenfc:'',
                    datosnfc:'',
                    datosprovedorestabla:'',
                    nombretf:'',
                    datostipofacturatabla:'',
                    ncf:'',
                    tfactura:'',
                    suplidor:'',
                    emisorRNC:'',
                    emisorfactura:'',
                    factura_ref:'',
                    fecha:'<?php echo date('Y-m-d')?>',
                    ncfno:'',
                    tipogasto:'',
                    condiciones:0,
                    concepto:'',
                    formapago:'',
                    subtotal:0,
                    descuento:0,
                    itbispagado:0,
                    flete:0,
                    nfc_nfc:'',
                    telefono_nfc:'',
                    rnc_nfc:'',
                    razon_nfc:'',
                    setting:''
                }
            },
            mounted(){
                _this = this;
                // _this.datostablanfc();
                _this.todosprovedores();
                _this.datostipofactura();
                _this.config();
            },
            methods:{
                config(){
                    axios.post('/configuracion/sale')
                        .then( (response) => {
                            for(var key in response['data']){
                                this.setting = response["data"][key]
                                break;
                            }
                        })
                        .catch(function (error) {
                        });
                },
                buscar_rnc()
                {
                    axios.post('/entrada/comprobante/data/rnc', {
                        rnc: this.rnc_nfc
                    })
                        .then( (response) => {
                            for(var key in response.data){
                                this.telefono_nfc = response.data[key].telefono_nfc;
                                this.razon_nfc = response.data[key].razon_nfc;
                                break;
                            }
                            if (response.data.length == 0){
                                toastr.warning("No se ha encotrado este RNC")
                            }
                        })
                        .catch(function (error) {
                        });
                },
                nuevonfc:function () {
                    _this = this;
                    if  (_this.nombrenfc == '')
                    {
                        toastr.warning('por favor llenar el campo', 'Validacion')
                    }else{
                        axios.post('/tipo/comprobante/store', {
                            nombre: _this.nombrenfc
                        })
                            .then(function (response) {
                                toastr.success('Los datos se han guadado', 'Validacion');
                                _this.nombrenfc = '';
                                _this.datostablanfc();
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                },
                datostablanfc:function () {
                    _this = this;
                    axios.post('/tipo/comprobante/datos/tabla')
                        .then(function (response) {
                            _this.datosnfc = response['data']
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                todosprovedores: function () {
                    _this = this
                    axios.post('/provedores/todos/provedores')
                        .then(function (response) {
                            _this.datosprovedorestabla = response['data']
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                nuevotipofactura:function () {
                    _this = this;
                    if (_this.nombretf == '')
                    {
                        toastr.warning('Por favor revisar el campo nombre', 'Validacion')
                    }
                    else{
                        axios.post('/tipo/factura/store', {
                            nombre: _this.nombretf
                        })
                            .then(function (response){
                                toastr.success('Los datos sea han guardado Corretamente', 'Validador');
                                _this.nombrenfc = '';
                                $('#modaltipof').modal('hide');
                                _this.datostipofactura();

                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                },
                datostipofactura:function () {
                    _this = this;
                    axios.post('/tipo/factura/datos')
                        .then(function (response) {
                            _this.datostipofacturatabla = response['data'];
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                nuevocomprobante:function () {
                    _this = this;

                    if (_this.ncf == '' || _this.tfactura == '' || _this.suplidor == '' || _this.factura_ref == '' || _this.fecha == '' || _this.tipogasto == '' ||
                        _this.formapago == '' || _this.subtotal == 0  || _this.condiciones == 0 || _this.netototal == 0)
                    {
                        toastr.warning('Revisar los Campos importante', 'Validador')
                    }else{
                        if (this.setting.generacomprobante == 'si')
                        {
                            if  (this.ncf != '02')
                            {
                                if (!this.telefono_nfc || !this.rnc_nfc || !this.razon_nfc ){
                                    toastr.warning("Llenar datos de NFC");
                                    return;
                                }
                            }
                        }
                        axios.post('/entrada/comprobante/store', {
                            setting:_this.setting,
                            nfc_nfc:_this.nfc_nfc,
                            telefono_nfc:_this.telefono_nfc,
                            rnc_nfc:_this.rnc_nfc,
                            razon_nfc:_this.razon_nfc,
                            ncf: _this.ncf,
                            tfactura: _this.tfactura,
                            suplidor: _this.suplidor,
                            emisorrnc: _this.emisorRNC,
                            emisorfactura: _this.emisorfactura,
                            factura_ref: _this.factura_ref,
                            fecha: _this.fecha,
                            ncfno: _this.ncfno,
                            tipogasto: _this.tipogasto,
                            condiciones: _this.condiciones,
                            concepto: _this.concepto,
                            formapago: _this.formapago,
                            subtotal: _this.subtotal,
                            descuento: _this.descuento,
                            itbispagado: _this.itbispagado,
                            flete: _this.flete,
                            netototal: _this.totalneto
                        })
                            .then(function (response) {
                                if  (response.data == "No es posible hacer la factura por falta de Comprobantes")
                                {
                                    toastr.warning(response.data, "validador");
                                    return;
                                }
                                if (response.data[2] != ""){
                                    toastr.info(response.data[2], "Aviso");
                                }
                                toastr.success('Los datos se han guardado Correctamente', 'validador')
                                _this.limpiar();
                            })
                            .catch(function (error) {
                                toastr.error('Se ha producido Error', 'validador');
                                console.log(error);
                            });
                    }
                },
                limpiar:function () {
                    _this = this;
                    _this.ncf = ''
                    _this.tfactura=''
                    _this.suplidor = ''
                    _this.emisorRNC = ''
                    _this.emisorfactura = ''
                    _this.factura_ref = ''
                    _this.fecha = '<?php echo date('Y-m-d')?>'
                    _this.ncfno = ''
                    _this.tipogasto = ''
                    _this.condiciones = 0
                    _this.concepto = ''
                    _this.formapago = ''
                    _this.subtotal = 0
                    _this.descuento = 0
                    _this.itbispagado = 0
                    _this.flete = 0
                    _this.netototal = 0

                }
            },
            computed:{
                 totalneto:function () {
                     _this = this;
                     var suma = 0;
                     suma = parseFloat(_this.subtotal) + parseFloat(_this.descuento) + parseFloat(_this.itbispagado) + parseFloat(_this.flete);
                     return suma;
                 }
            }
        })

    </script>

@endsection