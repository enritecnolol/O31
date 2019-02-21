<template>
    <div>
        <template v-if="!item">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nombre Cliente</label>
                        <input type="text" v-model="namec" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control form-control-sm" v-model="email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Password cliente</label>
                        <input type="password" v-model="pass" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Base de datos</label>
                        <input type="text" class="form-control form-control-sm" v-model="database">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Host</label>
                        <input type="text" class="form-control form-control-sm" v-model="host">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Port</label>
                        <input type="text" class="form-control form-control-sm" v-model="port">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">UserName</label>
                        <input type="text" class="form-control form-control-sm" v-model="username">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="text" class="form-control form-control-sm" v-model="password">
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <button type="button" class="btn btn-sm btn-primary" @click="save"><i class="fa fa-save"></i> Guardar</button>
                    </div>
                </div>
            </div>
            <br>
        </template>
        <template v-else>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nombre Cliente</label>
                        <input type="text" v-model="item.name" disabled class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" disabled class="form-control form-control-sm" v-model="item.email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Base de datos</label>
                        <input type="text" class="form-control form-control-sm" v-model="item.datab">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Host</label>
                        <input type="text" class="form-control form-control-sm" v-model="item.host">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Port</label>
                        <input type="text" class="form-control form-control-sm" v-model="item.port">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">UserName</label>
                        <input type="text" class="form-control form-control-sm" v-model="item.username">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="text" class="form-control form-control-sm" v-model="item.password">
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <button type="button" class="btn btn-sm btn-warning" @click="edit"><i class="fa fa-edit"></i> Editar</button>
                    </div>
                </div>
            </div>
            <br>
        </template>
    </div>
</template>
<script>
    export default {
        name:'formclient',
        props:['item'],
        data()
        {
            return{
                namec:'',
                email:'',
                database:'',
                pass:'',
                host:'',
                port:'',
                username:'',
                password:''
            }
        },
        methods:{
            save(){
                if (!this.namec || !this.email || !this.pass || !this.database || !this.host || !this.port || !this.username || !this.password)
                {
                    toastr.warning("Por Favor llenar todos los datos");
                    return;
                }
                axios.post('/user/connection/store', {
                    nameclient: this.namec,
                    email: this.email,
                    pass:this.pass,
                    database: this.database,
                    host:this.host,
                    port:this.port,
                    username: this.username,
                    password: this.password

                })
                    .then( (response) => {
                        toastr.success("Los datos se han guardado")
                        this.$emit('saved')
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            },
            edit() {
                if (!this.item.datab || !this.item.host || !this.item.port || !this.item.username || !this.item.password) {
                    toastr.warning("Por Favor llenar todos los datos");
                    return;
                }
                axios.post('/user/connection/edit', {
                    item: this.item
                })
                    .then( (response) => {
                        toastr.success("Los datos se han editado");
                        this.$emit('saved');
                    })
                    .catch( (error) => {
                        console.log(error);
                    });
            }
        },
        computed:{

        },
        mounted() {
        }
    }
</script>
<style>

</style>