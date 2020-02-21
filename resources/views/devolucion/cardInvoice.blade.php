<div class="card" style="width: 400px;cursor: pointer" @click="datosfactura(item.id)">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 text-center">
                <h6>Factura @{{ item.type_sale }}</h6>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-6" style="margin-top: 10px">
                <p><b>No. Factura: </b>@{{ item.id }}</p>
            </div>
            <div class="col-md-6" style="margin-top: 10px">
                <p><b>Fecha: </b> @{{ item.created_at }}</p>
            </div>
            <div class="col-md-6" style="margin-top: 10px">
                <p><b>Monto: </b> @{{ format2(item.total_facture, '') }}</p>
            </div>
            <div class="col-md-6" style="margin-top: 10px">
                <p><b>Devuelta: </b> @{{ format2(item.returns, '') }}</p>
            </div>
        </div>
    </div>
</div>