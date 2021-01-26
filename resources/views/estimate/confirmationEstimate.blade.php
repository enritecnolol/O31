@include('layouts.header')
@section('tittle', 'O31 | confirmacion de cotizacion')
<body class="animsition">
<div class="page-wrapper" id="Vue">
    <div class="loader" v-if="loading"></div>
    <div class="page-content--bge5" style="overflow: auto">
        <div class="container" style="">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-warning" role="alert" v-if="estimateStatus === 2">
                            Estamos confirmando la cotización.
                        </div>
                        <div class="alert alert-success" role="alert" v-else-if="estimateStatus === 1">
                            La cotización ha sido procesada. Gracias por preferirnos
                        </div>
                        <div class="alert alert-danger" role="alert" v-else>
                            Algo a salido mal. por favor intentelo de nuevo
                        </div>
                        <div class="text-center" v-if="estimateStatus === 1">
                            <button class="btn btn-primary" @click="redirect"> Volver inicio</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.scripts')
<script>
    var app = new Vue({
        el:'#Vue',
        data:{
            loading:false,
            estimateStatus:2
        },
        methods:{
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
            confirmation(auth, estimate)
            {
                if(auth === "" && estimate === "")
                {
                    _this.estimateStatus = 0;
                    return;
                }
                _this = this;
                this.loading = true;
                axios.post('confirmationEstimate', {
                    auth: auth,
                    estimate:estimate
                })
                    .then((response) => {
                        _this.estimateStatus = 1;
                        console.log(response)
                    })
                    .catch((err) => {
                        _this.estimateStatus = 0;
                        console.log(err)
                    })
                    .finally(()=> {
                        _this.loading = false;
                    })
            },
            redirect()
            {
                window.location.href = '/login'
            }
        },
        created(){
            this.confirmation(
                this.getUrlVars(window.location.href)['auth'],
                this.getUrlVars(window.location.href)['estimate']
            );
        }
    })
</script>
</body>
</html>
<!-- end document-->
